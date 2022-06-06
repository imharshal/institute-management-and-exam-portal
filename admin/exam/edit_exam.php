<?php include("includes/header.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("../../includes/dbmethods.php") ?>
<!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css"> -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- date time picker cdn css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />

<?php
$success = false;
$exam = $courses = [];
//------------GET METHOD---------------------------------
if (isset($_GET['examid'])) {
    global $exam;
    $exam = DB::queryFirstRow("SELECT * FROM exams WHERE id=%i", $_GET['examid']);
    $courses = DB::query("SELECT id,name FROM courses WHERE type = %s", $exam['department']);
}
$selected = explode(",", $exam['students']);
// $selected = ['Student2', 'Student4'];
// $students = ['Student1', 'Student2', 'Student3', 'Student4', 'Student5'];
$students = DB::query("SELECT DISTINCT studentId,uname FROM courses_enrolled
                            RIGHT JOIN admissions
                            ON admissions.id = studentId
                            WHERE courseId = %s", $exam['course']);

// ------------POST METHOD-------------------------------
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if (!empty($_POST) && isset($_POST['submit'])) {

    $exam_name = test_input($_POST['exam_name']);
    $department = test_input($_POST['department']);
    $course = test_input($_POST['course']);
    $exam_date = htmlspecialchars($_POST['exam_date']);
    $login_restrict_time = htmlspecialchars($_POST['login_restrict_time']);
    $exam_name = test_input($_POST['exam_name']);
    $total_question = test_input($_POST['total_question']);
    $marks = test_input($_POST['marks']);
    $practicalMarks = test_input($_POST['practicalMarks']);
    $passingPercent = test_input($_POST['passingPercent']);
    $duration = test_input($_POST['duration']);
    $instruction = test_input($_POST['instruction']);
    $students = implode(',', $_POST['students']);
    $exam_id = $exam['id'];
    $total_marks = (int)$total_question * (int)$marks;
    $datetime =  date("Y-m-d H:i:s");

    $result = DB::update('exams', [
        'examName' => $exam_name,
        'department' => $department,
        'course' => $course,
        'examDate' => $exam_date,
        'loginRestrictTime' => $login_restrict_time,
        'totalQuestion' => $total_question,
        'marks' => $marks,
        'practicalMarks' => $practicalMarks,
        'totalMarks' => $total_marks,
        'passingPercent' => $passingPercent,
        'duration' => $duration,
        'instruction' => $instruction,
        'createdOn' => $datetime,
        'students' => $students
    ], 'id=%s', $exam_id);
    if ($result) {
        global $success;
        $success = true;
    }
    // header("location:./exams.php/");
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Exam</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <?php
                if ($success == true) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Exam Updated Successfully</strong>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>

<?php
} else {

?>




    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Exam</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">

                <form class="row" method="POST" id="examform">
                    <div class="col col-12 col-md-6">
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Exam Name</label>
                                    <input type="text" class="form-control" name="exam_name" value="<?php echo $exam['examName'] ?>" id="" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Department</label>
                                    <select class="custom-select" name="department" id="department">
                                        <option value="Diploma" <?php if (!empty($exam) && $exam['department'] == 'Diploma') echo "selected" ?>>Diploma</option>
                                        <option value="Certification" <?php if (!empty($exam) && $exam['department'] == 'Certification') echo "selected" ?>>Certification</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Course</label>
                                    <select class="custom-select" name="course" id="courses">
                                        <?php foreach ($courses as $c) { ?>
                                            <option value="<?php echo $c['id'] ?>" <?php if (!empty($exam) && $exam['course'] == $c['id']) echo "selected"; ?>> <?php echo $c['name'] ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="">Date of Examination</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="exam_date" value="<?php echo $exam['examDate'] ?>" id="exam-date" placeholder="Date of Examination (dd/mm/yyyy)">
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="">Date & time of Examination (Y-M-D h:m)</label>
                                    <div class="input-group date" id="exam-date" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#exam-date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" name="exam_date" value="<?php echo $exam['examDate'] ?>" data-toggle="datetimepicker" class="form-control datetimepicker-input" autocomplete="off" data-target="#exam-date" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Don't allow login after (Y-M-D h:m)</label>
                                    <div class="input-group date" id="login-restrict-time" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#login-restrict-time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" name="login_restrict_time" value="<?php echo $exam['loginRestrictTime'] ?>" data-toggle="datetimepicker" class="form-control datetimepicker-input" autocomplete="off" data-target="#login-restrict-time" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Exam Duration (in minute)</label>
                                    <input type="text" class="form-control" value="<?php echo $exam['duration'] ?>" name="duration" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Total Questions</label>
                                    <input type="text" class="form-control" value="<?php echo $exam['totalQuestion'] ?>" name="total_question" id="" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Marks/Question</label>
                                    <input type="text" class="form-control" value="<?php echo $exam['marks'] ?>" name="marks" id="" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Practical Marks</label>
                                    <input type="number" class="form-control" name="practicalMarks" value="<?php echo $exam['practicalMarks'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Passing Percent(in %)</label>
                                    <input type="text" class="form-control" value="<?php echo $exam['passingPercent'] ?>" name="passingPercent" placeholder="">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col col-12 col-md-6">
                        <div class="card p-1 card-purple card-outline">
                            <div class="card-body pre-scrollable" id="student-list">
                                <strong>Select Students from List Below</strong>

                                <label class="form-check-label float-right">
                                    <input hidden type="checkbox" id="select-all">
                                    <span class="btn btn-primary btn-sm ">Select all</span>
                                </label>

                                <hr>

                                <div id="allStudents">
                                    <?php foreach ($students as $s) { ?>
                                        <div class="form-check pb-2">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="students[]" minlength="1" value="<?php echo $s['studentId'] ?>" <?php echo (in_array($s['studentId'], $selected)) ? 'checked="checked"' : '' ?>>
                                                <?php echo $s['uname'] ?>
                                            </label>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>


                        <div class="card card-purple card-outline p-2">
                            <style>
                                .ck-editor__editable {
                                    max-height: 500px !important;
                                }
                            </style>

                            <textarea class="form-control mb-0" name="instruction" id="instruction" rows="9" required>
                            <?php echo html_entity_decode($exam['instruction']); ?>
                        </textarea>

                        </div>
                        <center>
                            <input type="submit" class="btn btn-lg btn-primary  mb-3" name="submit" style="width:200px;" value="Update Exams">
                        </center>
                    </div>
                </form>

            </div>

        </section>
    </div>


    <?php include("includes/scripts.php") ?>
    <!-- datetimepicker cdn -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
    <!-- datetimepicker cdn end here -->

    <!-- Customized Ckeditor for instruction editing -->
    <script src="includes/ckeditor.js"></script>


    <script>
        $(document).ready(function() {
            // $('#exam-date').mask('00/00/0000');
            // $('#exam-date').datepicker({
            //     changeMonth: true,
            //     changeYear: true,
            //     dateFormat: "dd/mm/yy",
            //     yearRange: "1900:2100",
            //     onSelect: function(dateText, inst) {
            //         $('#exam-date').focusout();
            //     },
            // });

            // $('#courses').append('<option value="" hidden>Select department first</option>');

            // Exam timing and login methods
            $('#exam-date').datetimepicker({
                format: "yyyy-MM-DD HH:mm",
                icons: {
                    time: "fa fa-clock",
                }
            });
            $('#login-restrict-time').datetimepicker({
                format: "yyyy-MM-DD HH:mm",
                icons: {
                    time: "fa fa-clock",
                },
                useCurrent: false

            });
            $("#exam-date").on("change.datetimepicker", function(e) {
                $('#login-restrict-time').datetimepicker('minDate', e.date);
            });
            $("#login-restrict-time").on("change.datetimepicker", function(e) {
                $('#exam-date').datetimepicker('maxDate', e.date);
            });

            //populating the courses on diploma select
            $('#department').on('change', function() {
                department = $('#department :selected').val();
                // console.log(department);
                $("#courses").empty()
                    .append('<option value="" hidden>Select</option>');
                $.ajax({
                    url: '../api.php',
                    type: 'get',
                    data: 'courses=' + department,
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(i, row) {
                            // console.log(row.name)
                            $('#courses').append($('<option>').text(row.name).val(row.id));
                        });
                    }
                });
            })

            function get_student_list() {
                course = $('#courses :selected').val();
                // console.log(course);
                $.ajax({
                    url: '../api.php',
                    type: 'get',
                    data: 'getStudentsFor=' + course,
                    dataType: 'json',
                    success: function(data) {
                        $('#allStudents').empty();
                        if (data.length === 0)
                            $('#allStudents').append(
                                $('<h4>').html(
                                    $('<div class="badge badge-info">').html('There are no students in this course.')
                                )
                            );
                        $.each(data, function(i, row) {
                            // console.log(row)
                            $('#allStudents').append(
                                $('<div class="form-check pb-2">').html(
                                    $('<label class="form-check-label">').html(
                                        '<input type="checkbox" class="form-check-input" name="students[]" value="' + row.studentId + '">' + row.uname
                                    )
                                )
                            );
                        });
                    }
                });
            }

            $('#courses')
                .change(function() {
                    get_student_list()
                })
            // .click(function() {
            //     get_student_list()
            // });







            // Ckeditor5 for instruction editor
            var instructionEditor;
            ClassicEditor
                .create(document.querySelector('#instruction'), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'fontColor',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            'link',
                            '|',
                            'alignment',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'undo',
                            'redo'
                        ]
                    },
                    language: 'en',
                    licenseKey: '',
                })
                .then(editor => {
                    instructionEditor = editor.getData();
                });

            $('#instruction').text(instructionEditor);

            $('#select-all').click(function() {
                $('input[type="checkbox"]').prop('checked', this.checked)
            });

            $.validator.addMethod("requiredSelect", function(element) {
                return ($("select").val() != 'default');
            }, "You must select an option.");
            $("#examform").validate({
                rules: {
                    exam_name: "required",

                    department: {
                        required: true,
                        requiredSelect: true,
                    },
                    course: {
                        required: true,
                        requiredSelect: true,
                    },
                    exam_date: {
                        required: true,
                        minlength: 10,
                    },
                    login_restrict_time: {
                        required: true,
                    },
                    total_question: {
                        required: true,
                        minlength: 1,
                    },
                    marks: {
                        required: true,
                        minlength: 1,
                    },
                    practicalMarks: {
                        required: true,
                        minlength: 1,
                    },
                    passingPercent: {
                        required: true,
                        minlenght: 1,
                    },
                    duration: {
                        required: true,
                        minlength: 1,
                    },
                    'students[]': {
                        required: true,
                        minlength: 1
                    },
                },
                messages: {

                    'students[]': {
                        required: 'Please select atleast one students'
                    },
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
                        error.insertBefore('hr');
                    } else {
                        error.insertAfter(element.next(".pmd-textfield-focused"));
                    }

                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
                // submitHandeler: function(form) {

                // }
            })


        });
    </script>
<?php } ?>
</body>

</html>