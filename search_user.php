<?php
require_once('config.php');
session_start();

// Optional: restrict access only to admin or space_manager
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'space_manager'])) {
    echo "<p>Access denied.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>

<h2>🔍 Search User</h2>

<form method="GET">
    <label for="keyword">Full Name:</label>
    <input name="keyword" id="keyword" placeholder="Enter full name" required>
    <button type="submit">Search</button>
</form>

<?php
if (isset($_GET['keyword'])) {
    $keyword = $conn->real_escape_string($_GET['keyword']);
    $result = $conn->query("SELECT * FROM user WHERE full_name LIKE '%$keyword%'");

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Created At</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>{$row['role']}</td>
                    <td>" . htmlspecialchars($row['phone']) . "</td>
                    <td>{$row['created_at']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No users found matching your search.</p>";
    }
}
?>

</body>
</html>
