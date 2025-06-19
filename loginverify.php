<?php 
    session_start();
    require_once("config.php");

    print_r($_POST);

    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    $query = "SELECT * FROM usertable WHERE username='$enteredUsername' AND pass='$enteredPassword'";
    $result = mysqli_query($conn, $query);

    $userrow = mysqli_fetch_assoc($result);

    if(!isset($userrow)) {  
        header("Location: login.html");
    }

    $fetchedUserID = $userrow["user_id"];
    $fetchedUserName = $userrow["username"];
    $fetchedPassword = $userrow["pass"];
    $fetchedUserType = $userrow["role"];

    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION["LOGGED"] = TRUE;

        $_SESSION["USER"] = $fetchedUserName;
        $_SESSION["USERID"] = $fetchedUserID;
        $_SESSION["ROLE"] = $fetchedUserType;

        echo "Welcome, " . $_SESSION["USER"];
    } else {
        $_SESSION["LOGGED"] = FALSE;
        echo "There seems to be a problem. Please login again.";
    }
?>