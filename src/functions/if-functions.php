<?php
require_once "db.php";

//Checks if the request is POST 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["title"], $_POST["description"])) {
    
    
    addNewTask($_POST["title"], $_POST["description"]);
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"]) && isset($_POST["delete_id"])) {
        deleteTask($conn, $_POST["delete_id"]);
    } elseif (isset($_POST["status"]) && isset($_POST["id"])) {
        updateTask();
    }
}

$editTaskId = null;
if (isset($_GET["edit_task"])) {
    $editTaskId = (int)$_GET["edit_task"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_edit"])) {
    $editId = $_POST["edit_id"];
    $editTitle = $_POST["edit_title"];
    $editDescription = $_POST["edit_description"];

    editTask($conn, $editId, $editTitle, $editDescription);

    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["toggle_complete"])) {
    $task_id = $_POST["toggle_complete"];
    toggleTask($conn, $task_id);
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$tasks = fetchTasks($conn);

?>