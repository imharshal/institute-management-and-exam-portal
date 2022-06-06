<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<?php

$errors = $success = [];

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if (isset($_POST['btnPassword'])) {
	$old = md5(test_input($_POST['old_password']));
	$new = md5(test_input($_POST['new_password']));
	$confirm = md5(test_input($_POST['confirm_password']));

	$fromDatabase = DB::queryFirstRow("SELECT password FROM admin WHERE id=%i", 1);

	if ($old == $fromDatabase['password'] and $new == $confirm) {
		DB::update("admin", [
			'password' => $new
		], "id=%i", 1);
		array_push($success, "Password changed successfully");
	} else {
		array_push($errors, "Password does not match in the records. Please try again");
	}
}

if (isset($_POST['btnPin'])) {
	$old = md5(test_input($_POST['old_pin']));
	$new = md5(test_input($_POST['new_pin']));
	$confirm = md5(test_input($_POST['confirm_pin']));

	$fromDatabase = DB::queryFirstRow("SELECT paymentPin FROM admin WHERE id=%i", 1);

	if ($old == $fromDatabase['paymentPin'] and $new == $confirm) {
		DB::update("admin", [
			'paymentPin' => $new
		], "id=%i", 1);
		array_push($success, "Payment pin changed successfully");
	} else {
		array_push($errors, "Payment pin does not match in the records. Please try again");
	}
}

?>


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
			<?php if ($errors) { ?>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<strong><?php foreach ($errors as $e) echo $e . "</br>" ?></strong>
				</div>
			<?php } ?>
			<?php
			if ($success) { ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<strong><?php foreach ($success as $s) echo $s . "</br>" ?></strong>
				</div>
			<?php } ?>


			<div id="accordion" class="col-md-6">
				<div class="card">
					<button class="badge badge-info" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						<div class="card-header" id="headingOne">
							<h5>Change Login Password </h5>
						</div>
					</button>

					<div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							<div class="col-md-12 card ">
								<form method="post" class="card-body" id="passwordForm" autocomplete="off">
									<div class="form-group">
										<label for="inputPasswordOld">Current Password</label>
										<input type="password" class="form-control" id="old_password" name="old_password" data-toggle="password" data-placement="before">
									</div>
									<div class="form-group">
										<label for="inputPasswordNew">New Password</label>
										<input type="password" class="form-control" id="new_password" name="new_password" data-toggle="password" data-placement="before">
										<span class="form-text small text-muted">
											The password must be 8-20 characters, and must <em>not</em> contain spaces.
										</span>
									</div>
									<div class="form-group">
										<label for="inputPasswordNewVerify">Confirm New Password</label>
										<input type="password" class="form-control" id="confirm_password" name="confirm_password" data-toggle="password" data-placement="before">
										<span class="form-text small text-muted">
											To confirm, type the new password again.
										</span>
									</div>
									<center>
										<button type="submit" name="btnPassword" class="btn btn-primary btn-lg mt-2">Change Password</button>
									</center>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<button class="badge badge-info" href="#collapseTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<div class="card-header" id="headingTwo">
							<h5>Change Payment Pin</h5>
						</div>
					</button>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
						<div class="card-body">
							<div class="col-md-12 card">
								<form method="post" class="card-body" id="pinForm" autocomplete="off">
									<div class="form-group">
										<label for="inputPasswordOld">Current Payment Pin</label>
										<input type="password" maxlength="6" class="form-control" id="old_pin" name="old_pin" data-toggle="password" data-placement="before">
									</div>
									<div class="form-group">
										<label for="inputPasswordNew">New Payment Pin</label>
										<input type="password" maxlength="6" class="form-control" id="new_pin" name="new_pin" data-toggle="password" data-placement="before">
										<span class="form-text small text-muted">
											The payment pin must be 6 numbers.
										</span>
									</div>
									<div class="form-group">
										<label for="inputPasswordNewVerify">Confirm Payment Pin</label>
										<input type="password" maxlength="6" class="form-control" id="confirm_pin" name="confirm_pin" data-toggle="password" data-placement="before">
										<span class="form-text small text-muted">
											To confirm, type the new payment pin again.
										</span>
									</div>
									<center>
										<button type="submit" name="btnPin" class="btn btn-primary btn-lg mt-2">Change Pin</button>
									</center>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include("includes/scripts.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>

<script>
	$(document).ready(function() {



		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
		$.validator.addMethod("strongPassword", function(value, element) {
			return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[#$@!%&*?])(?=.*\W).*$/i.test(value);
		}, 'Password must contain:</br> 1] one lowercase letter,</br> 2] one uppercase letter,</br> 3] one number</br> 4] one special character');

		//password form validation
		$('#passwordForm').validate({
			rules: {
				old_password: "required",
				new_password: {
					required: true,
					strongPassword: true
				},
				confirm_password: {
					required: true,
					equalTo: '#new_password',
				}
			},

			onfocusout: function(element) {
				this.element(element);
			},
			errorElement: "em",

			errorPlacement: function(error, element) {
				// Add the `invalid-feedback` class to the error element
				error.addClass("invalid-feedback");
				error.insertAfter(element);

				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.next("label"));
				} else {
					error.insertAfter(element.next(".pmd-textfield-focused"));
				}

			},
			highlight: function(element, errorClass, validClass) {
				$(element).addClass("is-invalid").removeClass("is-valid");
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).addClass("is-valid").removeClass("is-invalid");

			},
			submitHandeler: function(form) {}
		})

		//pinform validation
		$('#pinForm').validate({
			rules: {
				old_pin: {
					required: true,
					digits: true,
					minlength: 6,

				},
				new_pin: {
					required: true,
					digits: true,
					minlength: 6,

				},
				confirm_pin: {
					required: true,
					digits: true,
					minlength: 6,
					equalTo: '#new_pin',
				}
			},

			onfocusout: function(element) {
				this.element(element);
			},
			errorElement: "em",

			errorPlacement: function(error, element) {
				// Add the `invalid-feedback` class to the error element
				error.addClass("invalid-feedback");
				error.insertAfter(element);

				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.next("label"));
				} else {
					error.insertAfter(element.next(".pmd-textfield-focused"));
				}

			},
			highlight: function(element, errorClass, validClass) {
				$(element).addClass("is-invalid").removeClass("is-valid");
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).addClass("is-valid").removeClass("is-invalid");

			},
			submitHandeler: function(form) {}
		})

	});
</script>
</body>

</html>