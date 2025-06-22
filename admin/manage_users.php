<?php
require_once('../config.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
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
echo "<br><a href='add_user.php'>Add New User</a>";
?>
