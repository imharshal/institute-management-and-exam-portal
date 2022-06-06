

<?php
// Return current date and time from the server
include("includes/db_config.php");
include("includes/dbmethods.php");

// echo "HEllo";
if (isset($_GET['referredBy']) && strlen($_GET['referredBy']) == 5) {
    try {
        $referral = $_GET['referredBy'];
        $result = DB::queryFirstRow("SELECT name FROM usrregistration where referralCode = %s", $referral);
        //'XTP04'";
        if ($result) echo $result['name'];
        else echo 'Invalid Code';
    } catch (Exception $e) {
    }
}

if (isset($_GET['username'])) {
    try {
        $username = $_GET['username'];
        $user = DB::queryFirstRow("SELECT username FROM usrregistration where username = %s", $username);
        if ($user) {
            echo 'false';
        } else {
            echo 'true';
        }
    } catch (Exception $e) {
    }
}

//  echo date("F d, Y h:i:s A");

// $serial = "0000"."3";
// $serialno = substr($serial, -3);
// echo $serialno;
?>
