<?php
require_once('../config.php');
$result = $conn->query("SELECT a.*, u.full_name FROM activity_log a JOIN usertable u ON a.user_id = u.user_id");
echo "<h2>Activity Log</h2><table border='1'><tr><th>User</th><th>Action</th><th>Time</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['full_name']}</td>
        <td>{$row['action_description']}</td>
        <td>{$row['action_timestamp']}</td>
    </tr>";
}
echo "</table>";
?>
