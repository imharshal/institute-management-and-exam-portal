<!-- ....../payment.php?pid=CE12345674545 -->
<!-- https://localhost/students/payment.php?pid=CE2021061604352 -->


<?php require("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>


<?php
$errors = $success = [];
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
?>



<?php
// if (false)
if (isset($_SESSION['student'])) {


    $pid = $_GET['pid'];
    $_SESSION['pid'] = $pid;
    $payment = DB::queryFirstRow("SELECT * FROM payment_status WHERE id=%s", $pid);
    $personal_details = DB::queryFirstRow("SELECT email, mobile FROM admissions
                                    LEFT JOIN courses_enrolled
                                    ON courses_enrolled.studentId = admissions.id
                                    WHERE courses_enrolled.id = %s
                                    ", $pid);
    // print_r($personal_details);
    // print_r($payment);

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Make Payment</h1>
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
                                            <form id="paymentForm" action="../includes/payments/pgRedirect.php" method="post">
                                                <div class="form-group">

                                                    <input type="hidden" id="ORDER_ID" name="ORDER_ID" value="<?php echo  generate_txn_id() ?>">
                                                    <input type="hidden" id="CUST_ID" name="CUST_ID" autocomplete="off" value="<?php echo $_SESSION['student'] ?>">
                                                    <input type="hidden" id="CHANNEL_ID" name="CHANNEL_ID" value="WEB">
                                                    <input type="hidden" id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" value="Retail">
                                                    <input type="hidden" name="user" value="student">
                                                    <input type="hidden" name="EMAIL" value="<?php echo $personal_details['email'] ?>">
                                                    <input type="hidden" name="MOBILE" value="<?php echo $personal_details['mobile'] ?>">
                                                    <label for="">Installment Amount/Fees</label>
                                                    <input type="text" class="form-control" value="<?php echo $amount ?>" name="TXN_AMOUNT" id="amount" readonly>
                                                </div>

                                                <center>
                                                    <button type="submit" name="btnPayment" class="btn btn-primary btn-lg" <?php if ($amount <= 0) echo 'disabled' ?>>Pay Online</button>
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

    <?php include("includes/scripts.php") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            $('#paymentForm').validate({
                rules: {
                    amount: "required",

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
<?php
} else {
    echo "<center><h1>Invalid Request</h1></center>";
}
?>

</html>