<?php 

    session_start();

    // Check if user is logged in
    if (!isset($_SESSION["login"])) {
      header("Location: log.php");
      exit;
    }

    // Get user ID from session
    $userId = $_SESSION["user_id"];

    // Call Function
    require 'func.php';

    // Get User Id
    if (!isset($_GET['id']) || !isset($userId)) {
        echo "Project ID or User ID not found.";
        exit;
    }

    $projectId = (int) $_GET['id'];    
    // $userId = (int) $_GET['user_id'];     


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

    if(isset($_POST["addTask"])){
      
      if(addTask($_POST) > 0){
        echo "<script>
                  alert('New Task Added!');
                  document.location.href='task.php?id={$getProject['id']}&user_id={$getProject['user_id']}';
              </script>";
      } else {
      echo "<script>
              alert('Error!');
              document.location.href='addTask.php?id={$getProject['id']}&user_id={$getProject['user_id']}';
          </script>";    
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Task</title>
  <link rel="stylesheet" href="css/addTask.css" />
</head>
<body>

  <!-- Add Task -->
  <div class="AddTask">
    <form action="" method="post">
      <input type="hidden" name="project_id" value="<?= htmlspecialchars($getProject['id']) ?>" />
      <input type="hidden" name="user_id" value="<?= htmlspecialchars($getProject['user_id']) ?>" />
      <input type="text" name="title" id="title" placeholder="Title" required />
      <textarea
        name="description"
        id="description"
        placeholder="Description"
        required
      ></textarea>
      <input type="text" name="assign" placeholder="Assign to" />


      <!-- Add Status  -->
      <label for="statusSelect1">Status:</label>
      <select
        id="statusSelect1"
        class="statusDropdown green"
        name="status"
        onchange="updateStatus(this)"
      >
        <option value="Finished" selected>Finished</option>
        <option value="Not Finished">Not Finished</option>
        <option value="On Progress">On Progress</option>
      </select>

      <!-- Add Task Button -->
      <button type="submit" name="addTask" id="addTask">Add Task</button>
      <a href="task.php?id=<?= $getProject['id'] ?>&user_id=<?= $getProject['user_id']?>" class="viewTasks">View Tasks</a>
    </form>
  </div>

  <!-- Script -->
  <script src="js/add.js"></script>
</body>
</html>
