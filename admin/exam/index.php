
<?php include("includes/header.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("../../includes/dbmethods.php") ?>
<?php
 $exam="";
 $exam = DB::query("SELECT count(id) FROM exams");
 $ready = DB::query("SELECT count(id) FROM exams WHERE status=%s",'Ready');
 $incomplete = DB::query("SELECT count(id) FROM exams WHERE status=%s",'Incomplete');
 $active = DB::query("SELECT count(id) FROM exams WHERE status=%s",'Active');
 $completed = DB::query("SELECT count(id) FROM exams WHERE status=%s",'Completed');

?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo strval($active[0]['count(id)']) ?></h3>

                                    <p>Active Now</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <a href="./exams.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo strval($completed[0]['count(id)']) ?></h3>

                                    <p>Completed Exams</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <a href="./exams.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box  bg-teal">
                                <div class="inner">
                                    <h3><?php echo strval($ready[0]['count(id)']) ?></h3>

                                    <p>Ready to take</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <a href="./exams.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo strval($incomplete[0]['count(id)']) ?></h3>

                                    <p>Incomplete</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-book-reader"></i>
                                </div>
                                <a href="./exams.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


<?php include("includes/scripts.php") ?>

</body>

</html> 