<?php
function active($currect_page) {
    $url = $_SERVER['REQUEST_URI'];

    if($currect_page == $url){
        echo 'active';
    }
}

$page_url = '/admin/exam';
$admin_url ='/admin';
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-purple elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="#" class="brand-link">
        <img src="../assets/img/logo-big.jpg" alt="SSDIT-logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bolder">SSDIT</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../assets/img/user-icon.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="<?php echo $page_url ?>" class="nav-link <?php active($page_url.'/')?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="create_exam.php" class="nav-link <?php active($page_url.'/create_exam.php')?>">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            Create Exam
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="exams.php" class="nav-link <?php active($page_url.'/exams.php')?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Manage Exams
                        </p>
                    </a>
                </li>
               <li class="nav-item ">
                    <a href="/admin/" class="nav-link ">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Admin Panel
                        </p>
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>