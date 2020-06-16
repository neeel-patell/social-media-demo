<?php
    require 'connection.php';
    $conn = getConn();
    session_start();

    $login = $_SESSION['login'];
    $username = $_POST['username'];
    $username = strtolower($username);
    $query = "select id from username where value='$username'";
    $result = $conn->query($query);

    if(mysqli_num_rows($result) != 0){
        header('location: set_username.php?msg=notavailable');
    }

    else{
        $character = $username[0];
        $query = "select min(id)'min_id',max(id)'max_id' from username where value like '$character%'";
        $result = $conn->query($query);
        $result = $result->fetch_array();
        $min_id = $result['min_id'];
        if($min_id <= 0){
            $min_id = 1;
        }
        $max_id = $result['max_id'];
        $total = ($max_id-$min_id) + 1;
        $query = "select value from username limit ".($min_id-1).", $total";
        $result = $conn->query($query);
        $data = array();
        while($row = $result->fetch_array()){
            array_push($data,$row['value']);
        }
        array_push($data,$username);
        sort($data);
        $key = array_search($username,$data);
        $min_id = $key+$min_id;
        $query = "UPDATE username SET id=id+1 where id >=$min_id;";
        $query .= "INSERT INTO username(id,value,user_id) VALUES($min_id,'$username',$login)";
        echo $query;
        if($conn->multi_query($query) == true){
            header('location: user/index.php');
        }
        else{
            header('location: set_username.php?msg=tryagain');
        }
    }
?>