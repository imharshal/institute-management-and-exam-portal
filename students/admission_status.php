<?php include("../includes/dbmethods.php") ?>
<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/uploader2.php") ?>
<?php include("../includes/enrollment_confirmation_mail.php") ?>
<?php
$registrationId = $enrollId = $role = '';
//---------------------- Mailer Function --------------------------
use PHPMailer\PHPMailer\PHPMailer;

function mailer($regId, $username, $enrollId)
{
	require_once "../includes/PHPMailer/PHPMailer.php";
	require_once "../includes/PHPMailer/Exception.php";
	require_once "../includes/PHPMailer/SMTP.php";

	$mail = new PHPMailer();

	$mail->isSMTP();
	$mail->Host = "smtp.hostinger.com";

	$mail->SMTPAuth = true;
	$mail->Username = "no-reply@ssdit.in";
	$mail->Password = EMAIL_PASS;
	$mail->Port = 587;
	$mail->SMTPSecure = "tls";

	$mail->isHTML(true);
	$mail->setFrom('no-reply@ssdit.in', 'SSDIT');
	$mail->addAddress($username);
	$mail->Subject = 'Course Enrollment Successfull.';
	$mail->Body = enrollment_confirmation_mail($regId, $username, $enrollId);
	$mail->send();
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function generate_referral()
{
	$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$referralId = strval(substr(str_shuffle($str_result), 0, 5));
	$result  = DB::queryFirstRow("SELECT * FROM usrregistration where referralCode = %s", $referralId);
	if ($result) {
		$referralCode = generate_referral();
	} else {
		$referralCode = $referralId;
	}
	return $referralCode;
}

function username_exist($username)
{
	//return true if username does not exist
	//return false if username exist
	try {
		$user = DB::queryFirstRow("SELECT * FROM usrregistration where username = %s", $username);
		if ($user) {
			return false;
		} else {
			return true;
		}
	} catch (Exception $e) {
	}
}


function generate_enrollId()
{
	$enId = strval(date("Ymd") . substr(str_shuffle("0987654321"), 0, 5));
	$result  = DB::queryFirstRow("SELECT * FROM courses_enrolled where id = %s", $enId);
	if ($result) {
		$enrollId = generate_enrollId();
	} else {
		$enrollId = $enId;
	}
	return 'CE' . $enrollId;
}


// function generate_regId()
// {
// 	$regId = strval(date("Ymd") . substr(str_shuffle("0987654321"), 0, 4));
// 	$result  = DB::queryFirstRow("SELECT * FROM usrregistration where registrationId = %s", $regId);
// 	if ($result) {
// 		$registrationId = generate_regId();
// 	} else {
// 		$registrationId = $regId;
// 	}
// 	return $registrationId;
// }


function delete_previous_upload($old_filename)
{
	$files = glob($old_filename . ".*");
	foreach ($files as $file) {
		unlink($file);
	}
}
$invalidRequest = false;

if (isset($_POST) and !isset($_SESSION['processing'])) {
	global $registrationId, $enrollId, $role;

	// $name = strtoupper(test_input($_POST['fname']) . " " . test_input($_POST['mname']) . " " . test_input($_POST['lname']));
	$mothername = strtoupper(test_input($_POST['mothername']));
	$dob = test_input($_POST['dob']);
	$pob = strtoupper(test_input($_POST['pob']));
	$address = strtoupper(test_input($_POST['address']));
	$city = strtoupper(test_input($_POST['city']));
	$country = test_input($_POST['country']);
	$state = test_input($_POST['state']);
	$district = test_input($_POST['district']);
	$pincode = test_input($_POST['pincode']);
	$aadhar = test_input($_POST['aadhar']);
	$nationality = test_input($_POST['nationality']);
	$religion = test_input($_POST['religion']);
	$caste = ucwords(test_input($_POST['caste']));
	$subcaste = ucwords(test_input($_POST['subcaste']));
	$bloodGroup = test_input($_POST['bloodGroup']);
	$tongue = test_input($_POST['tongue']);
	$distance = test_input($_POST['distance']);
	$telephone = test_input($_POST['telephone']);
	$mobile = test_input($_POST['mobile']);
	// $username = test_input($_POST['username']);
	$password = md5(test_input($_POST['mobile']));
	//$referredBy = test_input($_POST['referredBy']);
	$country = test_input($_POST['country']);
	//---------------------
	$acNo = test_input($_POST['acNo']);
	$acName = strtoupper(test_input($_POST['acName']));
	$acIfsc = strtoupper(test_input($_POST['acIfsc']));
	$acBankName = strtoupper(test_input($_POST['acBankName']));
	$acType = test_input($_POST['acType']);
	$pancard = strtoupper(test_input($_POST['pancard']));
	//---------------------
	//$role = "stud"; //test_input($_POST['role']);

	//$registrationId = generate_regId();
	//$referralCode = generate_referral();
	// if ($referredBy) {
	// 	$r = DB::queryFirstRow("SELECT userLevel FROM usrregistration WHERE referralCode=%s", $referredBy);
	// 	$newLevel = $r['userLevel'] + 1;
	// 	DB::update('usrregistration', ['userLevel' => $newLevel], 'referralCode=%s', $referredBy);
	// }
	//creating user account
	// $result = DB::insert('usrregistration', [
	// 	'name' => $name,
	// 	'username' => $username,
	// 	'password' => $password,
	// 	'role' => $role,
	// 	'referralCode' => $referralCode,
	// 	'referredBy' => $referredBy,
	// 	'registrationId' => $registrationId,
	// ]);
	$registrationId = $_SESSION['student'];
	$r = DB::queryFirstRow("SELECT role,username,name FROM usrregistration WHERE registrationId=%s", $registrationId);
	$name = $r['name'];
	$role = $r['role'];
	$username = $r['username'];
	date_default_timezone_set('Asia/Kolkata');

	if (isset($registrationId)) {
		$_SESSION["processing"] = $registrationId;

		// saving personal informations
		$tbl_admission = DB::insert('admissions', [
			'id' => $registrationId,
			'uname' => $name,
			'motherName' => $mothername,
			'dob' => $dob,
			'pob' => $pob,
			'aadharNo' => $aadhar,
			'nationality' => $nationality,
			'religion' => $religion,
			'caste' => $caste,
			'subcaste' => $subcaste,
			'bloodGroup' => $bloodGroup,
			'motherTongue' => $tongue,
			'distanceFrom' => $distance,
			'telephone' => $telephone,
			'mobile' => $mobile,
			'email' => $username,
		]);

		//saving address
		if ($tbl_admission) {
			DB::insert('addresses', [
				'id' => $registrationId,
				'address' => $address,
				'city' => $city,
				'district' => $district,
				'state' => $state,
				'country' => $country,
				'pincode' => $pincode,
			]);

			//saving bank details
			DB::insert('bank_details', [
				'id' => $registrationId,
				'acNumber' => $acNo,
				'acName' => $acName,
				'ifsc' => $acIfsc,
				'bankName' => $acBankName,
				'type' => $acType,
				'pancard' => $pancard,
			]);
			DB::disconnect();
		} else {
			$_SESSION['failure'] = true;
			DB::query("DELETE FROM admissions WHERE id=%s", $registrationId);
		}


		//checking if role is employee or not
		// if ($role == 'emp') {
		//  //saving employee data if user is employee
		//  $salary = test_input($_POST['salary']);
		//  $jobrole = test_input($_POST['jobrole']);
		//  // $registered = DB::queryFirstRow("SELECT registrationId FROM usrregistration WHERE registrationId=%s", $registrationId);
		//  if (!isset($_SESSION['failure'])) {
		// 	 DB::insert('employees', [
		// 		 'id' => $registrationId,
		// 		 'salary' => $salary,
		// 		 'doj' => date("d/m/Y"),
		// 		 'jobRole' => $jobrole
		// 	 ]);
		// 	 // DB::disconnect();
		// } else {
		// 	$_SESSION['failure'] = true;
		// }

		// 	$password = 'Your mobile no';
		//     //Sending email
		//     mailer($registrationId, $username, $password, $enrollId);
		// } else {


		//Saving courses enrolled data if user is student
		// $department = test_input($_POST['department']);
		$courseid = test_input($_POST['courseid']);
		$installments = (int)test_input($_POST['installments']);
		// $discount = test_input($_POST['discount']);
		// $scholarship = test_input($_POST['scholarship']);
		// $scholarBenificiary = test_input($_POST['scholarBenificiary']);
		$enrollId = generate_enrollId();

		$courseDetails = DB::queryFirstRow("SELECT duration,fees,discount,scholarship FROM courses WHERE id=%s", $courseid);
		$doc = date("d/m/Y", strtotime($courseDetails['duration'], strtotime(date("y-m-d"))));
		$fees = $courseDetails['fees'];
		$discount = $courseDetails['discount'];
		$scholarship = $courseDetails['scholarship'];
		$datetime =  date("Y-m-d H:i:s");
		$disc = (($fees * $discount) / 100);
		$feesPayable = $fees - (($fees * $discount) / 100 + (($fees - $disc) * $scholarship) / 100);
		if (!isset($_SESSION['failure'])) {
			DB::insert('courses_enrolled', [
				'id' => $enrollId,
				'courseId' => $courseid,
				'courseType' => ($courseid[0] == 'D') ? 'Diploma' : 'Certification',
				'studentId' => $registrationId,
				'doa' => date("d/m/Y"),
				'doc' => $doc,
				'timestamp' => $datetime
			]);
			$_SESSION["enrolledId"] = $enrollId;

			$i = DB::queryFirstRow("SELECT firstInstallment FROM courses WHERE id=%s", $courseid);
			$isemi = ($installments <= 1) ? 0 : 1;
			$installmentPerMonth = ($isemi) ? ($feesPayable - $i['firstInstallment']) / ($installments - 1) : 0;
			//saving payment and discount data
			DB::insert('payment_status', [
				'id' => $enrollId,
				'status' => 'Pending',
				'isemi' => $isemi,
				'installmentsTaken' => $installments,
				'discountTaken' => $discount,
				'scholarshipTaken' => $scholarship,
				// 'scholarshipDate' => $scholarBenificiary,
				'firstInstallmentAmount' => $i['firstInstallment'],
				'feesPayable' => $feesPayable,
				'installmentsRemain' => $installments,
				'installmentPerMonth' => $installmentPerMonth,
				'feesPaid' => 0,
				'feesRemain' => $feesPayable,
				'ps_timestamp' => $datetime
			]);
			DB::disconnect();

			$password = 'Password you entered at the time of registration.';
			//sending mail
			mailer($registrationId, $username, $enrollId);

			//adding documents record
			DB::insert('documents', [
				'id' => $registrationId
			]);
		} else {
			$_SESSION['failure'] = true;
		}
		// }

		//uploading documents
		//php scratch uploading method
		if (isset($_FILES) && !isset($_SESSION['failure'])) {
			global $registrationId;

			$file_inputs = ["photoFile", "passbookFile", "aadharFile", "tcFile", "marksheetFile", "incomeFile"];
			foreach ($file_inputs as $file_input) {
				$suffix = explode("File", $file_input); //getting photo from photoFile

				$file_size = $_FILES[$file_input]['size'];
				$extensionsAllowed = array("jpeg", "jpg", "png", "gif", "pdf");
				if ($file_size > 10) {
					$file_tmp = $_FILES[$file_input]['tmp_name'];
					$file_type = $_FILES[$file_input]['type'];
					$fname = $_FILES[$file_input]['name'];
					$file_ext = pathinfo($fname, PATHINFO_EXTENSION);

					if (in_array($file_ext, $extensionsAllowed)) {
						$file_name = $registrationId . '_' . $suffix[0] . '.' . $file_ext;
						// $old_file_name = $registrationId . '_' . $suffix[0];
						// delete_previous_upload($old_file_name);
						$file_location = "uploads/d/" . $file_name;
						DB::update('documents', [
							$suffix[0] => $file_location,
						], "id=%s", $registrationId);
						move_uploaded_file($file_tmp, "../" . $file_location);
					}
				}
			}
			DB::disconnect();
		} else {
			$_SESSION['failure'] = true;

			DB::query("DELETE FROM courses_enrolled WHERE id=%s", $enrollId);
		}


		//uploader plugin method
		// if (isset($_FILES)) {
		// 	DB::insert('documents', [
		// 		'id' => $registrationId
		// 	]);
		// 	$uploader = new Uploader();
		// 	$uploader->setDir('../uploads/d/');
		// 	$uploader->setExtensions(array('jpg', 'jpeg', 'png', 'gif', 'pdf'));  //allowed extensions list//
		// 	$uploader->setMaxSize(.5);
		// 	// $uploader->setUploadName('D34566' . '_aadhar');                      //set max file size to be allowed in MB//
		// 	$file_inputs = ["photoFile", "passbookFile", "aadharFile", "tcFile", "marksheetFile", "incomeFile"];
		// 	foreach ($file_inputs as $file_input) {
		// 		$suffix = explode("File", $file_input);
		// 		$filename = $registrationId . '_' . $suffix[0];
		// 		delete_previous_upload('../uploads/d/' . $filename);
		// 		$uploader->setUploadName($filename);		//setting custom file name
		// 		if ($uploader->uploadFile($file_input)) {   //file_input is the filebrowse element name variable //     
		// 			$image = $uploader->getUploadName(); //get uploaded file name, renames on upload//
		// 			$result = DB::update('documents', [
		// 				$suffix[0] => 'uploads/d/' . $image,
		// 			], "id=%s", $registrationId);
		// 		} else { //upload failed
		// 			$uploader->getMessage(); //get upload error message 
		// 		}
		// 	}
		// }
		$_POST = array();
	} else {
		$_SESSION['failure'] = true;
	}
} elseif (!isset($_SESSION['processing'])) $invalidRequest = true;

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="card w-100 min-vh-100">
					<div class="card-body">
						<?php if ($invalidRequest == true) { ?>
							<div class="alert alert-warning mb-4" role="alert">
								<h1>Invalid Request</h1>
							</div>
						<?php } elseif (isset($_SESSION['failure'])) {
						?>
							<div class="alert alert-warning mb-4" role="alert">
								<h3>Registration failed</h3>
								<h4>Something wents wrong. Please try again</h4>
							</div>
						<?php } else {
							$user = DB::queryFirstRow("SELECT username,registrationId FROM usrregistration WHERE registrationId=%s", $_SESSION['processing'])
						?>
							<center>
								<div class="alert alert-success mb-4" role="alert">
									<h1>Registration Successful</h1>
								</div>

								<h3>Course Enrollment ID: <span id="enroll-field"></span></h3>
								<h5>Registration ID: <?php echo $user['registrationId'] ?></h5>
								<h5>Username: <?php echo $user['username'] ?></h5>
								<!-- <h5>Password: Your mobile no.</h5> -->
								<div class="">
									<a class="m-3 btn btn-primary" href="./profile.php" role="button">Go to Profile</a>
									<button class="m-3 btn btn-primary" id="print" onclick="printJS('generatedForm', 'html')">Download/Print form</button>
								</div>
							</center>
						<?php	} ?>
					</div>

					<div class="row">
						<div class="offset-md-3 col" style="overflow-x: scroll;">
							<div id="generatedForm"></div>
							<div style="height: 50px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>
<!-- <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script> -->
<script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script>
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
	var rId = '<?php echo $_SESSION["processing"] ?>';
	var eId = '<?php echo $_SESSION["enrolledId"] ?>';
	var role = '<?php echo $role ?>';
	localStorage.setItem("registrationId", (rId != '') ? rId : localStorage.getItem("registrationId"));
	localStorage.setItem("enrollId", (eId != '') ? eId : localStorage.getItem("enrollId"));
	localStorage.setItem("role", role);

	$(document).ready(function() {
		$('#enroll-field').append(localStorage.getItem('enrollId'));
		<?php if (!isset($_SESSION['failure'])) { ?>
			$.ajax({
				type: "POST",
				url: "../includes/admission_acknoledgement.php",
				data: {
					registrationId: localStorage.getItem("registrationId"),
					enrollmentId: localStorage.getItem("enrollId"),
					print: true
				},
				success: function(data) {
					$('#generatedForm').append(data);
				}
			})
		<?php } else {
			echo ' $("#print").addClass("hidden");';
		} ?>
	});
</script>

</body>

</html>