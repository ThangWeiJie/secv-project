<?php
    session_start();

    if(!$_SESSION["LOGGED"]) {
        header("Location: index.php");
    }

?>