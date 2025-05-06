<?php 
    session_start();

    // Call Func
    require 'func.php';

    if(isset($_POST["login"])){

        $username = $_POST["username"];
        $password = $_POST["password"];

        $getUser = mysqli_query($db, "SELECT * FROM users WHERE username = '$username'");
        
        if(mysqli_num_rows($getUser) === 1){

            $getData = mysqli_fetch_assoc($getUser);

            if (password_verify($password, $getData["password"])) {
                $userId = $getData["id"];
            
                // Set session
                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $userId; // <-- Store user ID in session
                
                // Redirect to index.php with user_id as a query parameter
                header("Location: index.php?id=$userId");
                exit;
            }
            
        }
        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/log.css">
</head>
<body>
    <?php if(isset($error)): ?>
        <h1>Error: Invalid username or password!</h1>
    <?php endif; ?>
    <!-- Login Page -->
    <div class="Login">
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" id="username" required>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <button type="submit" name="login" id="login">Login</button>
            <a href="signIn.php" class="signIn">Sign In</a>
        </form>
    </div>
</body>
</html>
