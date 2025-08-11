<?php
session_start(); //start the session
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'owner') // If not logged in or not an owner
{  
    header("Location: login.php");
    exit();
}

//check if the owner already has a turf or a pending request
$owner_id = $_SESSION["user_id"];
$sql = "SELECT id, is_verified FROM turfs WHERE owner_id = ?"; //check if there is any turf having given owner_id
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) //if there is any turf present
{
    $turf = $result->fetch_assoc(); //fetch the info of that turf
    if($turf["is_verified"]) //check if the turf is verified
    {
        header("Location: manage_turf.php"); //redirect to manage_turf page
        exit();
    }
    else //if the turf is not verifies
    {
        header("Location: pending_approval.php"); //redirect to pending_approval message page
        exit();
    }
}
else //if there is no turf registered for that particular user
{
    header("Location: register_turf.php"); //redirect to turf_registration page
    exit();
}

?>

