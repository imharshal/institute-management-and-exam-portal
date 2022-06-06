<?php include("../../includes/dbmethods.php") ?>
<?php
//https://localhost/admin/includes/admission_acknoledgement.php

// $stdId = $u = "202106161349";
// $stdEnrollId = "CE2021081350196";
// $txnId = "TXN60e15aa1cbdaf";
if (isset($_POST['print']) && isset($_POST['registrationId']) && isset($_POST['txnId'])) {
    $u = $_POST['registrationId'];
    $txnId = $_POST['enrollmentId'];
    $user = DB::queryFirstRow("SELECT id, uname FROM admissions
                            WHERE admissions.id=%s", $u);
    $invoice = DB::queryFirstRow("SELECT t.id,courseId,name, datetime, enrollmentId, txnAmount, paymentMode, feesPayable, feesRemain from transactions as t
                        RIGHT JOIN payment_status as ps
                        ON ps.id = enrollmentId
                        RIGHT JOIN courses_enrolled as ce
                        ON ce.id = enrollmentId
                        RIGHT JOIN courses as c
                        ON c.id = courseId 
                        WHERE t.id=%s", $txnId);

    // print_r($user);
    // echo "<br>";
    // echo "<br>";
    // print_r($invoice);
?>

    <table style="float: left; height: 248px; width: 754px;" border="1" cellspacing="0" cellpadding="2">
        <tbody>
            <tr style="height: 52px;">
                <td style="width: 283.2px; height: 52px;"><img src="https://testing.ssdit.in/img/ssd-logo-with-text.png" alt="" width="150" height="41" /></td>
                <td style="width: 468.8px; height: 52px;">
                    <p style="text-align: center; font-size: 26; font-weight: bold;"><strong>Invoice</strong></p>
                </td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 752px; height: 21px;" colspan="2">
                    <p>E: shetesskill@gmail.com</p>
                    <p>M: 7219207413</p>
                </td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Transaction Id</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $invoice['id'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Date</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $invoice['datetime'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Transaction Type</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo ($invoice['paymentMode'] == 'Cash') ? 'Cash' : 'Online' ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Description</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $invoice['name'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Amount Paid</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $invoice['txnAmount'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;" colspan="2">&nbsp;</td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Course Enrollment ID</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $invoice['enrollmentId'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Student Registration ID</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $user['id'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Student Name</td>
                <td style="width: 468.8px; height: 21px;"><strong><?php echo $user['uname'] ?></strong></td>
            </tr>
            <tr style="height: 21px;">
                <td style="width: 283.2px; height: 21px;">Course Total Fees</td>
                <td style="width: 468.8px; height: 21px;"><strong>Rs. <?php echo $invoice['feesPayable'] ?></strong></td>
            </tr>
            <tr style="height: 21.5px;">
                <td style="width: 283.2px; height: 21.5px;">Remaining Fees</td>
                <td style="width: 468.8px; height: 21.5px;"><strong>Rs. <?php echo $invoice['feesRemain'] ?></strong></td>
            </tr>
        </tbody>
    </table>
<?php } ?>