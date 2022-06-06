<?php
function active($currect_page)
{
    $url = $_SERVER['REQUEST_URI'];

    if ($currect_page == $url) {
        echo 'active';
    }
}
?>
<?php
$student = DB::queryFirstRow("SELECT * FROM usrregistration WHERE registrationId = %s", $_SESSION['student']);
$enrolled = DB::queryFirstRow("SELECT count(id) FROM courses_enrolled WHERE studentId=%s", $_SESSION['student'])
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
                <a href="#" class="d-block"><?php echo $student['name']; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="index.php" class="nav-link <?php active($page_url . '/index.php') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="profile.php" class="nav-link <?php active($page_url . '/profile.php') ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            My Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="admission.php" class="nav-link <?php active($page_url . '/admission.php') || active($page_url . '/enroll_course.php') ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Enroll Course
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="documents.php" class="nav-link <?php active($page_url . '/documents.php') ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Documents & Certificates
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="accounts.php" class="nav-link <?php active($page_url . '/accounts.php*') ?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Accounts
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="courses.php" class="nav-link <?php active($page_url . '/courses.php*') ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            My Courses
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="change-password.php" class="nav-link <?php active($page_url . '/change-password.php') ?>">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Change password
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="logout.php" class="nav-link <?php active($page_url . '/index.php') ?>">
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