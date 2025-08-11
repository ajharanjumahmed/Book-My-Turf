<?php
    session_start(); //start the session
    if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "owner") //if not logged in or not an owner
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
        <h3 id="heading">Turf On Pending</h3>
        <br>
        <p id="paragraph">Dear <?php echo $_SESSION["user_name"]; ?> , your turf is on pending on our system. Our Admin will verify your turf and approve it! <br> If your turf was approved before, the turf is on pending due to security issues.<br> Please contact us for re-approval. Thank you!</p>
        <br>
        <div id="submit-button">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>

</html>