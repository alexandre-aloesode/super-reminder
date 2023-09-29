<?php
if (session_id() == "") session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do list</title>
    <link rel="stylesheet" href="../styles/global.css">
    <script defer src="../components/tasks.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shantell+Sans:ital@1&family=Ubuntu:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require_once '../components/navBar.php'; ?>
    <div id="toDoListDiv">
        <div id="toDoListTasksDiv">
            <div class="tasksDiv" id="toDoDiv">
                <div class="taskTitleDiv">
                    <h2>A faire</h2>
                    <i class="fa-solid fa-folder-plus" id="addTaskIcon"></i>
                </div>
                <div id="toDoTasks" class="dropzone"></div>
            </div>
            <div class="tasksDiv" id="currentDiv">
                <div class="taskTitleDiv">
                    <h2>En cours</h2>
                </div>
                <div id="currentTasks" class="dropzone"></div>
            </div>
            <div class="tasksDiv" id="doneDiv">
                <div class="taskTitleDiv">
                    <h2>Terminé</h2>
                </div>
                <div id="doneTasks" class="dropzone"></div>
            </div>
        </div>
    </div>
    <div id="addTaskDiv">
        <i class="fa-regular fa-circle-xmark" id="closeAddTaskDivBtn"></i>
        <form method="POST" id="addTaskForm">
            <input type="text" name="taskTitle" placeholder="Titre de la tâche">
            <textarea name="taskDescription" placeholder="Description de la tâche"></textarea>
            <input type="submit" value="Ajouter" id="addTaskButton" name="addTaskSubmit" class="mainButtons">
        </form>
    </div>
    <div id="showTaskDiv">
        <i class="fa-regular fa-circle-xmark" id="closeTaskDivBtn"></i>
        <h2 id="showTaskTitle"></h2>
        <div id="ShowTaskDetailsDiv">
            <div id="showTaskDescriptionDiv">
            </div>
            <div id="showTaskSubClassDiv">
            </div>
        </div>
    </div>
</body>

</html>