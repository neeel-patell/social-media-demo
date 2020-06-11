<?php
    require 'connection.php';
    $conn = getConn();
    session_start();

    $login = $_SESSION['login'];
    $username = $_POST['username'];

    $query = "select id from user where username='$username'";
    $result = $conn->query($query);

    if(mysqli_num_rows($result) != 0){ // check for availability
        header('location: set_username.php?msg=notavailable');
    }

    else{
        $query = "UPDATE user
                  SET username='$username'
                  WHERE id=$login";
        if($conn->query($query) == true){ // update if username is not available
            header('location: user/index.php');
        }
        else{
            header('location: set_username.php?msg=notavailable');
        }
    }
?>