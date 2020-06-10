<?php
    require '../connection.php';
    session_start();
    $conn = getConn();

    $description = $_POST['description'];
    $type = $_POST['type'];
    $artist = ltrim($_POST['tagged_artist']);
    $artist = explode("@",$artist); // to distinguise artists and to create array
    unset($artist[0]); // to remove unwanted element
    $login = $_SESSION['login'];
    $image = $_FILES['image'];
    
    $type = $conn->query("select id from type where name='$type'");
    $type = $type->fetch_array();
    $type = $type['id'];

    $query = "INSERT INTO post(description,type_id,user_id) values('$description',$type,$login)";
    if($conn->query($query) == true){
        $post = $conn->query("select id from post where description='$description' and type_id=$type and user_id=$login"); // to get unique post id
        $post = $post->fetch_array();
        $post = $post['id'];
        move_uploaded_file($image['tmp_name'],"../files/images/posts/$post.jpg");
        foreach($artist as $data){
            $query = "select id from artist where username='@$data'";
            $result = $conn->query($query);
            $artist = $result->fetch_array();
            $artist = $artist['id'];
            $conn->query("insert into post_artist(post_id,artist_id) values($post,$artist)"); // to map tagged artists to post
        }
        header("location: index.php");
    }


?>