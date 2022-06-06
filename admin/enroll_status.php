<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("../includes/enrollment_confirmation_mail.php") ?>

<?php

$errors = $success = [];
$studentid = $enrollId = "";

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

//generating course enrolled id
function generate_enrollId()
{
    $enId = strval(date("Ymd") . substr(str_shuffle("0987654321"), 0, 5));
    $result  = DB::queryFirstRow("SELECT * FROM courses_enrolled where id = %s", $enId);
    if ($result) {
        $enId = generate_enrollId();
    } else {
        $enId = $enId;
    }
    return 'CE' . $enId;
}

$invalidRequest = false;

if (isset($_POST['btnEnroll']) and !isset($_SESSION['enrollmentSuccess'])) {
    global $studentid, $enrollId;
    date_default_timezone_set('Asia/Kolkata');

    //Saving courses enrolled data if user is student
    $department = test_input($_POST['department']);
    $courseid = test_input($_POST['courseid']);
    $installments = (int)test_input($_POST['installments']);
    $discount = test_input($_POST['discount']);
    $scholarship = test_input($_POST['scholarship']);
    $scholarBenificiary = test_input($_POST['scholarBenificiary']);
    $enrollId = generate_enrollId();
    $studentid = test_input($_POST['studentid']);
    $u = DB::queryFirstRow('SELECT uname FROM admissions WHERE id=%s', $studentid);
    $username = $u['uname'];
    $datetime =  date("Y-m-d H:i:s");

    $course = DB::queryFirstRow("SELECT fees,duration FROM courses WHERE id=%s", $courseid);
    $doc = date("d/m/Y", strtotime($course['duration'], strtotime(date("y-m-d"))));
    $fees = $course['fees'];
    $disc = (($fees * $discount) / 100);
    $feesPayable = $fees - (($fees * $discount) / 100);
    $scholarship_payable =  (($fees - $disc) * $scholarship) / 100;
    $i = DB::queryFirstRow("SELECT firstInstallment FROM courses WHERE id=%s", $courseid);
    $isemi = ($installments <= 1) ? 0 : 1;
    $installmentPerMonth = ($isemi) ? ($feesPayable - $i['firstInstallment']) / ($installments - 1) : 0;

    $isExist = DB::queryFirstRow("SELECT id FROM courses_enrolled WHERE courseId=%s AND studentId=%s", $courseid, $studentid);
    if (isset($isExist)) {
        array_push($errors, 'Student already enrolled in the selected course');
    } else {
        global $success, $enrollId, $studentid;
        DB::insert('courses_enrolled', [
            'id' => $enrollId,
            'courseId' => $courseid,
            'courseType' => ($courseid[0] == 'D') ? 'Diploma' : 'Certification',
            'studentId' => $studentid,
            'doa' => date("d/m/Y"),
            'doc' => $doc,
            'timestamp' => $datetime

        ]);

        DB::insert('payment_status', [
            'id' => $enrollId,
            'status' => 'Pending',
            'isemi' => $isemi,
            'installmentsTaken' => $installments,
            'discountTaken' => $discount,
            'scholarshipTaken' => $scholarship,
            'scholarshipDate' => $scholarBenificiary,
            'firstInstallmentAmount' => $i['firstInstallment'],
            'feesPayable' => $feesPayable,
            'installmentsRemain' => $installments,
            'installmentPerMonth' => $installmentPerMonth,
            'feesPaid' => 0,
            'feesRemain' => $feesPayable,
            'ps_timestamp' => $datetime
        ]);
        mailer($studentid, $username, $enrollId);
        array_push($success, 'Student enrolled successfully.');
        $_SESSION['enrollmentSuccess'] = $enrollId;
        $_SESSION['enrolledStudent'] = $studentid;
    }
} elseif (!isset($_SESSION['enrollmentSuccess'])) $invalidRequest = true;
?>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card w-100 min-vh-100">
                    <div class="card-body">
                        <?php if ($invalidRequest == true) { ?>
                            <div class="alert alert-warning mb-4" role="alert">
                                <h3>Invalid Request</h3>
                                <a class="m-3 btn btn-primary" style="text-decoration: none;" href="./enroll_course.php">New Enrollment</a>
                            </div>
                        <?php } else if ($errors) { ?>

                            <div class="alert alert-warning mb-4" role="alert">
                                <h3>Student already enrolled in the selected course</h3>
                                <a class="m-3 btn btn-primary" style="text-decoration: none;" href="./enroll_course.php">New Enrollment</a>

                            </div>

                        <?php } else {
                            $user = DB::queryFirstRow("SELECT username,registrationId FROM usrregistration WHERE registrationId=%s", $_SESSION['enrolledStudent'])

                        ?>
                            <center>
                                <div class="alert alert-success mb-4" role="alert">
                                    <h3>Student enrolled successfully.</h3>
                                    <h5>Course Enrollment ID: <?php echo $_SESSION['enrollmentSuccess'] ?></h5>
                                    <h6>Registration ID: <?php echo $user['registrationId'] ?></h6>
                                </div>
                                <br>
                                <a class="m-3 btn btn-primary" href="./enroll_course.php">New Enrollment</a>
                                <button class="m-3 btn btn-primary" id="print" onclick="printJS('generatedForm', 'html')">Print form</button>
                                <div class="row">
                                    <div class="offset-md-3 col " style="overflow-x: scroll;">
                                        <div id="generatedForm"></div>
                                    </div>
                                </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<?php include("includes/scripts.php") ?>
<!-- <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script> -->
<script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    var rId = '<?php echo $_SESSION["enrolledStudent"] ?>';
    var eId = '<?php echo $_SESSION["enrollmentSuccess"] ?>';
    localStorage.setItem("ec_registrationId", (rId != '') ? rId : localStorage.getItem("ec_registrationId"));
    localStorage.setItem("ec_enrollId", (eId != '') ? eId : localStorage.getItem("ec_enrollId"));

    $.ajax({
        type: "POST",
        url: "../includes/admission_acknoledgement.php",
        data: {
            registrationId: localStorage.getItem("ec_registrationId"),
            enrollmentId: localStorage.getItem("ec_enrollId"),
            print: true
        },
        success: function(data) {
            console.log(data);
            $('#generatedForm').append(data);
        }
    })
</script>