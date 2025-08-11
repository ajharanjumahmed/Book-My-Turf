<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

//if form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //for changing name
    if(isset($_POST['edit_name']))
    {
        $new_name = $_POST['new_name'];
        $sql = "UPDATE users SET name=? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_name, $user_id);
        $stmt->execute();

        header("Location: edit_profile.php");
        exit();
    }

    //for changing number
    if(isset($_POST['edit_number']))
    {
        $new_name = $_POST['new_number'];
        $sql = "UPDATE users SET number=? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_number, $user_id);
        $stmt->execute();

        header("Location: edit_profile.php");
        exit();
    }

    //for changing number
    if(isset($_POST['edit_number']))
    {
        $new_number = $_POST['new_number'];
        $sql = "UPDATE users SET number=? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_number, $user_id);
        $stmt->execute();

        header("Location: edit_profile.php");
        exit();
    }

    //for changing email
    if(isset($_POST['edit_email']))
    {
        $new_email = $_POST['new_email'];
        $sql = "UPDATE users SET email=? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_email, $user_id);
        $stmt->execute();

        header("Location: edit_profile.php");
        exit();
    }

    //for changing password
    if(isset($_POST['edit_password']))
    {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_password, $user_id);
        $stmt->execute();

        header("Location: edit_profile.php");
        exit();
    }

    //for go to dashboard
    if(isset($_POST['back_to_dashboard'])){
        header("Location: user_dashboard.php");
        exit();
    }
}
?>