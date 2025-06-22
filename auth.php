<?php
    session_start();

    if(!$_SESSION["LOGGED"]) {
        header("Location: login.php");
    }
?>