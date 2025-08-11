<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { //if the submit button is clicked
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypting password for security purpose
    $role = $_POST['role'];

    // Insert into database
    $sql = "INSERT INTO users (name, email, password, number, role) VALUES (?, ?, ?, ?, ?)"; //using placeholders for not sending values directly to database
    $stmt = $conn->prepare($sql); //store the prepared statement object in $stmt
    $stmt->bind_param("sssss", $name, $email, $password, $number, $role); //Fills the placeholder with values

    if ($stmt->execute()) { //returns true if the data is successfully stored in the database
        header("Location: login.php"); //moves to the login page for logging in
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close(); //closes the connnection with the database
?>
