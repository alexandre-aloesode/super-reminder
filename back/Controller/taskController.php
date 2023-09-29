<?php
require_once '../Model/TaskModel.php';
require_once '../Model/SubTaskModel.php';
require_once '../Model/UserModel.php';

use App\Model\TaskModel;
use App\Model\SubTaskModel;
use App\Model\UserModel;

if (session_id() == "") session_start();

if (isset($_SESSION['user']) && isset($_POST['action']) && $_POST['action'] === 'getTasks') {
    $userTasks = new TaskModel();
    $userTasks = $userTasks->getOneUserTasks($_SESSION['user']->getId());
    echo json_encode(['success' => true, 'tasks' => $userTasks]);
}

if (isset($_SESSION['user']) && isset($_POST['action']) && $_POST['action'] === 'getSubTasks') {
    $userSubTasks = new subTaskModel();
    $userSubTasks = $userSubTasks->getOneUserSubTasks($_SESSION['user']->getId(), $_POST['taskId']);
    echo json_encode(['success' => true, 'subTasks' => $userSubTasks]);
}

if (isset($_POST["updateTaskStatus"]) && isset($_POST["taskId"])) {
    try {
        $task = new TaskModel();
        $task = $task->updateOne([
            ':status' => $_POST["updateTaskStatus"],
            ':id' => $_POST["taskId"]
        ]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

if (isset($_POST["updateTaskDescription"]) && isset($_POST["taskId"])) {
    try {
        $task = new TaskModel();
        $task = $task->updateOne([
            ':description' => $_POST["updateTaskDescription"],
            ':id' => $_POST["taskId"]
        ]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

if (isset($_POST["addTask"])) {
    try {
        $createdAt = new DateTime();
        $task = new TaskModel();
        $task = $task->createOne([
            ':title' => $_POST["taskTitle"],
            ':description' => $_POST["taskDescription"],
            ':status' => 'to_do',
            ':id_user' => $_SESSION['user']->getId(),
            ':created_at' => $createdAt->format('Y-m-d H:i:s')
        ]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

if (isset($_POST["deleteTask"])) {
    try {
        $task = new TaskModel();
        $task = $task->deleteOne([
            ':id' => $_POST["deleteTask"]
        ]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

if (isset($_POST["addSubTask"])) {
    try {
        $createdAt = new DateTime();
        $task = new SubTaskModel();
        $task = $task->createOne([
            ':id_task' => $_POST["addSubTask"],
            ':id_user' => $_SESSION['user']->getId(),
            ':created_at' => $createdAt->format('Y-m-d H:i:s'),
            ':description' => $_POST["subClassDescription"]
        ]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

if (isset($_POST["deleteSubTask"])) {
    try {
        $Subtask = new subTaskModel();
        $Subtask = $Subtask->deleteOne([
            ':id' => $_POST["deleteSubTask"]
        ]);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
