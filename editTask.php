<?php

  // Call Func
  require 'func.php';

  if (!isset($_GET['id'], $_GET['user_id'], $_GET['project_id'])) {
      echo "Missing required parameters.";
      exit;
  }

  $taskId = (int) $_GET['id'];
  $userId = (int) $_GET['user_id'];
  $projectId = (int) $_GET['project_id'];

  // Get User Data
  $userData = Query("SELECT * FROM users WHERE id = $userId");
  if (!$userData) {
      echo "User not found.";
      exit;
  }
  $userData = $userData[0];
  $username = mysqli_real_escape_string($db, $userData["username"]);

  // Get Project
  $getProjectData = Query("SELECT * FROM projects WHERE id = $projectId");
  if (!$getProjectData) {
      echo "Project not found.";
      exit;
  }
  $getProject = $getProjectData[0];

  // Get Task
  $taskData = Query("SELECT * FROM tasks WHERE id = $taskId AND project_id = $projectId");
  if (!$taskData) {
      echo "Task not found.";
      exit;
  }
  $task = $taskData[0];

  // Access Control
  $allowed = ($getProject['user_id'] == $userId || $task['assign'] == $username);
  if (!$allowed) {
      echo "You are not allowed to edit this task.";
      exit;
  }

  // Handle Update
  if (isset($_POST["editTask"])) {
      $_POST["id"] = $taskId; // Ensure task ID is passed
      if (updTask($_POST)) {
          echo "<script>
                  alert('Task Updated!');
                  window.location.href = 'task.php?id=$projectId&user_id=$userId';
                </script>";
      } else {
          echo "<script>alert('Error!');</script>";
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Task</title>
  <link rel="stylesheet" href="css/editTask.css" />
</head>
<body>

<div class="EditTask">
  <form action="" method="post">
    <!-- Hidden fields -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>" />
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($userId) ?>" />
    <input type="hidden" name="project_id" value="<?= htmlspecialchars($projectId) ?>" />

    <!-- Task title -->
    <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($task['title']) ?>" required />

    <!-- Task description -->
    <textarea name="description" placeholder="Description" required><?= htmlspecialchars($task['description']) ?></textarea>

    <!-- Assigned user -->
    <input type="text" name="assign" placeholder="Assign to" value="<?= htmlspecialchars($task['assign']) ?>" />

    <!-- Status dropdown -->
    <label for="statusSelect1">Status:</label>
    <select name="status" id="statusSelect1" class="statusDropdown <?= strtolower($task['status']) === 'finished' ? 'green' : (strtolower($task['status']) === 'on progress' ? 'orange' : 'red') ?>">
      <option value="Finished" <?= $task['status'] === 'Finished' ? 'selected' : '' ?>>Finished</option>
      <option value="Not Finished" <?= $task['status'] === 'Not Finished' ? 'selected' : '' ?>>Not Finished</option>
      <option value="On Progress" <?= $task['status'] === 'On Progress' ? 'selected' : '' ?>>On Progress</option>
    </select>

    <!-- Buttons -->
    <button type="submit" name="editTask" id="editTask">Edit Task</button>
    <a href="task.php?id=<?= $projectId ?>&user_id=<?= $userId ?>" class="viewTasks">View Tasks</a>
  </form>
</div>

<script src="js/edit.js"></script>
</body>
</html>
