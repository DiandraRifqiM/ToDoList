<?php 

    // call Func
    require 'func.php';

    if(isset($_POST["signin"])){

        if(signIn($_POST) > 0){
            echo  "<script>
                        alert('Sign In Success!');
                    </script>";
            header("Location: log.php");
            exit;
        }else{
            echo mysqli_error($db);
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
    <link rel="stylesheet" href="css/signIn.css">
</head>
<body>
    <!-- Sign In Page -->
     <div class="SignIn">
         <form action="" method="post">
             <input type="text" name="name" placeholder="Name" id="name" required>
             <input type="text" name="username" placeholder="Username" id="username" required>
             <input type="password" name="password" placeholder="Password" id="password" required>
             <input type="password" name="password2" placeholder="Confim Password" id="password2" required>
             <button type="submit" name="signin" id="signin"> Sign In</button>
             <a href="log.php" class="login">Login</a>
         </form>
     </div>
</body>
</html>