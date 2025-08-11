<?php
    session_start(); //start a php session to track the logged in user
    include 'db.php'; //include the connection to database file

    //Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    //Fetch the user from the database
    $sql = "SELECT id, name, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql); //store the prepared SQL query in $stmt
    $stmt->bind_param('s', $email); //fills the value of placeholde with $email value
    $stmt->execute(); //runs the query
    $result = $stmt->get_result(); //gets the result and stores it in $result

    if($result->num_rows == 1)//if the user exists
    { 
        $user = $result->fetch_assoc(); //store the user data in $user
        if(password_verify($password, $user["password"]))
        { //check if password matches
            //save user info in the session
            $_SESSION["user_id"] = $user["id"]; //store user id
            $_SESSION["user_name"] = $user["name"]; //store user name
            $_SESSION["user_role"] = $user["role"]; //store user role

            //redirect user to their respective dashboard based on their roles
            if($user["role"]=="owner") //if the user is a turf owner
            {
                header("Location: owner_dashboard.php"); //redirect to owners dashboard
                exit(); //stop the script
            }
            else if($user["role"]=="user") //if the user is a general user
            { 
                header("Location: user_dashboard.php"); //redirect to the user dashboard
                exit(); //stop the script
            }
            else if($user["role"]=="admin") //if the user is an admin
            { 
                header("Location: admin_dashboard.php"); //redirect to the admin dashboard
                exit(); //stop the script
            }
        }
        else //password didn't match
        {
            echo"Incorrect Password!"; 
        }
    }
    else //the given email is not available in the database
    {
        echo"User not found";
    }

    $conn->close(); //stop the database connection

?>