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

  // Update Process
  if (isset($_POST["updProject"])) {
      if (updProject($_POST) > 0) {
          echo "<script>
                  alert('Project Updated!');
                  document.location.href = 'index.php?id={$userData['id']}';
                </script>";
      } else {
          echo "<script>
                  alert('Error!');
                  document.location.href = 'updProject.php?id={$userData['id']}';
                </script>";
      }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update Project</title>
  <link rel="stylesheet" href="css/editProject.css" />
</head>
<body>

  <!-- Add Project -->
  <div class="editProject">
    <form action="" method="post">
      <input type="hidden" name="id" value="<?= htmlspecialchars($getProject['id']) ?>" />
      <input type="hidden" name="user_id" value="<?= htmlspecialchars($userData['id']) ?>" />
      <input type="text" name="title" id="title" placeholder="Title" value="<?= htmlspecialchars($getProject['title'])?>" required />
      <textarea
        name="description"
        id="description"
        placeholder="Description"
        required
        ><?= htmlspecialchars($getProject['description'])?></textarea>

      <!-- Add Status  -->
      <label for="statusSelect1">Status:</label>
      <select
        id="statusSelect1"
        class="statusDropdown green"
        name="status"
        value="<?= htmlspecialchars($getProject['status'])?>"
        onchange="updateStatus(this)"
      >
        <option value="Finished" selected>Finished</option>
        <option value="Not Finished">Not Finished</option>
        <option value="On Progress">On Progress</option>
      </select>

      <!-- Add Project Button -->
      <button type="submit" name="updProject" id="updProject" onclick="return confirm('You sure ?')">Update Project</button>
      <a href="index.php?id=<?= $userData['id'] ?>" class="viewProjects">View Projects</a>
    </form>
  </div>

  <!-- Script -->
  <script src="add.js"></script>
</body>
</html>
