<?php
    header('content-type: application/json');
    include '../connection.php';
    $conn = getConn();
    $data = array();

    $character = $_POST['character'];
    $query = "select start_index,end_index from username_index where `character`='$character'";
    $result = $conn->query($query);
    $result = $result->fetch_array();
    array_push($data,array("min"=>$result['start_index'],"max"=>$result['end_index']));
    echo json_encode($data);
?>