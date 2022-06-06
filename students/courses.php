<?php require("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>


<?php

    $courses_enrolled = DB::query("SELECT * FROM courses_enrolled
                        RIGHT JOIN courses
                        ON courseId = courses.id
                        RIGHT JOIN payment_status
                        ON payment_status.id = courses_enrolled.id
                        WHERE studentId=%s", $student['registrationId']);


?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Courses</h1>
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
                        <div class="card-body ">
                            <table id="Emp-payment-history" class="" data-toggle="table" data-search="true"
                                data-pagination="true">
                                <caption>Enrolled Courses</caption>
                                <thead class="">
                                    <tr>
                                        <th data-sortable="true">Course Id</th>
                                        <th data-sortable="true">Admission Date</th>
                                        <th data-sortable="true">Admission for</th>
                                        <th data-sortable="true">Total Fees</th>
                                        <th data-sortable="true">Fees Paid</th>
                                        <th data-sortable="true">Remaining Fees</th>
                                        <th data-sortable="true">Make Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses_enrolled as $ce) { ?>
                                    <tr>
                                        <td><?php echo $ce['courseId'] ?></td>
                                        <td><?php echo $ce['doa'] ?></td>
                                        <td><?php echo $ce['name'] ?></td>
                                        <td><?php echo $ce['fees'] ?></td>
                                        <td><?php echo $ce['feesPaid'] ?></td>
                                        <td><?php echo $ce['feesRemain'] ?></td>
                                        <td><button class="btn btn-sm btn-success" onClick="window.alert('Kindly visit the office with the amount mentioned in your admission form to confirm your admission.')">Make Payment</button></td>
                                    </tr>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>More Courses For You</h1>
                    <h3 class="card-title text-bold">More courses are coming for you with lots of exciting offers, Please hold on......!</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        
    </section>
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>
</body>

</html>