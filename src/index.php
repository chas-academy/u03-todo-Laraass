


<?php
/*DET ÄR FEL PÅ header("Location: /");*/
require_once './functions/functions.php';
require 'db.php';
require 'header.php';

// Hämta alla tasks från databasen
try {
    $stmt = $conn->query("SELECT * FROM Task WHERE is_completed = 0 ORDER BY created_at DESC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Failed to fetch tasks: " . $e->getMessage();
}

// Kontrollerar att formuläret har skickats via POST (funktion för att spara en task)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hämtar data från formuläret
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;

    // Kontrollerar att alla fält är ifyllda
    if (!empty($title) && !empty($description)) {
        try {
            // Förbered SQL-frågan för att spara data i Task-tabellen
            $stmt = $conn->prepare("INSERT INTO Task (title, description, created_at, updated_at, is_completed) 
                                    VALUES (:title, :description, NOW(), NOW(), 0)");

            // Bind parametrarna till värden från formuläret
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);

            // Kör SQL-frågan
            $stmt->execute();

            // Tar användaren tillbaka till index efter sparad task
            header("Location: /");
            exit;
        } catch (PDOException $e) {
            // Visa felmeddelande om ett fel inträffar
            echo "Failed to save task: " . $e->getMessage();
        }
    } else {
        // Visa felmeddelande om ett fält saknas
        echo "Title and description are required.";
    }

/*FUNKAR EJ MED DETTA } else {
    // Dirigera till index om en användare försöker nå sidan utan att skicka POST
    header("Location: /");
    exit;*/
}

// CRUD (CREATE) Kontrollera om formuläret för att skapa en task har skickats
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['description'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Anropa funktionen för att skapa tasken
    $isCreated = createTask($title, $description);

    if ($isCreated) {
        // Om tasken skapades, omdirigera till index.php för att visa uppgifterna
        header("Location: /");
        exit;
    }
}

// CRUD UPDATE Hantera uppdatering av en task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['task_id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $taskId = $_POST['task_id'];

    // Anropa funktionen för att uppdatera tasken
    $isUpdated = updateTask($taskId, $title, $description);

    if ($isUpdated) {
        // Om tasken uppdaterades, omdirigera till index.php för att visa de uppdaterade uppgifterna
        header("Location: /");
        exit;
    }
}

// Om användaren vill redigera en task
$isEditTask = isset($_GET['edit_task']);
$editTask = null;
if ($isEditTask) {
    $taskId = $_GET['edit_task'];
    try {
        $stmt = $conn->prepare("SELECT * FROM Task WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
        $editTask = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching task: " . $e->getMessage();
    }
}

// CRUD DELETE Kontrollera om en task ska tas bort
if (isset($_GET['delete_task'])) {
    $taskId = $_GET['delete_task'];

    // Anropa funktionen för att ta bort tasken
    $isDeleted = deleteTask($taskId);

if ($isDeleted) {
    // Om tasken tas bort, omdirigera till index.php för att visa den uppdaterade listan
    header("Location: /");
    exit;
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Do It!</title>
    <link rel="stylesheet" href="./style/style.scss">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
</head>

<body>
    <main>
        <!--Knapp för att lägga till ny uppgift-->
        <div class="add-task-button">
            <a href="?add_task=true">
                <button><img src="./assets/add-task.svg" alt="Add new task"></button>
            </a>
        </div>
        <section class="form">
            <!--Popup formulär vid "Add new task" klick-->
            <?php
                // Kontrollerar om "Add new task"-knappen har klickats
                $isAddNewTask = isset($_GET['add_task']);

                if ($isAddNewTask): ?>
                    <div class="add-task">
                            <form class="popup-form" action="save_task.php" method="POST">
                                <input type="text" name="title" placeholder="Title" required>
                                <textarea name="description" placeholder="Description..." required></textarea>
                                <button type="submit"><img src="./assets/save-button.svg" alt="Save button"></button>
                                <a href="/" class="close-popup">Cancel</a> <!--Stänger popup-formuläret-->
                            </form>
                        </div>
                <?php endif; ?>
                        <?php
                        
                        //PDO för att ansluta till databasen

                        ?>
        </section>
                <!-- Lista med tasks -->
        <section class="task-list">
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li>
                        <div class="task">
                            <div class="checkbox">
                            <button title="undone"><i class="fa fa-circle-thin-"></i></button>
                            <button title="done"><i class="fa fa-check-circle"></i></button>
                            </div>

                            <h3><?= htmlspecialchars($task['title']) ?></h3>
                            <p><?= htmlspecialchars($task['description']) ?></p>
                            
                            <!-- Edit-knapp -->
                            <div class="action-button">
                            <button><a href="?edit_task=<?= $task['id'] ?>"><img src="./assets/edit-icon.svg" alt="Edit button"></a></button>
                            </div>
                            
                            <!--funkar ej-->
                            <?php if ($isEditTask && $editTask): ?>
                            <div class="edit-task">
                            <form class="popup-form" action="index.php" method="POST">
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars($editTask['id']) ?>">
                                <input type="text" name="title" value="<?= htmlspecialchars($editTask['title']) ?>" required>
                                <textarea name="description" required><?= htmlspecialchars($editTask['description']) ?></textarea>
                                <button type="submit">Save Changes</button>
                            </form>
                            <a href="/" class="close-popup">Cancel</a>
                            <?php endif; ?>
                            </div>


                            <!-- Delete-knapp -->
                            <div class="action-button">
                            <button><a href="?delete_task=<?= $task['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?')">
                            <img src="./assets/delete-icon.svg" alt="Delete button"></a></button>
                            </div>
                            
                            </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>



    </main>
</body>
</html>


<!--<label for="checkbox">
                            <input type="checkbox" id="checkbox">
                            <span>
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8.5" cy="8.5" r="8" stroke="#0B0824"/>
                            </svg>
                            checkbox
                            </span>
                        </label>-->
                        
                        <!--<input type="checkbox" id="toggle">
                        <div class="control-me">control me</div>-->