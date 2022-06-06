<?php
function active($currect_page) {
    $url = $_SERVER['REQUEST_URI'];

    if($currect_page == $url){
        echo 'active';
    }
}
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-teal elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/img/user-icon.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Employee Name</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="index.php" class="nav-link <?php active($page_url.'/index.php')?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="profile.php" class="nav-link <?php active($page_url.'/profile.php')?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            My Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="stdadmission.php" class="nav-link <?php active($page_url.'/stdadmission.php')?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Students Admission
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="documents.php" class="nav-link <?php active($page_url.'/documents.php')?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Documents & Certificates
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="results.php" class="nav-link <?php active($page_url.'/results.php')?>">
                        <i class="nav-icon fas fa-users "></i>
                        <p>
                            Students' Results
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="accounts.php" class="nav-link <?php active($page_url.'/accounts.php*')?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Accounts
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="change-password.php" class="nav-link <?php active($page_url.'/change-password.php')?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Change password
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="logout.php" class="nav-link <?php active($page_url.'/index.php')?>">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>