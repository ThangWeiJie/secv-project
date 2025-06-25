<?php 
  session_start();

  if($_SESSION["ROLE"] != "space_manager") {
    echo "<p>You are not allowed to view this page!</p>";
    echo "<a href='../Homepage.php'>Click here to go back to the homepage.</a>";
    exit();
  }

  require_once('../config.php');

  // Fetch all booking records
  $query = "SELECT booking.*, usertable.full_name, room.room_name 
            FROM booking 
            JOIN usertable ON booking.lecturer_id = usertable.user_id 
            JOIN room ON booking.room_id = room.room_id";

  $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Report</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 40px;
      background-color: #f8fafc;
    }

    h1 {
      text-align: center;
      color: #1e40af;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 14px;
      border-bottom: 1px solid #e2e8f0;
      text-align: center;
    }

    th {
      background-color: #1d4ed8;
      color: white;
    }

    tr:hover {
      background-color: #f1f5f9;
    }

    .return-home-btn {
      position: fixed;
      right: 30px;
      bottom: 30px;
      background: #1e3a8a;
      color: #fff;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 1em;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: background 0.2s;
      text-align: center;
      z-index: 100;
    }

    .return-home-btn:hover {
      background: #2563eb;
    }
  </style>
</head>
<body>

<h1>Booking Report</h1>

<table id="bookingTable">
  <thead>
    <tr>
      <th>Booking ID</th>
      <th>Room</th>
      <th>Lecturer</th>
      <th>Date</th>
      <th>Time</th>
      <th>Purpose</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          printf('
            <tr>
              <td>%u</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s - %s</td>
              <td>%s</td>
              <td>%s</td>
            </tr>
          ',
            $row['booking_id'],
            $row['room_name'],
            $row['full_name'],
            $row['start_date'],
            $row['start_time'],
            $row['end_time'],
            $row['purpose'],
            $row['booking_status']
          );
        }
      } else {
        echo '<tr><td colspan="7">No bookings found.</td></tr>';
      }
    ?>
  </tbody>
</table>

<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>

</body>
</html>
