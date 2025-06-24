<?php 
    session_start();
    require_once("config.php");

    // print_r($_POST);

    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    $query = "SELECT * FROM usertable WHERE username='$enteredUsername' AND password='$enteredPassword'";
    $result = mysqli_query($conn, $query);

    $userrow = mysqli_fetch_assoc($result);

    if(!isset($userrow)) {  
        header("Location: login.php?err=1");
    }

    $fetchedUserID = $userrow["user_id"];
    $fetchedUserName = $userrow["username"];
    $fetchedPassword = $userrow["password"];
    $fetchedFullName = $userrow["full_name"];
    $fetchedEmail = $userrow["email"];
    $fetchedPhone = $userrow["phone"];
    $fetchedUserType = $userrow["role"];

    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION["LOGGED"] = TRUE;

        $_SESSION["USER"] = $fetchedUserName;
        $_SESSION["USERID"] = $fetchedUserID;
        $_SESSION["FULLNAME"] = $fetchedFullName;
        $_SESSION["EMAIL"] = $fetchedEmail;
        $_SESSION["PHONE"] = $fetchedPhone;
        $_SESSION["ROLE"] = $fetchedUserType;

        $activityMessage = "User logged in";
        $activityQuery = "INSERT INTO activity_log(user_id, action_description) VALUES (?, ?)";
        $stmt = $conn->prepare($activityQuery);
        $stmt->bind_param("is", $fetchedUserID, $activityMessage);
        $stmt->execute();

        setcookie("user", $fetchedUserName, time() + 60*60*24);
        header("Location: Homepage.php");

    } else {
        $_SESSION["LOGGED"] = FALSE;
        // echo "There seems to be a problem. Please login again.";
    }
?>