<?php
session_start(); //start the session
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') // If not logged in or not an admin
{
    header("Location: login.php");
    exit();
}

// Approve turf
$turf_id = $_POST['pturf_id'];
$sql = "UPDATE turfs SET is_verified = TRUE WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $turf_id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>
