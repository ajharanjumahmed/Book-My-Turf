<?php
    session_start(); //start the session
    if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "user") //if not logged in or not an owner
    {
        header("Location: login.php"); //redirect to the login page
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval</title>
    <link rel="stylesheet" href="pending_approval_style.css">
</head>

<body>
    <div class="box">
        <h3 id="heading">Your Account is Blocked!</h3>
        <br>
        <p id="paragraph">Dear <?php echo $_SESSION["user_name"]; ?> , Your account is currently blocked in our system due to some security issues. <br>Please contact us to unblock your account.</p>
        <br>
        <div id="submit-button">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>

</html>