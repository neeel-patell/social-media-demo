<?php
    require 'login_check.php';
    $conn = getConn(); 
    $type = $conn->query("select name from type");
    $artist = $conn->query("select first_name,last_name,username from artist");
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo - Feed</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <h3 class="container-fluid text-white bg-primary p-3 text-center">Feed</h3>
        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-lg-2"></div>
                <div class="col-lg-8 card">
                    <div class="container">
                        <div class="row p-3">
                            <div class="col-md-3"></div>
                            <form action="add_post.php" method="post" class="col-md-6 border rounded p-3 border-success" onsubmit="document.getElementById('tagged_artist').disabled = false;">
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
                                <input type="submit" class="btn btn-primary p-2 pl-4 pr-4 rounded m-0 mt-2" value="Post">
                            </form>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
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