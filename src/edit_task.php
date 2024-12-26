<?php
require "db.php";



$editTask = isset($_GET['edit_task']);
$editTask = null;
if ($editTask) {
    $taskId = $_GET['edit_task'];
    
        $stmt = $conn->prepare("SELECT * FROM Task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
        $editTask = $stmt->fetch(PDO::FETCH_ASSOC);
    
}

//redigera en task
function editTask($title, $description) {
    global $conn;
    
    $sql_edit = "UPDATE Task SET title = ?, description = ? WHERE id = ?";

    $stmt = $conn->prepare($sql_edit);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}


//eller kanske så???
$editTask = isset($_GET['edit_task']);
$sql_edit = "UPDATE Task SET title = ?, description = ? WHERE id = ?";
$editTask = null;
if ($editTask) {
    $taskId = $_GET['edit_task'];
    try {
        $stmt = $conn->prepare($sql_edit);
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
        $editTask = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching task: " . $e->getMessage();
    }
}

?>