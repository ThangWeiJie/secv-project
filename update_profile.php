<?php 
    require_once("config.php");
    require_once("auth.php");

    $user_id = $_SESSION["USERID"];
    
    if(isset($_POST["submit"])) {
        $newusername = trim($_POST["newusername"]);
        $newemail = trim($_POST["newemail"]);
        $newphone = trim($_POST["newphone"]);

        $updateQuery = "UPDATE usertable SET username=?, email=?, phone=? WHERE user_id=?";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $newusername, $newemail, $newphone, $user_id);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            header("Location: user-profile.php?updated=1");
        }

        $activityMessage = "Updated user profile";
        $fetchedUserID = $_SESSION["USERID"];
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $fetchedUserID, $activityMessage);
        $stmt->execute();
    }
?>