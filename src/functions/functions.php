<?php
require_once "db.php";

//Fetch tasks from the database
function fetchTasks() {
    global $conn;
    $sql = "SELECT * FROM Task";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Add a task
function addNewTask($title, $description) {
    global $conn;
    
    $sql = "INSERT INTO Task (title, description, created_at, updated_at, is_completed)
        VALUES (:title, :description, NOW(), NOW(), 0)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":description", $description);
    $stmt->execute();
}


//Remove a task
function deleteTask($conn, $id) {
    try {
        $stmt = $conn->prepare("DELETE FROM Task WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo "An error occured while trying to delete the task: " . $e->getMessage();
    }
}


//Mark task as done
function updateTask () {
    global $conn;
    
    if (isset($_POST["id"]) && isset($_POST["status"])) {
        $id = $_POST["id"];
        $status = $_POST["status"];

        updateTask($conn, $id, $status);
    }
}


//Edit a task
function editTask($conn, $id, $title, $description) {
    try {
        $stmt = $conn->prepare("UPDATE Task SET title = :title, description = :description, updated_at = NOW() WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);

        $stmt->execute();
        
    } catch (Exception $e) {
        echo "An error occurred while trying to edit the task: " . $e->getMessage();
    }
}


//Checkbox toggle
function toggleTask($conn, $id) {
    try {
        $stmt = $conn->prepare("UPDATE Task SET is_completed = NOT is_completed WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();
        
    } catch (PDOException $e) {
        error_log("Failed to toggle task " . $id . ": " . $e->getMessage());
    }
}

?>