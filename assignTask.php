<?php
// allTasks.php

require 'func.php';

if (!isset($_GET['user_id'])) {
    echo "User ID not provided.";
    exit;
}

$userId = (int)$_GET['user_id'];

// Get user
$userData = Query("SELECT * FROM users WHERE id = $userId");
if (!$userData) {
    echo "User not found.";
    exit;
}
$userData = $userData[0];
$username = mysqli_real_escape_string($db, $userData['username']);

// Get all tasks assigned to the user
$getTasks = Query("SELECT * FROM tasks WHERE assign = '$username' ORDER BY project_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assigned Tasks</title>
    <link rel="stylesheet" href="css/task.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<!-- Back Button -->
<div class="Task">
    <a href="index.php?id=<?= $userId ?>" class="iconButton">
        <i data-feather="arrow-left"></i>
    </a>
</div>

<div class="taskTable">
    <?php if (!empty($getTasks)): ?>
        <?php foreach ($getTasks as $task): ?>
            <?php
                $projectId = (int)$task['project_id'];
                $projectData = Query("SELECT title FROM projects WHERE id = $projectId");
                $projectTitle = !empty($projectData) ? $projectData[0]['title'] : 'Unknown Project';

                $creatorId = (int) $task['user_id'];
                $creatorData = Query("SELECT username FROM users WHERE id = $creatorId");
                $creatorUsername = $creatorData ? $creatorData[0]['username'] : 'Unknown';
            ?>

            <div class="taskCard">
                <h2><?= htmlspecialchars($task['title']) ?></h2>
                <div class="description">
                    Description: <?= htmlspecialchars($task['description']) ?>
                </div>
                <p>Project: <?= htmlspecialchars($projectTitle) ?></p>
                <p>Created by: <?= htmlspecialchars($creatorUsername) ?></p>
                <p>Assigned to: <?= htmlspecialchars($task['assign']) ?></p>

                <!-- View Task -->
                <a href="task.php?id=<?= $task['project_id'] ?>&user_id=<?= $userId ?>" class="Detail">
                    <button style="margin-top: 0.5rem;">
                        More Detail
                    </button>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; padding: 2rem; color: black;">No tasks assigned to you.</p>
    <?php endif; ?>
</div>

<script>feather.replace();</script>
</body>
</html>
