<?php
    session_start();
    require 'connection.php';
    $conn = getConn();

    $email = $_SESSION['email']; // email which is varified
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $password = hash('sha256',$_POST['password']); // hash generate to encrypted password
    $dob = str_replace("/","-",$_POST['dob']); // conversion if safari browser user writes date as DD/MM/YYYY
    $dob = date('Y-m-d',strtotime($dob)); // conversion of date as database format

    $query = "insert into user(email,first_name,last_name,mobile,dob,`password`)
              values('$email','$first_name','$last_name',$mobile,'$dob','$password')";

    if($conn->query($query) == true){
        $result = $conn->query("select id from user where email='$email'"); // getting unique user id acquired
        $user = $result->fetch_array();
        session_unset();
        $_SESSION['login'] = $user['id']; // setting user id as user directly logged in exact after registration
        header('location: set_username.php'); // redirection to set username for user
    }
    else{
        header('location: registration.php?msg=da'); // Registration failed
    }
?>