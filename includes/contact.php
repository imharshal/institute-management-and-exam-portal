<?php include("dbmethods.php") ?>
<?php
//contact page
use PHPMailer\PHPMailer\PHPMailer;

$errors = $success = [];

function test_input($data)
{
	if (!empty($data)) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	} else false;
}

if (isset($_POST['btnEnquiry'])) {
	global $success, $errors;
	$name = strtoupper(test_input($_POST['name']));
	$email = strtolower(test_input($_POST['email']));
	$mobile = test_input($_POST['mobile']);
	$subject = ucwords(test_input($_POST['subject']));
	$message = test_input($_POST['message']);

	$result = DB::insert("enquiries", [
		'name' => $name,
		'email' => $email,
		'mobile' => $mobile,
		'subject' => $subject,
		'message' => $message,
		'status' => 'Active'
	]);
	if ($result) {
		require_once "PHPMailer/PHPMailer.php";
		require_once "PHPMailer/Exception.php";
		require_once "PHPMailer/SMTP.php";
		// require_once "credentials.php";

		$mail = new PHPMailer();

		$mail->isSMTP();
		$mail->Host = "smtp.hostinger.com";

		$mail->SMTPAuth = true;
		$mail->Username = "contact@ssdit.in";
		$mail->Password = EMAIL_PASS;
		$mail->Port = 587;
		$mail->SMTPSecure = "tls";

		$mail->isHTML(true);
		$mail->setFrom('contact@ssdit.in', $name);
		$mail->addAddress('contact@ssdit.in');
		$mail->addReplyTo($email);
		$mail->Subject = $subject;
		$mail->Body = $message;

		if ($mail->send()) {
			array_push($success, "Thank you for your interest in SSDIT.</br>We have received your query and will get back to you soon.");
		} else {
			echo "Failed : " . $mail->ErrorInfo;
		}
	} else {
		array_push($success, "Something wents wrong, please try again");
	}
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="mystyles.css">
	<title>Contact</title>
</head>

<body>
	<!-- contact form -->
	<section class="w3l-contacts-12" id="contact">
		<div class="container py-5">

			<div class="contacts12-main py-md-3">
				<div class="header-section text-center">
					<h3 class="mb-md-5 mb-4">Contact us
				</div>
				<form method="post" id="contactForm">
					<div class="main-input">

						<input type="text" name="name" placeholder="Enter your name" class="contact-input" />
						<input type="email" name="email" placeholder="Enter your email" class="contact-input" />
						<input type="number" maxlength="10" name="mobile" placeholder="Enter your mobile number" class="contact-input" />
						<input type="text" name="subject" placeholder="Enter subject" class="contact-input" />
						<textarea class="contact-textarea contact-input" name="message" placeholder="Enter your message"></textarea>
					</div>
					<div class="text-right">
						<button name="btnEnquiry" class="btn-secondary btn theme-button">Send</button>
					</div>
				</form>
				<br>
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
			</div>

		</div>
		<?php // include('scripts.php') 
		?>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

		<script>
			if (window.history.replaceState) {
				window.history.replaceState(null, null, window.location.href);
			}
			$('#contactForm').validate({
				rules: {
					name: "required",
					email: {
						required: true,
						email: true
					},
					subject: {
						required: true
					},
					mobile: {
						required: true,
						digits: true,
					},
					message: "required"
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
						error.insertBefore(element.next("invalid-feedback"));
					}

				},
				highlight: function(element, errorClass, validClass) {
					$(element).addClass("is-invalid").removeClass("is-valid");
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).addClass("is-valid").removeClass("is-invalid");

				},
				submitHandeler: function(form) {}
			});
		</script>
</body>

</html>