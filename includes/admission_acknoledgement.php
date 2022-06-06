<?php include("dbmethods.php") ?>
<?php
//http://localhost/includes/admission_acknoledgement.php?print=TRUE&registrationId=202106161349&enrollmentId=CE2021081350196
// $stdId = $u = "202106161349";
// $stdEnrollId = "CE2021081350196";
if ($_SERVER["REQUEST_METHOD"] == "POST" or $_SERVER["REQUEST_METHOD"] == "GET")
    if (isset($_REQUEST['print']) && isset($_REQUEST['registrationId']) && isset($_REQUEST['enrollmentId'])) {
        $u = $_REQUEST['registrationId'];
        $stdEnrollId = $_REQUEST['enrollmentId'];
        $user = DB::queryFirstRow("SELECT * FROM admissions
                            RIGHT JOIN addresses 
                            ON admissions.id = addresses.id
                            RIGHT JOIN bank_details
                            ON admissions.id = bank_details.id
                            RIGHT JOIN usrregistration
                            ON registrationId = admissions.id
                            WHERE admissions.id=%s", $u);
        $enrolled = DB::queryFirstRow("SELECT * FROM courses_enrolled 
                                RIGHT JOIN courses
                                ON courseId = courses.id
                                RIGHT JOIN payment_status
                                ON payment_status.id = courses_enrolled.id
                                WHERE courses_enrolled.id=%s", $stdEnrollId);
        $refBy = (isset($user["referredBy"])) ? $user["referredBy"] : 'N/A';
        $ref = DB::queryFirstRow("SELECT name From usrregistration WHERE referralCode = %s", $refBy);

        // echo "<br>";
        // echo "<br>";
        // print_r($enrolled);
        // echo "<br>";
        // echo "<br>";

?>

    <table style="width: 694px; height: 250px; float: left;" border="1" cellspacing="0" cellpadding="1.5">
        <tbody>
            <tr style="height: 5px;">
                <td style="width: 915px; height: 5px; text-align: left; vertical-align: top;">
                    <h2 style="padding: 5px;"><img src="https://<?php echo $_SERVER['HTTP_HOST'] ?>/img/ssd-logo-with-text.png" alt="" width="120" height="35" /></h2>
                </td>
                <td style="width: 3806.46px; height: 5px;" colspan="2">
                    <p style="text-align: center; font-size: 22px; font-weight: bold;">Admission Form</p>
                    <p>E: shetesskill@gmail.com &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;M:&nbsp;7219207413</p>
                </td>
                <td style="width: 89.538px; text-align: center; height: 68px;" rowspan="4">
                    <p>&nbsp;</p>
                    <span>Affix </span><span>photo</span> <span> here</span>
                    &nbsp;
                </td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">&nbsp;Registration Id</td>
                <td style="width: 3806.46px; height: 21px; text-align: left;" colspan="2"><strong><?php echo $user["registrationId"] ?>
                    </strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">Username</td>
                <td style="width: 3806.46px; height: 21px; text-align: left;" colspan="2"><strong><?php echo $user["username"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">Enrollment Date</td>
                <td style="width: 3806.46px; height: 21px; text-align: left;" colspan="2"><strong><?php echo $enrolled["timestamp"] ?></strong></td>
            </tr>
            <!-- <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;" colspan="3"></td>
            </tr> -->
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Name&nbsp;</td>
                <td style="width: 4697px; height: 21px; text-align: left;" colspan="2"><strong><?php echo $user["uname"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">Date of Birth</td>
                <td style="width: 2584px; height: 21px; text-align: left;"><strong><?php echo $user["dob"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px; margin-left: 5px; text-align: left;">Place of Birth</td>
                <td style="width: 890.538px; height: 21px; margin-left: 5px; text-align: left;"><strong><?php echo $user["pob"] ?></strong></td>
            </tr>
            <tr style="height: 44px;">
                <td style="width: 915px; height: 44px; vertical-align: top; text-align: left;" scope="row">Address</td>
                <td style="width: 4697px; height: 44px; vertical-align: top; text-align: left;" colspan="3" scope="rowgroup"><strong><?php echo $user["address"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">City</td>
                <td style="width: 2584px; height: 21px; text-align: left;"><strong><?php echo $user["city"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px; text-align: left;">Country</td>
                <td style="width: 890.538px; height: 21px; text-align: left;"><strong><?php echo $user["country"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">&nbsp;State</td>
                <td style="width: 2584px; height: 21px; text-align: left;"><strong><?php echo $user["state"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px; text-align: left;">District</td>
                <td style="width: 890.538px; height: 21px; text-align: left;"><strong><?php echo $user["district"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">Pincode</td>
                <td style="width: 4697px; height: 21px; text-align: left;" colspan="3"><strong><?php echo $user["pincode"] ?></strong>&nbsp;&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left;">&nbsp;Aadhar No</td>
                <td style="width: 4697px; height: 21px; text-align: left;" colspan="3"><strong><?php echo $user["aadharNo"] ?>&nbsp;&nbsp;</strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">&nbsp;Nationality</td>
                <td style="width: 2584px; height: 21px;">&nbsp;<strong><?php echo $user["nationality"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Religion</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $user["religion"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Caste</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo $user["caste"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Subcaste</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $user["subcaste"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Blood Group</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo $user["bloodGroup"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Mother Tongue</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $user["motherTongue"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 3499px; height: 21px;" colspan="2">Distance from residence to institute (kms)</td>
                <td style="width: 2113px; height: 21px;" colspan="2"><strong><?php echo $user["distanceFrom"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">&nbsp;Res. Tel. No.</td>
                <td style="width: 2584px; height: 21px;">&nbsp;<strong><?php echo $user["telephone"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">&nbsp;Mobile No</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $user["mobile"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 3499px; height: 21px;" colspan="2">Email (This will be your username)</td>
                <td style="width: 2113px; height: 21px;" colspan="2"><strong><?php echo $user["username"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">&nbsp;Referred By</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo ($user["referredBy"] != "") ? $user["referredBy"] : "N/A" ?></strong></td>
                <td style="width: 2113px; height: 21px;" colspan="2">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">&nbsp;Referrer</td>
                <td style="width: 4697px; height: 21px;" colspan="3"><strong><?php echo (isset($ref["name"])) ? $ref["name"] : "N/A" ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 5612px; height: 21px;" colspan="4">
                    <p style="font-size:14px;font-weight:bold"><strong>Bank Details</strong></p>
                </td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Account No</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo $user["acNumber"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">IFSC Code</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $user["ifsc"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px; text-align: left; vertical-align: top;" scope="row">Account Holder&nbsp;</td>
                <td style="width: 4697px; height: 21px; text-align: left; vertical-align: top;" colspan="3"><?php echo $user["acName"] ?></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Bank Name</td>
                <td style="width: 4697px; height: 21px;" colspan="3"><strong><?php echo $user["bankName"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Account type</td>
                <td style="width: 4697px; height: 21px;" colspan="3"><strong><?php echo $user["type"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">PAN no.</td>
                <td style="width: 4697px; height: 21px;" colspan="3"><strong><?php echo ($user["pancard"] != "") ? $user["pancard"] : "N/A"; ?></strong></td>
            </tr>
            <tr style="height: 12px;">
                <td style="width: 5612px; height: 12px;" colspan="4">
                    <p style="font-size:14px;font-weight:bold"><strong>Course Details</strong></p>
                </td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">&nbsp;Admission for</td>
                <td style="width: 4697px; height: 21px;"><strong><strong><?php echo $enrolled["courseType"]; ?></strong></td>
                <td style="width: 1222.46px; height: 21px; margin-left: 5px; text-align: left;">Enrollment ID</td>
                <td style="width: 890.538px; height: 21px;"><strong><strong><?php echo $enrolled["id"]; ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Course</td>
                <td style="width: 4697px; height: 21px;" colspan="3"><strong><?php echo $enrolled["name"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Course fees</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo $enrolled["fees"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Duration</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $enrolled["duration"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Discount (in Rs)</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo (float)$enrolled["discountTaken"] * (float)$enrolled["fees"] / 100; ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Scholarship (in Rs)</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo (float)$enrolled["scholarshipTaken"] * (float)$enrolled["feesPayable"] / 100; ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">No. of Installments&nbsp;</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo $enrolled["installmentsTaken"] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Scholarship Benificiary Date</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $enrolled["scholarshipDate"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">Total Payable&nbsp; Fees (in Rs)</td>
                <td style="width: 4697px; height: 21px;" colspan="3"><strong><?php echo $enrolled["feesPayable"] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 915px; height: 21px;">First Installment</td>
                <td style="width: 2584px; height: 21px;"><strong><?php echo ($enrolled['isemi'] == 1) ? $enrolled["firstInstallment"] : $enrolled['feesPayable'] ?></strong></td>
                <td style="width: 1222.46px; height: 21px;">Installment per month (in Rs)</td>
                <td style="width: 890.538px; height: 21px;"><strong><?php echo $enrolled["installmentPerMonth"] ?></strong></td>
            </tr>   
            <tr style="height: 10px;">
                <td style="width: 5612px; height: 10px; padding-top:30px" colspan="4">
                    <p>Place:</p>
                    <p>Date:&nbsp;</p>
                </td>
            </tr>
            <tr style="height: 21.1px;">
                <td style="width: 915px; height: 21.1px; text-align: center;">&nbsp;Principal Signature</td>
                <td style="width: 3806.46px; height: 21.1px;" colspan="2" rowspan="2">&nbsp;&nbsp;&nbsp;</td>
                <td style="width: 890.538px; height: 21.1px; text-align: center;">Student&nbsp;Signature</td>
            </tr>
            <tr style="height: 39px;">
                <td style="width: 915px; height: 39px;">&nbsp;</td>
                <td style="width: 890.538px; height: 39px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
<?php } ?>