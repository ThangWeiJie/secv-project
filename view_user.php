<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'space_manager') {
    echo "<p>Access denied.</p>";
    exit();
}

$result = $conn->query("SELECT * FROM user");

echo "<h2>All Users</h2>";
echo "<table border='1' cellpadding='6'>
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
?>
<a href="search_user.php">🔍 Search User</a> |