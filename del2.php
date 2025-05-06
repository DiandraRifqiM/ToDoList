<?php 

    // Call Func
    require 'func.php';

    // Get Task and Project
    $id = (int)$_GET["id"];
    $user_id = (int)$_GET["user_id"];
    $project_id = (int)$_GET["project_id"];

    if (delTask($id, $user_id, $project_id) > 0) {
        echo "<script>
                alert('Task Deleted!');
                document.location.href='task.php?id=$project_id&user_id=$user_id';
              </script>";
    } else {
        echo "<script>
                alert('Error!');
                document.location.href='task.php?id=$project_id&user_id=$user_id';
              </script>";
    }
    

?>