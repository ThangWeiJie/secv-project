<?php 
    session_start();
    require_once("../config.php");

    // print_r($_POST);
    
    if(isset($_POST['submit'])) {
        $room = trim($_POST['room']);
        $date = trim($_POST['date']);
        $start = trim($_POST['startTime']);
        $end = trim($_POST['endTime']);
        $purpose = trim($_POST['purpose']);
        $status = 'pending';

        $query = "INSERT INTO booking (room_id, lecturer_id, start_date, start_time, end_time, purpose, booking_status) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisssss", $room, $_SESSION["USERID"], $date, $start, $end, $purpose, $status);  
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            echo '
                <div style="text-align: center; margin-top: 50px; font-family: Segoe UI;">
                    <h2 style="color: green;">✅ Your booking has been added successfully!</h2>
                    <a href="../Homepage.php" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #1d4ed8; color: white; text-decoration: none; border-radius: 8px; font-weight: bold;">Return to Homepage</a>
                </div>

            ';
        }

        $activityMessage = "Booking submitted";
        $fetchedUserID = $_SESSION["USERID"];
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $fetchedUserID, $activityMessage);
        $stmt->execute();

    } else {
        echo "What";
    }


?>