<?php
require("includes/header.php") ?>
<style>
    #pageloader {
        background: rgba(255, 255, 255, 0.8);
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    #pageloader img {
        left: 50%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
    }

    #pageloader h4 {
        left: 30%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 30%;
    }
</style>
<div id="pageloader">
    <h4>Please wait. Uploading documents.. this might take time, depends on your network speed. </h4>
    <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
</div>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery.steps@1.1.1/dist/jquery-steps.min.css"> -->
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />


<?php include("includes/scripts.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/imharshal/saveMyForm.jquery/src/saveMyForm.jquery.min.js" type="text/javascript"></script>

<?php unset($_SESSION["processing"]); ?>
<?php unset($_SESSION["failure"]); ?>
<?php unset($_SESSION["enrolledId"]); ?>


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
            <div class="card p-md-5">


                <!-- Step Wizard for registraion -->

                <!-- Referance: https://oguzhanoya.github.io/jquery-steps/ -->
                <!-- <form action="admission_status.php" method="post" id="wizardform" data-persist="garlic" enctype="multipart/form-data"> -->
                <form action="admission_status.php" method="post" id="wizardform" enctype="multipart/form-data">

                    <div id="wizard">
                        <!-- These are the steps -->
                        <ul class="nav d-flex   ">
                            <!-- <li data-step-target="step1">Registration</li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="#step-1">Basic Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#step-2">Bank Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#step-3">Documents Upload</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#step-4">Course Details</a>
                            </li>

                        </ul>

                        <div class="tab-content">

                            <?php include("includes/tabs/tab_student_form.php")
                            ?>
                            <?php // include("includes/tabs/tab_student_form2.php") 
                            ?>
                        </div>
                        <hr style="border-color: black;">
                        <style>
                            @media (min-width:600px) {
                                .btn-width-200 {
                                    width: 200px;
                                }
                            }
                        </style>
                        <center>
                            <p id="prev-btn" class="btn btn-primary btn-md-lg btn-width-200">Previous</p>
                            <input type="reset" class="ml-md-5 mx-3 btn-sm mb-3 btn btn-outline-warning" value="Reset form">
                            <p href="#" id="next-btn" name='submit' class=" ml-md-5 btn btn-primary btn-md-lg btn-width-200">Save and Next</p>
                        </center>


                </form>
            </div>

            <!-- </div> -->

        </div>


</div>
</div>
</section>

<script>
    // window.onbeforeunload = function() {
    //     return "Dude, are you sure you want to leave? Think of the kittens!";
    // }
    $(document).ready(function() {

        //input masking scripts
        $('#birth-date').mask('00/00/0000');
        $('#birth-date').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            yearRange: "1900:2100",
            onSelect: function(date) {
                $(this).focusout();
            },
        });
        $('#scholarBenificiary').mask('00/00/0000');
        $('#pancard').mask('SSSSS0000S');
        $('#scholarBenificiary').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            yearRange: "1900:2100",
            onSelect: function(date) {
                $(this).focusout();
            },
        });
        // $('#mobile').mask('00000 00000');
        $('#pincode').mask('000 000');
        $('#aadhar').mask('0000 0000 0000');
        $('#mobile').mask('0000000000');

        //initializes custom file input
        bsCustomFileInput.init();

        //Set default option on district select field
        $("#district").append('<option value="" selected>Please select state first</option>');

        // populating state on page load event
        $.ajax({
            url: 'api.php',
            type: 'get',
            data: 'state',
            dataType: 'json',
            success: function(data) {
                $.each(data, function(i, row) {
                    $('#state').append($('<option>').text(row.state_title).attr({
                        'value': row.state_title,
                        'data-id': row.state_id
                    }));
                });
            }

        });

        //method to chage cities
        function populate_cities() {
            stateid = $("option:selected").attr("data-id");
            $("#district").empty()
                .append('<option value="" hidden>Select</option>');
            $.ajax({
                url: 'api.php',
                type: 'get',
                data: 'district=' + stateid,
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(i, row) {
                        $('#district').append($('<option>').text(row.district_title).attr({
                            'value': row.district_title,
                            'data-id': row.district_id
                        }));
                    });
                }
            });
        }
        // populating cities on state chage event
        $('#state').on('change', function() {
            populate_cities();

        })

        //changing the fields on role change
        $('#role').on('change', function() {
            var value = $('#role').val();
            // console.log(value);
            if (value === "emp") {
                $('#enrollable').addClass('d-none');
                $('#not-enrollable').removeClass('d-none');
            } else {
                $('#not-enrollable').addClass('d-none');
                $('#enrollable').removeClass('d-none');
            }
        });

        // updating the course list on department change event
        $('#department').on('change', function() {
            department = $('#department :selected').val();
            // console.log(department);
            $("#courses").empty()
                .append('<option hidden>Select</option>');
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

        function calculatePayableFees() {
            var fees = parseFloat($('#course-fees').text());
            d = parseFloat($('#discount').val());
            s = parseFloat($('#scholarship').val());
            var discount = fees * d / 100;
            // var scholarship = fees * s / 100;
            var feesPayable = fees - discount;
            var scholarship_payable = (fees - discount) * s / 100;
            // feesPayable = fees*d/100;
            $('#fees-payable').text('Rs.' + feesPayable);
            $('#scholarship-payable').text('Rs.' + scholarship_payable);
        }

        $('.calculate-fees').on('input', function() {
            calculatePayableFees();
        });

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

                    $('#course-fees').text(row.fees);
                    inst = row.installments;
                    var i = 1;
                    while (i <= inst) {
                        $('#installments').append($('<option>').text(i).val(i));
                        i++;
                    }
                    $('#discount').val(row.discount);
                    $('#scholarship').val(row.scholarship);
                    calculatePayableFees();
                }

            });
        });

        //persist form data after refresh
        $("#wizardform").saveMyForm();

        //multistep form
        $('#wizard').smartWizard({
            theme: 'arrows',
            enableURLhash: false,
            autoAdjustHeight: false,
            toolbarSettings: {
                showNextButton: false, // show/hide a Next button
                showPreviousButton: false, // show/hide a Previous button
            },
            anchorSettings: {
                anchorClickable: false, // Enable/Disable anchor navigation
                removeDoneStepOnNavigateBack: true,
                markAllPreviousStepsAsDone: true,
            },
            keyboardSettings: {
                keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)

            },
        });



        //on tab switch event
        //previout step button click event
        $("#prev-btn").on("click", function() {
            // Navigate previous
            $('#wizardform').valid();
            $('#wizard').smartWizard("prev");
            return true;
        });
        //Next step button click event
        let errorsteps = [];
        $("#next-btn").on("click", function() {
            // Navigate next
            if ($('#wizardform').valid()) {
                var stepIndex = $('#wizard').smartWizard("getStepIndex");
                if (stepIndex == 3) {
                    $('#wizardform').submit();
                    // window.onbeforeunload = null;
                    $("#pageloader").fadeIn();
                } else {
                    $('#wizard').smartWizard("next");
                }
            }
        });


        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $("#referredBy").on('input', function() {
            try {
                referral = $("#referredBy").val();
                if (referral.length == 5) {
                    $.get("api.php", {
                        referredBy: referral
                    }, function(data) {
                        $("#result").val(data)
                    });
                }
            } catch (err) {}
        });
        $.validator.addMethod("invalidReferral", function(element) {
            result = $("#result").val() != '';
            // referredBy = $("#referredBy").length()>1 && $("#referredBy").length()<5;
            return (result);
        }, "Please enter valid referral code.");



        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000)
        }, 'File size must be less than {0} KB');


        $("#wizardform").validate({
            ignore: ":hidden",
            rules: {
                fname: "required",
                mname: "required",
                lname: "required",
                mothername: "required",
                dob: "required",
                pob: "required",
                address: "required",
                city: "required",
                country: "required",
                state: "required",
                district: "required",
                pincode: {
                    required: true,
                    minlength: 6
                },
                aadhar: {
                    required: true,
                    minlength: 12,
                },
                nationality: "required",
                religion: "required",
                caste: "required",
                tongue: "required",
                distance: "required",
                mobile: "required",
                username: {
                    required: true,
                    remote: {
                        url: 'api.php',
                        type: 'get',
                        data: {
                            username: function() {
                                return $('#username').val()
                            }
                        }
                    }
                },
                referredBy: {
                    minlength: 5,
                    invalidReferral: false
                },
                acNo: "required",
                acName: "required",
                acIfsc: "required",
                acBankName: "required",
                acType: "required",
                photoFile: {
                    required: true,
                    filesize: 120
                },
                passbookFile: {
                    required: true,
                    filesize: 120
                },
                aadharFile: {
                    required: true,
                    filesize: 120
                },
                tcFile: {
                    filesize: 120,
                    required: false
                },
                marksheetFile: {
                    filesize: 120,
                    required: false
                },
                incomeFile: {
                    filesize: 120,
                    required: false
                },

                role: "required",
                department: "required",
                courseid: "required",
                installments: "required",
                discount: "required",
                scholarship: "required",
                jobrole: "required",
                salary: "required"
            },

            messages: {
                username: {
                    remote: "This username is already taken! Try another."
                },
                referredBy: {
                    minlength: 'Please enter valid referral code.'
                }

            },

            focusCleanup: true,
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
                } else if (element.prop("type") === "file") {
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
            submitHandeler: function(form) {

            }
        })

    });
</script>

</body>

</html>