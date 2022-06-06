<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<!-- Content Wrapper. Contains page content -->
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/custom-view/bootstrap-table-custom-view.js"></script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Documents</h1>
				</div>

			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="container-fluid">
			<div class="row">
				<div class="card col-12 p-3">
					<table id="example1" class="" data-toggle="table" data-search="true" data-pagination="true">
						<thead class="">
							<tr>
								<th data-sortable="true">Reg. ID</th>
								<th data-sortable="true">Name</th>
								<th data-sortable="true">Relation</th>
								<th data-sortable="true">Contact no</th>
								<th data-sortable="true">Photo</th>
								<th data-sortable="true">Aadhar</th>
								<th data-sortable="true">Passbook</th>
								<th data-sortable="true">TC</th>
								<th data-sortable="true">Marksheet</th>
								<th data-sortable="true">Income</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$candidate = DB::query("SELECT * FROM admissions
													RIGHT JOIN usrregistration
													ON admissions.id = registrationId
													RIGHT JOIN documents
													ON admissions.id = documents.id");
							foreach ($candidate as $cd) {
							?>
								<tr>
									<td><?php echo $cd['id'] ?></td>
									<td><?php echo $cd['uname'] ?></td>
									<td><?php
										if ($cd['role'] == 'stud') echo 'Student';
										elseif ($cd['role'] == 'emp') echo 'Employee';
										elseif ($cd['role'] == 'empdip') echo 'Employee + Diploma';
										?>
									</td>
									<td><?php echo $cd['mobile'] ?></td>
									<td>
										<?php if (!empty($cd['photo'])) { ?>
											<a target="_blank" class="badge badge-info" href="/<?php echo $cd['photo'] ?>">view</a>
										<?php } ?>
									</td>
									<td>
										<?php if (!empty($cd['aadhar'])) { ?>
											<a target="_blank" class="badge badge-info" href="/<?php echo $cd['aadhar'] ?>">view</a>
										<?php } ?>
									</td>
									<td>
										<?php if (!empty($cd['passbook'])) { ?>
											<a target="_blank" class="badge badge-info" href="/<?php echo $cd['passbook'] ?>">view</a>
										<?php } ?>
									</td>
									<td>
										<?php if (!empty($cd['tc'])) { ?>
											<a target="_blank" class="badge badge-info" href="/<?php echo $cd['tc'] ?>">view</a>
										<?php } ?>
									</td>
									<td>
										<?php if (!empty($cd['marksheet'])) { ?>
											<a target="_blank" class="badge badge-info" href="/<?php echo $cd['marksheet'] ?>">view</a>
										<?php } ?>
									</td>
									<td>
										<?php if (!empty($cd['income'])) { ?>
											<a target="_blank" class="badge badge-info" href="/<?php echo $cd['income'] ?>">view</a>
										<?php } ?>
									</td>

								</tr>
							<?php } ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<!-- <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/custom-view/bootstrap-table-custom-view.js"></script> -->

<script>


</script>
</body>

</html>