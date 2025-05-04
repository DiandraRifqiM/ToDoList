<?php 

    // Connect DB
    $db = mysqli_connect("localhost:3307", "root", "", "todolist");


    // Print Data Function
    function Query($query){

        global $db;
        $result = mysqli_query($db, $query);
        $rows = [];
        
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }


    // Sign In Function
    function signIn($data){
        
        global $db;

        $name = stripslashes($data["name"]);
        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($db, $data["password"]);
        $password2 = mysqli_real_escape_string($db, $data["password2"]);
        
        $getUname = mysqli_query($db, "SELECT username FROM users WHERE username = '$username'");
        if(mysqli_fetch_assoc($getUname)){
            echo  "<script>
                        alert('Username already used!');
                    </script>";    
            return false;               
        }

        // Confirm Password Check
        if($password !== $password2){
            echo  "<script>
                        alert('Password not matched!');
                    </script>";    
            return false;        
        }

        // Password encrypted
        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($db ,"INSERT INTO users VALUES ('', '$name', '$username', '$password')");

        return mysqli_affected_rows($db);
    }


    // Add Data Project Function

    function addProject($data) {
        global $db;
    
        $user_id = (int)$data['user_id'];
        $title = htmlspecialchars($data['title']);
        $description = htmlspecialchars($data['description']);
        $status = htmlspecialchars($data['status']);
    
        $query = "INSERT INTO projects (user_id, title, description, status)
                  VALUES ('$user_id', '$title', '$description', '$status')";
    
        mysqli_query($db, $query);
    
        return mysqli_affected_rows($db);
    }
    

    // Delete Project Function

    function delProject($id, $user_id){
        global $db;
        mysqli_query($db, "DELETE FROM projects WHERE id = '$id' && user_id = '$user_id'");

        return mysqli_affected_rows($db);
    }
?>