<?php
    session_start();
    require 'connection.php';
    $conn = getConn();

    $email = $_SESSION['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $password = hash('sha256',$_POST['password']);
    $dob = str_replace("/","-",$_POST['dob']);
    $dob = date('Y-m-d',strtotime($dob));

    $query = "insert into user(email,first_name,last_name,mobile,dob,`password`)
              values('$email','$first_name','$last_name',$mobile,'$dob','$password')";

    if($conn->query($query) == true){
        $result = $conn->query("select id from user where email='$email'");
        $user = $result->fetch_array();
        session_unset();
        $_SESSION['login'] = $user['id'];
        header('location: index.php');
    }
    else{
        header('location: registration.php?msg=da');
    }
?>