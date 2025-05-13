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

    // Get Project and User id
    $id = (int)$_GET["id"];
    // $user_id = (int)$_GET["user_id"];

    if(delProject($id, $userId) > 0){
        echo "<script>
                alert('Project Deleted!');
                document.location.href='index.php?id=$userId'
            </script>";        
    }else{
        echo "<script>
                alert('Error!');
                document.location.href='index.php?id=$userId'
            </script>";     
    }

?>