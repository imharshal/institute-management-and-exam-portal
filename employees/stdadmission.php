<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admission Form</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="card">
                <div class="card-body col-md-8">
                    <form action="#">
                    <div class="tab-content" id="student-tabContent">

                        <?php include("includes/tabs/tab_student_form1.php") ?>
                        <?php include("includes/tabs/tab_student_form2.php") ?>
                    </div>
                        <script>
                            function formNextStep() {
                                var form1 = document.getElementById("tab-student-form1");
                                var form2 = document.getElementById("tab-student-form2");
                                if (form2.style.display === "none") {
                                    form2.style.display = "block";
                                    form1.style.display= "none";
                                }
                            }
                        </script>



                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include("includes/scripts.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#birth-date').mask('00/00/0000');
            $('#birth-date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd/mm/yy",
                yearRange: "1900:2100"
            });
            $('#mobile').mask('00000 00000');
            $('#pincode').mask('000 000');
            $('#aadhar').mask('0000 0000 0000');

            bsCustomFileInput.init();


        });
    </script>
    </body>

    </html>