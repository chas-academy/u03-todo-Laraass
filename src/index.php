<?php
require_once "./functions/functions.php";

$tasks = fetchTasks();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['description'])) {
    addNewTask($_POST['title'], $_POST['description']);
    header("Location: index.php");
    exit();
}

require_once "header.php";
?>

<body>
    <main>
        <div class="add-task-button">
            <a href="?add_task=true">
                <button><img src="./assets/add-task.svg" alt="Add new task"></button>
            </a>
        </div>
        <section class="form">
            <?php
                $addNewTask = isset($_GET['add_task']);
                if ($addNewTask):
            ?>
                <div class="add-task">
                    <form class="popup-form" action="index.php" method="POST">
                        <input type="text" name="title" placeholder="Title" required>
                        <textarea name="description" placeholder="Description..." required></textarea>
                        <button type="submit"><img src="./assets/save-button.svg" alt="Save button"></button>
                        <a href="/" class="close-popup">Cancel</a> 
                    </form>
                </div>
                <?php endif; ?>
        </section>

        <!-- Lista med tasks -->
        <section class="task-list">
            <ul>
                <?php
                foreach ($tasks as $task): 
                ?>
                    <li>
                        <div class="task">
                            <div class="top-row">
                            <div class="top-left">
                            <form class="checkbox" action="index.php">
                            <button>
                                    <?php if (isset($task["is_completed"])): ?>
                                    <i class="fa fa-check-circle"></i>
                                    <?php else: ?>
                                    <i class="fa fa-circle-thin"></i>
                                    <?php endif ?>
                            </button>
                            </form>
                            
                            <h3><?= htmlspecialchars($task['title']) ?></h3>
                            </div>

                            <div class="top-right">
                            <!-- Edit-knapp -->
                            <form action="edit_task.php">
                            <button><a href="?edit_task=<?= $task['id'] ?>"><img src="./assets/edit-icon.svg" alt="Edit button"></a></button>
                            </form>
                            
                            <!--funkar ej-->
                            <?php if ($editTask): ?>
                            <form class="edit-task" action="index.php">
                            <form class="popup-form" action="index.php" method="POST">
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars($editTask['id']) ?>">
                                <input type="text" name="title" value="<?= htmlspecialchars($editTask['title']) ?>" required>
                                <textarea name="description" required><?= htmlspecialchars($editTask['description']) ?></textarea>
                                <button type="submit">Save Changes</button>
                            </form>
                            <button type="submit">Cancel</button>
                        
                            <?php endif; ?>
                            </form>


                            <!-- Delete-knapp -->
                            <?php
                                if(isset($_GET["delete"])) {
                                    $id = $_GET["delete"];
                                    $conn->query("DELETE FROM Task WHERE id = 'id'");
                                }
                            ?>
                            <form class="action-button" action="index.php">
                            <button><a href="?delete_task=<?= $task['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?')">
                            <img src="./assets/delete-icon.svg" alt="Delete button"></a></button>
                            </form>
                            </div>
                            </div>
                            

                            <p><?= htmlspecialchars($task['description']) ?></p>
                            
                            
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