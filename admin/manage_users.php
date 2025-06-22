<?php
require_once('../config.php');
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$result = $conn->query("SELECT * FROM user");
echo "<h2>User Management</h2><a href='add_user.php'>Add User</a><br><br>";
echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['role']}</td>
        <td>
            <a href='edit_user.php?id={$row['user_id']}'>Edit</a> | 
            <a href='delete_user.php?id={$row['user_id']}'>Delete</a>
        </td>
    </tr>";
}
echo "</table>";
?>
