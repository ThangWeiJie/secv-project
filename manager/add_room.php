<?php
require_once('../config.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'space_manager') {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $type = $_POST['type'];
    $size = $_POST['size'];

    $stmt = $conn->prepare("INSERT INTO room (room_name, type, size) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $room_name, $type, $size);

    if ($stmt->execute()) {
        echo "<p>Room added successfully!</p>";
        echo "<a href='manage_room.php'>← Back to Room List</a>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<h2>Add New Room</h2>
<form method="post">
    Room Name: <input type="text" name="room_name" required><br>
    Type: <input type="text" name="type" required><br>
    Size: <input type="number" name="size" required><br>
    <button type="submit">Add Room</button>
</form>
