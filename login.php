<?php
    session_start();
    $msg = "";
    if(isset($_SESSION['login'])){
        header('location: user/index.php');
    }
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo - Login</title>
    </head>
    <body>
        <header class="jumbotron p-5 mdb-color darken-3 mb-0">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </header>
        <div class="container-fluid purple-gradient p-3">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 card p-4 mt-5 mb-5">
                    <h3 class="text-center text-monospace p-3">Login <hr class="bg-warning"></h3>
                    
                    <?php if($msg === 'pf'){ ?>
                    <div class="alert alert-danger text-center" role="alert">Wrong Password...</div>
                    <?php } else if($msg === 'ne'){ ?>
                    <div class="alert alert-danger text-center" role="alert">Email does not Exist...</div>
                    <?php } ?>
                    
                    <form method="post" action="login_user.php">
                        <div class="form-group p-2">
                            <label class="label">Email: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" id="email" maxlength="256" required>
                        </div>
                        <div class="form-group p-2">
                            <label class="label">Password: <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password" id="pass" minlength="8" maxlength="32" id="password" required>
                            <label class="ml-4 mt-1 form-check-label"><input type="checkbox" tabindex="-1" name="chkpass" id="chkpass" onchange='showPass("chkpass","pass")' class="form-check-input">Show Password</label>
                        </div>
                        <div class="form-group p-2 text-center">
                            <input class="btn btn-success" type="submit" value="Login">
                            <input class="btn btn-danger" type="button" value="Back" onclick='location.href="index.php"'>
                        </div>
                    </form>
                    
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <script type="text/javascript">
            function showPass(chk,pass){
                var chk = document.getElementById(chk);
                if(chk.checked == true){
                    document.getElementById(pass).setAttribute("type","text");
                }
                else{
                    document.getElementById(pass).setAttribute("type","password");
                }
            }
        </script>
        <?php require 'footer.php'; ?>
    </body>
</html>