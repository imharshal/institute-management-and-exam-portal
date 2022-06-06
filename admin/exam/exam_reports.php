<?php include("includes/header.php") ?>
<?php //include("includes/sidebar.php")
?>
<?php //include("includes/menubar.php")
?>
<?php include("../../includes/dbmethods.php") ?>
<?php

$exam = $presentStudents = $students = [];

function get_data_from_database($id)
{
    global $exam;
    global $students;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%i", $id);
    DB::disconnect();
}
if (isset($_GET['examid'])) {
    get_data_from_database($_GET['examid']);


    $presentStudents = DB::query("SELECT admissions.id,uname,attendance, marksObtain, percentObtain,practicalMarksObtain, result 
                                    FROM courses_enrolled
                                    RIGHT JOIN admissions
                                    ON admissions.id = courses_enrolled.studentId
                                    RIGHT JOIN exam_report
                                    ON exam_report.studentId = courses_enrolled.studentId  
                                    WHERE exam_report.examId = %s AND courseId=%s AND attendance=1", $exam['id'], $exam['course']);

    DB::disconnect();
    $absentStudents = DB::query("SELECT admissions.id,uname,attendance, marksObtain, percentObtain,practicalMarksObtain, result 
                                    FROM courses_enrolled
                                    RIGHT JOIN admissions
                                    ON admissions.id = courses_enrolled.studentId
                                    RIGHT JOIN exam_report
                                    ON exam_report.studentId = courses_enrolled.studentId  
                                    WHERE exam_report.examId = %s AND courseId=%s AND attendance=0", $exam['id'], $exam['course']);

    // $stud = DB::queryFirstRow("SELECT students from exams WHERE id=%s", $exam['id']);

    // $students = explode(',', $stud['students']);

?>


    <!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <center>
                        <h1>Exam Report</h1>
                    </center>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <center>

                <div id="success-message" class="d-none">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Results are declared for <?php echo $exam['examName'] ?></strong>
                    </div>
                </div>
            </center>
            <div class="card mx-md-5">
                <h4 class="p-2">Exam: <span class="text-primary"><?php echo $exam['examName'] ?></span></h4>
                <div class="card-body row">
                    <div class="col-12 col-md-4">
                        <div class="card card-purple card-outline p-3">
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Exam ID</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo $exam['id'] ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Total questions</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo $exam['totalQuestion'] ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Total marks</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo $exam['totalMarks'] ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Practical marks</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo $exam['practicalMarks'] ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Passing Percentage</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo $exam['passingPercent'] ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Total Students</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo (count($presentStudents) + count($absentStudents)) ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Present Students</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo count($presentStudents) ?></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col col-md-7">
                                    <h5>Absent Students</h5>
                                </div>
                                <div class="col col-md-5">
                                    <h5><?php echo count($absentStudents) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12 ">
                        <div class="card card-purple card-outline p-3">

                            <div class="table-responsive" style="height:485px; overflow-y:scroll;">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Student Id</th>
                                            <th style="width: 200px;">Student Name</th>
                                            <th>Attendance</th>
                                            <th>Obtained Marks</th>
                                            <th>Practical Marks</th>
                                            <!-- <th>Percentage</th>
                                            <th>Result</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form id="reportForm">
                                            <input type="hidden" name="examid" value="<?php echo $exam['id'] ?>">
                                            <input type="hidden" name="courseid" value="<?php echo $exam['course'] ?>">
                                            <?php
                                            //present students
                                            foreach ($presentStudents as $ps) { ?>
                                                <tr>
                                                    <td><?php echo $ps['id'] ?></td>
                                                    <td><?php echo $ps['uname'] ?></td>
                                                    <td><?php echo 'Present' ?></td>
                                                    <td><?php echo $ps['marksObtain'] ?></td>
                                                    <td><input type="number" class="practicalMarks" value="<?php echo $ps['practicalMarksObtain'] ?>" style="width:80px" name="id[<?php echo $ps['id'] ?>]" min="0" max="<?php echo $exam['practicalMarks'] ?>" <?php echo (($exam['status'] == 'Completed') and $exam['resultDeclared'] == 0) ? '' : 'disabled' ?>></td>
                                                </tr>
                                            <?php } ?>
                                        </form>
                                        <!-- ---------------------------------------------------------------- -->
                                        <?php
                                        //absent student
                                        foreach ($absentStudents as $ab) { ?>
                                            <tr>
                                                <td><?php echo $ab['id'] ?></td>
                                                <td><?php echo $ab['uname'] ?></td>
                                                <td><?php echo 'Absent' ?></td>
                                                <td><?php echo $ab['marksObtain'] ?></td>
                                                <td><?php echo $ab['practicalMarksObtain'] ?></td>
                                                <!-- <td><input type="text" style="width:80px" value="<?php echo $ab['practicalMarksObtain'] ?>" disabled> -->
                                                </td>
                                                <!-- <td id="percent_<?php //echo $ab['id'] 
                                                                        ?>"><?php //echo $ab['percentObtain'] 
                                                                            ?></td> -->
                                                <!-- <td id="result_<?php //echo $ab['id'] 
                                                                    ?>"><?php //echo $ab['result'] 
                                                                        ?></td> -->
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <center>
                            <button type="button" id="btnDeclare" <?php echo (($exam['status'] == 'Completed') and $exam['resultDeclared'] == 0) ? '' : 'disabled' ?> class="btn btn-lg btn-primary mb-3 " name="submit" style="width:200px;" value="Declare Result">
                                Submit
                            </button>
                        </center>

                    </div>
                </div>

            </div>
        </div>
        <!-- </div> -->
    </section>

    <!-- </div> -->


<?php include("includes/scripts.php");
} ?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    <?php if ($exam['resultDeclared']) { ?>
        $('#success-message').removeClass('d-none');
    <?php } ?>

    function updateValue(e) {
        $(document.activeElement).val(e.target.value);
        console.log('e', e.target.value);
    }
    $('#btnDeclare').on('click', function() {
        // alert('clicked');
        var data = $("#reportForm").serialize();
        console.log(data);
        $('#success-message').addClass('d-none');
        $.ajax({
            url: "api.php",
            type: "post",
            data: $("#reportForm").serialize(),
            success: function(data) {
                $('#success-message').removeClass('d-none');
                $('#btnDeclare').attr('disabled', 'disabled');
                $('.practicalMarks').attr('disabled', 'disabled');
                // console.log(data);
            }
        })
    });
</script>
</body>

</html>