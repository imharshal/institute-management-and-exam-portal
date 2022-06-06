<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Accounts</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-teal">
                        <div class="card-body p-0">
                            <table id="Emp-payment-history" class="" data-toggle="table" data-search="true"
                                data-pagination="true">
                                <caption>Payment History</caption>
                                <thead class="">
                                    <tr>
                                        <th data-sortable="true">Invoice Id</th>
                                        <th data-sortable="true">Payment Date</th>
                                        <th data-sortable="true">Base Salary</th>
                                        <th data-sortable="true">Refferal Bonus</th>
                                        <th data-sortable="true">Total Amount</th>
                                        <th data-sortable="true">Mode of Payment</th>
                                        <th data-sortable="true">Download Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SSDIT202100001</td>
                                        <td>01/01/2021</td>
                                        <td>12500</td>
                                        <td>2500</td>
                                        <td>15000</td>
                                        <td>Online</td>
                                        <td><i class="fas fa-download nav-icon"></i></td>
                                    </tr>

                                </tbody>

                            </table>
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
</body>

</html>