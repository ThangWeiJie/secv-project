<?php 
    require_once("config.php");

    $username = $_POST['username'];
    $password = $_POST["password"];

    $query = "SELECT username, pass FROM usertable WHERE username='$username' AND pass='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) != 0) {
        echo "User found";
    } else {
        echo "User not found";
    }
?>
