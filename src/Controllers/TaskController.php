<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController
{
    // Muestra una lista de tareas para el usuario autenticado.
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            echo 'No estás autenticado., <a href="' . BASE_URL . '/login">Regresar</a>';
            die();
        }
        $userId = $_SESSION['user_id'];
        $tasks = Task::findAll($userId);
      

        $content = __DIR__ . '/../Views/task/tasks.php';
        include __DIR__ . '/../Views/task/layout.php';
    }

    // Edita una tarea específica si pertenece al usuario autenticado.
    public function edit($id)
    {
        if (!is_numeric($id)) {
            echo 'Queriendo hacer trampa!, el id debe de ser númerico, <a href="' . BASE_URL . '/tasks">Regresar</a>';
            die();
        }
        $id = intval($id);
        if (!isset($_SESSION['user_id'])) {
            echo 'No estás autenticado., <a href="' . BASE_URL . '/login">Regresar</a>';
            die();
        }
        $task = Task::fetchTaskById($id);
        if (!$task) {
            echo 'La tarea no existe, <a href="' . BASE_URL . '/tasks">Regresar</a>';
            die();
        }
        if ($task['user_id'] != $_SESSION['user_id']) {
            echo 'No tienes permiso para editar esta tarea, <a href="' . BASE_URL . '/tasks">Regresar</a>';
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $status = $_POST['status'];
            $userId = $_SESSION['user_id'];
            $task = new Task($title, $description, $status, $userId, $id);
            $res = $task->save();
        }
        $task = Task::fetchTaskById($id);
      

        $content = __DIR__ . '/../Views/task/edit.php';
        include __DIR__ . '/../Views/task/layout.php';

    }

    // Crea una nueva tarea para el usuario autenticado.
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'No estás autenticado.']);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $status = $_POST['status'];
            $userId = $_SESSION['user_id'];

            $task = new Task($title, $description, $status, $userId);
            $res = $task->save();
        }
    

        $content = __DIR__ . '/../Views/task/create.php';
        include __DIR__ . '/../Views/task/layout.php';
    }

  

    // Elimina una tarea específica si pertenece al usuario autenticado.
    public function delete($id)
    {
        if (!is_numeric($id)) {
            echo 'Queriendo hacer trampa!, el id debe de ser númerico, <a href="' . BASE_URL . '/tasks">Regresar</a>';
            die();
        }
        $id = intval($id);
        $task = Task::fetchTaskById($id);
        if (!$task) {
            echo 'La tarea no existe, <a href="' . BASE_URL . '/tasks">Regresar</a>';
            die();
        }
        if ($task['user_id'] != $_SESSION['user_id']) {
            echo 'No tienes permiso para editar esta tarea, <a href="' . BASE_URL . '/tasks">Regresar</a>';
            die();
        }
        $res = Task::delete($id);
        $userId = $_SESSION['user_id'];
        $tasks = Task::findAll($userId);

            
        $content = __DIR__ . '/../Views/task/tasks.php';
        include __DIR__ . '/../Views/task/layout.php';
    }
}
