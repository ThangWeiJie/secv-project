<?php 
    require_once('../auth.php');
    require_once('../config.php');

    if(isset($_POST['btn-edit'])) {
        $idToModify = $_POST['book_id'];
        $editQuery = "SELECT * FROM booking WHERE booking_id=$idToModify";
        $editResult = mysqli_query($conn, $editQuery);
        $editRow = mysqli_fetch_assoc($editResult);

        $roomID = $editRow['room_id'];
        $bookDate = $editRow['start_date'];
        $startTime = $editRow['start_time'];
        $endTime = $editRow['end_time'];
        $purpose = $editRow['purpose'];

        header("Location: booking.php?&bookId=$idToModify&roomId=$roomID&edit=1&date=$bookDate&startTime=$startTime&endTime=$endTime&purpose=$purpose");

    } else if(isset($_POST['btn-delete'])) {
        $idToDelete = $_POST['book_id'];
        $deleteQuery = "DELETE FROM booking WHERE booking_id=$idToDelete";
        $deleteResult = mysqli_query($conn, $deleteQuery);        

        if(mysqli_affected_rows($conn) > 0) {
            header("Location: my_bookings.php");
        } else {
            echo "There was an error in deleting this record.";
        }
    }

    if(isset($_POST['submit'])) {
        $idToUpdate = $_POST['book_id'];
        $newRoom = $_POST['room'];
        $newDate = $_POST['date'];
        $newStartTime = $_POST['startTime'];
        $newEndTime = $_POST['endTime'];
        $newPurpose = $_POST['purpose'];

        $updateQuery = "UPDATE booking SET room_id=?, start_date=?, start_time=?, end_time=?, purpose=? WHERE booking_id=$idToUpdate";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("issss", $newRoom, $newDate, $newStartTime, $newEndTime, $newPurpose);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            echo "Your booking has been modified";
        }
    }
?>