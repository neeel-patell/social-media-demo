<?php require_once 'login_check.php'; ?>
<header class="jumbotron p-2 mdb-color darken-3 mb-0">
    <div class="row p-5">
        <div class="col-md-6 mb-3">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-light btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-lowercase h6 text-monospace"><i class="fas fa-user-alt"></i> <?php echo $full_name; ?></span>
                </button>
                <div class="dropdown-menu text-center">
                    <a class="dropdown-item" href="#">Profile <i class="fas fa-user-alt"></i></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../logout.php">Log Out <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-warning bg-warning">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav_bar" aria-controls="nav_bar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav_bar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link brown-text font-weight-bold" data-toggle="collapse" data-target="#post_collapse" area-expanded="false"><i class="fas fa-plus"></i> Add Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link brown-text font-weight-bold" href="friends.php"><i class="fas fa-users"></i> Friends</a>
            </li>
        </ul>
    </div>
</nav>
<!-- header and navigation -->