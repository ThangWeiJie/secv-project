<?php
    require_once('../config.php');
    require_once('../auth.php');

    if (!isset($_SESSION['USERID']) || $_SESSION['ROLE'] !== 'space_manager') {
        echo "Access denied.";
        exit();
    }

    $room_id = $_GET['id'] ?? '';
    if (!$room_id) {
        echo "Invalid room ID.";
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM room WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        echo "<p>Room deleted successfully.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $activityMessage = "Room deleted";
    $fetchedUserID = $_SESSION["USERID"];
    $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
    $stmt = $conn->prepare($activityQuery);
    $stmt->bind_param("is", $fetchedUserID, $activityMessage);
    $stmt->execute();

    $stmt->close();

    echo "<a href='manage_room.php'>← Back to Room List</a>";
?>
