// Functions for Done and Delete Buttons


function deleteItem(itemToDelete) {
  $.post("todo-json.php?id=" + itemToDelete + "&action=delete", function(item) {
    $(".todorow" + itemToDelete).fadeOut();
    console.log(item);
  });
};

function completeItem(itemToComplete) {
  $.post("todo-json.php?id=" + itemToComplete + "&action=delete", function(item) {
    $(".todorow" + itemToComplete).fadeOut();
    console.log(item);
    alert("Task Completed!")
  });
};

// Function for Add New Task Button

$(document).ready(function() {
  console.log("document loaded");

  $(".btn-new-item").click(function(element) {
    event.preventDefault();


    var content = $("#content").val();
    var priority = $("#priority").val();
    var dueDate = $("#due_date").val();
    var data = {
      "content": content,
      "priority": priority,
      "due_date": dueDate
    };

    $.post("todo-json.php?order_by=due_date", data, function(item) {
      console.log(item);
      console.log("success");
      var date = item.due_date;
      date = moment().format("MMM Do");
      $('.display').append(
        "<tr><td class='content'>" + item.content + 
        "</td><td class='priority'>" + item.priority +
        "</td><td class='dateclass'>" + date + 
        "</td><td><button class='btn btn-primary'onclick='completeItem(" + element.id + ")'>Done</button>" +
        "<button class='btn btn-danger'onclick='deleteItem(" + element.id + ")'>Delete</button>" +
        "</td></tr>");
    });
  });

//Edit items dropdown from Hamburger Icon 

  $("#edit_items").click(function(event) {
    event.preventDefault();
    $.get("todo-json.php", function(items) {
      console.log(items);
      $(".display").empty();

// Appends all of the data

      items.forEach(function(element, index) {
        var date = element.due_date;
        date = moment().format("MMM Do");
        var row = "<tr class='todorow" + element.id + "'>" +
          "<td class='content'>" +
          element.content +
          "</td>" +
          "<td class='priority'>" +
          element.priority +
          "</td>" +
          "<td class='dateclass'>" +
          date +
          "</td>" +
          "<td>" +
          "<button class='btn btn-primary'onclick='completeItem(" + element.id + ")'>Done</button>" +
          "<button class='btn btn-danger'onclick='deleteItem(" + element.id + ")'>Delete</button>" +
          "</td>" +
          "</tr>";
        $(".display").append(row);

      });

    });

  });

});


