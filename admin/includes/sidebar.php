<?php
function active($currect_page) {
    $url = $_SERVER['REQUEST_URI'];

    if($currect_page == $url){
        echo 'active';
    }
}

$page_url = '/admin';
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-teal elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="#" class="brand-link">
        <img src="assets/img/logo-big.jpg" alt="SSDIT-logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bolder">SSDIT</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/img/user-icon.png" class="img-circle elevation-2" alt="User Image">
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
                <li class="nav-item">
                    <a href="courses.php" class="nav-link <?php active($page_url.'/courses.php')?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Courses
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="admission.php" class="nav-link <?php active($page_url.'/admission.php')?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Admission
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="edit_details.php" class="nav-link <?php active($page_url.'/edit_details.php')?>">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Edit Details
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="enroll_course.php" class="nav-link <?php active($page_url.'/enroll_course.php')?>">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>
                            Enroll Course
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="documents.php" class="nav-link <?php active($page_url.'/documents.php')?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Documents
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="students.php" class="nav-link <?php active($page_url.'/students.php')?>">
                        <i class="nav-icon fas fa-users "></i>
                        <p>
                            Students
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="employees.php" class="nav-link <?php active($page_url.'/employees.php')?>">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Employees
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="exam/" class="nav-link ">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            Exam Portal
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="results.php" class="nav-link <?php active($page_url.'/results.php')?>">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Results
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="accounts.php" class="nav-link <?php active($page_url.'/accounts.php')?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Accounts
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="archive.php" class="nav-link <?php active($page_url.'/archive.php')?>">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                            Applications/Receipts
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="change_password.php" class="nav-link <?php active($page_url.'/change_password.php')?>">
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