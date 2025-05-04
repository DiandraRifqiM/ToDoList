<?php 

    // Call Func
    require 'func.php';

    // Get Project and User id
    $id = (int)$_GET["id"];
    $user_id = (int)$_GET["user_id"];

    if(delProject($id, $user_id) > 0){
        echo "<script>
                alert('Project Deleted!');
                document.location.href='index.php?id=$user_id'
            </script>";        
    }else{
        echo "<script>
                alert('Error!');
                document.location.href='index.php?id=$user_id'
            </script>";     
    }

?>