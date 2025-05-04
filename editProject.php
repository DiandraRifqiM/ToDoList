<?php 

    // Call Func
    require 'func.php';

    // Check User Id
    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        echo "User ID not found or invalid.";
        exit;
    }

    $id = (int)$_GET["id"];
    $user = Query("SELECT * FROM users WHERE id = $id");

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
  <title>Edit Project</title>
  <link rel="stylesheet" href="css/editProject.css" />
</head>
<body>

  <!-- Add Project -->
  <div class="editProject">
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
      <button type="submit" name="addProject" id="addProject">Update Project</button>
      <a href="index.php?id=<?= $userData['id'] ?>" class="viewProjects">View Projects</a>
    </form>
  </div>

  <!-- Script -->
  <script src="add.js"></script>
</body>
</html>
