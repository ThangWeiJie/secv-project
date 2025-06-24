<?php
require_once('../config.php');
require_once('../auth.php');
// session_start();
if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login.php");
    exit();
}


$result = $conn->query("SELECT * FROM usertable");
$message = "Are you sure you want to delete this user?";
echo "<h2>User Management</h2><br>";
echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['role']}</td>
        <td>
            <a href='edit_user.php?id={$row['user_id']}'>Edit</a> | 
            <a href='delete_user.php?id={$row['user_id']}' onclick='return confirm(\"$message\");'>Delete</a>
        </td>
    </tr>";
}
echo "</table>";
echo "<br><a href='add_user.php'>Add New User</a>";
?>
