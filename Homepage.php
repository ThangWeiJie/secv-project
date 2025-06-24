<?php
    require_once('config.php');
    require('auth.php');

    if(isset($_GET['LOGOUT'])) {

        $activityMessage = "User logged out";
        $fetchedUserID = $_SESSION["USERID"];
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $fetchedUserID, $activityMessage);
        $stmt->execute();

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
        <a href="user-profile.php">Profile</a> <br><br>
        <a href="admin/manage_users.php">Manage users</a> <br><br>
        <a href="admin/activity_log.php">View activity log</a> <br><br>
        <a href="homepage.php?LOGOUT=1">Logout</a>
    <?php endif; ?>
    <?php if($_SESSION["ROLE"] == "lecturer"): ?>
        <a href="user-profile.php">Profile</a> <br><br>
        <a href="lecturer/my_bookings.php">Own bookings</a> <br><br>
        <a href="lecturer/feedback.html">Feedback Form</a> <br><br>
        <a href="lecturer/booking.php">Booking Application</a> <br> <br>
        <a href="lecturer/availableRoom.php">Browse Available Rooms</a> <br><br>
        <a href="Homepage.php?LOGOUT=1">Logout</a>  
    <?php endif; ?>
    <?php if($_SESSION["ROLE"] == "space_manager"): ?>
        <h1>You are a space manager</h1>
        <a href="user-profile.php">Profile</a> <br><br>
        <a href="manager/approvalscopy.php">Approvals</a> <br><br>
        <a href="manager/manage_room.php">Room management</a> <br><br>
        <a href="Homepage.php?LOGOUT=1">Logout</a>
    <?php endif; ?>
</body>
</html>