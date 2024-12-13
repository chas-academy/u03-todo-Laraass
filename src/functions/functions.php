<?php

// funktion för att spara en task
function saveTask($title, $description, $conn) {
    try {
        // Förbered SQL-frågan för att spara data i Task-tabellen
        $stmt = $conn->prepare("INSERT INTO Task (title, description, created_at, updated_at, is_completed) 
                                VALUES (:title, :description, NOW(), NOW(), 0)");

        // Bind parametrarna till värden från formuläret
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        // Kör SQL-frågan
        $stmt->execute();
        
        return true; // Returnera true om allt gick bra
    } catch (PDOException $e) {
        // Om något går fel
        echo "Failed to save task: " . $e->getMessage();
        return false;
    }
}


// Funktion för att skapa en ny task CREATE
function createTask($title, $description) {
    global $conn;

    try {
        // Förbered SQL-frågan för att infoga en ny task
        $stmt = $conn->prepare("INSERT INTO Task (title, description, created_at, updated_at, is_completed) VALUES (:title, :description, NOW(), NOW(), 0)");
        // Binda parametrar till SQL-frågan
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        // Exekvera frågan
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error creating task: " . $e->getMessage();
        return false;
    }
}


// Funktion för att uppdatera en task UPDATE
function updateTask($taskId, $title, $description) {
    global $conn;

    try {
        // Förbered SQL-frågan för att uppdatera en task
        $stmt = $conn->prepare("UPDATE Task SET title = :title, description = :description, updated_at = NOW() WHERE id = :id");
        
        // Binda parametrar till SQL-frågan
        $stmt->bindParam(':id', $taskId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        // Exekvera frågan
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error updating task: " . $e->getMessage();
        return false;
    }
}


// Funktion för att ta bort en task DELETE
function deleteTask($taskId) {
    global $conn;

    try {
        // Förbered SQL-frågan för att ta bort en task
        $stmt = $conn->prepare("DELETE FROM Task WHERE id = :id");

        // Binda parametrar till SQL-frågan
        $stmt->bindParam(':id', $taskId);

        // Exekvera frågan
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error deleting task: " . $e->getMessage();
        return false;
    }
}



?>
