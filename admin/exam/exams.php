<?php include("includes/header.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("../../includes/dbmethods.php") ?>


<?php

$warning = $success = $error = [];
$action_examid;
$conduct_status = $conduct_warning = $conduct_active_warning = $completed_status = $completed_warning = $completed_already_warning = false;

date_default_timezone_set('Asia/Kolkata');

if (isset($_GET['conduct'])) {
	$GLOBALS['action_examid'] = $_GET['conduct'];
	$status = DB::queryFirstRow("SELECT status FROM exams WHERE id=%s", $_GET['conduct']);
	if ($status['status'] == 'Ready') {
		$conduct = DB::query("UPDATE exams SET status=%s WHERE id=%s", 'Active', $_GET['conduct']);
		if ($conduct) {
			array_push($success, 'is live now.');
		}
	} elseif ($status['status'] == 'Active') {
		array_push($warning, 'is already live.');
	} elseif ($status['status'] == 'Incomplete') {
		array_push($warning, 'is incomplete to conduct. Please add questions to continue.');
	}
}



//--- procedure to do after exam completed ---------
function generate_responseid()
{
	$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$resp = strval(substr(str_shuffle($str_result), 0, 10));
	$result  = DB::queryFirstRow("SELECT id FROM exam_report where id = %s", $resp);
	if ($result) {
		$responseId = generate_responseid();
	} else {
		$responseId = $resp;
	}
	return $responseId;
}

if (isset($_GET['completed'])) {
	$GLOBALS['action_examid'] = $_GET['completed'];
	$exam = DB::queryFirstRow("SELECT status,students,totalQuestion FROM exams WHERE id=%s", $_GET['completed']);
	if ($exam['status'] == 'Active') {
		$allowedStudent = explode(",", $exam['students']);
		$presentStudent = DB::queryFirstRow("SELECT studentId FROM exam_report WHERE examId=%s", $_GET['completed']);
		$absentStudent = (array_diff($allowedStudent, ($presentStudent) ? $presentStudent : []));
		
		//saving empty report for each absent student 
		foreach ($absentStudent as $ab) {

			$exam_report_id = generate_responseid();
			$datetime =  date("Y-m-d H:i:s");

			DB::insert('exam_report', [
				'id' => $exam_report_id,
				'studentId' => $ab,
				'examId' => $_GET['completed'],
				'wrong' => $exam['totalQuestion'],
				'timeStamp' => $datetime,
			]);
		}

		$completed = DB::query("UPDATE exams SET status=%s WHERE id=%s", 'Completed', $_GET['completed']);
		if ($completed) {
			array_push($success, 'is marked as Completed');
		}
	} elseif ($exam['status'] == 'Completed') array_push($warning, 'is already marked as Completed');
	elseif ($exam['status'] == 'Ready') array_push($warning, 'is not yet conducted. Please conduct exam to mark as Completed.');
	elseif ($exam['status'] == 'Incomplete') array_push($warning, 'is not ready. Please add question to conduct the exam.');
}
//----------------------------------------------------


?>


<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Exams</h1>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">


			<?php
			foreach ($warning as $w) { ?>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<?php $examname = DB::queryFirstRow("SELECT examName FROM exams WHERE id=%s", $GLOBALS['action_examid']); ?>
					<strong><?php echo $examname['examName'] . " " . $w ?> </strong>
					<?php ?>
				</div>
			<?php } ?>
			<!-- Exam Conduct alert message -->
			<?php foreach ($success as $s) { ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<?php $examname = DB::queryFirstRow("SELECT examName FROM exams WHERE id=%s", $GLOBALS['action_examid']); ?>
					<strong><?php echo $examname['examName'] . " " . $s ?></strong>
				</div>
			<?php } ?>
			<?php if (isset($_GET['s']) && $_GET['s'] == "delete_success") { ?>
				<div id="delete-alert">
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<strong id="delete-message">Selected course deleted successfully. </strong>
					</div>
				</div>
			<?php } ?>



			<div class="row">
				<div class="col">
					<div class="card card-purple card-outline ">
						<div class="card-body">
							<table class="display" data-height="600" id="exams-table" data-toggle="table" data-sort-name="timestamp" data-pagination="true" data-sort-order="desc" data-search="true" sortable="true">
								<thead>
									<tr>
										<th data-sortable="true" data-width="200">Exam Name</th>
										<th data-sortable="true">Dept</th>
										<th data-sortable="true" data-width="200">Course</th>
										<th data-sortable="true">Date</th>
										<th data-sortable="true">Total Que</th>
										<th data-sortable="true">Exam Marks</th>
										<th data-sortable="true">Pr Marks</th>
										<th data-sortable="true">Duration(min)</th>
										<th data-sortable="true">Status</th>
										<th data-field="timestamp" data-sortable="true" data-visible="false">Time Stamp</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$examlist = DB::query("SELECT examName,exams.id as examid,department,name,examDate,totalQuestion,totalMarks,practicalMarks,exams.duration as duration,status,createdOn
															FROM exams 
															LEFT JOIN courses
															ON courses.id = exams.course 
															WHERE status != %s", 'Deleted');
									//Deleted courses will not be shown here
									foreach ($examlist as $exam) {
									?>
										<tr>
											<td data-width="200"><?php echo $exam['examName'] ?></td>
											<td><?php echo $exam['department'] ?></td>
											<td data-width="200"><?php echo $exam['name'] ?></td>
											<td><?php echo $exam['examDate'] ?></td>
											<td><?php echo $exam['totalQuestion'] ?></td>
											<td><?php echo $exam['totalMarks'] ?></td>
											<td><?php echo $exam['practicalMarks'] ?></td>
											<td><?php echo $exam['duration'] ?></td>
											<td><?php echo $exam['status'] ?></td>
											<td><?php echo $exam['createdOn'] ?></td>

											<td>
												<!-- Action Dropdown Menu -->
												<div class="dropdown">
													<a class="btn btn-sm btn-outline-info" data-search-align="left" data-toggle="dropdown" href="#">
														Actions
													</a>
													<div class="dropdown-menu dropdown-menu-left">
														<a href="exams.php?conduct=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-tasks mr-2"></i> Conduct Exam
														</a>
														<div class="dropdown-divider"></div>
														<a href="exams.php?completed=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-check mr-2"></i> Mark as Completed
														</a>
														<div class="dropdown-divider"></div>
														<a href="edit_exam.php?examid=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-pen mr-2"></i> Edit Exam
														</a>
														<div class="dropdown-divider"></div>
														<a href="add_questions.php?examid=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-question mr-2"></i> Add Questions
														</a>
														<div class="dropdown-divider"></div>
														<a href="review_questions.php?examid=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-eye mr-2"></i> Review Questions
														</a>
														<div class="dropdown-divider"></div>
														<a href="exam_reports.php?examid=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-chart-pie mr-2"></i> Exam Report
														</a>
														<div class="dropdown-divider"></div>
														<a id="delete-menu" href="exams.php?delete=<?php echo $exam['examid'] ?>" class="dropdown-item pb-0 pt-0">
															<i class="fas fa-trash mr-2"></i> Delete Exam
														</a>
													</div>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>


<div class="modal fade" id="delete-exam">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title text-danger text-bold">Are you sure?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card">

					<div class="card-body">
						<strong>This will delete all the questions, related to this exam.</strong>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">No, Cancel</button>
				<button type="button" id="exam-delete-btn" class="btn btn-danger">Yes, Delete</button>
			</div>
		</div>
	</div>
</div>

<?php //include("includes/exam_report.php") 
?>
<?php include("includes/scripts.php") ?>
<script>
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
	$(document).ready(function() {
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		$(window).on('load', function() {
			if (urlParams.has('delete')) {
				$('#delete-exam').modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});
			}
		});

		$('#exam-delete-btn').on('click', function() {
			$.get("../api.php", {
				deleteExam: urlParams.get('delete')
			}, function(data) {
				if (data == true)
					window.location.replace("./exams.php?s=delete_success");
			});
		})
	})
	// $(document).ready(function() {
	// 	deleteUrl = $('#delete-menu').attr('data-url');
	// 	$('#exam-delete-btn').attr('href', deleteUrl);
	// });
</script>


</body>

</html>