<?php 

  // Call Function
  require 'func.php';

  if (!isset($_GET['id'])) {
      echo "User ID not provided.";
      exit;
  }

  $userId = (int)$_GET['id'];

  // Get Current User Data
  $userData = Query("SELECT * FROM users WHERE id = $userId");
  if (!$userData) {
      echo "User not found.";
      exit;
  }
  $userData = $userData[0];

  // Get Project By User Id
  $getProject = Query("SELECT * FROM projects WHERE user_id = $userId");
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
    <div class="searchBar">
      <i data-feather="search" class="search-icon"></i>
      <input type="text" name="search" placeholder="Search" autofocus />
    </div>
    <div class="navbar-nav">
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">Task</a></li>
        <li><a href=""><i data-feather="user"></i></a></li>
        <li><a href="login.php"><i data-feather="log-out"></i></a></li>
      </ul>
    </div>
  </nav>

  <!--Add Project-->
  <div class="createIcon">
    <a href="addProject.php?id=<?= $userId ?>" class="createLink">
      <i data-feather="plus"></i>
    </a>
  </div>

  <!-- Project Table -->
  <div class="projectTable">
    <?php foreach ($getProject as $project): ?>
      <div class="projectCard">
        <h2><?= htmlspecialchars($project['title']) ?></h2>

        <a href="projectDetail.php?id=<?= (int)$project['id'] ?>" class="Detail">
          <div class="description">
            Detail: <?= htmlspecialchars($project['description']) ?>
          </div>
        </a>

        <p>Created by: <?= htmlspecialchars($userData['name']) ?></p>

        <label for="statusSelect<?= $project['id'] ?>">Status:</label>
        <select
          id="statusSelect<?= $project['id'] ?>"
          class="statusDropdown 
            <?= strtolower($project['status']) === 'finished' ? 'green' : 
                (strtolower($project['status']) === 'on progress' ? 'orange' : 'red') ?>"
          onchange="updateStatus(this)"
        >
          <option value="Finished" <?= $project['status'] === 'Finished' ? 'selected' : '' ?>>Finished</option>
          <option value="Not Finished" <?= $project['status'] === 'Not Finished' ? 'selected' : '' ?>>Not Finished</option>
          <option value="On Progress" <?= $project['status'] === 'On Progress' ? 'selected' : '' ?>>On Progress</option>
        </select>


        <!-- Delete and Edit Button -->
        <div class="buttons">
          <!-- Edit -->
          <button>
            <a href="editProject.php">
              <i data-feather="edit"></i>
            </a>
          </button>

          <!-- Delete -->
          <button>
            <a href="del1.php?id=<?= urlencode($project['id'])?>&user_id=<?= urlencode($userId)?>" onclick="return confirm('You Sure ?')">
              <i data-feather="trash-2"></i>
            </a>
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Feather Icons Script -->
  <script>
    feather.replace();
  </script>

  <!-- Link JS -->
  <script src="script.js"></script>
</body>
</html>
