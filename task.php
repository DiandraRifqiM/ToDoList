<?php 

  session_start();

  // Check if user is logged in
  if (!isset($_SESSION["login"])) {
    header("Location: log.php");
    exit;
  }

  // Get user ID from session
  $userId = $_SESSION["user_id"];

  // Call Func 
  require 'func.php';

  // Validate ID
  if (!isset($_GET['id']) || !isset($userId)) {
      echo "Project ID or User ID not found.";
      exit;
  }

  $projectId = (int) $_GET['id'];    
  // $userId = (int) $_GET['user_id'];     

  // Get User Data
  $userData = Query("SELECT * FROM users WHERE id = $userId");
  if (!$userData) {
      echo "User not found.";
      exit;
  }
  $userData = $userData[0];
  $getUname = mysqli_real_escape_string($db, $userData["username"]);

  // Get project (regardless of owner)
  $getProjectData = Query("SELECT * FROM projects WHERE id = $projectId");
  if (!$getProjectData || count($getProjectData) === 0) {
      echo "No Project Found!";
      exit;
  }
  $getProject = $getProjectData[0];

  // Access control: allow if user owns or assigned to task in project
  $allowed = false;

  if ($getProject['user_id'] == $userId) {
      $allowed = true;
  } else {
      $checkAssign = Query("SELECT * FROM tasks WHERE project_id = $projectId AND assign = '$getUname' LIMIT 1");
      if (!empty($checkAssign)) {
          $allowed = true;
      }
  }

  if (!$allowed) {
      echo "You are not allowed to view this project.";
      exit;
  }

  // Handle status update
  if (isset($_POST["status"], $_POST["task_id"])) {
      $status = mysqli_real_escape_string($db, $_POST["status"]);
      $taskId = (int) $_POST["task_id"];

      $update = "UPDATE tasks SET status = '$status' WHERE id = $taskId";
      if (mysqli_query($db, $update)) {
          echo "<script>
                  alert('Status Updated!');
                  window.location.href = 'task.php?id=$projectId&user_id=$userId';
                </script>";
      } else {
          echo "<script>
                  alert('Error!');
                </script>";
      }
  }

  // Get tasks By Creator or Assign
  $getTask = Query("SELECT * FROM tasks 
                    WHERE project_id = $projectId 
                    AND (user_id = $userId OR assign = '$getUname')
                  ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Task</title>
  <link rel="stylesheet" href="css/task.css" />
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

  <div class="Task">
    <!-- Back Button -->
    <a href="index.php?id=<?= $userId ?>" class="iconButton">
      <i data-feather="arrow-left"></i>
    </a>

    <!-- Add Task Button -->
    <?php if ($getProject['user_id'] == $userId): ?>
      <a href="addTask.php?id=<?= $getProject['id']?>&user_id=<?= $getProject['user_id']?>" class="iconButton">
        <i data-feather="plus"></i>
      </a>
    <?php endif; ?>
  </div>

  <!-- Task Table -->
  <div class="taskTable">
    <?php if (!empty($getTask)): ?>
      <?php foreach($getTask as $task): ?>
        <div class="taskCard">
          <h2><?= htmlspecialchars($task['title'])?></h2>

          <a href="task.php?id=<?= $task['project_id']?>&user_id=<?= $userId ?>" class="Detail">
            <div class="description">
              Description: <?= htmlspecialchars($task['description'])?>
            </div>
          </a>

          <?php 
            // Get creator's username for this task
            $creatorId = (int) $task['user_id']; // Task creator ID
            $creatorData = Query("SELECT username FROM users WHERE id = $creatorId");
            $creatorUsername = $creatorData ? $creatorData[0]['username'] : 'Unknown';
          ?>

          <p>Created by: <?= htmlspecialchars($creatorUsername) ?></p>
          <p>Assigned to: <?= htmlspecialchars($task['assign'])?></p>

          <!-- Status Dropdown -->
          <form method="POST" action="">
            <input type="hidden" name="task_id" value="<?= $task['id']?>">

            <select
              name="status"
              class="statusDropdown 
                <?= strtolower($task['status']) === 'finished' ? 'green' : 
                    (strtolower($task['status']) === 'on progress' ? 'orange' : 'red') ?>"

              onchange="if (confirm('You sure?')) { this.form.submit(); } else { this.value = '<?= $task['status'] ?>'; }"
            >
              <option value="Finished" <?= $task['status'] === 'Finished' ? 'selected' : '' ?>>Finished</option>
              <option value="Not Finished" <?= $task['status'] === 'Not Finished' ? 'selected' : '' ?>>Not Finished</option>
              <option value="On Progress" <?= $task['status'] === 'On Progress' ? 'selected' : '' ?>>On Progress</option>
            </select>
          </form>

          <!-- Buttons -->
          <div class="buttons">
            <!-- Edit -->
            <button>
              <a href="editTask.php?id=<?= urlencode($task['id']) ?>&user_id=<?= urlencode($task['user_id']) ?>&project_id=<?= urlencode($task['project_id'])?>">
                <i data-feather="edit"></i>
              </a>
            </button>

            <!-- Delete -->
            <?php if ($task['user_id'] == $userId): ?>
              <button>
                <a href="del2.php?id=<?= urlencode($task['id']) ?>&user_id=<?= urlencode($task['user_id']) ?>&project_id=<?= urlencode($task['project_id'])?>" onclick="return confirm('You Sure ?')">
                  <i data-feather="trash-2"></i>
                </a>
              </button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center; padding: 2rem;">No tasks found for this project.</p>
    <?php endif; ?>
  </div>

  <script>feather.replace();</script>
  <script src="js/task.js"></script>
</body>
</html>
