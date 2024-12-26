<?php
require_once "./functions/functions.php";
require "./edit_task.php";

$tasks = fetchTasks();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['description'])) {
    addNewTask($_POST['title'], $_POST['description']);
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
        deleteTask($conn, $_POST['delete_id']);
    } elseif (isset($_POST['status']) && isset($_POST['id'])) {
        updateTask();
    }
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
                        <div class="popup-buttons">
                            <button type="submit"><img src="./assets/save-button.svg" alt="Save button"></button>
                            <a href="/" class="close-popup">Cancel</a> 
                        </div>
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
                            <form class="edit-task" action="edit_task.php" method="POST">
                            <button><a href="?edit_task=<?= $task['id'] ?>"><img src="./assets/edit-icon.svg" alt="Edit button"></a></button>
                            
                            <?php if ($editTask): ?>
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars(string: $task['id']) ?>">
                                <input type="text" name="title" value="<?= htmlspecialchars(string: $task['title']) ?>" required>
                                <textarea name="description" required><?= htmlspecialchars(string: $task['description']) ?></textarea>
                                <button type="submit">Save Changes</button>
                            <button type="submit">Cancel</button>
                            <?php endif; ?>
                            </form>


                            <!-- Delete-knapp -->
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <input type="hidden" name="delete_id" value="<?= $task['id'] ?>">
                                <button title="delete" name="delete" value="true">
                                <img src="./assets/delete-icon.svg" alt="Delete button">
                            </button>
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