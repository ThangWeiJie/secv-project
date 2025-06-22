<?php 
    session_start();
    require_once("config.php");

    print_r($_POST);
    
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
                <div>
                    Your booking has been added.
                </div>
            ';
        }
    } else {
        echo "What";
    }


?>