<?php 

    // Call Function
    require 'func.php';

    // Get User Id
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

    // Get Project By User ID
    $getProjectData = Query("SELECT * FROM projects WHERE id = $projectId AND user_id = $userId");


    if (!$getProjectData || count($getProjectData) === 0) {
        echo "No Project Found!";
        exit;
    }

    $getProject = $getProjectData[0];

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
  <div class="projectDetail">
    <!-- Tombol Back -->
    <a href="index.php?id=<?= $userData['id'] ?>" class="iconButton">
      <i data-feather="arrow-left"></i>
    </a>

    <!-- Tombol Add -->
    <a href="addTask.php?id=<?= $getProject['id']?>&user_id=<?= $getProject['user_id']?>" class="iconButton">
      <i data-feather="plus"></i>
    </a>
  </div>

  <script>
    feather.replace();
  </script>
</body>
</html>