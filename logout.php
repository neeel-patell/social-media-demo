<?php
    session_start();
    session_unset(); // unsetting of all sessions available for client
    header('location: index.php'); // Redirection to homepage
?>