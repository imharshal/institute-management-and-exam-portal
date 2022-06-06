<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
$_SESSION['logged_in'] = true;
$_SESSION['student'] = $_GET['s'];
?>

<?php require("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/paymentemail.php") ?>
<?php

use PHPMailer\PHPMailer\PHPMailer;

$studentId = $txnid = '';

$pid = $_GET['pid']; //course enrolled/ payment_status id
$payment = DB::queryFirstRow("SELECT * FROM payment_status WHERE id=%s", $pid);
$sid = DB::queryFirstRow("SELECT studentId,courseId FROM courses_enrolled WHERE id=%s", $pid);
$studDetails = DB::queryFirstRow('SELECT id,mobile,email FROM admissions WHERE id=%s', $sid['studentId']);
?>

<style>
    .success {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .failed {
        color: #d9534f;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }
</style>


<?php
//---------------------- Payment Table Details --------------------------
function online_payment_table($data, $isErr = False)
{ ?>
    <tr>
        <th>TRANSACTION ID</th>
        <td><?php echo $data['ORDERID'] ?></td>
    </tr>
    <tr>
        <th>DATE</th>
        <td><?php echo ($isErr ? date('Y-m-d H:i:s') : $data["TXNDATE"]) ?></td>
    </tr>
    <tr>
        <th>TRANSACTION AMOUNT</th>
        <td><?php echo $data['TXNAMOUNT'] ?></td>
    </tr>
    <tr>
        <th>PAYMENT MODE</th>
        <td><?php echo ($isErr ? '-' : $data["PAYMENTMODE"]) ?></td>
    </tr>
    <tr>
        <th>PAYTM TRANSACTION ID</th>
        <td><?php echo $data['TXNID'] ?></td>
    </tr>
    <tr>
        <th>BANK TRANSACTION ID</th>
        <td><?php echo ($isErr ? '-' : $data["BANKTXNID"]) ?></td>
    </tr>
<?php }

//---------------------- Mail Payment Details --------------------------
function string_payment_table($data, $isErr = False)
{

    return '
<tr>
    <th style="min-width:180px;">TRANSACTION ID</th>
    <td>' . $data["ORDERID"] . '</td>
</tr>
<tr>
    <th style="min-width:180px;">DATE</th>
    <td>' . ($isErr ? date('Y-m-d H:i:s') : $data["TXNDATE"]) . '</td>
</tr>
<tr>
    <th style="min-width:180px;">TRANSACTION AMOUNT</th>
    <td>Rs ' . $data["TXNAMOUNT"] . '</td>
</tr>
<tr>
    <th style="min-width:180px;">PAYMENT MODE</th>
    <td>' . ($isErr ? '-' : $data["PAYMENTMODE"]) . '</td>
</tr>
<tr>
    <th style="min-width:180px;">PAYTM TRANSACTION ID</th>
    <td>' . $data["TXNID"] . '</td>
</tr>
<tr>
    <th style="min-width:180px;">BANK TRANSACTION ID</th>
    <td>' . ($isErr ? '-' : $data["BANKTXNID"]) . '</td>
</tr>';
}

//---------------------- Mailer Function --------------------------
function mailer($email, $statustext, $statusimage, $subject, $isErr = False)
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
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = paymentmail($statustext, $statusimage, $subject, $isErr);
    $mail->send();
}

?>


<?php
// following files need to be included
require_once("../includes/payments/lib/config_paytm.php");
require_once("../includes/payments/lib/encdec_paytm.php");

$paytmChecksum = "";
$ordid = $datetime = $studentId = $txnid = $txnAmount = $bnkTxnId = "";
$paramList = array();
$isValidChecksum = "FALSE";
$success = $errors = array();
$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
if ($isValidChecksum == "TRUE") {

    $ordid = $_POST['ORDERID'];
    $studentId = $studDetails['id'];
    $txnid = $_POST['TXNID'];
    $txnAmount = $_POST['TXNAMOUNT'];

    // echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
    if ($_POST["STATUS"] == "TXN_SUCCESS") {
        // echo "<b>Transaction status is success</b>" . "<br/>";
        //Process your transaction here as success transaction.
        //Verify amount & order id received from Payment gateway with your application's order id and amount.

        $iTaken = ($payment['installmentsTaken'] == 0) ? 1 : $payment['installmentsTaken'];
        $installment = ($payment['feesPaid'] >= $payment['firstInstallmentAmount']) ? $payment['installmentPerMonth'] : $payment['firstInstallmentAmount']; //(float)$payment['feesPayable'] / $iTaken;
        $amount = (($payment['installmentsRemain'] == 0) or $iTaken == 1) ? $payment['feesRemain'] : $installment;

        date_default_timezone_set('Asia/Kolkata');
?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="text-center">
                    <br>
                    <div class="elevation-1" style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                        <i class="success">✓</i>
                    </div>
                    <h1 class="font-weight-bolder" style="color:#9ABC66;">Payment Successful!</h1>
                    <h4 class="text-muted">Thank you!<br /> We have received your payment.</h4>
                </div>
                <br>
                <center>
                    <button class="m-3 btn btn-primary" id="print" onclick="printJS('generatedForm', 'html')">Download/Print invoice</button>
                </center>
                <div class="row offset-md-2" style="overflow: scroll;">
                    <!-- <div class="col-md-6">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                <?php //online_payment_table($_POST) 
                                ?>
                            </tbody>
                        </table>
                    </div> -->
                    <div id="generatedForm"></div>
                </div>
                <div style="height: 50px;"></div>
            </div>
        </div>
        <?php
        $isInserted = DB::queryFirstRow("SELECT * FROM transactions WHERE id =%s", $ordid);
        global $studentId;
        if (empty($isInserted)) {
            DB::startTransaction();
            try {
                $result = DB::insert("transactions", [
                    'id' => $ordid,
                    'txnId' => $txnid,
                    'datetime' => substr($_POST['TXNDATE'], 0, 19),
                    'status' => 'Success',
                    'studentId' => $studentId,
                    'enrollmentId' => $pid,
                    'txnAmount' => $txnAmount,
                    'paymentMode' => $_POST['PAYMENTMODE'],
                    'bankTxnId' => $_POST['BANKTXNID']
                ]);

                if ($result) {
                    $feesRemain = $payment['feesRemain'] - $amount;
                    $feesPaid = $payment['feesPaid'] + $amount;
                    $installmentsRemain = ($payment['installmentsRemain'] == 0) ? 0 : ($payment['installmentsRemain'] - 1);
                    $status = ($feesRemain == 0) ? 'Completed' : 'Pending';

                    $updatation = DB::update('payment_status', [
                        'feesRemain' => $feesRemain,
                        'feesPaid' => $feesPaid,
                        'feesRemain' => $feesRemain,
                        'installmentsRemain' => $installmentsRemain,
                        'status' => $status,
                    ], "id=%s", $pid);

                    DB::commit();
                    array_push($success, "Payment proceed successful");
                    //-------------------- Success Email Code -------------------------------------
                    $statusimage = "https://d15k2d11r6t6rl.cloudfront.net/public/users/BeeFree/beefree-n7f4bp7o2gk/editor_images/6565dae7-d61b-4f69-a4f0-950374eda257.png";
                    $statustext = "Thank you for the payment";
                    $subject = "Payment Successful!";
                    mailer($studDetails['email'], $statustext, $statusimage, $subject);
                    //------------------------------------------------==============================-
                }
            } catch (Exception $e) {
                DB::rollback();
            }
        }
    } else if (($_POST["STATUS"] == "TXN_FAILURE") && isset($_POST['PAYMENTMODE'])) {
        //------------------------------------------------------------------------
        //Transaction failed Section
        //------------------------------------------------------------------------

        $isInserted = DB::queryFirstRow("SELECT * FROM transactions WHERE id =%s", $ordid);
        if (empty($isInserted)) {
            DB::startTransaction();
            try {
                $result = DB::insert("transactions", [
                    'id' => $ordid,
                    'txnId' => $txnid,
                    'datetime' => substr($_POST['TXNDATE'], 0, 19),
                    'status' => 'Failed',
                    'studentId' => $studentId,
                    'enrollmentId' => $pid,
                    'txnAmount' => $txnAmount,
                    'paymentMode' => $_POST['PAYMENTMODE'],
                    'bankTxnId' => $_POST['BANKTXNID']
                ]);
                if ($result) DB::commit();
                //-------------------- Failure Email Code -------------------------------------
                $statusimage = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtGLEIlbWD2s2BvOW0ahTjiw-h5BPWqx-_Zw&usqp=CAU";
                $statustext = " Incase any amount has been deducted from your account it will be refunded in 3-4 days.";
                $subject = "Payment Failed!";
                //                 echo $studDetails['email'];
                mailer($studDetails['email'], $statustext, $statusimage, $subject);
                //----------------------------------------------------------------------------
            } catch (Exception $e) {
                DB::rollback();
            }
        }

        ?>
        <div class="content-wrapper">
            <div class="text-center">
                <div class="elevation-1" style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="failed fa-10x fa fa-exclamation-triangle"></i>
                </div>
                <h1 class="font-weight-bolder text-danger">Payment Failed!</h1>
                <h5 class="text-muted">Incase any amount has been deducted from your account it will be refunded in 3-4 days.</h3>
            </div>
            <div class="mt-5 row justify-content-center">
                <div class="col-md-6">
                    <table class="table table-hover table-responsive">
                        <tbody>
                            <?php online_payment_table($_POST) ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    } else {

        $isInserted = DB::queryFirstRow("SELECT * FROM transactions WHERE id =%s", $ordid);
        if (empty($isInserted)) {
            DB::startTransaction();
            try {
                $result = DB::insert("transactions", [
                    'id' => $ordid,
                    'txnId' => $txnid,
                    'datetime' => date('Y-m-d H:i:s'),
                    'status' => 'Failed',
                    'studentId' => $studentId,
                    'txnAmount' => $txnAmount,
                    'paymentMode' => '-',
                    'bankTxnId' => '-'
                ]);
                if ($result) DB::commit();
                //-------------------- Failure Email Code -------------------------------------
                $statusimage = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtGLEIlbWD2s2BvOW0ahTjiw-h5BPWqx-_Zw&usqp=CAU";
                $statustext = " Incase any amount has been deducted from your account it will be refunded in 3-4 days.";
                $subject = "Payment Failed!";
                $isErr = true;
                echo $studDetails['email'];
                mailer($studDetails['email'], $statustext, $statusimage, $subject, $isErr);
                //----------------------------------------------------------------------------
            } catch (Exception $e) {
                DB::rollback();
            }
        }
    ?>
        <div class="content-wrapper">
            <div class="text-center">
                <div class="elevation-1" style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="failed fa-10x fa fa-exclamation-triangle"></i>
                </div>
                <h1 class="font-weight-bolder text-danger">Payment Failed!</h1>
                <h5 class="text-muted">Something wents wrong; you might have cancelled the payment on payment page.</h5>
                <br>
                <h5 class="text-muted">Incase any amount has been deducted from your account it will be refunded in 3-4 days.</h5>
            </div>
            <div class="mt-5 row justify-content-center">
                <div class="col-md-6">
                    <table class="table table-hover table-responsive">
                        <tbody>
                            <?php online_payment_table($_POST, true) ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo "<b>Checksum mismatched.</>";
    //Process transaction as suspicious.
}

include("includes/scripts.php");

?>
<script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> -->

<!-- <script type="text/javascript" src="https://unpkg.com/jspdf@2.0.0/dist/jspdf.umd.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js" integrity="sha512-w3u9q/DeneCSwUDjhiMNibTRh/1i/gScBVp2imNVAMCt6cUHIw6xzhzcPFIaL3Q1EbI2l+nu17q2aLJJLo4ZYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script>
    $(document).ready(function() {

        var rId = '<?php echo $studentId ?>';
        var tId = '<?php echo $ordid ?>';
        localStorage.setItem("op_registrationId", (rId != '') ? rId : localStorage.getItem("op_registrationId"));
        localStorage.setItem("op_txnId", (tId != '') ? tId : localStorage.getItem("op_txnId"));

        $.ajax({
            type: "GET",
            url: "../includes/invoice.php",
            data: {
                registrationId: localStorage.getItem("op_registrationId"),
                txnId: localStorage.getItem("op_txnId"),
                print: true
            },
            success: function(data) {
                // console.log(data);
                $('#generatedForm').append(data);
            }
        });
       
    });
</script>
</body>

</html>