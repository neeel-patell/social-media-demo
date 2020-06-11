<?php
    require 'connection.php';
    session_start();
    $conn = getConn();

    $email = $_POST['email'];
    $password = hash("sha256",$_POST['password']);

    $query = "select id,active from user where email = '$email' and password = '$password'"; // check that credential matche or not
    $result = $conn->query($query);
    
    if(mysqli_num_rows($result) != 0){
        $row = $result->fetch_array();
        if($row['active'] == 1){ // check admin allows him/her to be on the plateform
            $_SESSION['login'] = $row['id']; // set login id for session of logged in user
            header("location: user/index.php");
        }
        else{
            header("location: login.php?msg=blocked");
        }
    }
    else{
        $result = $conn->query("select id from user where email = '$email'");
        if(mysqli_num_rows($result) == 0){ // checking email is there or not
            header("location: login.php?msg=ne");
        }
        else{ // email is registered then password is wrong
            header("location: login.php?msg=pf");
        }
    }
?>