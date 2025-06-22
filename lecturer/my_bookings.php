<?php 
    require_once('../auth.php');
    require_once('../config.php');

    $lectureID = $_SESSION["USERID"];
    $query = "SELECT * FROM booking WHERE booking_status='pending' AND lecturer_id = $lectureID";
    $result = mysqli_query($conn, $query);

    // while($row = mysqli_fetch_assoc($result)) {
    //     print_r($row);
    // }

    $joinquery_lecturer = "SELECT full_name FROM booking INNER JOIN usertable ON booking.lecturer_id=usertable.user_id AND booking.lecturer_id=$lectureID";
    $joinresult_lecturer = mysqli_query($conn, $joinquery_lecturer);
    $fullname = mysqli_fetch_assoc($joinresult_lecturer);
    
    // while($row = mysqli_fetch_assoc($joinresult_lecturer)) {
    //     print_r($row);
    // }


    $joinquery_room = "SELECT room_name FROM booking INNER JOIN room ON booking.room_id=room.room_id";
    $joinresult_room = mysqli_query($conn, $joinquery_room);
    $roomname = mysqli_fetch_assoc($joinresult_room);
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

    .edit-btn {
      background-color:rgb(9, 105, 168);
    }

    .delete-btn {
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
              <form method="post" action="modifybooking.php">
                <input type="submit" class="btn edit-btn" name="btn-edit" value="Edit">
                <input type="submit" onclick="return confirm(\'%s\');" class="btn delete-btn" name="btn-delete" value="Delete">
								<input type="hidden" name="book_id" value="%u">
              </form>
            </td>
          </tr>
        ', $row['booking_id'], $roomname["room_name"], $fullname["full_name"], $row["start_date"], $row["start_time"], $row["end_time"], $row["purpose"], "Are you sure you want to delete this row?", $row["booking_id"]);
      }
    }
  ?>
</table>
