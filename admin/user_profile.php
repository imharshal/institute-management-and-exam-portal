<?php include("includes/header.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("../includes/dbmethods.php") ?>


<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['u'])) {
    $u = test_input($_GET['u']);

    $user = DB::queryFirstRow("SELECT * FROM admissions
                            RIGHT JOIN addresses 
                            ON admissions.id = addresses.id
                            RIGHT JOIN bank_details
                            ON admissions.id = bank_details.id
                            RIGHT JOIN documents
                            ON admissions.id = documents.id
                            RIGHT JOIN usrregistration
                            ON registrationId = admissions.id
                            WHERE admissions.id=%s", $u);

    $enrolled = DB::query("SELECT * FROM courses_enrolled
                        RIGHT JOIN courses
                        ON courseId = courses.id
                        RIGHT JOIN payment_status
                        ON payment_status.id = courses_enrolled.id
                        WHERE studentId=%s", $u);
    $employee = DB::queryFirstRow("SELECT * FROM employees WHERE id=%s", $u);

?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <!-- Personal details starts here -->
                <div class="card card-teal card-blue">
                    <div class="card-header">
                        <h4 class="text-bold text-center">Basic Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="">Name </label><br>
                                <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['uname'] ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="">Mother Name</label><br>
                                <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['motherName'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="">Date of Birth </label><br>
                                <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['dob'] ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="">Place of Birth</label><br>
                                <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['pob'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="">Address </label><br>
                                <textarea name="" class="form-control" cols="30" rows="3" readonly><?php echo $user['address'] ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="">City/Town</label><br>
                                <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['city'] ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="">Country</label><br>
                                <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['country'] ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">State</label><br>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['state'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">District</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['district'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Pin Code</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['pincode'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Aadhar no.</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['aadharNo'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nationality</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['nationality'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Religion</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['religion'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Caste</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['caste'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Subcaste</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['subcaste'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blood Group</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['bloodGroup'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Mother Tongue</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['motherTongue'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Distance from residence to institute (kms)</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['distanceFrom'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Res. Tel. No.</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['telephone'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Mobile no.</label>
                                    <input type="text" class="form-control text-capitalize" readonly value="<?php echo $user['mobile'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label> <span class=" text-sm text-info">(This is username)</span>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['email'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Personal Details end here -->

                <!-- Employee details -->
                <?php if ($user['role'] == 'emp') { ?>

                    <div class="card card-teal card-blue">
                        <div class="card-header">
                            <h4 class="text-bold text-center">Employee Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Job Role</label>
                                        <input type="text" class="form-control" readonly value="<?php echo $employee['jobRole'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Salary</label>
                                        <input type="text" class="form-control" readonly value="<?php echo $employee['salary'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Date of Joining</label>
                                        <input type="text" class="form-control" readonly value="<?php echo $employee['doj'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Experience</label>
                                        <input type="text" class="form-control" readonly value="<?php echo $employee['experience'] ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } else { ?>
                    <!--Course and payments Details  -->
                    <div class="card card-teal card-blue">
                        <div class="card-header">
                            <h4 class="text-bold text-center">Course & Payment Details</h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <?php foreach ($enrolled as $en) { ?>
                                    <div class=" col-md-6">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <h4><span class=" badge badge-secondary text-wrap text-left"> <?php echo $en['name'] ?></span></h4>
                                            </div>
                                        </div>

                                        <div class="row mb-6">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Date of joining</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['doa'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-6">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">No. of Installments Taken</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['installmentsTaken'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Discount (in %)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['discountTaken'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Scholorship (in %)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['scholarshipTaken'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Scholorship Beneficiary Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['scholarshipDate'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Fees Payable</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['feesPayable'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Fees Paid</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['feesPaid'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Fees Remaining</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2" readonly value="<?php echo $en['feesRemain'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- Bank Details starts Here -->
                <div class="card card-teal card-blue">
                    <div class="card-header">
                        <h4 class="text-bold text-center">Bank Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account Number</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['acNumber'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account Holder's Name</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['acName'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">IFSC Code</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['ifsc'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bank Name</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['bankName'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account type</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['type'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">PAN Card Number</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $user['pancard'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bank Details Ends Here -->

                <!-- Documents Section -->
                <div class="card card-teal card-blue">
                    <div class="card-header">
                        <h4 class="text-bold text-center">Documents</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $labels = array('Passport Photo', 'Bank Passbook', 'Aadhar Card', 'TC', 'Marksheet', 'Income Certificate');
                            $file = array('photo', 'passbook', 'aadhar', 'tc', 'marksheet', 'income');
                            foreach ($labels as $i => $label) {
                                if (!empty($user[$file[$i]])) {
                                    $extension = explode('.', $user[$file[$i]]);
                            ?>
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label for=""><?php echo $label ?></label>
                                            <br>
                                            <?php if ($extension[1] == 'pdf') { ?>
                                                <!-- <a target="_blank" href="../<?php echo $user[$file[$i]] ?>"> <embed class="ml-5" src="../<?php echo $user[$file[$i]] ?>" width="200"> </a> -->
                                                <div class=" embed-responsive embed-responsive-4by3" style=" max-width:320px">
                                                    <iframe class="ml-2 embed-responsive-item" src="https://docs.google.com/gview?url=https://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $user[$file[$i]] ?>&embedded=true"></iframe>
                                                </div>
                                            <?php } else { ?>
                                                <a target=" _blank" href="../<?php echo $user[$file[$i]] ?>"> <img class="ml-md-1 img-fluid" src="../<?php echo $user[$file[$i]] ?>" alt="Click to open" width="250"> </a>
                                            <?php } ?>
                                        </div>
                                        <hr>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Documents section ends here -->
            </div>
        </section>
    </div>


    <?php include("includes/scripts.php") ?>
<?php } ?>

</body>

</html>