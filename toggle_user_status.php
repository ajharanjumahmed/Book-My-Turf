<?php
session_start(); //start the session
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') // If not logged in or not an admin
{
    header("Location: login.php");
    exit();
}

// Toggle user status
$user_id = $_POST['user_id'];
$sql = "UPDATE users SET status = IF(status='active', 'banned', 'active') WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>