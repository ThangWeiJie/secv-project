<?php
require_once('../config.php');
if (isset($_GET['keyword'])) {
    $keyword = $conn->real_escape_string($_GET['keyword']);
    $result = $conn->query("SELECT * FROM user WHERE full_name LIKE '%$keyword%'");
    while ($row = $result->fetch_assoc()) {
        echo "{$row['full_name']} ({$row['role']})<br>";
    }
}
?>
<form method="GET">
    Search User: <input name="keyword">
    <button type="submit">Search</button>
</form>
