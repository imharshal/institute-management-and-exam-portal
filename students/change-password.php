<?php require("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Change Password</h1>
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
					<div class="card">

						<div class="card-body col-md-6">
						<h3 class="card-title text-bold" style="color: red;">This feature is not available as of now, We request you to do not forgot your password.</h3>
							<form class="form" role="form" autocomplete="off">
								<div class="form-group">
									<label for="inputPasswordOld">Current Password</label>
									<input type="password" class="form-control" id="inputPasswordOld" required="" readonly>
								</div>
								<div class="form-group">
									<label for="inputPasswordNew">New Password</label>
									<input type="password" class="form-control" id="inputPasswordNew" required="" readonly>
									<span class="form-text small text-muted">
										The password must be 8-20 characters, and must <em>not</em> contain spaces.
									</span>
								</div>
								<div class="form-group">
									<label for="inputPasswordNewVerify">Confirm New Password</label>
									<input type="password" class="form-control" id="inputPasswordNewVerify" required="" readonly>
									<span class="form-text small text-muted">
										To confirm, type the new password again.
									</span>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary float-right w-25" hidden>Save</button>
								</div>
							</form>
							</ </div>
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

<?php include("includes/footer.php") ?>