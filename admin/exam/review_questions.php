<?php include("includes/header.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("../../includes/dbmethods.php") ?>
<?php

$exam = $addedQue = $success = $questions = [];
function get_data_from_database($id)
{
    global $exam;
    global $addedQue, $questions;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%i", $id);
    $addedQue = DB::queryFirstRow("SELECT count(id) FROM questions WHERE examId=%s", $id);
    $questions = DB::query("SELECT * FROM questions WHERE examId=%s ORDER BY srNo ASC", $id);
}

function myfunction_key($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? 1 : -1;
}

function myfunction_value($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? 1 : -1;
}

function array_diff_assoc_recursive($array1, $array2)
{
    foreach ($array1 as $key => $value) {
        if (is_array($value)) {
            if (!isset($array2[$key])) {
                $difference[$key] = $value;
            } elseif (!is_array($array2[$key])) {
                $difference[$key] = $value;
            } else {
                $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                if ($new_diff != FALSE) {
                    $difference[$key] = $new_diff;
                }
            }
        } elseif (!isset($array2[$key]) || $array2[$key] != $value) {
            $difference[$key] = $value;
        }
    }
    return !isset($difference) ? 0 : $difference;
}


if (isset($_GET['examid'])) {
    get_data_from_database($_GET['examid']);
}

if (isset($_POST['btnUpdate'])) {


    $queDB = DB::query("SELECT id,question,op1,op2,op3,op4,answer FROM questions WHERE examId=%s", $_GET['examid']);

    $queResp = $_POST['q'];

    $result = array_diff_assoc_recursive($queDB, $queResp);

    if (!empty($result)) {
        foreach ($result as $ind => $r) {
            $id = $queResp[$ind]['id'];
            $que = $queResp[$ind]['question'];
            $op1 = $queResp[$ind]['op1'];
            $op2 = $queResp[$ind]['op2'];
            $op3 = $queResp[$ind]['op3'];
            $op4 = $queResp[$ind]['op4'];
            $ans = $queResp[$ind]['answer'];

            $result = DB::update('questions', [
                'question' => $que,
                'op1' => $op1,
                'op2' => $op2,
                'op3' => $op3,
                'op4' => $op4,
                'answer' => $ans,
            ], "id = %s", $id);
        }
        if ($result) {
            array_push($success, "All the changes are saved successfully");
        }
    } else {
        array_push($success, "No changes to save you are all done.");
    }
    get_data_from_database($_GET['examid']);




    //    $string = " INSERT INTO questions (id, question, op1, op2, op3, op4, answer)
    // VALUES";
    // foreach ($_POST as $id => $q) {
    //     $string .= "(" . $id . "," . $q['que'] . "," . $q['op1'] . "," . $q['op2'] . "," . $q['op3'] . "," . $q['op4'] . "," . $q['ans'] . ")";
    // }
    // echo $string;

    // $string .="ON DUPLICATE KEY UPDATE id=VALUES(id),
    // a=VALUES(a),
    // b=VALUES(b),
    // c=VALUES(c)"
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Review Question</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <?php foreach ($success as $s) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong><?php echo $s ?></strong>
                </div>
            <?php } ?>
            <div class="">
                <div class="card" style="background-color: skyblue;">
                    <div class="card-body pb-0">
                        <h2 class="text-bold text-white mb-4"><?php echo $exam['examName'] ?></h2>
                        <div class="row p-0">
                            <div class="col-md-2 col-6">
                                <p class="text-bold ml-4 text-white">Total Que: <?php echo $exam['totalQuestion'] ?></p>
                            </div>
                            <div class="col-md-2 col-6">
                                <p class="text-bold ml-4 text-white">Added Que: <?php echo $addedQue['count(id)'] ?></p>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
                <form method="post">
                    <?php
                    $counter = 0;
                    foreach ($questions as $q) {
                    ?>
                        <input type="hidden" value="<?php echo $q['id'] ?>" name="<?php echo 'q[' . $counter . '][id]' ?>">
                        <div class="card-body p-0">
                            <div class="callout callout-info">
                                <h4 class="mb-4 text-primary">Question <?php echo $counter + 1 ?></h4>
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="<?php echo 'q[' . $counter . '][question]' ?>" placeholder="Enter Question"><?php echo $q['question'] ?></textarea>
                                </div>


                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" name="<?php echo 'q[' . $counter . '][answer]' ?>" value="op1" <?php if ($q['answer'] == 'op1') echo "checked"; ?>></span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo $q['op1'] ?>" name="<?php echo 'q[' . $counter . '][op1]' ?>" placeholder="Option a)">
                                </div>


                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" name="<?php echo 'q[' . $counter . '][answer]' ?>" value="op2" <?php if ($q['answer'] == 'op2') echo "checked"; ?>></span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo $q['op2'] ?>" name="<?php echo 'q[' . $counter . '][op2]' ?>" placeholder="Option b)">
                                </div>


                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" name="<?php echo 'q[' . $counter . '][answer]' ?>" value="op3" <?php if ($q['answer'] == 'op3') echo "checked"; ?>></span>
                                    </div>
                                    <input type="text" value="<?php echo $q['op3'] ?>" name="<?php echo 'q[' . $counter . '][op3]' ?>" class="form-control" placeholder="Option c)">
                                </div>


                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><input type="radio" name="<?php echo 'q[' . $counter . '][answer]' ?>" value="op4" <?php if ($q['answer'] == 'op4') echo "checked"; ?>></span>
                                    </div>
                                    <input type="text" value="<?php echo $q['op4'] ?>" name="<?php echo 'q[' . $counter . '][op4]' ?>" class="form-control" placeholder="Option d)">
                                </div>
                            </div>
                        </div>
                    <?php
                        $counter++;
                    } ?>
                    <div class="form-group float-left">
                        <button type="submit" name="btnUpdate" class="btn btn-lg btn-primary " style="width:200px;">Save & Finish</button>
                    </div>
                </form>
            </div>
        </div>
</div>
</section>

</div>


<?php include("includes/scripts.php") ?>

</body>

</html>