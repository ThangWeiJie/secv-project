<?php 
  session_start();
  require_once("config.php");

  if($_SESSION["ROLE"] != "admin") {
    echo "<p>You are not allowed to view this page!</p>";
    echo "<a href='user-profile.php'>Click here to go back to the homepage.</a>";
    exit();
  }

  $query = "SELECT * FROM booking WHERE booking_status='pending'";
  $result = mysqli_query($conn, $query);

  $joinquery_lecturer = "SELECT full_name FROM booking INNER JOIN usertable ON booking.lecturer_id=usertable.user_id";
  $joinresult_lecturer = mysqli_query($conn, $joinquery_lecturer);
  $fullname = mysqli_fetch_assoc($joinresult_lecturer);

  $joinquery_room = "SELECT room_name FROM booking INNER JOIN room ON booking.room_id=room.room_id";
  $joinresult_room = mysqli_query($conn, $joinquery_room);
  $roomname = mysqli_fetch_assoc($joinresult_room);

  // print_r($fullname["full_name"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Approvals</title>
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

    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .approve-btn {
      background-color: #16a34a;
    }

    .reject-btn {
      background-color: #dc2626;
    }
  </style>
</head>
<body>

<h1>Pending Booking Approvals</h1>

<table id="bookingTable">
  <tr>
    <th>Booking ID</th>
    <th>Room</th>
    <th>Lecturer</th>
    <th>Date</th>
    <th>Time</th>
    <th>Purpose</th>
    <th>Action</th>
  </tr>
  <?php 
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        printf('
          <tr>
            <td>%u</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td>%s - %s</td>
            <td>%s</td>
            <td>
              <button class="btn approve-btn" onclick="updateStatus(102, "approved")">Approve</button>
              <button class="btn reject-btn" onclick="updateStatus(102, "rejected")">Reject</button>
            </td>
          </tr>
        ', $row['booking_id'], $roomname["room_name"], $fullname["full_name"], $row["start_date"], $row["start_time"], $row["end_time"], $row["purpose"]);
      }
    }
  ?>
</table>

</body>
</html>
