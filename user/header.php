<?php require_once 'login_check.php'; ?>
<header class="jumbotron p-2 mdb-color darken-3 mb-0">
    <div class="row p-5">
        <div class="col-md-6 mb-3">
            <h4 class="font-weight-bolder text-monospace text-warning"><i class="fas fa-globe"></i> Social App <i class="fas fa-users"></i></h4>
        </div>
        <div class="col-md-6 text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-alt"></i> <?php echo $full_name; ?>
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