<?php
    require_once('../config.php');
    require_once('../auth.php');
    $id = $_GET['id'];
    $conn->query("DELETE FROM usertable WHERE user_id = $id");

    $activityMessage = "User deleted";
    $fetchedUserID = $_SESSION["USERID"];
    $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
    $stmt = $conn->prepare($activityQuery);
    $stmt->bind_param("is", $fetchedUserID, $activityMessage);
    $stmt->execute();

    header("Location: manage_users.php");
    exit();
?>
