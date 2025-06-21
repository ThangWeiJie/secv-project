<?php 
    session_start();
    require_once("config.php");

    // print_r($_POST);

    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    $query = "SELECT * FROM usertable WHERE username='$enteredUsername' AND pass='$enteredPassword'";
    $result = mysqli_query($conn, $query);

    $userrow = mysqli_fetch_assoc($result);

    if(!isset($userrow)) {  
        header("Location: login.php?err=1");
    }

    $fetchedUserID = $userrow["user_id"];
    $fetchedUserName = $userrow["username"];
    $fetchedPassword = $userrow["pass"];
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

        setcookie("user", $fetchedUserName, time() + 60*60*24);

        // echo "Welcome, " . $_SESSION["USER"];
        header("Location: approvalscopy.php");
        print_r($_SESSION);
    } else {
        $_SESSION["LOGGED"] = FALSE;
        // echo "There seems to be a problem. Please login again.";
    }
?>