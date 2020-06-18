<?php
    session_start();
    $login = 0;
    $msg = "";
    if(isset($_SESSION['login'])){ // check login, It's set or not
        $login = $_SESSION['login']; // give login id to a variable to use
        if($login == 0){
            header("location: index.php"); // Redirection to home page if session is not set properly
        }
    }
    else{
        header("location: index.php"); // Redirection to home page if session is not set
    }
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo - Registration</title>
    </head>
    <body>
        <header class="jumbotron p-5 mdb-color darken-3 mb-0">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </header>
        <div class="container-fluid purple-gradient p-3">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 card p-4 mt-5 mb-5">
                    <h3 class="text-center text-monospace p-3">Set Username <hr class="bg-warning"></h3>
                   
                    <?php if($msg === 'setname'){ ?>
                    <div class="alert alert-secondary text-center" role="alert">Set Username first...</div>
                    <?php }else if($msg === 'notavailable'){ ?>
                    <div class="alert alert-danger text-center" role="alert">Please Pick Other One, This one has taken...</div>
                    <?php }else if($msg === 'tryagain'){ ?>
                    <div class="alert alert-success text-center" role="alert">Please Try again...</div>
                    <?php }else if($msg === 'num'){ ?>
                    <div class="alert alert-warning text-center" role="alert">First letter of username must be alphabet or underscore...</div>
                    <?php } ?>
                        
                    <form class="mt-3" action="add_username.php" method="post" onsubmit="return post_check()">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" class="form-control" onkeypress="check()" placeholder="Enter Username" aria-label="Username" aria-describedby="basic-addon1" name="username" id="username" maxlength="32" required>
                        </div>
                        
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Use">
                        </div>
                        
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <script type="text/javascript">
            // regex for frontend and presubmit validation
            function check(){
                var username = document.getElementById('username');
                var regex = /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/igm;
                if(regex.test(username.value) == false){
                    username.setAttribute("class","form-control border border-danger");
                }
                else{
                    username.setAttribute("class","form-control border border-success");
                }
            }
            function post_check(){
                var username = document.getElementById('username');
                var regex = /^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/igm;
                if(regex.test(username.value) == false){
                    alert("Username doesn't match with criteria");
                    return false;
                }
                else{
                    return true;
                }
            }
        </script>
        <?php require 'footer.php'; ?>
    </body>
</html>