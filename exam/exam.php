<?php include("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>

<?php
session_start();
if (isset($_SESSION['submitted'])) {
    unset($_SESSION['submitted']);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$exam = $questions = $examiner = [];
unset($_SESSION['examid']);

function get_data_from_database($id)
{
    global $exam;
    global $questions, $examiner;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%s", $id);
    $questions = DB::query("SELECT * FROM questions WHERE examId=%s", $id);
    $examiner = DB::queryFirstRow("SELECT * FROM usrregistration WHERE registrationId=%s", $_SESSION['student']);
}

if (isset($_POST['submit']) and isset($_SESSION['student'])) {

    get_data_from_database($_POST['examid']);

?>

    <script type="text/javascript">

    </script>

    <div class="container ">

        <div class="card fixed-bottom mb-0 ">
            <div class="card-body ">
                <h4 class="d-inline" id="exam-timer"></h4>

                <button data-toggle="modal" data-target="#modelId" class="btn btn-outline-info float-right">Submit Exam</button>
            </div>
        </div>
        <form action="exam_submit.php" method="post" id="exam_response">
            <div class="card mt-2">
                <div class="card-header">
                    <h4><?php echo $exam['examName'] ?></h4>
                    <div class="row p-0">
                        <div class="col-md-2 col-6">
                            <p class="text-muted ml-2"><strong>Total Questions: </strong><?php echo $exam['totalQuestion'] ?></p>
                        </div>
                        <div class="col-md-2 col-6">
                            <p class="text-muted ml-2"><strong>Total Marks:</strong> <?php echo $exam['totalMarks'] ?></p>
                        </div>
                    </div>
                    <div class="row p-0">
                        <div class="col col-12">
                            <p class="text-muted ml-2"><strong>Name:</strong> <?php echo $examiner['name'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Hidden Fields to post -->
                <input type="hidden" name="examid" value="<?php echo $exam['id'] ?>">
                <input type="hidden" name="start_time" id="start-time">
                <!-- <input type="hidden" name="examid" value="<?php // echo $exam['id'] 
                                                                ?>"> -->

                <?php
                $counter = 0;

                foreach ($questions as $q) {
                    $counter++;
                ?>
                    <div class="card-body pb-0">
                        <div class="callout callout-info">
                            <!-- <p class="text-info float-right">2m</p> -->

                            <h5 class="pb-2"><?php echo $counter . ") " . $q['question'] ?> </h5>
                            <?php if ($q['op1']) { ?>
                                <div class="form-check pb-2">
                                    <input class="mr-2" type="radio" name="response[<?php echo $q['id'] ?>]" value="op1" id="<?php echo $q['id'] . '-a' ?>">
                                    <label for="<?php echo $q['id'] . '-a' ?>" class="form-check-label"> <?php echo $q['op1'] ?></label>
                                </div>
                            <?php } ?>

                            <?php if ($q['op2']) { ?>
                                <div class="form-check pb-2">
                                    <input class="mr-2" type="radio" name="response[<?php echo $q['id'] ?>]" value="op2" id="<?php echo $q['id'] . '-b' ?>">
                                    <label for="<?php echo $q['id'] . '-b' ?>" class="form-check-label"> <?php echo $q['op2'] ?></label>
                                </div>
                            <?php } ?>

                            <?php if ($q['op3']) { ?>
                                <div class="form-check pb-2">
                                    <input class="mr-2" type="radio" name="response[<?php echo $q['id'] ?>]" value="op3" id="<?php echo $q['id'] . '-c' ?>">
                                    <label for="<?php echo $q['id'] . '-c' ?>" class="form-check-label"> <?php echo $q['op3'] ?></label>
                                </div>
                            <?php } ?>

                            <?php if ($q['op4']) { ?>
                                <div class="form-check">
                                    <input class="mr-2" type="radio" name="response[<?php echo $q['id'] ?>]" value="op4" id="<?php echo $q['id'] . '-d' ?>">
                                    <label for="<?php echo $q['id'] . '-d' ?>" class="form-check-label"> <?php echo $q['op4'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class=" p-5"></div>
            <!-- Submit Modal -->
            <div class="modal fade" id="modelId" data-backdrop='static' tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Are you sure?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            You will not be able to modify your responses, once you submit the exam
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                            <button id="submit_exam" type="button" onclick="submit_exam()" class="btn btn-primary">Yes, Submit Exam</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>



    <div class="modal fade" id="tabSwitched" data-backdrop='static' tabindex="-1" role="dialog" aria-labelledby="tabSwitchedTitleId" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ">Warning:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="tab-switched-message">
                    You are not allowed to leave exam screen. If you leave screen your exam will be terminated and auto submitted.
                </div>
                <div class="modal-footer">

                    <button id="tab-switched-button" type="button" class="btn btn-warning" data-dismiss="modal">I will not do that again</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    date_default_timezone_set('Asia/Kolkata');
    $serverTime =  date("Y-m-d H:i:s");
    ?>

    <?php include("includes/scripts.php");

    ?>

    <script language="JavaScript">
        var stud = <?php echo $_SESSION['student'] ?>;
        var start_time;
        if (localStorage.getItem("start_time_" + stud))
            start_time = localStorage.getItem("start_time_" + stud)
        else {
            localStorage.setItem("start_time_" + stud, '<?php echo $serverTime ?>');
            start_time = localStorage.getItem("start_time_" + stud)
        }
        document.getElementById("start-time").value = start_time;

        //----------------------- Timer code --------------------------------
        if (localStorage.getItem("total_seconds_" + stud)) {
            var total_seconds = localStorage.getItem("total_seconds_" + stud);
        } else {
            var total_seconds = <?php echo (int)$exam['duration'] * 60 ?>;
        }
        var minutes = parseInt(total_seconds / 60);
        var hours = parseInt(minutes / 60);
        var seconds = parseInt(total_seconds % 60);

        function countDownTimer() {
            if (seconds < 10) {
                seconds = "0" + seconds;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            if (hours < 10) {
                hours = "0" + hours;
            }

            document.getElementById("exam-timer").innerHTML = "Time Left " + hours + ":" + minutes + ":" + seconds;
            if (total_seconds <= 0) {
                // submitting exam on timeout 
                // submit_exam() definition is at bottom of page
                setTimeout("submit_exam()", 1); //any js function
                localStorage.removeItem("total_seconds_" + stud)
            } else {
                total_seconds = total_seconds - 1;
                minutes = parseInt(total_seconds / 60);
                hours = parseInt(minutes / 60);
                seconds = parseInt(total_seconds % 60);
                localStorage.setItem("total_seconds_" + stud, total_seconds)
                setTimeout("countDownTimer()", 1000);
            }
        }
        setTimeout("countDownTimer()", 1000);
        //-------------------------------------------------------
        // document.oncontextmenu = new Function("return false;");
        $(function() {
            $('input[type=radio]').each(function() {
                var state = JSON.parse(localStorage.getItem('ans_' + $(this).attr('id')));

                if (state) this.checked = state.checked;
            });
        });

        $(window).bind('unload', function() {
            $('input[type=radio]').each(function() {
                localStorage.setItem('ans_' + $(this).attr('id'), JSON.stringify({
                    checked: this.checked
                }));
            });
        });

        $(window).blur(function() {
            $('#tabSwitched').modal('show');
            let count;
            if (localStorage.getItem("tab_switched")) {
                count = localStorage.getItem("tab_switched")
                localStorage.setItem("tab_switched", ++count);
                if (count >= 3) {
                    $('#tab-switched-message').text('This is last chance for you. If you leave the exam screen your exam will be auto submited.');
                }
                if (count == 4) {
                    localStorage.removeItem('tab_switched');
                    submit_exam();
                }
            } else {
                localStorage.setItem("tab_switched", 1);
            }

        });

        function submit_exam() {
            response = $('#exam_response')
            window.localStorage.clear();
            response.submit();
            $('input[type=radio]').each(function() {
                $('input[type="radio"]').prop('checked', false);
            })
        }

        $('#submit_exam').click(function() {
            submit_exam();
        });
    </script>

<?php } else {
    echo "<center><h4>Invalid Request</h4></center>";
}
?>
</body>

</html>