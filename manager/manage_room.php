<?php
require_once('../config.php');
require_once('../auth.php');

// Access control
if (!isset($_SESSION['USER']) || $_SESSION['ROLE'] !== 'space_manager') {
    echo "<p>Access denied. Only space managers can manage rooms.</p>";
    exit();
}

// Fetch all rooms
$result = $conn->query("SELECT * FROM room");
$message = "Are you sure you want to delete this room?";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Management</title>
    <style>
        body {
            background-color: #add8e6;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .manage-room-container {
            background: #fff;
            padding: 24px;
            border: 1px solid #ccc;
            max-width: 900px;
            margin: 40px auto 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            color: #1e3a8a;
            text-align: center;
        }
        .add-room-btn {
            display: inline-block;
            margin: 20px 0 0 0;
            background: #1e3a8a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1em;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }
        .add-room-btn:hover {
            background: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #f8fafc;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px 10px;
            text-align: left;
        }
        th {
            background: #1e3a8a;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f0f6ff;
        }
        .actions a {
            margin-right: 10px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .return-home-btn {
            position: fixed;
            right: 30px;
            bottom: 30px;
            background: #1e3a8a;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: background 0.2s;
            text-align: center;
            z-index: 100;
        }
        .return-home-btn:hover {
            background: #2563eb;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="manage-room-container">
    <h2>Room Management</h2>
    <div class="center">
        <a href='add_room.php' class='add-room-btn'>Add New Room</a>
    </div>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Availability</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['room_id']) ?></td>
                <td><?= htmlspecialchars($row['room_name']) ?></td>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td><?= htmlspecialchars($row['size']) ?></td>
                <td><?= htmlspecialchars($row['availability']) ?></td>
                <td class="actions">
                    <a href='edit_room.php?id=<?= $row['room_id'] ?>'>Edit</a> | 
                    <a href='delete_room.php?id=<?= $row['room_id'] ?>' onclick='return confirm("<?= $message ?>");'>Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="center">No rooms found.</p>
    <?php endif; ?>
</div>
<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>
</body>
</html>