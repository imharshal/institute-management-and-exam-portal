<?php
include("../includes/db_config.php");
include("../includes/dbmethods.php");


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function username_allowed($username)
{
    //return true if username does not exist
    //return false if username exist
    try {
        $user = DB::queryFirstRow("SELECT * FROM usrregistration where username = %s", $username);
        if ($user) {
            return 'false';
        } else {
            return 'true';
        }
    } catch (Exception $e) {
    }
}

function validate_referral($referral)
{
    //returns referrer's name if code valid
    // returns nothing if code is invalid
    try {
        $result = DB::queryFirstRow("SELECT * FROM usrregistration where referralCode = %s", $referral);
        //'XTP04'";
        if ($result) return $result['name'];
        else return '';
    } catch (Exception $e) {
    }
}

function validate_payment_pin($pin)
{
    //returns true if pin valid
    // returns false if pin is invalid
    try {
        $result = DB::queryFirstRow("SELECT registrationId FROM admin WHERE paymentPin = %s", md5($pin));
        if ($result) return 'true';
        else return 'false';
    } catch (Exception $e) {
    }
}

// ------------------- POPULATE METHODS ---------------------
function populate_states()
{
    $states = DB::query("SELECT * FROM state");
    return json_encode($states);
}

function populate_districts($state)
{
    $districts = DB::query("SELECT * FROM district WHERE state_id = %i", $state);
    return json_encode($districts);
}

function populate_courses($dept)
{
    $courses = DB::query("SELECT * FROM courses WHERE type = %s AND cstatus=%s", $dept,'Active');
    return json_encode($courses);
}

function populate_exams($course)
{
    $exams = DB::query("SELECT id,examName FROM exams WHERE course = %s", $course);
    return json_encode($exams);
}

function get_course_details($course)
{
    $courses = DB::queryFirstRow("SELECT * FROM courses WHERE id = %s AND cstatus=%s", $course,'Active');
    return json_encode($courses);
}


function get_students_for($courseid)
{
    $students = DB::query("SELECT DISTINCT studentId,uname FROM courses_enrolled
                            RIGHT JOIN admissions
                            ON admissions.id = studentId
                            WHERE courseId = %s
                            ORDER BY uname ASC", $courseid);
    return json_encode($students);
}

function get_all_students()
{
    $students = DB::query("SELECT registrationId as id,name FROM usrregistration WHERE role='stud' OR 'empdip'");
    return json_encode($students);
}

//------------- GET METHODS -------------------------
if (isset($_GET['username'])) {
    $username = test_input($_GET['username']);
    echo username_allowed($username);
}

if (isset($_GET['referredBy']) && strlen($_GET['referredBy']) == 5) {
    $referredBy = test_input($_GET['referredBy']);
    echo validate_referral($referredBy);
}

if (isset($_GET['state'])) {
    echo populate_states();
}

if (isset($_GET['district'])) {
    $s = test_input($_GET['district']);
    echo populate_districts($s);
}

if (isset($_GET['courses'])) {
    $s = test_input($_GET['courses']);
    echo populate_courses($s);
}

if (isset($_GET['course'])) {
    $s = test_input($_GET['course']);
    echo get_course_details($s);
}

if (isset($_GET['exam'])) {
    $s = test_input($_GET['exam']);
    echo populate_exams($s);
}

if (isset($_GET['getStudentsFor'])) {
    $c = test_input($_GET['getStudentsFor']);
    echo get_students_for($c);
}

if (isset($_GET['getAllStudents'])) {
    echo get_all_students();
}

if (isset($_POST['paymentPin'])) {
    $p = test_input($_POST['paymentPin']);
    echo validate_payment_pin($p);
}
