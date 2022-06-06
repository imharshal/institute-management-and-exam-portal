<!-- <div class="tab-pane " role="tabpanel" id="tab-student-form1"> -->


<div id="step-1" class="tab-pane overflow-auto" role="tabpanel" aria-labelledby="step-1">
    <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory</p>


    <label for="">Name <span class="text-danger">*</span></label><br>
    <div class="row">
        <div class="col-md-3 mb-4">
            <!-- <input type="text" class="form-control text-capitalize" name="lname" id="" placeholder="Last Name" value="<?php //echo $sname[2] 
                                                                                                                            ?>" hidden> -->
            <input type="text" class="form-control text-capitalize" name="lname" id="" placeholder="Last Name" value="<?php echo $sname[2] ?>" readonly>
            <small class="form-text text-muted ">Last Name</small>

        </div>
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize" name="fname" id="" placeholder="First Name" value="<?php echo $sname[0] ?>" readonly>
            <small class="form-text text-muted">First Name</small>

        </div>
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize" name="mname" id="" placeholder="Middle Name" value="<?php echo $sname[1] ?>" readonly>
            <small class="form-text text-muted">Middle Name</small>
        </div>
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize" name="mothername" id="" placeholder="Mother Name">
            <small class="form-text text-muted">Mother Name</small>
        </div>
    </div>
    <!-- /name -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Date of Birth<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="dob" id="birth-date" placeholder="dd/mm/yyyy">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Place of Birth<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize" name="pob" id="" placeholder="City">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Address<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address" id="" placeholder="Street/House no./Building Name">
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">City/Town<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="city" id="" placeholder="City">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Country<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="India" name="country" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">State<span class="text-danger">*</span></label>
                <select class="form-control" name="state" id="state">
                    <option value="" hidden selected>Select</option>
                    <!-- <option value="Maharashtra">Maharashtra</option>
                    <option></option> -->
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="">District<span class="text-danger">*</span></label>
                <select class="form-control" name="district" id="district">
                    <!-- <option hidden value="" selected>Select</option> -->
                </select>
            </div>
        </div>
        <div class="col-md-4">

            <div class="form-group">
                <label for="">Pin Code<span class="text-danger">*</span></label>
                <input type="text" minlength="6" class="form-control" name="pincode" id="pincode" placeholder="Pincode">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Aadhar no.<span class="text-danger">*</span></label>
                <input type="text" maxlength="12" class="form-control" name="aadhar" id="aadhar" placeholder="Aadhar no.">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Nationality<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="Indian" readonly name="nationality" id="" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Religion<span class="text-danger">*</span></label>
                <select class="form-control" name="religion">
                    <option value="">Select</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Sikh">Shikh</option>
                    <!-- <option value="Bauddh">Bauddh</option> -->

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Caste<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize" name="caste" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Subcaste</label>
                <input type="text" class="form-control text-capitalize" name="subcaste" placeholder="">
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Blood Group</label>
                <select class="form-control" name="bloodGroup">
                    <option value="" hidden>Select</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Mother Tongue<span class="text-danger">*</span></label>
                <select class="form-control" name="tongue" id="">
                    <option value="" selected hidden>Select</option>
                    <option value="Marathi">Marathi</option>
                    <option value="Hindi">Hindi</option>
                    <option value="English">English</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Distance from residence to institute (kms)<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="distance" id="" placeholder="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Res. Tel. No.</label>
                <input type="number" class="form-control" name="telephone" id="" placeholder="">
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Mobile no.<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="mobile" id="mobile">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Email<span class="text-danger">*</span></label> <span class=" text-sm text-info">(This will be your username)</span>

                <input type="email" class="form-control" name="username" id="username" value="<?php echo $tmp['username'] ?>" hidden>
                <input type="email" class="form-control" name="username" id="username" value="<?php echo $tmp['username'] ?>" readonly>
            </div>
        </div>
    </div>

</div>
<!-- Bank Details starts Here -->
<div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
    <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Account Number<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="acNo" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Account Holder's Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize" name="acName">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">IFSC Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-uppercase" name="acIfsc">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Bank Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize" name="acBankName">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Account type<span class="text-danger">*</span></label>
                <select class="form-control" name="acType" id="">
                    <option value="default" hidden>Select</option>
                    <option value="Saving">Saving Account</option>
                    <option value="Current">Current Account</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">PAN Card Number</label>
                <input type="text" class="form-control text-uppercase" id="pancard" name="pancard">
            </div>
        </div>
    </div>
</div>
<!-- Bank Details Ends Here -->

<div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
    <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory.</p>
    <p class="text-sm text-info">File size must be less than <label class="text-danger">120 KB</label></p>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Passport Photo<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="photoFile" id="photoFile">
                    <label class="custom-file-label" for="photoFile">Passport Photo</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Bank Passbook<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="passbookFile" id="passbookFile">
                    <label class="custom-file-label" for="passbookFile">Bank Passbook
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Aadhar card<span class="text-danger">*</span></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="aadharFile" id="aadharFile">
                    <label class="custom-file-label" for="aadharFile">Aadhar Card</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">TC</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="tcFile" id="tcFile">
                    <label class="custom-file-label" for="tcFile">TC</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Marksheet</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="marksheetFile" id="marksheetFile">
                    <label class="custom-file-label" for="marksheetFile">Marksheet</label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Income Certificate</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="incomeFile" id="incomeFile">
                    <label class="custom-file-label" for="incomeFile">Income Certificate</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
    <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory.</p>

    <!-- Code for auto select the course starts here -->
    <?php
    $courseDetails = [];
    if (isset($_GET['x_token']))
        $courseDetails = DB::queryFirstRow("select * from courses where id=%s", $_GET['x_token']);

    ?>
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

    <!-- populating div hides when empoyee selected -->
</div>



<!-- 
Hindu
Muslim
sikh
Buddhist
Jain
Other -->