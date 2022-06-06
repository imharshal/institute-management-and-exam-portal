<?php
// session_start();
// if (isset($_SESSION['logged_in']) && isset($_SESSION['student'])) {
	// header("Location: ./admin");
	// $_SESSION['logged_in'] = false;
	// $_SESSION['user_id'] =false;

?>
<?php require("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("../includes/db_config.php") ?>
<?php 
   $student_detail = DB::queryFirstRow("SELECT * FROM usrregistration WHERE registrationId = %s",$_SESSION['student']);
?>

<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Students</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card card-widget widget-user shadow">
                        <!-- Add the bg color to the header using any of the bg-* classes -->

                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username"><?php echo $student_detail['name'];?></h3>
                            <!-- <h5 class="widget-user-desc"></h5> -->
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="assets/img/user-icon.png" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Registration Id</h5>
                                        <span class="description-text"><?php echo $student['registrationId'];?></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Referral Code</h5>
                                        <span
                                            class="description-text"><?php echo $student_detail['referralCode'] ?></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">Level Chart</h5>
                                        <span class="description-text" data-toggle="dropdown"><a href="">See Here</a></span>
                                        <ul class="dropdown-menu">
                                            <li>Level 1: (0)</li>
                                            <li>Level 2: (0)</li>
                                            <li>Level 3: (0)</li>
                                        </ul>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </div>
                <div class="col col-lg-4">
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Announcements</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h3>Upcoming Exams:</h3>
                            <h5>Unit Test-II</h5>
                            <p><a href="#">Click Here</a> For the Exam.</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php //} else echo "<h1>Please login first .</h1>"; ?>
<?php include("includes/footer.php") ?>