<?php
    session_start();
    session_unset(); // all session destroy to restart registration
    header("location: index.php");
?>