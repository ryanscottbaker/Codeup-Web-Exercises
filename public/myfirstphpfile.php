<?php

$greeting= 'Hello';
$name= 'Ryan';

$message = $greeting . ' ' . $name; 
var_dump($message);


$message = "{$greeting} {$name}";
var_dump($message);

// line 6 and 8 are the same, line 8 is interpolation 
$names= [
	'Chris',
	'Mars',
	'Rachel',
	'Bernie',
	'Tom'
];

foreach ($names as $studentName) {
	echo "{$greeting} {$studentName}\n";
}

echo 'Shut up ' . $names[1];

echo "\n";

echo 'I have ' . count ($names) . ' names';

echo "\n";

echo $message;

$names[] = 'Boris';

var_dump($names);

$students= [
	'first_name' => 'Kate',
	'last_name' => 'McKaterson',
	'cohort' => 'Balboa'
	];

	echo "Hello " .$students['first_name']. ' ' . $students['last_name'];

	var_dump('$students');

function echoName($greeting, $names)
{
		echo "{$greeting} {$names[0]} \n";
}

echoName("Hola", $names[0]);
?>
<ul>
<?php foreach ($names as $studentName): ?>
	<li><?php echo $studentName ?></li>
<?php endforeach; ?>
</ul>

