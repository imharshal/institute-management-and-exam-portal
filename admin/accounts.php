<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Students</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-teal card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="accounts-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="accounts-tab1" data-toggle="pill" href="#tab_pending_payments" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Pending Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="accounts-tab2" data-toggle="pill" href="#tab_completed_payments" role="tab" aria-controls="custom-tabs-one-profile1" aria-selected="false">Completed Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="accounts-tab3" data-toggle="pill" href="#tab_transaction_history" role="tab" aria-controls="custom-tabs--profile" aria-selected="false">Transactions History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="accounts-tab3" data-toggle="pill" href="#tab_verify_transaction" role="tab" aria-controls="custom-tabs--profile" aria-selected="false">Verify Transactions</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <!-- Pending Payments Tab -->
                                <?php include("includes/tabs/tab_pending_payments.php")
                                ?>
                                <!--./ Completed Payments Tab -->
                                <?php include("includes/tabs/tab_completed_payments.php")
                                ?>
                                <!-- Transaction history Tab -->
                                <?php include("includes/tabs/tab_transaction_history.php")
                                ?>
                                <!-- Transaction history Tab -->
                                <?php include("includes/tabs/tab_verify_transaction.php")
                                ?>
                            </div>
                            <!-- ./ Add New Department Tab -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>

<script>
    $(document).ready(function() {

        $("#btn-fetch-txn").click(function() {
            $.post("../includes/payments/TxnStatus.php", {
                    ORDER_ID: $('#order_id').val(),
                },
                function(data, status) {
                    $('#fetch-result').html('');

                    var json = $.parseJSON(data);
                    var theHTML="";
                    $.each(json, function(key, value) {
                        theHTML += "<tr><th>" + key + "</th><td>" + value + "</td></tr>";
                    })
                    $('#fetch-result').append(theHTML);
                    // console.log(theHTML);
                }

            );


        });
    });
</script>
</body>

</html>