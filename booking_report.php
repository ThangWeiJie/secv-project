<?php
require_once('config.php');
$result = $conn->query("SELECT b.*, u.full_name, r.room_name 
                        FROM booking b 
                        JOIN user u ON b.user_id = u.user_id 
                        JOIN room r ON b.room_id = r.room_id
                        ORDER BY b.date DESC");

echo "<h2>Booking Report</h2><table border='1'><tr><th>Lecturer</th><th>Room</th><th>Date</th><th>Time</th><th>Status</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['full_name']}</td>
        <td>{$row['room_name']}</td>
        <td>{$row['date']}</td>
        <td>{$row['start_time']} - {$row['end_time']}</td>
        <td>{$row['status']}</td>
    </tr>";
}
echo "</table>";
?>
