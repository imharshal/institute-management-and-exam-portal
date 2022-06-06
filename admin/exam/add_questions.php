<?php include("includes/header.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("../../includes/dbmethods.php") ?>

<?php

$success = false;

$exam = $addedQue = [];
function get_data_from_database($id)
{
    global $exam;
    global $addedQue;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%i", $id);
    $addedQue = DB::queryFirstRow("SELECT count(id) FROM questions WHERE examId=%i", $id);
}


function generate_id()
{

    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $queId = strval(substr(str_shuffle($str_result), 0, 9));
    $result = DB::query("SELECT * FROM questions where id =%i", $queId);

    // $sql  = "SELECT * FROM exams where id = '$examId'";
    // $query = $connect->query($sql);
    if ($result) {
        $queId = generate_id();
    }
    return $queId;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!empty($_POST) && isset($_POST['submit'])) {

    $question = test_input($_POST['question']);
    $op1 = test_input($_POST['op1']);
    $op2 = test_input($_POST['op2']);
    $op3 = test_input($_POST['op3']);
    $op4 = test_input($_POST['op4']);
    $ans = test_input($_POST['ans']);
    $examId = test_input($_POST['examid']);

    $queId = generate_id();
    $result = DB::insert('questions', [
        'id' => $queId,
        'question' => $question,
        'op1' => $op1,
        'op2' => $op2,
        'op3' => $op3,
        'op4' => $op4,
        'answer' => $ans,
        'examId' => $examId,
    ]);
    if ($result) {
        global $sucess;
        $success = true;
    }
    get_data_from_database($examId);
}


//------------GET METHOD---------------------------------
if (isset($_GET['examid']) or isset($_POST['examid'])) {
    get_data_from_database($_GET['examid']);
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <?php
                if ($success == true) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Question Added Successfully</strong>
                    </div>
                <?php } ?>
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Question</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid"></div>
            <div class="">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="text-bold text-muted"><?php echo $exam['examName'] ?></h5>
                        <div class="row p-0">
                            <div class="col-md-2 col-6">
                                <p class="text-bold ml-4">Total Que: <?php echo $exam['totalQuestion'] ?></p>
                            </div>
                            <div class="col-md-2 col-6">
                                <p class="text-bold ml-4">Added Que: <?php echo $addedQue['count(id)'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (($addedQue['count(id)'] < $exam['totalQuestion'])) { ?>
                    <form id="question-form" method="post">

                        <div class="card-body p-0">
                            <div class="callout callout-info">
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo intval(((int)$addedQue['count(id)'] / (int)$exam['totalQuestion']) * 100) ?>%; ">
                                    </div>
                                </div>
                                <h4 class="pt-3"><?php echo "Question <strong>" . ((int)$addedQue['count(id)'] + 1) . "/" . $exam['totalQuestion'] . "</strong>" ?></h4>
                                <div class="form-group">
                                    <textarea class="form-control" name="question" rows="3" placeholder="Enter Question"></textarea>
                                </div>

                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" value="op1" name="ans"></span>
                                    </div>
                                    <input type="text" name="op1" class="form-control" placeholder="Option a)">
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" value="op2" name="ans"></span>
                                    </div>
                                    <input type="text" name="op2" class="form-control" placeholder="Option b)">
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" value="op3" name="ans"></span>
                                    </div>
                                    <input type="text" name="op3" class="form-control" placeholder="Option c)">
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" value="op4" name="ans"></span>
                                    </div>
                                    <input type="text" name="op4" class="form-control" placeholder="Option d)">
                                </div>
                                <input type="hidden" name="examid" value="<?php echo $exam['id'] ?>">
                            </div>
                        </div>

                        <div class="form-group float-left">
                            <button type="submit" name="submit" class="btn btn-lg btn-primary " style="width:200px;">Save & Next</button>
                        </div>
                    </form>
                <?php
                } else {
                    if ($exam['status'] == 'Incomplete') {
                        $result = DB::update('exams', [
                            'status' => 'Ready'
                        ], 'id=%s', $exam['id']);
                    }
                ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        All questions are added already.<a href="review_questions.php?examid=<?php echo $exam['id'] ?>">Click here to review</a>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </div>



    <?php include("includes/scripts.php"); ?>
    <script>
        $('#question-form').validate({
            rules: {
                question: "required",
                ans: "required",
                op1: "required",
                op2: "required",
            },

            onfocusout: function(element) {
                this.element(element);
            },
            errorElement: "em",

            errorPlacement: function(error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                error.insertAfter(element);

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.next("label"));
                } else {
                    error.insertAfter(element.next(".pmd-textfield-focused"));
                }

            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");

            },
            // submitHandeler: function(form) {

            // }
        });
    </script>
<?php } else {
?>
    <div class="offset-md-2">
        <div class="alert alert-danger" role="alert">
            <strong>Invalid Request</strong>
        </div>
    </div>
<?php } ?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>

</html>