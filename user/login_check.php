<?php
    session_start();
    require_once '../connection.php';
    $login = 0;
    if(isset($_SESSION['login'])){
        $login = $_SESSION['login'];
        if($login == 0){
            header("location: ../index.php");
        }
    }
    else{
        header("location: ../index.php");
    }
    $conn = getConn();
    $full_name = $conn->query("select first_name,last_name from user where id=$login");
    $full_name = $full_name->fetch_array();
    $full_name = $full_name['first_name']." ".$full_name['last_name'];
?>