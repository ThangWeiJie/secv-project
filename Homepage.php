<?php
    session_start();

    if(isset($_GET['LOGOUT'])) {
        session_destroy();
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if($_SESSION["ROLE"] == "admin"): ?>
        <h1>You are an admin</h1>
        <a href="Homepage.php?LOGOUT=1">Logout</a>
    <?php endif; ?>
    <?php if($_SESSION["ROLE"] == "lecturer"): ?>
        <a href="feedback.html">Feedback Form</a> <br><br>
        <a href="booking.html">Booking Application</a> <br> <br>
        <a href="availableRoom.php">Browse Available Rooms</a> <br>
        <a href="Homepage.php?LOGOUT=1">Logout</a>  
    <?php endif; ?>
    <?php if($_SESSION["ROLE"] == "space_manager"): ?>
        <h1>You are a space manager</h1>
        <a href="Homepage.php?LOGOUT=1">Logout</a>
    <?php endif; ?>
</body>
</html>