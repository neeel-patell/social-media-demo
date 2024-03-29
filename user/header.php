<?php require_once 'login_check.php'; ?>
<header class="jumbotron p-2 mdb-color darken-3 mb-0">
    <div class="row p-5">
        <div class="col-md-8 mb-3">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav_bar" aria-controls="nav_bar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav_bar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link brown-text font-weight-bold" href="index.php"><i class="fas fa-home"></i> Feed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link brown-text font-weight-bold" href="friends.php"><i class="fas fa-people-arrows"></i> Friends</a>
            </li>
            <li class="nav-item">
                <a class="nav-link brown-text font-weight-bold" href="people.php"><i class="fas fa-users"></i> People</a>
            </li>
        </ul>
        <div class="d-inline">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link brown-text font-weight-bold" href="../logout.php">Logout <i class="fas fa-sign-out-alt"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- header and navigation -->