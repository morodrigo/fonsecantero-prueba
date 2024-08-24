$(document).ready(function () {
  // Eliminar tarea
  $("#tasksTable").on("click", ".delete", function () {
    var id = $(this).data("id");
    if (confirm("¿Estás seguro de que deseas eliminar esta tarea?")) {
      return true;
    } else {
      return false;
    }
  });
});
