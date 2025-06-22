<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO user (username, password, full_name, email, role, phone) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $_POST['username'], $_POST['password'], $_POST['full_name'], $_POST['email'], $_POST['role'], $_POST['phone']);
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}
?>
<form method="POST">
    Username: <input name="username"><br>
    Password: <input type="password" name="password"><br>
    Full Name: <input name="full_name"><br>
    Email: <input name="email"><br>
    Role: <select name="role"><option>admin</option><option>lecturer</option><option>space_manager</option></select><br>
    Phone: <input name="phone"><br>
    <button type="submit">Add User</button>
</form>
