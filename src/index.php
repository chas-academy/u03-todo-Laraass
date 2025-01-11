<?php
require_once "./functions/if-functions.php";
require_once "header.php";
?>

<body>
    <main>
        <div class="add-task-button">
            <a href="?add_task=true">
                <button><img src="./assets/add-task.svg" alt="Add new task"></button>
            </a>
        </div>

        <!-- Add a new task -->
        <section class="form">
            <?php
            $addNewTask = isset($_GET["add_task"]);
            if ($addNewTask):
            ?>
                <div class="add-task">
                    <form class="popup-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="text" name="title" placeholder="Title" required>
                        <textarea name="description" placeholder="Description..." required></textarea>
                        <div class="popup-buttons">
                            <a href="/" class="close-popup">Cancel</a>
                            <button type="submit">
                                <img src="./assets/save-button.svg" alt="Save button">
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </section>

        <!-- List with incompleted tasks -->
        <section class="task-list">
            <ul>
                <?php
                foreach ($tasks as $task):
                    if ($task["is_completed"] == 0):
                ?>
                        <li>
                            <div class="task">
                                <div class="top-row">
                                    <div class="top-left">
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                            <input type="hidden" name="id" value="<?= $task["id"] ?>">
                                            <button title="Checkbox" name="toggle_complete" value="<?= $task["id"] ?>">
                                                <i class="fa <?= ($task["is_completed"] == 1) ? "fa-check-circle" : "fa-circle-thin" ?>"></i>
                                            </button>
                                        </form>

                                        <h3><?= htmlspecialchars($task["title"]) ?></h3>
                                    </div>

                                    <div class="top-right">
                                        <!-- Edit button -->
                                        <form class="edit-task" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <a href="?edit_task=<?php echo $task["id"]; ?>" class="edit-button">
                                                <img src="./assets/edit-icon.svg" alt="Edit button">
                                            </a>
                                        </form>

                                        <?php if ($editTaskId === $task["id"]): ?>
                                            <div class="popup-form">
                                                <form class="edit-task" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($task["id"]); ?>">
                                                    <input type="text" name="edit_title" value="<?php echo htmlspecialchars($task["title"]); ?>" placeholder="Task Title" required>
                                                    <textarea name="edit_description" placeholder="Task Description" required><?php echo htmlspecialchars($task["description"]); ?></textarea>
                                                    <div class="popup-buttons">
                                                    <a href="index.php" class="close-popup">Cancel</a>
                                                    <button title="Edit" type="submit" name="save_edit">
                                                        <img src="./assets/save-button.svg" alt="Save button">
                                                    </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                        <!-- Delete button -->
                                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="delete_id" value="<?= $task["id"] ?>">
                                            <button title="Delete" name="delete" value="true">
                                                <img src="./assets/delete-icon.svg" alt="Delete button">
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <p><?= htmlspecialchars($task["description"]) ?></p>

                            </div>
                        </li>
                <?php
                    endif;
                endforeach;
                ?>
            </ul>
        </section>

        <!-- List with completed tasks -->
        <section class="task-list">
            <h1>Done</h1>
            <ul>
                <?php
                foreach ($tasks as $task):
                    if ($task["is_completed"] == 1):
                ?>
                        <li>
                            <div class="task">
                                <div class="top-row">
                                    <div class="top-left">
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                                            <input type="hidden" name="id" value="<?= $task["id"] ?>">
                                            <button title="Checkbox" name="toggle_complete" value="<?= $task["id"] ?>">
                                                <i class="fa fa-check-circle"></i>
                                            </button>
                                        </form>

                                        <h3><?= htmlspecialchars($task["title"]) ?></h3>
                                    </div>

                                    <div class="top-right">
                                        <!-- Edit button -->
                                        <form class="edit-task" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <a href="?edit_task=<?php echo $task["id"]; ?>" class="edit-button">
                                                <img src="./assets/edit-icon.svg" alt="Edit button">
                                            </a>
                                        </form>

                                        <?php if ($editTaskId === $task["id"]): ?>
                                            <div class="popup-form">
                                                <form class="edit-task" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($task["id"]); ?>">
                                                    <input type="text" name="edit_title" value="<?php echo htmlspecialchars($task["title"]); ?>" placeholder="Task Title" required>
                                                    <textarea name="edit_description" placeholder="Task Description" required><?php echo htmlspecialchars($task["description"]); ?></textarea>
                                                    <div class="popup-buttons">
                                                    <a href="index.php">Cancel</a>
                                                    <button title="Edit" type="submit" name="save_edit">
                                                        <img src="./assets/save-button.svg" alt="Save button">
                                                    </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Delete button -->
                                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="delete_id" value="<?= $task["id"] ?>">
                                            <button title="Delete" name="delete" value="true">
                                                <img src="./assets/delete-icon.svg" alt="Delete button">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p><?= htmlspecialchars($task["description"]); ?></p>
                            </div>
                        </li>
                <?php
                    endif;
                endforeach;
                ?>
            </ul>
        </section>
    </main>
</body>

</html>