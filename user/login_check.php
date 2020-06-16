<?php
    session_start();
    require_once '../connection.php';
    $login = 0;
    if(isset($_SESSION['login'])){ // check login, It's set or not
        $login = $_SESSION['login']; // give login id to a variable to use
        if($login == 0){
            header("location: ../index.php"); // Redirection to home page if session is not set properly
        }
    }
    else{
        header("location: ../index.php"); // Redirection to home page if session is not set
    }
    $conn = getConn();
    $full_name = $conn->query("select value from username where user_id=$login"); // acquire full name of user
    if(mysqli_num_rows($full_name) == 0){
        header('location: ../set_username.php?msg=setname');
    }
    $full_name = $full_name->fetch_array();
    $full_name = '@'.$full_name['value'];
?>