<?php
require_once('../config.php');
$id = $_GET['id'];
$conn->query("DELETE FROM usertable WHERE user_id = $id");
header("Location: manage_users.php");
exit();
?>
