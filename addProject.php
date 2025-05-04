<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" href="addProject.css">
</head>
<body>
    <?php
        $error = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = $_POST["Title"];
            $description = $_POST["Description"];
            $status = $_POST["status"]; // ambil status dari form
        }
    ?>

    <div class="AddProject">
        <?php if ($error): ?>
            <div class="error-message">Semua field wajib diisi.</div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="Title" placeholder="Title" required>
            <textarea name="description" placeholder="Description" required></textarea>

            <!-- Status Dropdown -->
            <label for="status">Status:</label>
            <select name="status" id="status" class="statusDropdown" required>
                <option value="">-- Pilih Status --</option>
                <option value="Finished">Finished</option>
                <option value="Unfinish">Unfinish</option>
                <option value="On Progress">On Progress</option>
            </select>

            <button type="submit" name="submit">Add Project</button>
            <a href="projectList.php" class="viewProjectsLink">View Projects</a>
        </form>
    </div>
</body>
</html>
