<?php
require_once('../config.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'space_manager') {
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

$stmt->close();

echo "<a href='manage_room.php'>← Back to Room List</a>";
?>
