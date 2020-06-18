<?php
    require 'login_check.php';
    $method = "";
    if(isset($_GET['following']) == true){
        $method = "following";
    }
    else if(isset($_GET['requests']) == true){
        $method = "requests";
    }
    else{
        $method = "followers";
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Friends</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <div class="container w-50">
            <div class="d-inline">
                <ul class="nav nav-pills nav-fill mt-1">
                    <li class="nav-item">
                        <a class="nav-link <?php if($method === "following") echo 'bg-success white-text'; ?>" <?php if(!($method === "following")) echo 'href="friends.php?following"'; ?>>Following</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($method === "followers") echo 'bg-success white-text'; ?>" <?php if(!($method === "followers")) echo 'href="friends.php?followers"'; ?>>Followers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($method === "requests") echo 'bg-success white-text'; ?>" <?php if(!($method === "requests")) echo 'href="friends.php?requests"'; ?>>Requests</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container p-3 pl-5 pr-5">
            <div class="row">
            <?php
                if($method === "following"){ 
                    $query = "select friend_id from friend where user_id=$login and approve=1 order by updated_at desc"; // checking to whom you are following
                    $friends = $conn->query($query);
                    while($row = $friends->fetch_array()){
                        $name = $conn->query("select first_name,last_name from user where active=1 and id=".$row['friend_id']); // getting name details
                        $name = $name->fetch_array();
                        $result = $conn->query("select value from username where user_id='".$row['friend_id']."'"); // getting username
                        $result = $result->fetch_array();
                        $name['username'] = $result['value'];
                        $rev_follow = $conn->query("select friend_id from friend where user_id=".$row['friend_id']." and friend_id=$login and approve=1"); // to see he/she follows you back or not
            ?>
            <div class="card p-3 col-md-4 mb-3">
                <div>
                    <img src="../files/images/profile/<?php echo $row['friend_id']; ?>.jpg" class="float-left border rounded mr-5 p-2" style="width: 20%; height:70px; display:inline-block;" alt="Image">
                    <h6 class="ml-5 font-weight-bold"><?php echo $name['first_name'].' '.$name['last_name']; ?></h6>
                    <h6 class="text-primary h6 ml-5 mt-0 font-weight-bold">@ <?php echo $username = $name['username']; ?></h6>
                </div>
                <div class="text-center">
                    <button class="btn btn-light rounded p-2 text-capitalize" onclick="unfollow('<?php echo $username; ?>')">Following</button>
                    <?php if(mysqli_num_rows($rev_follow) > 0){ ?>
                    <button class="btn p-2 btn-primary font-weight-bold rounded text-capitalize" disabled>Follows You</button>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-2"></div>
            <?php }}
                else if($method === "followers"){
                    $query = "select user_id from friend where friend_id=$login and approve = 1 order by updated_at desc"; // getting followers of a user
                    $friends = $conn->query($query);
                    while($row = $friends->fetch_array()){
                        $name = $conn->query("select first_name,last_name from user where active=1 and id=".$row['user_id']); // getting name
                        $name = $name->fetch_array();
                        $result = $conn->query("select value from username where user_id='".$row['user_id']."'"); // getting username
                        $result = $result->fetch_array();
                        $name['username'] = $result['value'];
            ?>
            <div class="card p-3 col-md-4 mb-3">
                <div>
                    <img src="../files/images/profile/<?php echo $row['user_id']; ?>.jpg" class="float-left border rounded mr-5 p-2" style="width: 20%; height:70px; display:inline-block;" alt="Image">
                    <h6 class="ml-5 font-weight-bold"><?php echo $name['first_name'].' '.$name['last_name']; ?></h6>
                    <h6 class="text-primary h6 ml-5 mt-0 font-weight-bold">@ <?php echo $username = $name['username']; ?></h6>
                </div>
                <button class="btn btn-dark rounded p-2 form-control text-capitalize" onclick="remove('<?php echo $username; ?>')">Remove from Followers</button>
            </div>
            <div class="col-md-2"></div>
            <?php }}
                else{
                    $query = "select user_id from friend where friend_id=$login and approve = 0 order by created_at desc"; // getting user who requested
                    $friends = $conn->query($query);
                    while($row = $friends->fetch_array()){
                        $name = $conn->query("select first_name,last_name from user where active=1 and id=".$row['user_id']); // name of requested user
                        $name = $name->fetch_array();
                        $result = $conn->query("select value from username where user_id='".$row['user_id']."'"); // getting username
                        $result = $result->fetch_array();
                        $name['username'] = $result['value'];
            ?>
            <div class="card p-3 col-md-4 mb-3">
                <div>
                    <img src="../files/images/profile/<?php echo $row['user_id']; ?>.jpg" class="float-left border rounded mr-5 p-2" style="width: 20%; height:70px; display:inline-block;" alt="Image">
                    <h6 class="ml-5 font-weight-bold"><?php echo $name['first_name'].' '.$name['last_name']; ?></h6>
                    <h6 class="text-primary h6 ml-5 mt-0 font-weight-bold">@ <?php echo $username = $name['username']; ?></h6>
                </div>
                <div class="clearfix">
                    <button class="btn btn-success rounded form-control p-2 float-left" style="font-family: sans-serif; width: 40%;" onclick="confirm_request('<?php echo $username; ?>')">Confirm</button>
                    <button class="btn btn-secondary rounded form-control p-2 float-right" style="font-family: sans-serif; width: 40%;" onclick="decline_request('<?php echo $username; ?>')">Decline</button>
                </div>
            </div>
            <div class="col-md-2"></div>
            <?php }} ?>
            </div>
        </div>
        <script type="text/javascript">
            function unfollow(username){
                swal({
                    title: "Do you want to unfollow @"+username+"?",
                    text: "Once unfollowed, you will not be able to see posts and updates!",
                    icon: "warning",
                    buttons: ['Cancel','Unfollow'],
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        swal("Unfollowed", {
                        icon: "success",
                        });
                        window.location="remove.php?method=following&username="+username; // request to remove from table
                    }
                });
            }
            function remove(username){
                swal({
                    title: "Do you want to remove @"+username+" from followers?",
                    text: "Once removed, he/she will not be able to see your posts and updates!",
                    icon: "warning",
                    buttons: ['Cancel','Remove'],
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        swal("Removed", {
                        icon: "success",
                        });
                        window.location="remove.php?method=followers&username="+username; // request to remove from table
                    }
                });
            }
            function confirm_request(username){
                swal({
                    title: "Do you want to confirm request from @"+username+"?",
                    text: "Once confirmed, he/she will be able to see your posts and updates!",
                    buttons: ['Cancel','Confirm'],
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        swal("Confirmed", {
                        icon: "success",
                        });
                        window.location="confirm_request.php?username="+username; // request to change approve column value to 1
                    }
                });
            }
            function decline_request(username){
                swal({
                    title: "Do you want to decline @"+username+"'s Request?",
                    icon: "warning",
                    buttons: ['Cancel','Decline'],
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        swal("Removed", {
                        icon: "success",
                        });
                        window.location="remove.php?method=requests&username="+username; // request to remove from table
                    }
                });
            }
        </script>
        <?php require 'footer.php'; ?>
    </body>
</html>