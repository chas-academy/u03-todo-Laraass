<?php
require_once "db.php";

//hämta tasks från databasen
function fetchTasks() {
    global $conn;
    $sql = "SELECT * FROM Task";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//lägg till en task
function addNewTask($title, $description, $type="Task list") {
    global $conn;
    
    $sql = "INSERT INTO Task (title, description, type, created_at, updated_at)
            VALUES (:title, :description, 0, NOW(), NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}



//redigera en task
function editTask($title, $description) {
    global $conn;
    
    $sql = ("UPDATE Task SET title = :title, description = :description WHERE id = :id ");

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}


//ta bort en task
function deleteTask() {

}


//uppdatera en task
function updateTask () {

}



?>
