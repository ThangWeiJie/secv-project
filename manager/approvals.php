<?php 
  session_start();

  if($_SESSION["ROLE"] != "admin") {
    echo "<p>You are not allowed to view this page!</p>";
    echo "<a href='user-profile.php'>Click here to go back to the homepage.</a>";
    exit();
  }
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
  <thead>
    <tr>
      <th>Booking ID</th>
      <th>Room</th>
      <th>Lecturer</th>
      <th>Date</th>
      <th>Time</th>
      <th>Purpose</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <!-- Example Data -->
    <tr>
      <td>101</td>
      <td>Lab A1</td>
      <td>Dr. Lim</td>
      <td>2025-06-20</td>
      <td>10:00 - 12:00</td>
      <td>Java Lab Session</td>
      <td>
        <button class="btn approve-btn" onclick="updateStatus(101, 'approved')">Approve</button>
        <button class="btn reject-btn" onclick="updateStatus(101, 'rejected')">Reject</button>
      </td>
    </tr>
    <tr>
      <td>102</td>
      <td>Lecture Hall B</td>
      <td>Ms. Wong</td>
      <td>2025-06-21</td>
      <td>09:00 - 11:00</td>
      <td>Guest Lecture</td>
      <td>
        <button class="btn approve-btn" onclick="updateStatus(102, 'approved')">Approve</button>
        <button class="btn reject-btn" onclick="updateStatus(102, 'rejected')">Reject</button>
      </td>
    </tr>
    <!-- More rows will be populated with PHP -->
  </tbody>
</table>

<script>
  function updateStatus(bookingId, status) {
    if (!confirm(`Are you sure to ${status} booking ID ${bookingId}?`)) return;

    // Send status update to backend
    fetch('update_approval.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `booking_id=${bookingId}&status=${status}`
    })
    .then(response => response.text())
    .then(msg => {
      alert(msg);
      // Optional: Refresh page or remove row
      location.reload();
    })
    .catch(err => {
      alert("Error: " + err);
    });
  }
</script>

</body>
</html>
