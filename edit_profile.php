<?php
include 'edit_profile_process.php';
if (!isset($_SESSION["user_id"])) //if the user is not logged in
{
    header("Location: login.php"); //redirect to the login page
    exit(); //stop running the script
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile_style.css">
</head>

<body>
    <div class="header">
        <h1>Edit Profile</h1>
    </div>
    <div class="card">
        <div class="edit_name">
            <form method="POST">
                <label>New Name</label>
                <input type="text" name="new_name" required>
                <button type="submit" name="edit_name">Set Name</button>
            </form>
        </div>
        <div class="edit_number">
            <form method="POST">
                <label>New Number</label>
                <input type="tel" name="new_number" pattern="[0-9]*" inputmode="numeric" maxlength="11" required>
                <button type="submit" name="edit_name">Set Number</button>
            </form>
        </div>
        <div class="edit_email">
            <form method="POST">
                <label>New Email</label>
                <input type="email" name="new_email" required>
                <button type="submit" name="edit_email">Set Email</button>
            </form>
        </div>
        <div class="edit_email">
            <form method="POST">
                <label>New Password</label>
                <input type="password" name="new_password" required>
                <button type="submit" name="edit_password">Set Password</button>
            </form>
        </div>
    </div>
    <div class="back_button">
        <form method="POST">
            <button type="submit" name="back_to_dashboard" id="back">Go to Dashboard</button>
        </form>
    </div>
</body>

</html>