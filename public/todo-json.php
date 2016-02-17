<?php
/**
 * Kick off the session, always return "JSON" data, and switch our timezone over to Central Time
 * Realistically the last part should be done through a config,
 * but hard coding here makes students' lives easier
 */
session_start();
header('Content-Type: application/json');
date_default_timezone_set('America/Chicago');
/**
 * Dump basic error information in JSON format.
 */
set_error_handler(function($num, $msg, $file, $line) {
    http_response_code(500);
    echo json_encode(compact('num', 'msg', 'file', 'line'), JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);
    die();
});
/**
 * Global exception handler allowing us to send error information back as JSON
 * Not exactly best practice, but quick and dirty way to give parseable data back from API
 * Realistically, we should base this off of the environment: Handler for production, exceptions for dev
 */
set_exception_handler(function($exception) {
    // If a code was set in the exception use that as the HTTP status code, otherwise default 400
    // We assume 400 since exceptions in this app are almost all based on bad user data, not on internal errors
    if (!empty($exception->getCode())) {
        http_response_code($exception->getCode());
    } else {
        http_response_code(400);
    }
    echo json_encode(['msg' => $exception->getMessage()], JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);
});
/**
 * Grab a value from either the form request values or JSON data included in the payload
 *
 * @param string $key Name of value from the request
 * @return mixed|null Value from either $_REQUEST or JSON object in request body. Null if it doesn't exist
 */
function requestValue($key)
{
    // Check both $_GET & $_POST
    if (isset($_REQUEST[$key])) {
        return $_REQUEST[$key];
    }
    // Read the request body and convert it from a JSON object
    $body = file_get_contents('php://input');
    $data = json_decode($body, true);
    if (!empty($data)) {
        // Merge JSON data with $_REQUEST so subsequent lookups will just return from the array
        $_REQUEST = array_merge($data, $_REQUEST);
        return isset($data[$key]) ? $data[$key] : null;
    }
    // Key wasn't found anywhere
    return null;
}
/**
 * Grab a todo item from the session and convert it to JSON
 *
 * Doing the JSON encoding here in this function does somewhat limit its usefulness
 * but in the very narrow use cases in this application, it does ultimately save some code
 *
 * @param int $id Todo item ID
 * @throws Exception if ID does not exist in session
 * @return string Todo item encoded as a JSON object
 */
function getItem($id)
{
    if (!isset($_SESSION['items'][$id])) {
        throw new Exception("No items found for $id.", 404);
    }
    return json_encode(encodeItem($_SESSION['items'][$id]), JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);
}
/**
 * Convert all the DateTime objects in a single item to RFC 2822 strings (for JSON)
 *
 * @param array $item A single todo item
 * @return array Todo item with DateTime objects stringified
 */
function encodeItem(array $item)
{
    $item['created_at'] = $item['created_at']->format(DATE_RFC2822);
    if (isset($item['due_date'])) {
        $item['due_date'] = $item['due_date']->format(DATE_RFC2822);
    }
    if (isset($item['completed'])) {
        $item['completed'] = $item['completed']->format(DATE_RFC2822);
    }
    return $item;
}
/**
 * Set content, priority, and/or due date values on a sigle todo item from request values
 *
 * The passed item should already have all the possible fields filled, this function just modifies
 * the ones that can be set directly from the API
 *
 * @param array $item A single todo item
 * @throws Exception If the content field was not included in the request
 * @throws Exception If the priority field was not an integer
 * @throws Exception If the due date field cannot be parsed by DateTime
 * @return array Todo item with new value(s) set
 */
function setItemProp(array $item)
{
    $content = requestValue('content');
    if (!empty($content)) {
        $item['content'] = $content;
    } else {
        throw new Exception('Missing required field "content".');
    }
    $priority = requestValue('priority');
    if (isset($priority)) {
        if ((is_int($priority) && $priority >= 0)|| ctype_digit($priority)) {
            $item['priority'] = $priority;
        } else {
            throw new Exception('Priority must be a positive integer.');
        }
    }
    $dueDate = requestValue('due_date');
    if (isset($dueDate)) {
        try {
            $item['due_date'] = new DateTime($dueDate);
        } catch (Exception $e) {
            $msg = "Due date must be a valid date string; could not parse " . requestValue('due_date') . ".";
            throw new Exception($msg, 400, $e);
        }
    }
    return $item;
}
// Initialize our items array in the session
if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = array();
}
// It's not exactly a database sequence, and it's certainly not atomic, but it'll do in a pinch
if (!isset($_SESSION['next_id'])) {
    $_SESSION['next_id'] = 1;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get request; either looking up a single item, or a list
    if (isset($_GET['id'])) {
        // They sent an ID, we'll give them a single item
        $id = $_GET['id'];
        echo getItem($id);
    } else {
        // They want a list of items
        $items = $_SESSION['items'];
        // Filter items down based on whether they are complete or not
        if (isset($_GET['complete'])) {
            $completeFilter = strtolower($_GET['complete']);
            if ($completeFilter == 'true' || $completeFilter == '1') {
                $items = array_filter($items, function($item) {
                    return isset($item['completed']);
                });
            } elseif ($completeFilter == 'false' || $completeFilter == '0') {
                $items = array_filter($items, function($item) {
                    return !isset($item['completed']);
                });
            } else {
                $msg = "Filtering completed tasks requires a true/false or 0/1 value, not $completeFilter.";
                throw new Exception($msg);
            }
        }
        // Change how the items are sorted
        if (isset($_GET['order_by'])) {
            usort($items, function($a, $b) {
                $key   = strtolower($_GET['order_by']);
                $value = 0;
                switch ($key) {
                    case 'content':
                        // Convert strings to lower case so alpha sorting is not case sensitive
                        $a[$key] = strtolower($a[$key]);
                        $b[$key] = strtolower($b[$key]);
                        // THIS FALL THROUGH IS INTENTIONAL
                    case 'id':
                    case 'created_at':
                    case 'priority':
                        // These items can all be sorted by simple comparison
                        if ($a[$key] < $b[$key]) {
                            $value = -1;
                        } elseif ($a[$key] > $b[$key]) {
                            $value = 1;
                        } // Else: values were equal
                        break;
                    case 'due_date':
                    case 'completed':
                        // If both values are set convert to int timestamps and get a value through basic arithmatic
                        // Otherwise, filter null values towards the end
                        if (isset($a[$key]) && isset($b[$key])) {
                            $value = $a[$key]->getTimestamp() - $b[$key]->getTimestamp();
                        } elseif (isset($a[$key])) {
                            $value = -1;
                        } elseif (isset($b[$key])) {
                            $value = 1;
                        } // Else: both values were null and therefore equal because this ain't SQL
                        break;
                    default:
                        $msg = "You can only sort by a value that exists in each todo item, not $key.";
                        throw new Exception($msg);
                }
                // This tortured ternary basically says that if they passed a direction
                // and it's "desc" reverse our existing values
                return (isset($_GET['direction']) && strtolower($_GET['direction']) == 'desc') ? -$value : $value;
            });
        }
        $items = array_map('encodeItem', $items);
        echo json_encode(array_values($items), JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Post request, we're trying to modify some data
    $id = requestValue('id');
    if (isset($id)) {
        if (!isset($_SESSION['items'][$id])) {
            // That ain't no ID I've ever heard of...
            throw new Exception("No items found for $id.", 404);
        }
        // Look for an action specified in the request, otherwise assume it's "update"
        $action = requestValue('action');
        $action = isset($action) ? strtolower($action) : 'update';
        switch($action) {
            case 'update':
                // Run the existing item through setItemProp() to get all our changes from the request
                $_SESSION['items'][$id] = setItemProp($_SESSION['items'][$id]);
                echo getItem($id);
                break;
            case 'delete':
                // Just remove it from the array, easy peasy
                unset($_SESSION['items'][$id]);
                echo json_encode(['msg' => "Deleted todo item $id."], JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT);
                break;
            case 'complete':
                $state = requestValue('state');
                $state = is_string($state) ? strtolower($state) : $state;
                if (in_array($state, [null, true, 'true', 1, '1'], true)) {
                    // State was "truthy" or not specified
                    // Set the completion date to right now if it's not already set
                    if (!isset($_SESSION['items'][$id]['completed'])) {
                        $_SESSION['items'][$id]['completed'] = new DateTime();
                    }
                } elseif (in_array($state, [false, 'false', 0, '0'], true)) {
                    // State was "falsy", we need to undo the completion state
                    $_SESSION['items'][$id]['completed'] = null;
                } else {
                    throw new Exception("Invalid state specified for completion: $state");
                }
                echo getItem($id);
                break;
            default:
                throw new Exception("Invalid action specified: $action");
        }
    } else {
        // No ID was specified; create a new item
        // Our initial properties and default values..
        $item = array(
            'created_at' => new DateTime(),
            'priority' => 0,
            'due_date' => null,
            'completed' => null
        );
        // ...now add in whatever values came from the request..
        $item = setItemProp($item);
        // ...and add it to the next index in the session
        // Tracking a "next id" separately from the array add some weird complexity, but helps ensure
        // the integrity of our data; a user can't just delete the last item, insert a new one, and take
        // its place. Further, storing the ID in as both the array index and in each item seems redundant
        // but it makes lookup trivial, while keeping all the data easily accessible to the user
        $id = $_SESSION['next_id'];
        $item['id'] = $id;
        $_SESSION['items'][$id] = $item;
        $_SESSION['next_id']++;
        // Status code indicates an entity was created
        http_response_code(201);
        // When sending a 201, you should include the URL for that new entity in Location
        // (http://www.restapitutorial.com/httpstatuscodes.html)
        header("Location: {$_SERVER['SCRIPT_NAME']}?id=$id");
        echo getItem($id);
    }
} else {
    $msg = "Unknown request type {$_SERVER['REQUEST_METHOD']}.";
    $msg.= " This application only responds to GET and POST requests.";
    throw new Exception($msg, 501);
}