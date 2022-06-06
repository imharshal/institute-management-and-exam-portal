<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Retrive Forms</h1>
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
									<a class="nav-link active" id="archieve-forms" data-toggle="pill" href="#tab-archieve-forms" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Enrollment Form</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="archieve-receipt" data-toggle="pill" href="#tab-archieve-receipt" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Payment Receipt</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-one-tabContent">
								<!-- Department Tab -->
								<?php include("includes/tabs/tab_archieve_forms.php") ?>
								<!--./ Department Tab -->

								<!-- Add New Department Tab -->
								<?php include("includes/tabs/tab_archieve_receipt.php") ?>
								<!-- ./ Add New Department Tab -->
							</div>
						</div>
						<!-- /.card-body -->
					</div>
					<div class="card d-none" id="result-card">
						<center><button class="m-3 btn btn-primary" id="print" onclick="printJS('generatedForm', 'html')">Print/Download result</button></center>
						<div class="card-body">
							<div class="row">
								<div class="offset-md-2 col" style="overflow-x: scroll;">
									<div id="generatedForm"></div>
									<div style="height: 50px;"></div>
								</div>
							</div>
						</div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script>
	$('#fetch-form').addClass('disabled');
	$('#fetch-receipt').addClass('disabled');
	// refresh_student_list(form = true);
	var studentsList;
	$('.select-name').selectpicker('refresh');

	//refresh the students list on form load
	$.ajax({
		url: 'api.php',
		type: 'get',
		data: 'getAllStudents',
		dataType: 'json',
		success: function(data) {
			studentsList = data;
			$.each(data, function(i, row) {
				$('#students-form').append($('<option>').text(row.name).attr({
					'value': row.id,
					'data-subtext': row.id
				}));
			});
			$('#fetch-form').addClass('disabled');
			$('#students-form').selectpicker('refresh');
		}
	});

	//refresh student list on tab change
	$('#archieve-form').on("shown.bs.tab", function(event) {
		$('#students-form').empty();
		$.each(studentsList, function(i, row) {
			// console.log(row.name)
			$('#students-form').append($('<option>').text(row.name).attr({
				'value': row.id,
				'data-subtext': row.id
			}));
		});

		$('#fetch-form').addClass('disabled');
		$('#students-form').selectpicker('refresh');
	});

	//refresh student list on tab change
	$('#archieve-receipt').on("shown.bs.tab", function(event) {
		$('#students-receipt').empty();
		$.each(studentsList, function(i, row) {
			// console.log(row.name)
			$('#students-receipt').append($('<option>').text(row.name).attr({
				'value': row.id,
				'data-subtext': row.id
			}));
		});
		$('#fetch-receipt').addClass('disabled');
		$('#students-receipt').selectpicker('refresh');
	})



	//change enrollment list on student change
	$('#students-form').on('change', function() {
		$('#enrollments').empty();
		studentid = $('#students-form').val();
		$.ajax({
			url: 'api.php',
			type: 'get',
			data: {
				'getAllEnrollments': studentid
			},
			dataType: 'json',
			success: function(data) {
				// console.log(data)
				$.each(data, function(i, row) {
					// console.log(row.name)
					$('#enrollments').append($('<option>').text(row.name).attr({
						'value': row.id,
						'data-subtext': row.id
					}));
				});
				$('#result-card').addClass('d-none');
				$('#enrollments').selectpicker('refresh');

			}
		});
	})

	//change transaction list on student change
	$('#students-receipt').on('change', function() {
		$('#transactions').empty();
		studentid = $('#students-receipt').val();
		$.ajax({
			url: 'api.php',
			type: 'get',
			data: {
				'getAllTransactions': studentid
			},
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, row) {
					$('#transactions').append($('<option>').text(row.id).attr({
						'value': row.id,
						'data-subtext': row.datetime
					}));

				});
				$('#result-card').addClass('d-none');
				$('#transactions').selectpicker('refresh');
			}
		});
	})

	//enable fetch button on enrollment select
	$('#enrollments').on('change', function() {
		$('#fetch-form').removeClass('disabled');
	})

	$('#transactions').on('change', function() {
		$('#fetch-receipt').removeClass('disabled');
	})

	//fetch enrollment form on button click
	$('#fetch-form').on('click', function() {
		$.ajax({
			type: "POST",
			url: "../includes/admission_acknoledgement.php",
			data: {
				print: true,
				registrationId: $('#students-form :selected').val(),
				enrollmentId: $('#enrollments :selected').val()
			},
			success: function(data) {
				$('#generatedForm').html(data);
				$('#fetch-form').addClass('disabled');
				$('#result-card').removeClass('d-none');
			}
		})
	});
	$('#fetch-receipt').on('click', function() {
		$.ajax({
			type: "POST",
			url: "../includes/invoice.php",
			data: {
				print: true,
				archieve:true,
				registrationId: $('#students-receipt :selected').val(),
				txnId: $('#transactions :selected').val()
			},
			success: function(data) {
				$('#generatedForm').html(data);
				$('#fetch-receipt').addClass('disabled');
				$('#result-card').removeClass('d-none');
			}
		})
	});
</script>


</body>

</html>