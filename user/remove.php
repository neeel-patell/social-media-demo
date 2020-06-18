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

    $query = "select user_id'id' from username where value='$username'"; // getting id by username
    $result = $conn->query($query);
    
    
    if(mysqli_num_rows($result) == 0){
        header('location: index.php');
    }
    else{
        $result = $result->fetch_array();
        $id = $result['id'];

        // deleting appropriate entries and redirections
        if($method === "following"){
            $query = "delete from friend where user_id=$login and friend_id=$id";
            $conn->query($query);
            header('location: friends.php?following');
        }
        else if($method === "requests"){
            $query = "delete from friend where user_id=$id and friend_id=$login";
            $conn->query($query);
            header('location: friends.php?requests');
        }
        else{
            $query = "delete from friend where user_id=$id and friend_id=$login";
            $conn->query($query);
            header('location: friends.php?followers');
        }
    }
    
?>