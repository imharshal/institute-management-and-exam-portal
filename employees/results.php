<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>

<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Results</h1>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<!-- Default box -->
					<div class="card card-teal card-tabs">
						<div class="card-header p-0 pt-1">
							<ul class="nav nav-tabs" id="accounts-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="accounts-tab1" data-toggle="pill" href="#tab-results" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Results</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="accounts-tab2" data-toggle="pill" href="#tab-results-certificates" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Certificates</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-one-tabContent">
								<!-- Department Tab -->
								<?php include("includes/tabs/tab_results.php") ?>
								<!--./ Department Tab -->

								<!-- Add New Department Tab -->
								<?php include("includes/tabs/tab_results_certificates.php") ?>
								<!-- ./ Add New Department Tab -->
							</div>
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

<?php include("includes/scripts.php") ?>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
</body>

</html>