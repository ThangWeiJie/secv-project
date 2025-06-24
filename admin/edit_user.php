<?php
require_once('../config.php');
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE usertable SET full_name=?, email=?, role=?, phone=? WHERE user_id=?");
    $stmt->bind_param("ssssi", $_POST['full_name'], $_POST['email'], $_POST['role'], $_POST['phone'], $id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}
$result = $conn->query("SELECT * FROM usertable WHERE user_id=$id");
$user = $result->fetch_assoc();
?>
<form method="POST">
    Full Name: <input name="full_name" value="<?= $user['full_name'] ?>"><br>
    Email: <input name="email" value="<?= $user['email'] ?>"><br>
    Role: <select name="role">
        <option <?= $user['role'] == 'admin' ? 'selected' : '' ?>>admin</option>
        <option <?= $user['role'] == 'lecturer' ? 'selected' : '' ?>>lecturer</option>
        <option <?= $user['role'] == 'space_manager' ? 'selected' : '' ?>>space_manager</option>
    </select><br>
    Phone: <input name="phone" value="<?= $user['phone'] ?>"><br>
    <button type="submit">Update</button>
</form>
