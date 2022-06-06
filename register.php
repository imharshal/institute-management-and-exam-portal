<?php
include("includes/dbmethods.php");
include("includes/db_config.php");
include("includes/admission_confirmation_mail.php");

session_start();

$tablename = "";
$url = '';
$sqluser = '';
$sql = '';
$role = '';
$referredBy = '';
$fname = '';
$mname = '';
$lname = '';
$success = '';
$error = '';


//---------------------- Mailer Function --------------------------
use PHPMailer\PHPMailer\PHPMailer;

function mailer($regId, $username, $password)
{
    require_once "includes/PHPMailer/PHPMailer.php";
    require_once "includes/PHPMailer/Exception.php";
    require_once "includes/PHPMailer/SMTP.php";

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
    $mail->Subject = 'You are registered successfully. Welcome to SSDIT';
    $mail->Body = admission_confirmation_mail($regId, $username, $password);
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
    $res = DB::queryFirstRow("SELECT referralCode FROM usrregistration where referralCode=%s", $referralId);
    if (isset($res)) {
        $referralCode = generate_referral();
    } else {
        $referralCode = $referralId;
    }
    return $referralCode;
}

function username_exist()
{
    //return true if username does not exist
    //return false if username exist
    $username = test_input($_POST['username']);
    $res = DB::queryFirstRow("SELECT username FROM usrregistration where username =%s", $username);
    $e = false;
    if (isset($res)) {
        $e = false;
    } else {
        $e = true;
    }
    return $e;
}
function generate_regId()
{
    $regId = strval(date("Ymd") . substr(str_shuffle("0987654321"), 0, 4));
    $res = DB::queryFirstRow("SELECT registrationId FROM usrregistration where registrationId=%s", $regId);
    if (isset($res)) {
        $registrationId = generate_referral();
    } else {
        $registrationId = $regId;
    }
    return $registrationId;
}

if (!empty($_POST) && isset($_POST['submit'])) {

    global $fname;
    global $mname;
    global $lname;
    global $success;
    $username = strtolower(test_input($_POST['username']));
    $password = test_input($_POST['password']);
    $fname = strtoupper(test_input($_POST['fname']));
    $mname = strtoupper(test_input($_POST['mname']));
    $lname = strtoupper(test_input($_POST['lname']));
    $role = test_input($_POST['role']);

    $referredBy = strtoupper(test_input($_POST['referredBy']));
    $refExist = DB::queryFirstRow("SELECT referralCode FROM usrregistration WHERE referralCode=%s", $referredBy);
    $referredBy = $refExist['referralCode'];

    $registrationId = generate_regId();
    $referralCode = generate_referral();
    $password = md5($password);

    // check username and password
    if (username_exist()) {
        $name = $fname . " " . $mname . " " . $lname;
        DB::disconnect();
        $result = DB::insert('usrregistration', [
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'role' => $role,
            'referralCode' => $referralCode,
            'referredBy' => $referredBy,
            'registrationId' => $registrationId,
        ]);

        if (isset($result)) {
            $success = True;

            $password = 'Password you entered at the time of registration.';
            //sending mail
            mailer($registrationId, $username, $password);

            //user come from enroll now button
            if (isset($_GET['x_token'])) {
                //login to dashbord for admission form
                $_SESSION['logged_in'] = True;
                $_SESSION['student'] = $registrationId;
                //TODO
                header("location:students/admission.php?user=" . $role . "&x_token=" . $_GET['x_token']);
            }
        }
    } else {
        global $error;
        $error = True;
    }
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Register</title>
    <!-- meta-tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- //meta-tags -->
    <!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" /> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- <link href="css/style1.css" rel="stylesheet" type="text/css" media="all" /> -->
    <!-- font-awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <style>
        h3.tittle {
            color: #000;
            font-size: 3em;
            text-align: center;
            margin-bottom: 16px;
        }

        h3.tittle span {
            color: #ef5861;
        }

        .tittle-style {
            position: relative;
        }

        .tittle-style:before {
            content: "";
            background: #000;
            width: 7%;
            height: 1px;
            position: absolute;
            top: 0;
            left: 46%;
        }

        .tittle-style:after {
            content: "";
            background: #ef5861;
            width: 3%;
            height: 5px;
            position: absolute;
            top: -2px;
            left: 48%;
            border-radius: 6px;
        }

        .title-div {
            margin-bottom: 70px;
        }

        .register-form-btn {
            outline: none;
            color: #FFF;
            background: #ef5861;
            color: #fff;
            width: 100%;
            border: none;
            padding: 11px 40px;
            margin: 1em 0 0 0;
            cursor: pointer;
            font-size: 17px;
            letter-spacing: 1px;
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
            -ms-transition: 0.5s all;
            transition: 0.5s all;
        }

        .register-form-btn:hover {
            background: #ed2e37;
            /* background: #282a2b; */
            -webkit-transition: 0.5s all;
            -moz-transition: 0.5s all;
            -o-transition: 0.5s all;
            -ms-transition: 0.5s all;
            transition: 0.5s all;
        }

        label {
            font-weight: 600;
            color: grey;
        }
    </style>
</head>

<body>
    <!-- header -->
    <!-- TODO For letter Need Like Notification -->

    <div class="register-form-main">
        <div class="container">
            <?php if ($success == true) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>Congratulations</strong>
                    <p>You are registered successfully. Kindly click on below link to login to dashboard and complete your profile</p>
                    <a class="btn btn-primary" href="<?php echo $SERVER['HTTP_HOST'] . '/login.php' ?>">Login here</a>
                </div>
            <?php  } ?>
            <?php if ($error == true) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>Seems like you are already registered. </strong><a class="btn btn-primary btn-sm" href="login.php?user=student&x_token=<?php echo $_GET['x_token'] ?>">Click here to login</a>

                </div>
            <?php  } ?>
            <div class="title-div mb-5">
                <h3 class="tittle">
                    <span>R</span>egister
                    <span>F</span>orm
                </h3>
                <div class="tittle-style">

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="card p-4">

                    <form method="POST" id="registration">
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control " name="role" id="role" style="height: 40px;font-size:large ">
                                <option selected value="default">Select role</option>
                                <option value="stud">Student</option>
                                <option value="emp">Employee</option>
                                <option value="empdip">Employee with Diploma</option>
                            </select>
                        </div>
                        <label for="">Name </label><br>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <input type="text" class="form-control text-capitalize" name="fname" id="fname" placeholder="First Name">
                                <!-- onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"> -->

                            </div>
                            <div class="col-md-4 mb-4">
                                <input type="text" class="form-control text-capitalize" name="mname" id="mname" placeholder="Middle Name">

                            </div>
                            <div class="col-md-4 mb-4">
                                <input type="text" class="form-control text-capitalize" name="lname" id="lname" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="username" id="username" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="">
                        </div>

                        <div class="">
                            <label>Referred By </label>
                            <div class="row">
                                <div class="col col-md-4">
                                    <input type="text" maxlength="5" class="form-control text-uppercase" name="referredBy" id="referredBy" placeholder="Referral Code" />
                                </div>
                                <div class="col col-md-8">
                                    <input type="text" placeholder="Referrer Name" class="form-control" name="result" id="result" readonly />
                                </div>

                            </div>
                        </div>
                        <br>
                        <div>
                            <span>Already Registered? <a href="login.php?user=student<?php echo (isset($_GET['x_token'])) ? '&x_token=' . $_GET['x_token'] : '' ?>">Login Here</a></span>
                            <input type="submit" class=" mt-4 register-form-btn" name="submit" value="Register">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        var invalidRef = false;
        $(document).ready(function() {
            $("#referredBy").on('input', function() {
                try {
                    referral = $("#referredBy").val();
                    if (referral.length == 5) {
                        $.get("api.php", {
                            referredBy: referral
                        }, function(data) {
                            $("#result").val(data)
                        });
                    }
                } catch (err) {}
            });

            $.validator.addMethod("requiredSelect", function(element) {
                return ($("select").val() != 'default');
            }, "You must select an option.");

            $.validator.addMethod("invalidReferral", function(element) {
                return (invalidRef);
            }, "Please enter valid referral code. <br> <strong>Note: </strong>Referral code is not mandatory");


            $("#registration").validate({
                rules: {
                    fname: "required",
                    mname: "required",
                    lname: "required",
                    role: {
                        requiredSelect: true,
                    },
                    username: {
                        required: true,
                        email: true,
                        remote: {
                            url: 'api.php',
                            type: 'get',
                            data: {
                                username: function() {
                                    return $('#username').val()
                                }
                            }
                        }
                    },

                    password: {
                        required: true,
                        minlength: 6,
                    },
                    cpassword: {
                        required: true,
                        equalTo: "#password",
                    },
                    referredBy: {
                        minlength: 5,
                        invalidReferral: false,
                    },

                },
                messages: {
                    fname: "Please enter your first name",
                    lname: "Please enter your last name",
                    mname: "Please enter your middle name",
                    username: {
                        remote: "This username is already taken! Try another."
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    cpassword: {
                        required: "Please confirm a password",
                        equalTo: "Password does not matched"
                    },
                    role: {
                        requiredSelect: "Please select role",
                    },
                    referredBy: {
                        minlength: "Invalid referral code <br> <strong>Note:</strong>Referral code is not mandatory"
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
                }
                // submitHandeler: function(form) {

                // }
            })
        });
    </script>

    <!-- jQuery -->
    <!-- <script src="admin/assets/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap 4 -->
    <script src="admin/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js" integrity="sha512-MqEDqB7me8klOYxXXQlB4LaNf9V9S0+sG1i8LtPOYmHqICuEZ9ZLbyV3qIfADg2UJcLyCm4fawNiFvnYbcBJ1w==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

</body>

</html>