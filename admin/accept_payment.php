<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>



<?php
$errors = $success = [];
$txnid = $studentId = '';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_payment_pin($pin)
{
    //returns true if pin valid
    // returns false if pin is invalid
    try {
        $result = DB::queryFirstRow("SELECT registrationId FROM admin WHERE paymentPin = %s", $pin);
        if ($result) return true;
        else return false;
    } catch (Exception $e) {
    }
}

function generate_txn_id()
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $id =  uniqid($prefix = 'TXN'); //strval(substr(str_shuffle($str_result), 0, 10));
    $result  = DB::queryFirstRow("SELECT id FROM transactions where id = %s", $id);
    if ($result) {
        $txnid = generate_txn_id();
    } else {
        $txnid = $id;
    }
    return $txnid;
}

if (isset($_POST['btnPayment'])) {
    $pid = test_input($_GET['ps']); //course enrolled/ payment_status id
    $payment = DB::queryFirstRow("SELECT * FROM payment_status WHERE id=%s", $pid);
    $sid = DB::queryFirstRow("SELECT studentId FROM courses_enrolled WHERE id=%s", $pid);
    $studDetails = DB::queryFirstRow('SELECT id,mobile,email FROM admissions WHERE id=%s', $sid['studentId']);

    $userAmount = test_input($_POST['amount']);
    $paymentPin = md5(test_input($_POST['paymentPin']));

    $iTaken = ($payment['installmentsTaken'] == 0) ? 1 : $payment['installmentsTaken'];
    $installment = ($payment['feesPaid'] >= $payment['firstInstallmentAmount']) ? $payment['installmentPerMonth'] : $payment['firstInstallmentAmount']; //(float)$payment['feesPayable'] / $iTaken;
    $amount = (($payment['installmentsRemain'] == 0) or $iTaken == 1) ? $payment['feesRemain'] : $installment;


    // $iTaken = ($payment['installmentsTaken'] == 0) ? 1 : $payment['installmentsTaken'];
    // $installment = $payment['installmentPerMonth']; //$payment['feesPayable'] / $iTaken;
    // $amount = ($payment['installmentsRemain'] === 0) ? $payment['feesRemain'] : $installment;
    date_default_timezone_set('Asia/Kolkata');

    if ($userAmount == $amount) {
        if (validate_payment_pin($paymentPin)) {
            global $txnid, $studentId;
            $txnid = generate_txn_id();
            $datetime =  date("Y-m-d H:i:s");
            $studentId = $studDetails['id'];
            $mobile = $studDetails['mobile'];
            $email = $studDetails['email'];

            DB::startTransaction();
            try {
                $result = DB::insert("transactions", [
                    'id' => $txnid,
                    'datetime' => $datetime,
                    'status' => 'Success',
                    'studentId' => $studentId,
                    'enrollmentId' => $pid,
                    'txnAmount' => $amount,
                    'paymentMode' => 'Cash',
                ]);

                if ($result) {
                    $feesRemain = $payment['feesRemain'] - $amount;
                    $feesPaid = $payment['feesPaid'] + $amount;
                    $installmentsRemain = ($payment['installmentsRemain'] == 0) ? 0 : ($payment['installmentsRemain'] - 1);
                    $status = ($feesRemain == 0) ? 'Completed' : 'Pending';

                    $updatation = DB::update('payment_status', [
                        'feesRemain' => $feesRemain,
                        'installmentsRemain' => $installmentsRemain,
                        'feesPaid' => $feesPaid,
                        'status' => $status,
                    ], "id=%s", $pid);

                    DB::commit();
                    array_push($success, "Payment proceed successful");
                }
            } catch (Exception $e) {
                DB::rollback();
            }
        }
    } else {
        array_push($errors, "Amount cannot be verified please try again");
    }
?>
    <div class="content-wrapper">

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
                    <br>
                    <center>
                        <a href="./accounts.php" class="m-3 btn btn-primary">Accept another payment</a>
                        <button class="m-3 btn btn-primary" id="print" onclick="printJS('generatedForm', 'html')">Print invoice</button>
                        <br>
                    </center>

                    <div style="overflow-x: scroll;">
                        <center>
                            <div id="generatedForm"></div>
                        </center>
                    </div>

                <?php } ?>
            </div>
        </section>
    </div>
<?php } ?>



<?php
if (!isset($_POST['btnPayment']))
    if (isset($_GET['ps'])) {
        $pid = $_GET['ps'];
        $payment = DB::queryFirstRow("SELECT * FROM payment_status WHERE id=%s", $pid);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Accept Payment</h1>
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
                        <div class="card card-outline card-teal ">

                            <div class="card-body row">
                                <div class="col-md-4 card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col col-md-7">
                                                <h5>Total Fees</h5>
                                            </div>
                                            <div class="col col-md-5">
                                                <h5><?php echo $payment['feesPayable'] ?></h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col col-md-7">
                                                <h5>Fees Paid</h5>
                                            </div>
                                            <div class="col col-md-5">
                                                <h5><?php echo $payment['feesPaid'] ?></h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col col-md-7">
                                                <h5>Fees Remain</h5>
                                            </div>
                                            <div class="col col-md-5">
                                                <h5><?php echo $payment['feesRemain'] ?></h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col col-md-7">
                                                <h5>Installments Taken</h5>
                                            </div>
                                            <div class="col col-md-5">
                                                <h5><?php echo $payment['installmentsTaken']
                                                    ?></h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col col-md-7">
                                                <h5>Installments Remain</h5>
                                            </div>
                                            <div class="col col-md-5">
                                                <h5><?php echo $payment['installmentsRemain']
                                                    ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $iTaken = ($payment['installmentsTaken'] == 0) ? 1 : $payment['installmentsTaken'];
                                $installment = ($payment['feesPaid'] >= $payment['firstInstallmentAmount']) ? $payment['installmentPerMonth'] : $payment['firstInstallmentAmount']; //(float)$payment['feesPayable'] / $iTaken;
                                $amount = (($payment['installmentsRemain'] == 0) or $iTaken == 1) ? $payment['feesRemain'] : $installment;
                                ?>

                                <div class="card offset-1 col-md-6">
                                    <div class="row card-body">
                                        <div class="col-md-12">
                                            <form id="paymentForm" action="" method="post">
                                                <div class="form-group">
                                                    <label for="">Installment Amount/Fees</label>
                                                    <input type="text" class="form-control" value="<?php echo $amount ?>" name="amount" id="amount" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Payment Pin</label>
                                                    <input type="password" maxLength="6" class="form-control" name="paymentPin" id="paymentPin">
                                                </div>

                                                <center>
                                                    <button type="submit" name="btnPayment" class="btn btn-primary btn-lg">Accept Cash</button>
                                                </center>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php } else {
        echo "<center><h1>Invalid Request</h1></center>";
    }
?>
<?php include("includes/scripts.php") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    $(document).ready(function() {


        <?php if ($success) { ?>
            var rId = '<?php echo $studentId ?>';
            var tId = '<?php echo $txnid ?>';
            localStorage.setItem("ap_registrationId", (rId != '') ? rId : localStorage.getItem("ap_registrationId"));
            localStorage.setItem("ap_txnId", (tId != '') ? tId : localStorage.getItem("ap_txnId"));

            $.ajax({
                type: "GET",
                url: "../includes/invoice.php",
                data: {
                    registrationId: localStorage.getItem("ap_registrationId"),
                    txnId: localStorage.getItem("ap_txnId"),
                    print: true
                },
                success: function(data) {
                    console.log(data);
                    $('#generatedForm').append(data);
                }
            });

        <?php } ?>
        $('#paymentForm').validate({
            rules: {
                amount: "required",
                paymentPin: {
                    required: true,
                    remote: {
                        url: 'api.php',
                        type: 'post',
                        data: {
                            paymentPin: function() {
                                return $('#paymentPin').val()
                            }
                        }
                    }
                }
            },
            messages: {
                paymentPin: {
                    remote: "Invalid Payment Pin"
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
            submitHandeler: function(form) {

            }


        })
    });
</script>


</body>

</html>