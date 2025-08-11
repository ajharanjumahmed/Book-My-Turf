<?php
session_start();
include 'db.php';

// Verify owner authentication
if ($_SESSION['user_role'] != 'owner') {
    header("Location: login.php");
    exit();
}

// Get owner's turf information
$owner_id = $_SESSION['user_id'];
$turf_sql = "SELECT * FROM turfs WHERE owner_id = ?";
$turf_stmt = $conn->prepare($turf_sql);
$turf_stmt->bind_param("i", $owner_id);
$turf_stmt->execute();
$turf_result = $turf_stmt->get_result();

if ($turf_result->num_rows == 0) {
    die("No turf found for this owner");
}

$turf = $turf_result->fetch_assoc();
$turf_id = $turf['id'];

//When the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //when turf visibility is toggled
    if(isset($_POST['toggle_visibility']))
    {
        $new_visibility = $turf['visibility'] ? 0 : 1;
        $update_sql = "UPDATE turfs SET visibility = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_visibility, $turf_id);
        $update_stmt->execute();
        $turf['visibility'] = $new_visibility;

        header("Location: manage_turf.php");
        exit();
    }

    //when hourly rate is set
    if(isset($_POST['set_hourly_rate'])){
        $new_hourly_rate = $_POST['new_hourly_rate'];
        $update_rate_sql = "UPDATE turfs SET hourly_rate = ? WHERE id = ?";
        $update_rate_stmt = $conn->prepare($update_rate_sql);
        $update_rate_stmt->bind_param("ii", $new_hourly_rate, $turf_id);
        $update_rate_stmt->execute();

        header("Location: manage_turf.php");
        exit();
    }
    
    //For custom booking
    if(isset($_POST['book_slot']))
    {
        $custom_name = $_POST['custom_name'];
        $custom_number = $_POST['custom_number'];
        $booking_date = $_POST['select_date'];
        $booking_time = $_POST['select_time'];
        
        //check if the desired slot is not available
        $check_sql = "SELECT * FROM bookings WHERE booking_date = ? AND booking_time = ? AND is_available = 0";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("ss", $booking_date, $booking_time);
        $stmt_check->execute();

        $available_slot = $stmt_check->get_result();
        
        //if the slot is available
        if($available_slot->num_rows == 0) {

            //check if the slot is already booked?
            $check_book_sql = "SELECT booking_id FROM bookings WHERE booking_date = ? AND booking_time = ? AND turf_id = ? AND is_booked = 1 ";
            $check_book_stmt = $conn->prepare($check_book_sql);
            $check_book_stmt->bind_param("ssi", $booking_date, $booking_time, $turf_id);
            $check_book_stmt->execute();
            $check_book_result = $check_book_stmt->get_result();

            //if the slot is already booked
            if($check_book_result->num_rows > 0){
                die("The slot is already booked");
            }

            //if the slot is not booked
            else {
                $book_sql = "INSERT INTO bookings (custom_name, custom_number, booking_date, booking_time, user_id, turf_id, is_booked) VALUES (?, ?, ?, ?, NULL, ?, 1)";
                $stmt = $conn->prepare($book_sql);
                $stmt->bind_param("ssssi", $custom_name, $custom_number, $booking_date, $booking_time, $turf_id);
                $stmt->execute();
                header("Location: manage_turf.php");
                exit();
            }
        }
        //if the slot is not available
        else
        {
            die("The slot is unavailable");
        }
    }

    //For changing availability
    if(isset($_POST['toggle_status']))
    {
        $booking_date = $_POST['select_date'];
        $booking_time = $_POST['select_time'];

        //check if the slot is already booked?
        $check_book_sql = "SELECT booking_id FROM bookings WHERE booking_date = ? AND booking_time = ? AND turf_id = ? AND is_booked = 1 ";
        $check_book_stmt = $conn->prepare($check_book_sql);
        $check_book_stmt->bind_param("ssi", $booking_date, $booking_time, $turf_id);
        $check_book_stmt->execute();
        $check_book_result = $check_book_stmt->get_result();
        
        //if the slot is already booked
        if($check_book_result->num_rows > 0){
            $error2 = "The slot is already booked";
        }
        
        //if the slot is not booked
        else {
            $book_sql = "INSERT INTO bookings (custom_name, custom_number, booking_date, booking_time, user_id, turf_id, is_available) VALUES (NULL, NULL, ?, ?, NULL, ?, 0)";
            $stmt = $conn->prepare($book_sql);
            $stmt->bind_param("ssi", $booking_date, $booking_time, $turf_id);
            $stmt->execute();

            header("Location: manage_turf.php");
            exit();
        }
    }

    //To see all bookings
    if(isset($_POST['see_all_bookings']))
    {
        header("Location: all_bookings_page.php");
        exit();
    }
}