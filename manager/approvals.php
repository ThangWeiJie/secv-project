<?php 
  session_start();
  require_once("../config.php");

  if($_SESSION["ROLE"] != "space_manager") {
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

  $currentTimestamp = time();

  $bookingQuery = "SELECT * FROM booking WHERE booking_status='approved'";
  $bookingResult = mysqli_query($conn, $bookingQuery);

  if ($bookingResult) {
    $roomStatus = [];

    while ($bookingRow = mysqli_fetch_assoc($bookingResult)) {
      $startTimestamp = strtotime($bookingRow['start_date'] . " " . $bookingRow['start_time']);
      $endTimestamp = strtotime($bookingRow['start_date'] . " " . $bookingRow['end_time']);
      $roomId = $bookingRow['room_id'];

      if ($currentTimestamp >= $startTimestamp && $currentTimestamp <= $endTimestamp) {
        $roomStatus[$roomId] = 'Unavailable';
      } else {
        if (!isset($roomStatus[$roomId])) {
          $roomStatus[$roomId] = 'Available';
        }
      }
    }

  
    foreach ($roomStatus as $roomId => $status) {
    mysqli_query($conn, "UPDATE room SET availability='$status' WHERE room_id=$roomId");
  }
}

    $reviewerID = $_SESSION['USERID'];
  	if(isset($_POST["btn-approve"])) {
			$idToApprove = $_POST['book_id'];
			$approveQuery = "UPDATE booking SET booking_status='approved', reviewed_by='$reviewerID' WHERE booking_id='$idToApprove'";
			$approveResult = mysqli_query($conn, $approveQuery);
		
			if(mysqli_affected_rows($conn) > 0) {

        $activityMessage = "Booking approved";
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $reviewerID, $activityMessage);
        $stmt->execute();

				header("Location: approvals.php");
      }
		} else if(isset($_POST["btn-reject"])) {
			$idToReject = $_POST['book_id'];
			$rejectQuery = "UPDATE booking SET booking_status='rejected', reviewed_by='$reviewerID' WHERE booking_id = '$idToReject'";
			$rejectResult = mysqli_query($conn, $rejectQuery);

			if(mysqli_affected_rows($conn) > 0) {

        $activityMessage = "Booking rejected";
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $reviewerID, $activityMessage);
        $stmt->execute();

				header("Location: approvals.php");
		}
	}

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
              <form method="post" action="approvals.php">
                <input type="submit" class="btn approve-btn" name="btn-approve" value="Approve">
                <input type="submit" class="btn reject-btn" name="btn-reject" value="Reject">
								<input type="hidden" name="book_id" value="%u">
              </form>
            </td>
          </tr>
        ', $row['booking_id'], $roomname["room_name"], $fullname["full_name"], $row["start_date"], $row["start_time"], $row["end_time"], $row["purpose"], $row["booking_id"]);
      }
    }

	// 	$reviewerID = $_SESSION['USERID'];
  // 	if(isset($_POST["btn-approve"])) {
	// 		$idToApprove = $_POST['book_id'];
	// 		$approveQuery = "UPDATE booking SET booking_status='approved', reviewed_by='$reviewerID' WHERE booking_id='$idToApprove'";
	// 		$approveResult = mysqli_query($conn, $approveQuery);
		
<<<<<<< HEAD
			if(mysqli_affected_rows($conn) > 0) {
				header("Location: approvals.php");
		}
	} else if(isset($_POST["btn-reject"])) {
			$idToReject = $_POST['book_id'];
			$rejectQuery = "UPDATE booking SET booking_status='rejected', reviewed_by='$reviewerID' WHERE booking_id = '$idToReject'";
			$rejectResult = mysqli_query($conn, $rejectQuery);

			if(mysqli_affected_rows($conn) > 0) {
				header("Location: approvals.php");
		}
	}
=======
	// 		if(mysqli_affected_rows($conn) > 0) {
	// 			header("Location: approvals.php");
	// 	}
	// } else if(isset($_POST["btn-reject"])) {
	// 		$idToReject = $_POST['book_id'];
	// 		$rejectQuery = "UPDATE booking SET booking_status='rejected', reviewed_by='$reviewerID' WHERE booking_id = '$idToReject'";
	// 		$rejectResult = mysqli_query($conn, $rejectQuery);

	// 		if(mysqli_affected_rows($conn) > 0) {
	// 			header("Location: approvals.php");
	// 	}
	// }
>>>>>>> 371d29bb4c029e146de56e90ae27e0191228e8cd
  ?>
</table>
<a href="../Homepage.php" class="return-home-btn">&#8592; Return Home</a>
</body>
</html>