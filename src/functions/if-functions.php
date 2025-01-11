<?php

require_once "functions.php";

//Verifies if the request is POST and if title and description are provided
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["title"], $_POST["description"])) {

    //Sanitizes user input to prevent attacks
    $title=htmlspecialchars($_POST["title"]);
    $description=htmlspecialchars($_POST["description"]);

    //Adds a task with a title and description
    addNewTask($title, $description);

    //Redirects to homepage and stops script
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Deletes the task with the given id if delete and delete_id are set
    if (isset($_POST["delete"]) && isset($_POST["delete_id"])) {
        deleteTask($conn, $_POST["delete_id"]);
    }

    //Updates the task with the given id
    elseif (isset($_POST["id"])) {
        updateTask();
    }
}

//Default value is null
$editTaskId = null;

//Verifies if edit_task is set in the URL
if (isset($_GET["edit_task"])) {
    //Converts edit_task to an int and stores it in the variable
    $editTaskId = (int)$_GET["edit_task"];
}

//Verifies if the request is POST and if save_edit is set
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_edit"])) {
    
    //Retrieves task data from POST 
    $editId = $_POST["edit_id"];
    $editTitle = $_POST["edit_title"];
    $editDescription = $_POST["edit_description"];

    //Updates task in the database
    editTask($conn, $editId, $editTitle, $editDescription);

    header("Location: index.php");
    exit();
}

//Verifies if the request is POST and if toggle_completed is set
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["toggle_complete"])) {
    
    //Fetch task id from POST
    $task_id = $_POST["toggle_complete"];

    //Toggle if task is completed or not
    toggleTask($conn, $task_id);

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

//Get tasks from database and store them in the variable
$tasks = fetchTasks($conn);