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
    $full_name = $conn->query("select username from user where id=$login"); // acquire full name of user
    $full_name = $full_name->fetch_array();
    if($full_name['username'] == null){
        header('location: ../set_username.php?msg=setname');
    }
    $full_name = '@'.$full_name['username'];
?>