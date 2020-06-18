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
        if($character === "_"){
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '\_%'";
        }
        else{
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '$character%'";
        }
        $result = $conn->query($query);
        $result = $result->fetch_array();
        $min_id = $result['min_id'];
        if(($min_id == 0 || $min_id === null) && $character === '_'){
            $min_id = 1;
            $max_id = 0;
        }
        else if($min_id == 0 || $min_id === null){
            $min_id = get_min_id($character);
            $max_id = $min_id-1;
        }
        else{
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
        }
        $query = "UPDATE username SET id=id+1 where id >=$min_id;";
        $query .= "INSERT INTO username(id,value,user_id) VALUES($min_id,'$username',$login);";
        $query .= "UPDATE username_index set start_index=$min_id, end_index=".($max_id+1)." WHERE `character`='$character';";
        if($character !== 'z'){
            $string = updatable_characters($character);
            $query .= "UPDATE username_index set start_index = start_index + 1, end_index = end_index + 1 WHERE `character` IN($string) AND end_index <> 0";
        }
        if($conn->multi_query($query) == true){
            header('location: user/index.php');
        }
        else{
            header('location: set_username.php?msg=tryagain');
        }
    }
    function updatable_characters($character){
        $string = "";
        if($character === '_'){
            for($i = 'a' ; $i < 'z' ; $i++){
                $string .= "'$i',";
            }
        }
        else{
            for($i = ++$character ; $i < 'z'; $i++){
                $string .= "'$i',";
            }
        }
        return $string."'z'";
    }
    function get_min_id($character){
        if($character !== '_'){
            $character = chr(ord($character)-1);
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '$character%'";
        }
        else{
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '\\$character%'";
        }
        $conn = getConn();
        $result = $conn->query($query);
        $result = $result->fetch_array();
        if($result['max_id'] !== null){
            $max_id = $result['max_id'];
        }
        else{
            $max_id = 0;
        }
        if($max_id == 0){
            if($character === 'a'){
                return get_min_id('_');
            }
            else if($character !== '_'){
                return get_min_id($character);
            }
            else{
                return 1;
            }
        }
        else{
            return ($max_id+1);
        }
    }
?>