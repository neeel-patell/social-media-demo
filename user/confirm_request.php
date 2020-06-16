<?php
    require '../connection.php';
    $conn = getConn();
    session_start();

    if(isset($_SESSION['login']) == false){
        header('location: index.php');
    }

    $login = $_SESSION['login'];
    $username = $_GET['username'];

    $query = "select id from user where username='$username'";
    $result = $conn->query($query);
    
    if(mysqli_num_rows($result) == 0){
        header('location: index.php');
    }
    else{
        $result = $result->fetch_array();
        $id = $result['id'];

        $query = "UPDATE friend 
                  SET approve = 1
                  where user_id = $id AND friend_id = $login";
        $conn->query($query);
        header('location: friends.php?requests');
    }
    
?>