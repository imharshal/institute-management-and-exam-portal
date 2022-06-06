<!-- <div class="tab-pane active  col-md-8" role="tabpanel" id="tab-registration" style="display:block;"> -->

<!-- <div class="step-tab-panel" data-step="step1"> -->
<div class="container" id="regPanel" style="display: block;">
    <form method="post" action="api.php" id="registration">
        <div class="form-group">
            <label>Role</label>
            <select class="form-control " name="role" id="role" style="height: 50px;font-size:large ">
                <option selected value="default">Select role</option>
                <option value="stud">Student</option>
                <option value="emp">Employee</option>
                <option value="empdip">Employee with Diploma</option>
            </select>
        </div>
        <label for="">Name </label><br>
        <div class="row">
            <div class="col-md-4 mb-4">
                <input type="text" class="form-control text-capitalize" name="fname" id="fname" placeholder="First Name">
                <!-- onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"> -->

            </div>
            <div class="col-md-4 mb-4">
                <input type="text" class="form-control text-capitalize" name="mname" id="mname" placeholder="Middle Name">

            </div>
            <div class="col-md-4 mb-4">
                <input type="text" class="form-control text-capitalize" name="lname" id="lname" placeholder="Last Name">
            </div>
        </div>

        <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" name="username" id="username" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Confirm Password</label>
            <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="">
        </div>

        <div class="">
            <p>Referred By </p>
            <div class="row">
                <div class="col col-md-4">
                    <input type="text" maxlength="5" class="form-control text-uppercase" name="referredBy" id="referredBy" placeholder="Referral Code" />
                </div>
                <div class="col col-md-8">
                    <input type="text" class="form-control" name="result" id="result" disabled />
                </div>

            </div>
        </div>
        <button type="button" class=" mt-xl-5 btn btn-primary" name="submit" id="btnSubmit" style="width: 200px;"> Register</button>


        <!-- <input type="submit" onclick="formNextStep(1)" class=" mt-xl-5 btn btn-primary" style="width: 200px;" name="submit" value="Register"> -->
    </form>

    <script>
        $(document).ready(function() {
            $("#referredBy").on('input', function() {
                try {
                    referral = $("#referredBy").val();
                    $.get("api.php", {
                        referredBy: referral
                    }, function(data) {
                        $("#result").val(data)
                    });
                } catch (err) {}

            });


            $('#btnSubmit').click(function() {
                if ($("#registration").valid()) {
                    $.ajax({
                        type: 'POST',
                        url: 'api.php',
                        data: $('#registration').serialize(),
                        success: function(response) {
                            $('#regPanel').html(response);
                            $("#regPanel").toggle();
                            $("#wizard").toggle();
                            // submitted = true;
                        }
                    })
                }
            })



            $.validator.addMethod("requiredSelect", function(element) {
                return ($("select").val() != 'default');
            }, "You must select an option.");
            $.validator.addMethod("invalidReferral", function(element) {
                result = $("#result").val() != 'Invalid Code';
                // referredBy = $("#referredBy").length()>1 && $("#referredBy").length()<5;
                return (result);
            }, "Please enter valid referral code. <br> <strong>Note: </strong>Referral code is not mandatory");
            $("#registration").validate({
                rules: {
                    fname: "required",
                    mname: "required",
                    lname: "required",
                    role: {
                        requiredSelect: true,
                        // valueNotEquals: "default"
                    },
                    username: {
                        required: true,
                        email: true,

                    },
                    password: {
                        required: true,
                        minlength: 6,
                    },
                    cpassword: {
                        required: true,
                        equalTo: "#password",
                    },
                    referredBy: {
                        invalidReferral: true,
                        minlength: 5,

                    },

                },
                messages: {
                    fname: "Please enter your first name",
                    lname: "Please enter your last name",
                    mname: "Please enter your middle name",
                    username: {
                        required: "Please enter a email",
                        minlength: "Your username must consist of at least 2 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    cpassword: {
                        required: "Please confirm a password",
                        equalTo: "Password does not matched"
                    },
                    role: {
                        requiredSelect: "Please select role",
                        // valueNotEquals: "Please select role"
                    },
                    referredBy: {
                        minlength: "Invalid referral code <br> <strong>Note:</strong>Referral code is not mandatory"
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
                    form.submit();
                    $("#regPanel").toggle();
                    $("#wizard").toggle();
                }
            })
        });
    </script>

</div>
<!-- </div> -->