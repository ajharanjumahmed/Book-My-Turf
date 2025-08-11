<?php
    session_start();  // Start the session
    session_destroy();  // Delete all session data
    header("Location: login.php");  // Redirect to login page
    exit(); //stop running the script
?>