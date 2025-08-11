<?php
session_start();
include 'db.php';

// Verify user authentication
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //For update profile
    if (isset($_POST['edit_profile'])) {
        header("Location: edit_profile.php");
        exit();
    }

    //For book turf
    if(isset($_POST['book_turf'])){
        $turf_id = $_POST['turf_id'];
        $turf_name = $_POST['turf_name'];
        $booking_date = $_POST['booking_date'];
        $booking_time = $_POST['booking_time'];
        $user_id = $_SESSION['user_id'];

        //recheck if the slot is available or not
        $recheck_sql = "SELECT booking_id FROM bookings WHERE turf_id = ? AND booking_date = ? AND booking_time=? AND is_booked = 1";
        $recheck_stmt = $conn->prepare($recheck_sql);
        $recheck_stmt->bind_param("iss", $turf_id, $booking_date, $booking_time);
        $recheck_stmt->execute();

        //if not available, stop the process showing error
        if($recheck_stmt->get_result()->num_rows > 0){
            die("The slot is already booked");
        }

        //if available, book it
        $book_sql = "INSERT INTO bookings (user_id, turf_id, booking_date, booking_time, is_booked) VALUES (?,?,?,?,1)";
        $book_stmt = $conn->prepare($book_sql);
        $book_stmt->bind_param("iiss", $user_id, $turf_id, $booking_date, $booking_time);
        $book_stmt->execute();
        header("Location: user_dashboard.php");
        exit();
    }

    //for rating
    if(isset($_POST['submit_rating'])){
        $turf_id = $_POST['turf_id'];
        $rating = $_POST['rating'];

        $update_sql = "INSERT INTO ratings (turf_id, user_id, rating) VALUES (?,?,?)";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iid", $turf_id, $user_id, $rating);
        $update_stmt->execute();
        header("Location: user_dashboard.php");
        exit();
    }
}
