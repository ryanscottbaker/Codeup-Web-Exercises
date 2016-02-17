$(document).ready(function() {
  console.log("document loaded");
  $(".btn-new-item").click(function(event) {
    event.preventDefault();
    var content = $("#content").val();
    var priority = $("#priority").val();
    var dueDate = $("#due_date").val();
    var data = {
      "content": content,
      "priority": priority,
      "due_date": dueDate
    };
    $.post("todo-json.php?order_by=", data, function(item) {
      console.log(item);
      console.log("success");
      $('#display').append("<tr><td>" + item.content + "</td><td>" + item.priority +
        "</td><td>" + item.due_date + "</td></tr>");
    });
  });

  var remove =

    $("#removeitem").click(function(event) {
      $.post("todo-json.php?id=5&action=delete");

    });

  $("#clearlist").click(function(event) {
    event.preventDefault();
    $.get("todo-json.php", function(items) {
      console.log(items);
    });
  });
}); 

