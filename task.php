<?php 
require 'func.php';

// Get User Id and Project Id from URL
if (!isset($_GET['id']) || !isset($_GET['user_id'])) {
    echo "Project ID or User ID not found.";
    exit;
}

$projectId = (int) $_GET['id'];    
$userId = (int) $_GET['user_id'];     

// Get Current User Data
$userData = Query("SELECT * FROM users WHERE id = $userId");
if (!$userData) {
    echo "User not found.";
    exit;
}
$userData = $userData[0];
$getUname = mysqli_real_escape_string($db, $userData["username"]);

// Get Project By User ID
$getProjectData = Query("SELECT * FROM projects WHERE id = $projectId AND user_id = $userId");
if (!$getProjectData || count($getProjectData) === 0) {
    echo "No Project Found!";
    exit;
}
$getProject = $getProjectData[0];

// Get Task By User Id, Project Id, and Assign
$getTask = Query("SELECT * FROM tasks 
                  WHERE project_id = $projectId 
                  AND (tasks.user_id = $userId OR assign = '$getUname')");
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
    <a href="index.php?id=<?= $userData['id'] ?>" class="iconButton">
      <i data-feather="arrow-left"></i>
    </a>

    <!-- Add Task Button -->
    <a href="addTask.php?id=<?= $getProject['id']?>&user_id=<?= $getProject['user_id']?>" class="iconButton">
      <i data-feather="plus"></i>
    </a>
  </div>

  <!-- Task Table -->
  <div class="taskTable">
    <?php foreach($getTask as $task): ?>
      <div class="taskCard">
        <h2><?= htmlspecialchars($task['title'])?></h2>

        <a href="task.php?id=<?= $task['project_id']?>&user_id=<?= $userId ?>" class="Detail">
          <div class="description">
            Description: <?= htmlspecialchars($task['description'])?>
          </div>
        </a>

        <p>Created by: <?= htmlspecialchars($userData['username'])?></p>
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
            <a href="editTask.php?id=<?= $task['id'] ?>&user_id=<?= $userId ?>">
              <i data-feather="edit"></i>
            </a>
          </button>

          <!-- Delete -->
          <button>
            <a href="del2.php?id=<?= urlencode($task['id']) ?>&user_id=<?= urlencode($task['user_id']) ?>&project_id=<?= urlencode($task['project_id'])?>" onclick="return confirm('You Sure ?')">
              <i data-feather="trash-2"></i>
            </a>
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <script>feather.replace();</script>
  <script src="js/task.js"></script>
</body>
</html>
