<?php include("includes/header.php") ?>
<?php include("../includes/dbmethods.php") ?>

<?php
session_start();
if (isset($_SESSION['submitted'])) {
    unset($_SESSION['submitted']);
}
$exam = $examiner = [];

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function get_data_from_database($examid, $rollno)
{
    global $exam;
    global $examiner;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%s", $examid);
    $examiner = DB::queryFirstRow("SELECT * FROM usrregistration WHERE registrationId=%s", $rollno);
}

if (isset($_GET['logout'])) {
    // unset($_SESSION["logged_in"]);
    unset($_SESSION["student"]);
    header("location:./admit.php?e=" . $_SESSION['examid']);
}

if (isset($_GET) and isset($_SESSION['student'])) {
    if (isset($_GET['e'])) {
        $examid = $_GET['e']; //examid
        $_SESSION['examid'] = $examid;
        $rollno = $_SESSION['student']; //examid
        get_data_from_database($examid, $rollno);
    }


?>

    <div class="container">
        <form id="verifyform" action="exam.php" method="post">
            <div class="card card-warning mt-2">
                <div class="card-header">
                    <h2 class=" text-danger text-center">Important Instruction</h2>
                </div>


                <div class="card-body mx-md-4" style="min-height:350px">
                    <div>
                        <?php echo html_entity_decode($exam['instruction']); ?>
                    </div>
                    <br>
                    <h5 class="mt-4 text-bold ">Exam Details:</h5>
                    <div class=" callout callout-info mt-2 ">
                        <div class="row text-black-50">
                            <div class="col col-sm-6 col-md-2 text-bold h5">Exam:</div>
                            <div class="col col-sm-6 col-md-6 h5"><?php echo $exam['examName'] ?></div>
                        </div>
                        <div class="row text-black-50">
                            <div class="col col-sm-6 col-md-2 text-bold h5">Total Questions:</div>
                            <div class="col col-sm-6 col-md-2 h5"><?php echo $exam['totalQuestion'] ?></div>
                        </div>
                        <div class="row text-black-50">
                            <div class="col col-sm-6 col-md-2 text-bold h5">Total Marks:</div>
                            <div class="col col-sm-6 col-md-2 h5"><?php echo $exam['totalMarks'] ?></div>
                        </div>
                        <div class="row text-black-50">
                            <div class="col col-sm-6 col-md-2 text-bold h5">Duration:</div>
                            <div class="col col-sm-6 col-md-2 h5"><?php echo $exam['duration'] ?> Minutes</div>
                        </div>
                    </div>

                    <h5 class="mt-4 text-bold ">Candidate Details:</h5>
                    <div class=" callout callout-warning mt-2 ">
                        <div class="row text-black-50">
                            <div class="col col-sm-6 col-md-2 text-bold h5">Name:</div>
                            <div class="col col-sm-6 col-md-6 h5"><?php echo $examiner['name'] ?></div>
                            <div class="col col-sm-6 col-md-4 h5"> Not you?
                                <a class="btn btn-outline-danger text-decoration-none text-grey" href="<?php echo './instructions.php?logout' ?>">Logout</a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div class="form-check pb-3">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="agreecheck" id="agreecheck" value="checkedValue">
                    I have read all the instructions carefully and I am ready to start the examination.
                </label><br>
                <span class="text-danger d-none" id="agreecheck_error">Please check this box before continue</span>
            </div>

            <input type="hidden" name="examid" value="<?php echo $_GET['e'] ?>">
            <center>
                <button type="submit" name="submit" class="btn btn-lg btn-info m-5">Start Examination</button>
            </center>
        </form>
    </div>

    <?php include("includes/scripts.php") ?>
    <script language="JavaScript">
        document.oncontextmenu = new Function("return false;");
        // function validate() {
        $("#verifyform").on("submit", function(form) {
            if ($("#agreecheck").prop("checked") && matched) {
                // window.location = "./exam.php";
                // alert(rollno + " " + rollnoVerify);
                form.submit();

            } else {
                $("#agreecheck_error").removeClass('d-none');
                form.preventDefault();
            }
            return false;
        });
    </script>
    </body>
<?php } else {
    echo "<center><h1>Invalid Request</h1></center>";
    echo "<center><h4>Redirecting to login page</h4></center>";
    header("location:./admit.php?e=" . $_GET['e']);
} ?>

</html>