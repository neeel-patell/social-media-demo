<?php
    require '../connection.php';
    $conn = getConn();
    session_start();

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

        $query = "UPDATE friend 
                  SET approve = 1
                  where user_id = $id AND friend_id = $login"; // update approve to 1 to allow following
        $conn->query($query);
        header('location: friends.php?requests');
    }
    
?>