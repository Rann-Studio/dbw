<!-- Nav Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Database Berbasis Web</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown" style="display: <?php if(isset($_SESSION['ADMINISTRATOR'])) {echo 'block';} else {echo 'none';}?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Table
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php">View All</a></li>
                        <li><a class="dropdown-item" href="pengungsi.php">Pengungsi</a></li>
                        <li><a class="dropdown-item" href="dana.php">Dana</a></li>
                    </ul>
                </li>
            </ul>
            <?php
                if(isset($_SESSION['ADMINISTRATOR'])) {
                    if(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "index.php"){
                        echo '<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#insertDataModal"><i class="fas fa-plus-circle"></i> Insert New Data</button>&nbsp;';
                    }
                    echo '<form method="post" class="d-flex">';
                    echo '<button name="admLog" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>';
                    echo '</form>';
                } else {
                    echo '<form method="post" class="d-flex">';
                    echo '<button name="admLog" class="btn btn-success btn-sm" type="submit"><i class="fas fa-sign-out-alt"></i> Login</button>';
                    echo '</form>';
                }
            ?>
        </div>
    </div>
</nav>

<?php
    if (isset($_POST['admLog'])){
         if (isset($_SESSION['ADMINISTRATOR'])) {
            session_destroy();
            header("Location: index.php");
        } else {
            header("Location: login.php");
        }
    }
?>
<!-- End Nav Bar -->