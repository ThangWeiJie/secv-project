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

// Fetch existing room info
$stmt = $conn->prepare("SELECT * FROM room WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

if (!$room) {
    echo "Room not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $availability = $_POST['availability'];

    $updateStmt = $conn->prepare("UPDATE room SET room_name = ?, type = ?, size = ?, availability = ? WHERE room_id = ?");
    $updateStmt->bind_param("ssisi", $room_name, $type, $size, $availability, $room_id);

    if ($updateStmt->execute()) {
        echo "<p>Room updated successfully!</p>";
        echo "<a href='manage_room.php'>← Back to Room List</a>";
    } else {
        echo "<p style='color:red;'>Error: " . $updateStmt->error . "</p>";
    }

    $updateStmt->close();

    $activityMessage = "Room updated";
    $fetchedUserID = $_SESSION["USERID"];
    $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
    $stmt = $conn->prepare($activityQuery);
    $stmt->bind_param("is", $fetchedUserID, $activityMessage);
    $stmt->execute();
}
?>

<h2>Edit Room</h2>
<form method="post">
    Room Name: <input type="text" name="room_name" value="<?= htmlspecialchars($room['room_name']) ?>" required><br>
    Type: <input type="text" name="type" value="<?= htmlspecialchars($room['type']) ?>" required><br>
    Size: <input type="number" name="size" value="<?= $room['size'] ?>" required><br>
    <!-- Availability: <input type="number" name="size" value="<?= $room['size'] ?>" required><br> -->

    <label for="availability">Availability:</label>
    <select id="availability" name="availability">
        <option value="Unavailable">Unavailable</option>
        <option value="Available">Available</option>
    </select> <br>

    <button type="submit">Update Room</button>
</form>
