<?php
    session_start();
    if(isset($_SESSION['login'])){ // Check that user already logged in or not
        header('location: user/index.php'); // sent to dashboard if user's already logged in
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'css_files.php'; ?>
        <title>Social Media Demo</title>
    </head>
    <body>
        <header class="jumbotron p-5 mdb-color darken-3 mb-0">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </header>
        <div class="container-fluid p-3">
            <div class="row p-3">
                <div class="col-md-4 card p-3 text-center">
                    <a href="login.php" class="link border rounded p-3 bg-primary text-white"><span class="h5">Login (Existing Account)</h5></a>
                    <a href="registration.php" class="link border rounded p-3 bg-primary text-white"><span class="h5">Registration (Create a new Account)</h5></a>
                </div>
            </div>
        </div>
        <?php require 'footer.php'; ?>
    </body>
</html>