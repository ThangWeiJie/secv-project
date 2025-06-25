<?php
require_once('../config.php');
session_start();

if ($_SESSION['ROLE'] != 'space_manager') {
    echo "<p>You are not allowed to view this page.</p>";
    echo "<a href='../Homepage.php'>Return to Home</a>";
    exit();
}

$sql = "SELECT f.*, u.username FROM feedback f 
        JOIN usertable u ON f.user_id = u.user_id 
        ORDER BY f.submitted_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 40px;
            background-color: #f8fafc;
        }

        h1 {
            text-align: center;
            color: #1e40af;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }

        th {
            background-color: #1d4ed8;
            color: white;
        }

        tr:hover {
            background-color: #f1f5f9;
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

<h1>📋 All Feedback Submissions</h1>

<?php
if (mysqli_num_rows($result) > 0) {
    echo "<table>
            <tr>
                <th>Username</th>
                <th>Satisfaction</th>
                <th>Resolved?</th>
                <th>Professionalism</th>
                <th>Improvement</th>
                <th>Comments</th>
                <th>Submitted At</th>
            </tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['username']) . "</td>
                <td>" . htmlspecialchars($row['satisfaction']) . "</td>
                <td>" . ($row['resolved'] ? 'Yes' : 'No') . "</td>
                <td>" . htmlspecialchars($row['professionalism']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['improvement'])) . "</td>
                <td>" . nl2br(htmlspecialchars($row['comments'])) . "</td>
                <td>" . $row['submitted_at'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No feedback submitted yet.</p>";
}
?>

<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>

</body>
</html>

<?php
$conn->close();
?>
