<?php
session_start(); //start the session
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') // If not logged in or not an admin
{
    header("Location: login.php");
    exit();
}

// Toggle verification status
$turf_id = $_POST['turf_id'];
$sql = "UPDATE turfs SET is_verified = NOT is_verified WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $turf_id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();

?>