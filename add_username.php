<?php
    require 'connection.php';
    $conn = getConn();
    session_start();

    $login = $_SESSION['login']; // Id where we want to change username
    $username = $_POST['username']; 
    if(is_numeric($username[0]) == true){ // backend validation for 1st letter should be character or underscore
        header('location: set_username?msg=num');
    }
    $username = strtolower($username); // converted to lower if bymistake regex allow it in capital in some systems with lower version of safari, Internet explorer
    $query = "select id from username where value='$username'"; // chech for already available username existatance
    $result = $conn->query($query);

    if(mysqli_num_rows($result) != 0){ // if available then redirect to use other one
        header('location: set_username.php?msg=notavailable');
    }

    else{
        $character = $username[0]; // getting 1st charcter of username
        if($character === "_"){
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '\_%'"; // fetching available entries' min and max id for underscore
        }
        else{
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '$character%'"; // fetching available entries' min and max id for character
        }
        $result = $conn->query($query);
        $result = $result->fetch_array();
        $min_id = $result['min_id'];
        if(($min_id == 0 || $min_id === null) && $character === '_'){ // if min id is either 0 or not set and character is underscore then 
            $min_id = 1;
            $max_id = 0;
        }
        else if($min_id == 0 || $min_id === null){ // if min id is either 0 or not set and character is not underscore then 
            $min_id = get_min_id($character);
            $max_id = $min_id-1;
        }
        else{ // if min id is not 0 and the character is any letter or underscore
            $max_id = $result['max_id'];
            $total = ($max_id-$min_id) + 1; // finding total entries
            $query = "select value from username limit ".($min_id-1).", $total"; // getting all entries for character
            $result = $conn->query($query);
            $data = array();
            while($row = $result->fetch_array()){
                array_push($data,$row['value']); // making array of available entries for character to sort
            }
            array_push($data,$username); // adding current username to it
            sort($data); // shorting all entries
            $key = array_search($username,$data); // getting the position of username in sorted
            $min_id = $key+$min_id; // getting position where username should be placed in database
        }
        $query = "UPDATE username SET id=id+1 where id >=$min_id;"; // updating all entries id which should be after actual position
        $query .= "INSERT INTO username(id,value,user_id) VALUES($min_id,'$username',$login);"; // inserting username to actual position in database
        $query .= "UPDATE username_index set start_index=$min_id, end_index=".($max_id+1)." WHERE `character`='$character';"; // updating searching index for the character
        if($character !== 'z'){ // if character is z then no need to find next characters
            $string = updatable_characters($character);
            $query .= "UPDATE username_index set start_index = start_index + 1, end_index = end_index + 1 WHERE `character` IN($string) AND end_index <> 0"; // updating searching index of characters which are after current character
        }
        if($conn->multi_query($query) == true){
            header('location: user/index.php');
        }
        else{
            header('location: set_username.php?msg=tryagain'); // indexing fail
        }
    }
    function updatable_characters($character){ // finding next characters
        $string = "";
        if($character === '_'){ // if its underscore then all characters from a-z will be next
            for($i = 'a' ; $i < 'z' ; $i++){
                $string .= "'$i',";
            }
        }
        else{
            for($i = ++$character ; $i < 'z'; $i++){ // if particular character is there then it'll be upto z
                $string .= "'$i',";
            }
        }
        return $string."'z'";
    }
    function get_min_id($character){ // recursive function to find proper position if there is no entries for current character to find previous character available's max id
        if($character !== '_'){ // underscore is very first character in sorting
            $character = chr(ord($character)-1); // find previous character
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '$character%'"; // finding availablability of previous character
        }
        else{
            $query = "select min(id)'min_id',max(id)'max_id' from username where value like '\\$character%'"; // if there is no max id for previous character till 'a' then fetch for '_'
        }
        $conn = getConn();
        $result = $conn->query($query);
        $result = $result->fetch_array();
        if($result['max_id'] !== null){ // checking maximumm id for previous character available or not
            $max_id = $result['max_id'];
        }
        else{
            $max_id = 0; // if not available then make it 0
        }
        if($max_id == 0){
            if($character === 'a'){ // character is 'a' then previous will be '_' as per algorithm
                return get_min_id('_');
            }
            else if($character !== '_'){ // if character is not underscore then send it
                return get_min_id($character);
            }
            else{
                return 1; // return 1 as position when you don'd find min id
            }
        }
        else{
            return ($max_id+1); // return position if we get previous character max id as already set
        }
    }
?>