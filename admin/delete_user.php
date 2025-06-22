<?php
include '../db_connect.php';
$id = $_GET['id'];
$conn->query("DELETE FROM user WHERE user_id = $id");
header("Location: manage_users.php");
exit();
?>
