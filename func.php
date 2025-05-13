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
        $username = stripslashes($data["username"]);
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

        // Delete tasks inside project
        mysqli_query($db, "DELETE FROM tasks WHERE project_id = '$id'");

        // Delete 
        mysqli_query($db, "DELETE FROM projects WHERE id = '$id' && user_id = '$user_id'");

        return mysqli_affected_rows($db);
    }


    // Update Project Function
    function updProject($data){
        global $db;

        // Get Current Data
        $id = mysqli_real_escape_string($db, (int)$data["id"]);
        $user_id = mysqli_real_escape_string($db, (int)$data["user_id"]);
        $title = mysqli_real_escape_string($db, htmlspecialchars($data["title"]));
        $description = mysqli_real_escape_string($db, htmlspecialchars($data["description"]));
        $status = mysqli_real_escape_string($db, htmlspecialchars($data["status"]));

        // Query For Update
        $updQuery = "UPDATE projects SET
                    title = '$title',
                    description = '$description',
                    status = '$status'
                    WHERE id = '$id' AND user_id = '$user_id'
                    ";
        return mysqli_query($db, $updQuery);

    }

    // Add Task Funciton
    function addTask($data){
        global $db;

        $title = htmlspecialchars($data["title"]);
        $description = htmlspecialchars($data["description"]);;
        $assign = htmlspecialchars($data["assign"]);
        $status = htmlspecialchars($data["status"]);
        $user_id = (int)$data["user_id"];
        $project_id = (int)$data["project_id"];

        // Check uname & name
        $getName = mysqli_query($db, "SELECT * FROM users WHERE username = '$assign' ");

        if(mysqli_fetch_assoc($getName)){
            echo  "<script>
                        alert('User Assigned!');
                    </script>";    
        }else{
            echo  "<script>
                        alert('User Not Found!');
                    </script>"; 
            return false;             
        }

        $addQuery = "INSERT INTO tasks VALUES ('', '$title', '$description', '$assign', '$status' ,'$user_id', '$project_id')";

        mysqli_query($db, $addQuery);

        return mysqli_affected_rows($db);

    }


    // Delete Task Funciton
    function delTask($id, $user_id, $project_id){
        global $db;
        mysqli_query($db, "DELETE FROM tasks WHERE id = '$id' && user_id = '$user_id' && project_id = '$project_id'");

        return mysqli_affected_rows($db);
    }


    // Edit Task
    function updTask($data){
        global $db;

        $id = mysqli_real_escape_string($db, $data["id"]);
        $user_id = mysqli_real_escape_string($db, $data["user_id"]);
        $project_id = mysqli_real_escape_string($db, $data["project_id"]);
        $title = mysqli_real_escape_string($db, $data["title"]);
        $description = mysqli_real_escape_string($db, $data["description"]);
        $assign = mysqli_real_escape_string($db, $data["assign"]);
        $status = mysqli_real_escape_string($db, $data["status"]);
    
        $updQuery = "UPDATE tasks SET
                        title = '$title',
                        description = '$description',
                        assign = '$assign',
                        status = '$status'
                        WHERE id = '$id' AND user_id = '$user_id' AND project_id = '$project_id'
                        ";
        
        return mysqli_query($db, $updQuery);
    }

    
    // Live Search Function
    function search($search){

        $srcQuery = "SELECT * FROM projects WHERE
                    title LIKE '%$search%' || description LIKE '%$search%'";
        

        return Query($srcQuery);
    }


?>