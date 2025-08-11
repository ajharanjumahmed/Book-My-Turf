<?php
session_start(); //start the session
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') // If not logged in or not an admin
{
    header("Location: login.php");
    exit();
}

// Reject turf (delete from database)
$turf_id = $_POST['pturf_id'];
$sql = "DELETE FROM turfs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $turf_id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>