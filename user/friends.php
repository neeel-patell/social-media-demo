<?php
    require 'login_check.php';
    $query = "select friend_id,approve from friend where user_id = $login and approve<>3 order by approve desc";
    echo $query;
    $friends = $conn->query($query);
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo - Friends</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <h3 class="container-fluid text-white bg-primary p-3 text-center">Friends</h3>
        <div class="container p-3 pl-5 pr-5">
            <div class="row">
                <?php
                    while($row = $friends->fetch_array()){
                    $name = $conn->query("select first_name,last_name,username from user where active=1 and id=".$row['friend_id']);
                    $name = $name->fetch_array();
                    $rev_follow = $conn->query("select friend_id from friend where user_id=".$row['friend_id']." and friend_id=$login and approve=1");
                ?>
                <div class="card p-3 col-md-4 mb-3">
                    <div>
                        <img src="../files/images/profile/<?php echo $row['friend_id']; ?>.jpg" class="float-left border rounded mr-5 p-2" style="width: 20%; height:70px; display:inline-block;" alt="Image">
                        <h6 class="ml-5 font-weight-bold"><?php echo $name['first_name'].' '.$name['last_name']; ?></h6>
                        <h6 class="text-primary h6 ml-5 mt-0 font-weight-bold">@ <?php echo $name['username']; ?></h6>
                    </div>
                    <div class="p-2 text-center">
                        <?php if($row['approve'] == 1){ ?>
                        <button class="btn btn-success rounded p-2 text-capitalize"><i class="fas fa-check"></i> Following</button>
                        <?php } else if($row['approve'] == 2) { ?>
                        <button class="btn btn-success rounded p-2 text-capitalize"><i class="fas fa-user"></i> requested</button>
                        <?php } ?>
                        <?php if(mysqli_num_rows($rev_follow) > 0){ ?>
                        <button class="btn p-2 btn-primary font-weight-bold rounded text-capitalize" disabled>Follows You</button>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <?php } ?>
            </div>
        </div>
        <div class="container w-50 mt-3">
        
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