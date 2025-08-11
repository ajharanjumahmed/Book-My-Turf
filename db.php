<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'turf_db';

// Create connection with the databse
$conn = new mysqli($host, $user, $password, $database);

// Check if the connection is successful
if ($conn->connect_error) { //gives null when connection is successful
    die("Connection failed: " . $conn->connect_error); //$conn->connect_error shows the actual error message
}
?>
