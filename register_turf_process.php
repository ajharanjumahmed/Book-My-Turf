<?php
    session_start(); //start the session
    include 'db.php'; //add the database connection
    if(!isset($_SESSION["user_id"]) || $_SESSION["user_role"] != "owner") //if not logged in or not an owner
    {
        header("Location: login.php"); //redirect to the login page
        exit();
    }

// Check if the owner already has a turf
$owner_id = $_SESSION['user_id'];
$sql_check = "SELECT id FROM turfs WHERE owner_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $owner_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {  //if already has a turf
    header("Location: owner_dashboard.php"); //redirect to dashboard
    exit();
}

// Image upload
$image_path = "uploads/default.jpg"; //set a default image if image is not included
if (!empty($_FILES['image']['name'])) { //checks if any image is uploaded
    $target_dir = "uploads/"; //sets the target location to store image
    $target_file = $target_dir . basename($_FILES['image']['name']); //concates the name of image file after uploads/ 
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file); //move the image from temporary storage to the target file
    $image_path = $target_file; //set the path of image
}

// Insert turf details into database
$name = $_POST['name'];
$location = $_POST['location'];
$zone = $_POST['zone'];
$hourly_rate = $_POST['new_hourly_rate'];
$sql = "INSERT INTO turfs (owner_id, hourly_rate, name, zone, location, image, is_verified) 
        VALUES (?, ?, ?, ?, ?, ?, FALSE)"; //keep the turf unverified [will be verified by admin]
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $owner_id, $hourly_rate, $name, $zone, $location, $image_path);
$stmt->execute();

header("Location: pending_approval.php"); //redirect to the pending approval page
exit();
?>