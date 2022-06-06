<?php include("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>

<?php
session_start();
$exam = $questions = $examiner = [];

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function get_data_from_database($id)
{
    global $exam;
    global $questions, $examiner;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%s", $id);
    $questions = DB::query("SELECT * FROM questions WHERE examId=%s", $id);
    $examiner = DB::queryFirstRow("SELECT * FROM usrregistration WHERE registrationId=%s", $_SESSION['student']);
}

function generate_responseid()
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $resp = strval(substr(str_shuffle($str_result), 0, 10));
    $result  = DB::queryFirstRow("SELECT id FROM exam_report where id = %s", $resp);
    if ($result) {
        $responseId = generate_responseid();
    } else {
        $responseId = $resp;
    }
    return $responseId;
}
if (isset($_POST['examid']) and !isset($_SESSION['submitted'])) {
    $_SESSION['submitted'] = $_SESSION['student'];
    // get_data_from_database('85OYZ49');
    get_data_from_database($_POST['examid']);

    $start_time = test_input($_POST['start_time']);
    date_default_timezone_set('Asia/Kolkata');
    $end_time =  date("Y-m-d H:i:s");

    $d1 = strtotime($start_time);
    $d2 = strtotime($end_time);
    $totalSecondsDiff = abs($d1 - $d2);
    $totalMinutesDiff = $totalSecondsDiff / 60;
    $anskey = [];

    $response = (isset($_POST['response'])) ? $_POST['response'] : [];
    foreach ($questions as $q) {
        global $anskey;
        $anskey[$q['id']] = $q['answer'];
    }
    $wrongarr = array_diff_assoc($anskey, $response);


    $attemted_que = count($response);
    $wrong_ans = count($wrongarr);
    $correct_ans =  count($anskey) - count($wrongarr);
    $marksObtained = $correct_ans * $exam['marks'];
  
    $datetime =  date("Y-m-d H:i:s");

    $responseid = generate_responseid();
    $success = DB::insert('exam_report', [
        'id' => $responseid,
        'studentId' => $examiner['registrationId'],
        'attempted' => $attemted_que,
        'correct' => $correct_ans,
        'attendance' => true,
        'wrong' => $wrong_ans,
        'marksObtain' => $marksObtained,
        'result' => 'Pending',
        'startTime' => $start_time,
        'endTime' => $end_time,
        'timeTaken' => $totalMinutesDiff,
        'responseData' => (isset($_POST['response'])) ? json_encode($response) : "{}",
        'examId' => $exam['id'],
        'timeStamp' => $datetime
    ]);

?>



    <div class="container">
        <form action="">
            <div class="card card-success mt-2">
                <div class="card-header card-success">
                    <h4>Exam Submited Successfully</h4>
                </div>
                <div class="card-body  align-content-center">
                    <h3 class="text-muted mb-5"><?php echo $exam['examName'] ?></h3>
                    <div class=" align-content-center">
                        <div class="row  mb-2">
                            <div class="col-md-4">
                                <label for="">Total Questions</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" readonly value="<?php echo $exam['totalQuestion'] ?>">
                            </div>
                        </div>

                        <div class="row  mb-2">
                            <div class="col-md-4">
                                <label for="">Attempted Questions</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" readonly value="<?php echo count($response) ?>">
                            </div>
                        </div>

                        <div class="row  mb-2">
                            <div class="col-md-4">
                                <label for="">Time Taken</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" readonly value="<?php echo $totalMinutesDiff . ' Minutes' ?>">
                            </div>
                        </div>

                        <div class="row  mb-2">
                            <div class="col-md-4">
                                <label for="">Candidate Id</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" readonly value="<?php echo $examiner['registrationId'] ?>">
                            </div>
                        </div>

                        <div class="row  mb-2">
                            <div class="col-md-4">
                                <label for="">Candidate Name</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" readonly value="<?php echo $examiner['name'] ?>">
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION['logged_in']) || isset($_SESSION['student'])) {
                        unset($_SESSION['logged_in']);
                        unset($_SESSION['student']);
                    }
                    ?>
                </div>
            </div>
        </form>
        <div class="alert alert-warning" role="alert">
            <strong>You can close the window or</strong> <a href="/" class="alert-link">go to homepage</a>
        </div>
    </div>

    <?php include("includes/scripts.php") ?>
    <script language="JavaScript">
        document.oncontextmenu = new Function("return false;");
        alert(now());

        $(document).ready(function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>

    </body>
<?php } elseif ($_POST) { ?>
    <div class="container">
        <div class="alert alert-success" role="alert">
            <h4>Exam submitted successfully<br>You can close this window now</h4>
        </div>
    </div>
<?php } else {
    echo "<center><h4>Invalid Request</h4></center>";
} ?>

</html>