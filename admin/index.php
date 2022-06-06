<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>

                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h1 class="card-title text-bold">Enquiries</h1>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow-y:scroll; height:400px;">
                        <div class="post">
                            <?php
                            $enquiries = DB::query("SELECT * FROM enquiries WHERE status = %s ORDER BY timestamp ASC", 'Active');
                            foreach ($enquiries as $eq) {
                            ?>
                                <div class="card">
                                    <div class="card-body"> 
                                        <h6 class="m-0"><b><?php echo $eq['name'] ?></b> <i class="fas fa-check-square float-right text-success"></i></h6>
                                        <p>
                                            <span class="text-blue text-sm "><?php echo $eq['email'] ?></span>
                                            <span class=" text-blue text-sm float-right"><?php echo $eq['mobile'] ?></span>
                                        </p>
                                        <!-- <div class="h5"> -->
                                        <span style="width: 100px;" class=" badge-light w-100">"
                                            <?php echo $eq['message'] ?> "</span>
                                        <!-- </div> -->
                                    </div>
                                </div>
                                <!-- /.user-block -->

                            <?php } ?>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


            <div class="col-12 col-md-4">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title text-bold">Active Exams</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body" style="overflow-y:scroll; height:400px;">
                        <div class="post">
                            <div class="d-block">

                                <?php $exam = DB::query("SELECT examName,department FROM exams WHERE status=%s", 'Active') ?>
                                <?php if ($exam) {
                                    foreach ($exam as $e) { ?>
                                        <a href="./exam/exams.php">
                                            <div> <span class="h5"><?php echo $e['examName'] ?></span>
                                                <span class="p badge badge-primary float-right"><?php echo $e['department'] ?></span>
                                            </div>
                                        </a>
                                        <hr>
                                <?php }
                                } else echo "<center>No active exams found </center>" ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col col-md-4">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title text-bold">Send Message</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <form action="" method="post" id="msgForm">
                        <div class="card-body" style="overflow-y:scroll; height:400px; ">
                            <div class="form-group">
                                <label for="">User ID </label>
                                <select class="form-control select-name" title="Select User.." data-live-search="true" name="studentid" id="students-list">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea class="form-control" name="message" rows="7" placeholder="Type your Message Here"></textarea>
                            </div>
                            <button class="btn btn-primary float-right" style="width: 100px;" onClick="window.alert('Messege sent successfuly.')">Send</button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include("includes/scripts.php") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $.ajax({
        url: 'api.php',
        type: 'get',
        data: 'getAllUsers',
        dataType: 'json',
        success: function(data) {
            // console.log(data)
            $.each(data, function(i, row) {
                console.log(row.name)
                $('#students-list').append($('<option>').text(row.name).attr({
                    'value': row.id,
                    // 'data-token': row.id,
                    'data-subtext': row.id
                }));

            });

            $('.select-name').selectpicker('refresh');
        }
    })
    $('#msgForm').validate({
        rules: {
            message: "required",
            studentid: {
                required: true,
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


    });

   
</script>
</body>

</html>