<?php
require_once "./db.php";
require_once "./functions/functions.php";

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

$editTaskId = null;
if (isset($_GET['edit_task'])) {
    $editTaskId = (int)$_GET['edit_task'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['toggle_complete'])) {
    $task_id = $_POST['toggle_complete'];
    toggleTask($conn, $task_id);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}




$tasks = fetchTasks($conn);

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
                    <form class="popup-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
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
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                        <input type="hidden" name="id" value="<?= $task["id"] ?>">
                                        <button title="Toggle" name="toggle_complete" value="<?= $task["id"] ?>">
                                            <i class="fa <?= ($task["is_completed"] == 1) ? 'fa-check-circle' : 'fa-circle-thin' ?>"></i>
                                        </button>
                                    </form>

                                    <h3><?= htmlspecialchars($task['title']) ?></h3>
                                </div>

                                <div class="top-right">
                                    <!-- Edit-knapp-->
                                    <form class="edit-task" method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <a href="?edit_task=<?php echo $task['id']; ?>" class="edit-button">
                                            <img src="./assets/edit-icon.svg" alt="Edit button">
                                        </a>
                                    </form>

                                    <?php if ($editTaskId === $task['id']): ?>
                                        <div class="popup-form">
                                            <form class="edit-task" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                                                <input type="text" name="edit_title" value="<?php echo htmlspecialchars($task['title']); ?>" placeholder="Task Title" required>
                                                <textarea name="edit_description" placeholder="Task Description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
                                                <button type="submit" name="save_edit">
                                                    <img src="./assets/save-button.svg" alt="Save button">
                                                </button>
                                                <a href="index.php">Cancel</a>
                                            </form>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Delete-knapp -->
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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