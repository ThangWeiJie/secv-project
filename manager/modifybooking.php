<?php 
    require_once('auth.php');
    require_once('config.php');

    if(isset($_POST['btn-edit'])) {

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
?>