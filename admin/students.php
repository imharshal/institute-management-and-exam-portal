<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<?php
// $diploma = DB::query("SELECT * FROM courses_enrolled WHERE courseType='Diploma'");
// print_r($diploma);
// $certification = DB::query("SELECT * FROM courses_enrolled WHERE courseType='Certification'");
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Students</h1>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card card-teal card-tabs">
						<div class="card-header p-0 pt-1">
							<ul class="nav nav-tabs col-sm-6" id="student-tab" role="tablist">
								<li class="nav-item ">
									<a class="nav-link active" id="student-tab1" data-toggle="pill" href="#tab-diploma-stud" role="tab">Diploma Students</a>
								</li>
								<li class="nav-item">
									<a class="nav-link " id="student-tab2" data-toggle="pill" href="#tab-cert-stud" role="tab">Certification Course Students</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="student-tabContent">
								<!-- Department Tab -->
								<?php include("includes/tabs/tab_diploma_student.php") ?>
								<!--./ Department Tab -->

								<!-- Add New Department Tab -->
								<?php include("includes/tabs/tab_certificate_student.php") ?>
								<!-- ./ Add New Department Tab -->
							</div>
						</div>
						<!-- /.card -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>
</body>

</html>