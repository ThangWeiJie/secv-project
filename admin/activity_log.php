<?php
require_once('../config.php');
$result = $conn->query("SELECT a.*, u.full_name FROM activity_log a JOIN usertable u ON a.user_id = u.user_id ORDER BY action_timestamp ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Log</title>
    <style>
        body {
            background-color: #add8e6;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .activity-log-container {
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
    </style>
</head>
<body>
<div class="activity-log-container">
    <h2>Activity Log</h2>
    <table>
        <tr><th>User</th><th>Action</th><th>Time</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['action_description']) ?></td>
            <td><?= htmlspecialchars($row['action_timestamp']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>
</body>
</html>