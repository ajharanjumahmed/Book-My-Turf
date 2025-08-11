<?php
    session_start(); //start the session
    include "db.php"; //include the database connection

    if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "owner") //if not logged in or not an owner
    {
        header("Location: login.php"); //redirect to the login page
        exit();
    }

    //check if the user already registered a turf or not
    $owner_id = $_SESSION["user_id"];
    $sql = "SELECT id FROM turfs WHERE owner_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $owner_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) //if user already have a turf
    {
        header("Location: owner_dashboard.php"); //redirect to the dashbaoard
        exit();
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New Turf</title>
    <link rel="stylesheet" href="register_turf_style.css">
</head>
<body>
    <div class="main-frame">
        <h2 id="header">Register your turf</h2>
        <div class="form-body">
            <form  class = "form"  action="register_turf_process.php" method="POST" enctype="multipart/form-data">
                <div class="tname">
                    <label class="label">Turf name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="tzone">
                    <label class="label">Zone</label>
                    <select id="select_time" name="zone" required>
                    <option value="Inside Sylhet City">Inside Sylhet City Corporation</option>
                    <option value="Outside Sylhet City">Outside Sylhet City Corporation</option>
                    </select>
                </div>
                <div class="tlocation">
                    <label class="label">Location</label>
                    <input type="text" name="location" required>
                </div>
                <div class="trate">
                    <label class="label">Hourly Rate</label>
                    <input type="number" name="new_hourly_rate" step="50" required>
                </div>
                <div class="timage">
                    <label class="label">Image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="submit">
                    <input type="submit" value="Submit for Approval">
                </div>
            </form>
        </div>
    </div>
</body>
</html>