<?php require("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/enrollment_confirmation_mail.php") ?>
<?php unset($_SESSION["enrollmentSuccess"]); ?>
<?php unset($_SESSION['enrolledStudent']); ?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Enroll in new course</h1>
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
                    <div class="card card-teal ">
                        <div class="card-body">
                            <?php
                            $courseDetails = [];
                            if (isset($_GET['x_token']))
                                $courseDetails = DB::queryFirstRow("select * from courses where id=%s", $_GET['x_token']);

                            ?>
                            <form id="enrollform" action="enroll_status.php" class="container" method="post">
                                <input type="hidden" name="studentid" value="<?php echo $_SESSION['student'] ?>">
                                <input type="hidden" name="x_token" value="<?php echo isset($_GET['x_token']) ? $_GET['x_token'] : '' ?>">
                                <!--  -->
                                <div class="m-md-5"></div>
                                <?php if (isset($_GET['x_token'])) { ?>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Course Name<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <input type="hidden" name="courseid" value="<?php echo $courseDetails['id'] ?>">
                                                    <!-- <input type="text" class="form-control"  aria-describedby="helpId" placeholder="" value="<?php echo $courseDetails['name'] ?>" readonly> -->
                                                    <strong><?php echo $courseDetails['name'] ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Admission For<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="department" id="department">
                                                    <option value="">Select</option>
                                                    <option value="Diploma">Diploma</option>
                                                    <option value="Certification">Certifications</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Courses<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="courseid" id="courses">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Course Fees</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if (isset($_GET['x_token'])) { ?>
                                            <h4 class="text-muted">Rs. <span><?php echo $courseDetails['fees'] ?></span></h4>
                                        <?php } else { ?>
                                            <h4 class="text-muted">Rs. <span id="course-fees"></span></h4>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">No. of Installments<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php if (isset($_GET['x_token'])) { ?>
                                                <select class="form-control" name="installments" id='installments-new-user'>
                                                    <?php for ($i = 1; $i <= (int)$courseDetails['installments']; $i++)
                                                        echo "<option value='$i'>$i</option>"; ?>
                                                </select>
                                            <?php } else { ?>
                                                <select class="form-control" name="installments" id="installments">
                                                </select>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($_GET['x_token'])) {
                                    $fees = $courseDetails['fees'];
                                    $disc = (($fees * $courseDetails['discount']) / 100);
                                    $feesPayable = $fees - $disc;
                                    $scholarship_payable =  (($fees - $disc) * $courseDetails['scholarship']) / 100;
                                }
                                ?>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fees Payable</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if (isset($_GET['x_token'])) { ?>
                                            <h4 class="text-muted">Rs. <span><?php echo $fees ?></span></h4>
                                        <?php } else { ?>
                                            <h4 class="text-muted" id="fees-payable"></h4>
                                        <?php } ?>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Scholarship Benefit</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if (isset($_GET['x_token'])) { ?>
                                            <h4 class="text-muted">Rs. <span><?php echo $scholarship_payable ?></span></h4>
                                        <?php } else { ?>
                                            <h4 class="text-muted" id="scholarship-payable"></h4>
                                        <?php } ?>
                                    </div>
                                </div>
                                <center>
                                    <button type="submit" name="btnEnroll" class="btn btn-primary btn-lg" style="width:200px;">Enroll</button>
                                </center>

                            </form>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <?php //} 
            ?>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


<script>
    $(document).ready(function() {

        $('#scholarBenificiary').mask('00/00/0000');
        $('#scholarBenificiary').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            yearRange: "1900:2100",
            onSelect: function(date) {
                $(this).focusout();
            },
        });



        // updating the course list on department change event
        $('#department').on('change', function() {
            department = $('#department :selected').val();
            // console.log(department);
            $("#courses").empty()
                .append('<option value="" hidden>Select</option>');
            $.ajax({
                url: 'api.php',
                type: 'get',
                data: 'courses=' + department,
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(i, row) {
                        // console.log(row.name)
                        $('#courses').append($('<option>').text(row.name).val(row.id));
                    });
                }
            });
        })

        // $('.calculate-fees').on('input', function() {
        //     calculatePayableFees();
        // });


        // function calculatePayableFees() {
        //     var fees = parseFloat($('#course-fees').text());
        //     d = parseFloat($('#discount').val());
        //     s = parseFloat($('#scholarship').val());
        //     var discount = fees * d / 100;
        //     // var scholarship = fees * s / 100;
        //     var feesPayable = fees - discount;
        //     var scholarship_payable = (fees - discount) * s / 100;
        //     // feesPayable = fees*d/100;
        //     $('#fees-payable').text('Rs.' + feesPayable);
        //     $('#scholarship-payable').text('Rs.' + scholarship_payable);
        // }


        // updating the field values on course change event
        $('#courses').on('change', function() {
            course = $('#courses :selected').val();
            // console.log(department);
            $.ajax({
                url: 'api.php',
                type: 'get',
                data: 'course=' + course,
                dataType: 'json',
                success: function(row) {
                    // console.log(row);
                    console.log(row.installments);
                    $('#course-fees').text(row.fees);
                    inst = row.installments;
                    var i = 1;
                    while (i <= inst) {
                        $('#installments').append($('<option>').text(i).val(i));
                        i++;
                    }
                    fees = row.fees
                    d = row.discount;
                    s = row.scholarship;
                    var discount = fees * d / 100;
                    var feesPayable = fees - discount;
                    var scholarship_payable = (fees - discount) * s / 100;
                    $('#fees-payable').text('Rs.' + feesPayable);
                    $('#scholarship-payable').text('Rs.' + scholarship_payable);
                }

            });
        });

        $("#enrollform").validate({
            rules: {
                studentid: "required",
                department: "required",
                courseid: "required",
                installments: "required",
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
                // $('#next-btn').attr('disabled', true);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
                $('#next-btn').removeAttr('disabled');

            },
            // submitHandeler: function(form) {}
        })



    });
</script>


</body>

</html>