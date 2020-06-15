<?php
    require '../connection.php';
    $conn = getConn();
    session_start();

    $method = $_GET['method'];
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

        if($method === "following"){
            $query = "delete from friend where user_id=$login and friend_id=$id";
            $conn->query($query);
            header('location: friends.php?following');
        }
        else{
            $query = "delete from friend where user_id=$id and friend_id=$login";
            $conn->query($query);
            header('location: friends.php?followers');
        }
    }
    
?>