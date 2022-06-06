<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("includes/uploader2.php") ?>
<?php //include("../includes/admission_confirmation_mail.php") 
?>
<?php //include("../includes/enrollment_confirmation_mail.php") 
?>
<?php
$registrationId = $enrollId = $role = '';
//---------------------- Mailer Function --------------------------
use PHPMailer\PHPMailer\PHPMailer;

function mailer($regId, $username, $password, $enrollId)
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
    $mail->Subject = 'You are registered successfully. Welcome to SSDIT';
    $mail->Body = admission_confirmation_mail($regId, $username, $password);
    $mail->send();

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

function delete_previous_upload($old_filename)
{
    $files = glob($old_filename . ".*");
    foreach ($files as $file) {
        unlink(realpath($file));
        echo realpath($file);
    }
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

// function delete_previous_upload($old_filename)
// {
//     unlink($file);
// }
$invalidRequest = false;

if (isset($_POST) and !isset($_SESSION['processing'])) {
    global $registrationId, $enrollId, $role;

    $name = strtoupper(test_input($_POST['fname']) . " " . test_input($_POST['mname']) . " " . test_input($_POST['lname']));
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
    // $username = strtolower(test_input($_POST['username']));
    $password = md5(test_input($_POST['mobile']));
    // $referredBy = strtoupper(test_input($_POST['referredBy']));
    $country = test_input($_POST['country']);
    //---------------------
    $acNo = test_input($_POST['acNo']);
    $acName = strtoupper(test_input($_POST['acName']));
    $acIfsc = strtoupper(test_input($_POST['acIfsc']));
    $acBankName = strtoupper(test_input($_POST['acBankName']));
    $acType = test_input($_POST['acType']);
    $pancard = strtoupper(test_input($_POST['pancard']));
    //---------------------

    $registrationId = test_input($_POST['registrationId']);
    $ur = DB::queryFirstRow("SELECT name,username FROM usrregistration WHERE registrationId = %s", $registrationId);
    // $name = $ur['name'];
    $email = $ur['username'];
    date_default_timezone_set('Asia/Kolkata');

    $_SESSION["processing"] = $registrationId;

    // saving personal informations
    $tbl_admission = DB::insertUpdate('admissions', [
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
        'email' => $email,
    ]);

    //saving address
    if ($tbl_admission) {
        DB::insertUpdate('usrregistration', [
            'registrationId' => $registrationId,
            'name' => $name
        ]);

        DB::insertUpdate('addresses', [
            'id' => $registrationId,
            'address' => $address,
            'city' => $city,
            'district' => $district,
            'state' => $state,
            'country' => $country,
            'pincode' => $pincode,
        ]);

        //saving bank details
        DB::insertUpdate('bank_details', [
            'id' => $registrationId,
            'acNumber' => $acNo,
            'acName' => $acName,
            'ifsc' => $acIfsc,
            'bankName' => $acBankName,
            'type' => $acType,
            'pancard' => $pancard,
        ]);
        DB::disconnect();
        DB::insertIgnore('documents', [
            'id' => $registrationId
        ]);
    } else {
        $_SESSION['failure'] = true;
    }





    //uploading documents 
    //php scratch uploading method
    if (isset($_FILES) && !isset($_SESSION['failure'])) {
        //adding documents record

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
                    // $old_file = DB::queryFirstRow("SELECT %s FROM documents WHERE id=%s", $suffix[0], $registrationId);
                    $old_file_name = "../uploads/d/" . $registrationId . '_' . $suffix[0];
                    try {
                        delete_previous_upload($old_file_name);
                    } catch (Exception $e) {
                    }
                    $file_location = "uploads/d/" . $file_name;
                    DB::update('documents', [
                        $suffix[0] => $file_location,
                    ], "id=%s", $registrationId);
                    DB::disconnect();
                    move_uploaded_file($file_tmp, '../' . $file_location);
                }
            }
        }
    } else {
        $_SESSION['failure'] = true;
    }


    $_POST = array();
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
                                <h3>Details Updation failed</h3>
                                <h4>Something wents wrong. Please try again</h4>
                            </div>
                        <?php } else {
                            $user = DB::queryFirstRow("SELECT username,registrationId FROM usrregistration WHERE registrationId=%s", $_SESSION['processing'])
                        ?>
                            <center>
                                <div class="alert alert-success mb-4" role="alert">
                                    <h1>Details Updated Successful</h1>
                                </div>
                                <h5>Registration ID: <?php echo $user['registrationId'] ?></h5>
                                <h5>Username: <?php echo $user['username'] ?></h5>
                                <div class="">
                                    <a class="m-3 btn btn-primary" href="./" role="button">Go home</a>
                                    <a class="m-3 btn btn-primary" href="./admission.php" role="button">New admission</a>
                                </div>
                            </center>
                        <?php    } ?>
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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>

</html>