<?php
    require 'login_check.php';
    $conn = getConn();
    $type = $conn->query("select name from type"); // Fetch for display in type in add post
    $artist = $conn->query("select first_name,last_name,username from artist"); // Fetch for display in type in add post
    $friends = array();
    $result = $conn->query("select friend_id from friend where user_id=$login and approve=1"); // Fetched to see posts of people who are connected with you
    while($row = $result->fetch_array()){
        array_push($friends,$row['friend_id']);
    }
    $friends = implode(",",$friends);
    if($friends === ""){
        $friends = 0;
    }
    $query = "select id'image',description,type_id'type',user_id'user',created_at'date' from post where user_id in ($friends,$login) order by created_at desc"; // Fetch posts to display
    $post = $conn->query($query);
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo - Feed</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <h3 class="jumbotron text-white bg-primary p-3 pl-5"><i class="fas fa-house-user"></i> Feed</h3>
        <div class="container-fluid">
            <a class="btn btn-link btn-dark border border-danger p-3 mt-3 white-text font-weight-bold" data-toggle="collapse" data-target="#post_collapse" area-expanded="false"><i class="fas fa-plus"></i> Add Post</a>
            <div class="row p-3 collapse" id="post_collapse">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 card">
                    <div class="container">
                        <div class="row p-3">
                            <div class="col-md-3"></div>
                            <form action="add_post.php" method="post" class="col-md-6 border rounded p-3 border-success" onsubmit="document.getElementById('tagged_artist').disabled = false;" enctype="multipart/form-data">
                                <h5><i class="fas fa-plus"></i> Add New Post</h5>
                                <textarea class="form-control" name="description" placeholder="Description" rows="8" style="resize: none;" maxlength="2000" required></textarea>
                                <input list="type" type="text" class="form-control mt-2" placeholder="Select type of Post" name="type">
                                <datalist id="type">
                                    <?php while($row = $type->fetch_array()){ ?>
                                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?>
                                </datalist>
                                <div class="form-group mt-2">
                                    <input list="artist" type="text" class="form-control w-75 float-left" placeholder="Search Artist to tag" id="tag_artist">
                                    <button type="button" class="form-control w-25 btn-dark" onclick="add_tagged()">Tag</button>
                                </div>
                                <datalist id="artist">
                                    <?php while($row = $artist->fetch_array()){ ?>
                                    <option value="<?php echo $row['username']; ?>"><?php echo $row['first_name']." ".$row['last_name']; ?></option>
                                    <?php } ?>
                                </datalist>
                                <div class="form-group mt-2">
                                    <input type="text" class="form-control w-75 float-left" placeholder="Tagged artist will appear here" name="tagged_artist" id="tagged_artist" disabled>
                                    <button type="button" class="form-control w-25 btn-danger" onclick="make_editable()">Remove</button>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="file" class="btn btn-dark" name="image" accept="image/*">
                                </div>
                                <input type="submit" class="btn btn-primary p-2 pl-4 pr-4 rounded m-0 mt-2" value="Post">
                            </form>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        <div class="container w-50 mt-3">
            <?php
                if(mysqli_num_rows($post) == 0){
                    echo "Follow people to view posts";
                }
                else{
                    while($row = $post->fetch_array()){
                    $result = $conn->query("select value from username where user_id=".$row['user']); // Name of User who's post is
                    $result = $result->fetch_array();
                    $row['user'] = '@ '.$result['value'];
                    $description = explode(" ",$row['description']); // Description stored as array to find existing urls
                    $type = $conn->query("select name from type where id=".$row['type']); // Find type of post
                    $type = $type->fetch_array();
                    $tagged = "";
                    $result = $conn->query("select username from artist join post_artist where post_artist.post_id=".$row['image']." and artist_id=artist.id"); // Find tagged artists in the post
                    while($artist = $result->fetch_array()){
                        $tagged .= $artist['username']." ";
                    }
                ?>
                <div class="card p-3 mb-3">
                    <div>
                        <div class="row">
                            <div class="col-md-6 h5">
                                <?php echo $row['user'] ?>
                            </div>
                            <div class="col-md-6 h6">
                                Posted on : <?php echo date('dS F Y  H:i A',strtotime($row['date'])); ?>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="../files/images/posts/<?php echo $row['image']; ?>.jpg" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                Type : <?php echo $type['name']; ?><br>
                                <div class="border border-success rounded p-3 mt-2">
                                <?php
                                    foreach($description as $data){
                                        if(preg_match("#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si",$data)){ // Finding of link if word is link
                                            echo "<a href='$data' target='_blank'>$data</a> ";
                                        }
                                        else{
                                            echo $data." ";
                                        }
                                    }
                                    echo "<br><br>$tagged";
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
       </div>
        <script type="text/javascript">
            function add_tagged(){
                var artist = document.getElementById('tag_artist');
                document.getElementById('tagged_artist').value = document.getElementById('tagged_artist').value+" "+artist.value;
                document.getElementById('tagged_artist').disabled = true;
            }
            function make_editable(){
                var tagged_artist = document.getElementById('tagged_artist');
                tagged_artist.disabled = false;
            }
        </script>
        <?php require 'footer.php'; ?>
    </body>
</html>
