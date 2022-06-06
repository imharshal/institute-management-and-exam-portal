<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Employees</h1>
				</div>
			</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="container-fluid">
			<div class="row">

				<!-- Default box -->

				<div class="col">
					<div class="card card-teal card-tabs">

						<div class="card-body">
							<table id="example1" class="" data-toggle="table" data-search="true" data-pagination="true">
								<thead class="">
									<tr>
										<th data-sortable="true">Profile</th>
										<th data-sortable="true">ID</th>
										<th data-sortable="true">Employees Name</th>
										<th data-sortable="true">Contact no</th>
										<th data-sortable="true">Referred By</th>
										<th data-sortable="true">Date of joining</th>
										<th data-sortable="true">Experience (months)</th>

									</tr>
								</thead>
								<tbody>
									<?php
									$employees = DB::query(
										"SELECT * FROM usrregistration u
										RIGHT JOIN admissions
										ON u.registrationId = admissions.id
										RIGHT JOIN employees
										ON u.registrationId = employees.id
										WHERE u.role=%s",
										'emp'
									);
									// print_r($employees);
									foreach ($employees as $emp) {
									?>
										<tr>
											<td class="text-center"><a target="_blank" href="./user_profile.php?u=<?php echo $emp['id'] ?>" class="badge badge-primary"><i class="fas fa-eye"></i> View</a></td>
											<td><?php echo $emp['id'] ?></td>
											<td><?php echo $emp['uname'] ?></td>
											<td><?php echo $emp['mobile'] ?></td>
											<td><?php echo $emp['userLevel'] ?></td>
											<td><?php echo $emp['doj'] ?></td>
											<td><?php echo $emp['experience'] ?></td>
										</tr>
									<?php } ?>

								</tbody>
							</table>
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