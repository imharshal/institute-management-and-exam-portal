<!-- <div class="tab-pane " role="tabpanel" id="tab-student-form1"> -->
<div id="step-1" class="tab-pane overflow-auto" role="tabpanel" aria-labelledby="step-1">
    <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory</p>
    <?php
    $name;
    if (isset($ur['name']))
        $name = explode(' ', $ur['name']);
    ?>
    <label for="">Name <span class="text-danger">*</span></label><br>
    <div class="row">
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize" value="<?php echo isset($name) ? $name[2] : '' ?>"
                name="lname" placeholder="Last Name" >
            <small class="form-text text-muted ">Last Name</small>

        </div>
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize" value="<?php echo isset($name) ? $name[0] : '' ?>"
                name="fname" id="" placeholder="First Name" >
            <small class="form-text text-muted">First Name</small>

        </div>
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize" value="<?php echo isset($name) ? $name[1] : '' ?>"
                name="mname" id="" placeholder="Middle Name" >
            <small class="form-text text-muted">Middle Name</small>
        </div>
        <div class="col-md-3 mb-4">
            <input type="text" class="form-control text-capitalize"
                value="<?php echo isset($u) ? $u['motherName'] : '' ?>" name="mothername" id=""
                placeholder="Mother Name">
            <small class="form-text text-muted">Mother Name</small>
        </div>
    </div>
    <!-- /name -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Date of Birth<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo isset($u) ? $u['dob'] : '' ?>" name="dob"
                    id="birth-date" placeholder="dd/mm/yyyy">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Place of Birth<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize" value="<?php echo isset($u) ? $u['pob'] : '' ?>"
                    name="pob" id="" placeholder="City">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Address<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo isset($u) ? $u['address'] : '' ?>"
                    name="address" id="" placeholder="Street/House no./Building Name">
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">City/Town<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo isset($u) ? $u['city'] : '' ?>" name="city"
                    id="" placeholder="City">
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
                    <option value="<?php echo isset($u) ? $u['state'] : '' ?>" data-id="fromdb" hidden>
                        <?php echo isset($u) ? $u['state'] : '' ?></option>
                    <!-- <option value="Maharashtra">Maharashtra</option>
                    <option></option> -->
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="">District<span class="text-danger">*</span></label>
                <select class="form-control" name="district" id="district">
                </select>
            </div>
        </div>
        <div class="col-md-4">

            <div class="form-group">
                <label for="">Pin Code<span class="text-danger">*</span></label>
                <input type="text" minlength="6" class="form-control"
                    value="<?php echo isset($u) ? $u['pincode'] : '' ?>" name="pincode" id="pincode"
                    placeholder="Pincode">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Aadhar no.<span class="text-danger">*</span></label>
                <input type="text" maxlength="12" class="form-control"
                    value="<?php echo isset($u) ? $u['aadharNo'] : '' ?>" name="aadhar" id="aadhar"
                    placeholder="Aadhar no.">
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
                    <?php if (isset($u)) { ?>
                    <option value="<?php echo $u['religion'] ?>" selected hidden><?php echo $u['religion'] ?></option>
                    <?php } ?>
                    <option value="" hidden>Select</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Sikh">Sikh</option>
                    <option value="Bauddh">Bauddh</option>

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Caste<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize"
                    value="<?php echo isset($u) ? $u['caste'] : '' ?>" name="caste" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Subcaste</label>
                <input type="text" class="form-control text-capitalize"
                    value="<?php echo isset($u) ? $u['subcaste'] : '' ?>" name="subcaste" placeholder="">
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Blood Group</label>
                <select class="form-control" name="bloodGroup">
                    <?php if (isset($u)) { ?>
                    <option value="<?php echo $u['bloodGroup'] ?>" selected hidden><?php echo $u['bloodGroup'] ?>
                    </option>
                    <?php }
                    ?>
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
                    <?php if (isset($u)) { ?>
                    <option value="<?php echo $u['motherTongue'] ?>" selected hidden><?php echo $u['motherTongue'] ?>
                    </option>
                    <?php } ?>
                    <option value="" hidden>Select</option>
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
                <input type="number" class="form-control" value="<?php echo isset($u) ? $u['distanceFrom'] : '' ?>"
                    name="distance" id="" placeholder="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Res. Tel. No.</label>
                <input type="number" class="form-control" value="<?php echo isset($u) ? $u['telephone'] : '' ?>"
                    name="telephone" id="" placeholder="">
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Mobile no.<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?php echo isset($u) ? $u['mobile'] : '' ?>"
                    name="mobile" id="mobile" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Email<span class="text-danger">*</span></label> <span class=" text-sm text-info">(This
                    will be your username)</span>
                <input type="email" class="form-control" value="<?php echo $ur['username'] ?>" disabled id="username"
                    placeholder="">
            </div>
        </div>
    </div>
    <input type="hidden" name="registrationId" value="<?php echo $ur['registrationId'] ?>">
    <!-- <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Referral Code</label>
                <input type="text" maxlength="5" class="form-control text-uppercase" name="referredBy" id="referredBy" placeholder="">
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <label for="">Referred by</label>
                <input type="text" class="form-control" readonly id="result" placeholder="">
            </div>
        </div>
    </div> -->
</div>

<!-- Bank Details starts Here -->
<div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
    <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Account Number<span class="text-danger">*</span></label>
                <input type="number" class="form-control" value="<?php echo isset($u) ? $u['acNumber'] : '' ?>"
                    name="acNo" placeholder="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Account Holder's Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize"
                    value="<?php echo isset($u) ? $u['acName'] : '' ?>" name="acName">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">IFSC Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-uppercase" value="<?php echo isset($u) ? $u['ifsc'] : '' ?>"
                    name="acIfsc">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Bank Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control text-capitalize"
                    value="<?php echo isset($u) ? $u['bankName'] : '' ?>" name="acBankName">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Account type<span class="text-danger">*</span></label>
                <select class="form-control" name="acType" id="">
                    <?php if (isset($u)) { ?>
                    <option value="<?php echo $u['type'] ?>" selected hidden><?php echo $u['type'] ?></option>
                    <?php } ?>
                    <option value="">Select</option>
                    <option value="Saving">Saving Account</option>
                    <option value="Current">Current Account</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">PAN Card Number</label>
                <input type="text" id="pancard" class="form-control text-uppercase"
                    value="<?php echo isset($u) ? $u['pancard'] : '' ?>" name="pancard">
            </div>
        </div>
    </div>
</div>
<!-- Bank Details Ends Here -->

<div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
    <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="" id="skipupload" value="doupload" checked>
            Skip document upload
        </label>
    </div>
    <br>
    <div id="documents-section" class="d-none">
        <p class="text-sm text-info">Note: Fields marked with <label class="text-danger">*</label> are mandatory for new
            admission.</p>
        <p class="text-sm text-info">File size must be less than <label class="text-danger">120 KB</label></p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Passport Photo<span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="photoFile"
                            id="photoFile">
                        <label class="custom-file-label" for="photoFile">Passport Photo</label>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Bank Passbook<span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" accept="application/pdf,image/*"
                            name="passbookFile" id="passbookFile">
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
                        <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="aadharFile"
                            id="aadharFile">
                        <label class="custom-file-label" for="aadharFile">Aadhar Card</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">TC</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="tcFile"
                            id="tcFile">
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
                        <input type="file" class="custom-file-input" accept="application/pdf,image/*"
                            name="marksheetFile" id="marksheetFile">
                        <label class="custom-file-label" for="marksheetFile">Marksheet</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Income Certificate</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" accept="application/pdf,image/*" name="incomeFile"
                            id="incomeFile">
                        <label class="custom-file-label" for="incomeFile">Income Certificate</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>