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

  // Get current user
  $userData = Query("SELECT * FROM users WHERE id = $userId");
  if (!$userData) {
      echo "User not found.";
      exit;
  }
  $userData = $userData[0];

  // Get projects owned by user
  $getProject = Query("SELECT * FROM projects WHERE user_id = $userId");

  // Determine first relevant project (owned or assigned)
  $firstProjectId = null;

  if (!empty($getProject)) {
      $firstProjectId = (int)$getProject[0]['id'];
  } else {
      // Check if user is assigned to any task
      $username = mysqli_real_escape_string($db, $userData['username']);
      $assignedTask = Query("SELECT project_id FROM tasks WHERE assign = '$username' LIMIT 1");
      if (!empty($assignedTask)) {
          $firstProjectId = (int)$assignedTask[0]['project_id'];
      }
  }


  // Live Search
  if (isset($_POST["search"])) {
    $getProject = search(trim($_POST["search"]));
  }

  // Handle Status Change
  if (isset($_POST["status"]) && isset($_POST["project_id"])) {
      $status = mysqli_real_escape_string($db, $_POST["status"]);
      $projectId = (int)$_POST["project_id"];

      $update = "UPDATE projects SET status = '$status' WHERE id = $projectId AND user_id = $userId";
      if (mysqli_query($db, $update)) {
          echo "<script>
                  alert('Status Updated!');
                  document.location.href = 'index.php?id=$userId';
                </script>";
      } else {
          echo "<script>
                  alert('Error!');
                </script>";
      }
  }


  // Get assign 
  $getTask = Query("SELECT * FROM tasks");
  $getAssign = !empty($getTask) ? $getTask[0]['assign'] : null;
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quests</title>
  <link rel="stylesheet" href="css/index.css" />
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="#" class="navbar-logo">Que<span>2ts</span></a>

    <!-- Search Bar -->
    <form action="" method="post">   
      <div class="searchBar">
        <input type="text" name="search" placeholder="Search" autofocus />
        <i data-feather="search" class="search-icon"></i>
      </div>
    </form>

    <div class="navbar-nav">
      <ul>
        <li><a href="index.php?id=<?= $userId ?>">Home</a></li>
        <?php if ($firstProjectId): ?>
          <li>
            <a href="assignTask.php?user_id=<?= $userId ?>">Assign</a>
          </li>
        <?php else: ?>
          <li>
            <a href="#" onclick="alert('No projects or assigned tasks found.'); return false;">Assign</a>
          </li>
        <?php endif; ?>
        <li><a href="#"><i data-feather="user"></i></a></li>
        <li><a href="logout.php"><i data-feather="log-out"></i></a></li>
      </ul>
    </div>
  </nav>

  <!-- Add Project Button -->
  <div class="createIcon">
    <a href="addProject.php?id=<?= $userId ?>" class="createLink">
      <i data-feather="plus"></i>
    </a>
  </div>

  <!-- Project Table -->
  <div class="projectTable">
    <?php if (!empty($getProject)): ?>
      <?php foreach ($getProject as $project): ?>
        <div class="projectCard">
          <h2><?= htmlspecialchars($project['title']) ?></h2>
          <a href="task.php?id=<?= (int)$project['id'] ?>&user_id=<?= (int)$project['user_id']?>" class="Detail">
            <div class="description">
              Detail: <?= htmlspecialchars($project['description']) ?>
            </div>
          </a>
          <p>Created by: <?= htmlspecialchars($userData['name']) ?></p>

          <!-- Status Dropdown -->
          <form method="POST" action="">
            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
            <select
              name="status"
              class="statusDropdown 
                <?= strtolower($project['status']) === 'finished' ? 'green' : 
                    (strtolower($project['status']) === 'on progress' ? 'orange' : 'red') ?>"
              onchange="if (confirm('You sure?')) { this.form.submit(); } else { this.value = '<?= $project['status'] ?>'; }"
            >
              <option value="Finished" <?= $project['status'] === 'Finished' ? 'selected' : '' ?>>Finished</option>
              <option value="Not Finished" <?= $project['status'] === 'Not Finished' ? 'selected' : '' ?>>Not Finished</option>
              <option value="On Progress" <?= $project['status'] === 'On Progress' ? 'selected' : '' ?>>On Progress</option>
            </select>
          </form>

          <!-- Edit and Delete -->
          <div class="buttons">
            <button>
              <a href="editProject.php?id=<?= urlencode($project['id']) ?>&user_id=<?= urlencode($userId) ?>">
                <i data-feather="edit"></i>
              </a>
            </button>
            <button>
              <a href="del1.php?id=<?= urlencode($project['id']) ?>&user_id=<?= urlencode($userId) ?>" onclick="return confirm('You Sure ?')">
                <i data-feather="trash-2"></i>
              </a>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center; padding: 2rem; color: black;">You don’t own any projects yet. Assigned tasks are still accessible through the Task menu if available.</p>
    <?php endif; ?>
  </div>

  <!-- Feather Icons -->
  <script>
    feather.replace();
  </script>
  <script src="js/script.js"></script>
</body>
</html>
