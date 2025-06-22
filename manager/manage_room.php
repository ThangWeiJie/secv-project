<?php
require_once('../config.php');
session_start();

// Access control
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'space_manager') {
    echo "<p>Access denied. Only space managers can manage rooms.</p>";
    exit();
}

// Fetch all rooms
$result = $conn->query("SELECT * FROM room");

echo "<h2>Room Management</h2>";
echo "<a href='add_room.php'><button>Add New Room</button></a><br><br>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='6'>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['room_id']}</td>
                <td>" . htmlspecialchars($row['room_name']) . "</td>
                <td>" . htmlspecialchars($row['type']) . "</td>
                <td>{$row['size']}</td>
                <td>
                    <a href='edit_room.php?id={$row['room_id']}'>Edit</a> |
                    <a href='delete_room.php?id={$row['room_id']}' onclick=\"return confirm('Are you sure you want to delete this room?');\">Delete</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No rooms found.</p>";
}

$conn->close();
?>
