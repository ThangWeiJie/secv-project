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

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $availability = $_POST['availability'];

    $updateStmt = $conn->prepare("UPDATE room SET room_name = ?, type = ?, size = ?, availability = ? WHERE room_id = ?");
    $updateStmt->bind_param("ssisi", $room_name, $type, $size, $availability, $room_id);

    if ($updateStmt->execute()) {
        $message = "<p style='color: green; font-weight: bold;'>✅ Room updated successfully!</p>";
    } else {
        $message = "<p style='color:red;'>❌ Error: " . $updateStmt->error . "</p>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Room</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #1e40af;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #1e293b;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #2563eb;
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #1e40af;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Room</h2>

    <?php if (!empty($message)) : ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Room Name:</label>
        <input type="text" name="room_name" value="<?= htmlspecialchars($room['room_name']) ?>" required>

        <label>Type:</label>
        <input type="text" name="type" value="<?= htmlspecialchars($room['type']) ?>" required>

        <label>Size:</label>
        <input type="number" name="size" value="<?= $room['size'] ?>" required>

        <label>Availability:</label>
        <select name="availability" required>
            <option value="Available" <?= $room['availability'] == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Unavailable" <?= $room['availability'] == 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
        </select>

        <button type="submit">Update Room</button>
    </form>
    <a href="manage_room.php" class="back-link">&#8592; Back to Room List</a>
</div>

</body>
</html>
