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
function addNewTask($title, $description, $type="Task list") { //ta bort type sen kanske
    global $conn;
    
    $sql = "INSERT INTO Task (title, description, type, created_at, updated_at)
            VALUES (:title, :description, 0, NOW(), NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}



//ta bort en task
function deleteTask($conn, $id) {
    try {
        $stmt = $conn->prepare("DELETE FROM Task WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo "An error occured while trying to delete the task: " . $e->getMessage();
    }

}



//markera task klar
function updateTask () {
    global $conn;
    
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        updateTask($conn, $id, $status);
    }
}



?>