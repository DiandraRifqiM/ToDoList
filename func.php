<?php 

    // Connect DB
    $db = mysqli_connect("localhost:3307", "root", "", "todolist");

    // Sign In Function
    function signIn($data){
        
        global $db;

        $name = strtolower(stripslashes($data["name"]));
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

?>