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

    // Check User Id
    if (!isset($_GET["id"]) || !is_numeric($userId)) {
        echo "User ID not found or invalid.";
        exit;
    }

    $id = (int)$_GET["id"];
    $user = Query("SELECT * FROM users WHERE id = $userId");

    if (!$user) {
        echo "User not found.";
        exit;
    }

    $userData = $user[0];

    
    if (isset($_POST["addProject"])) {
        if (addProject($_POST) > 0) {
            echo "<script>
                    alert('New Project Added!');
                    document.location.href='index.php?id={$userData['id']}';
                </script>";
        } else {
            echo "<script>
                    alert('Error!');
                    document.location.href='addProject.php?id={$userData['id']}';
                </script>";    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Project</title>
  <link rel="stylesheet" href="css/addProject.css" />
</head>
<body>

  <!-- Add Project -->
  <div class="AddProject">
    <form action="" method="post">
      <input type="hidden" name="user_id" value="<?= htmlspecialchars($userData['id']) ?>" />
      <input type="text" name="title" id="title" placeholder="Title" required />
      <textarea
        name="description"
        id="description"
        placeholder="Description"
        required
      ></textarea>

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

      <!-- Add Project Button -->
      <button type="submit" name="addProject" id="addProject">Add Project</button>
      <a href="index.php?id=<?= $userData['id'] ?>" class="viewProjects">View Projects</a>
    </form>
  </div>

  <!-- Script -->
  <script src="add.js"></script>
</body>
</html>
