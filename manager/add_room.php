<?php
require_once('../config.php');
require_once('../auth.php');

if (!isset($_SESSION['USERID']) || $_SESSION['ROLE'] !== 'space_manager') {
    echo "Access denied.";
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $type = $_POST['type'];
    $size = $_POST['size'];

    $stmt = $conn->prepare("INSERT INTO room (room_name, type, size) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $room_name, $type, $size);

    if ($stmt->execute()) {
        $message = "<p style='color: green; font-weight: bold;'>✅ Room added successfully!</p>";
    } else {
        $message = "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
    }

    $activityMessage = "Room added";
    $fetchedUserID = $_SESSION["USERID"];
    $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
    $stmt = $conn->prepare($activityQuery);
    $stmt->bind_param("is", $fetchedUserID, $activityMessage);
    $stmt->execute();

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Room</title>
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

        input {
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
    <h2>Add New Room</h2>
    <?php if (!empty($message)) : ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Room Name:</label>
        <input type="text" name="room_name" required>

        <label>Type:</label>
        <input type="text" name="type" required>

        <label>Size:</label>
        <input type="number" name="size" required>

        <button type="submit">Add Room</button>
    </form>
    <a href="manage_room.php" class="back-link">&#8592; Back to Room List</a>
</div>

</body>
</html>
