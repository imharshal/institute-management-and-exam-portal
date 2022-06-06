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
function generate_id()
{

    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $examId = strval(substr(str_shuffle($str_result), 0, 7));
    $result = DB::query("SELECT * FROM exams where id =%i", $examId);

    // $sql  = "SELECT * FROM exams where id = '$examId'";
    // $query = $connect->query($sql);
    if ($result) {
        $examId = generate_id();
    }
    return $examId;
}
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
    $exam_id = generate_id();
    $total_marks = (int)$total_question * (int)$marks;
    date_default_timezone_set('Asia/Kolkata');
    $datetime =  date("Y-m-d H:i:s");

    $result = DB::insert('exams', [
        'id' => $exam_id,
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
        'status' => 'Incomplete',
        'createdOn' => $datetime,
        'students' => $students
    ]);
    if ($result) {
        global $sucess;
        $success = true;
    }
}
?>







<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Exam</h1>
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
                    <strong>Exam Created Successfully</strong>
                </div>
            <?php } ?>
            <form class="row" method="POST" id="examform">
                <div class="col col-12 col-md-6">
                    <div class="card card-purple card-outline">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Exam Name</label>
                                <input type="text" class="form-control" name="exam_name" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Department</label>
                                <select class="custom-select" name="department" id="department">
                                    <option value="" hidden>Select</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Certification">Certification</option>
                                    <!-- <option value="Job + Diploma">Job + Diploma</option> -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Course</label>
                                <select class="custom-select" name="course" id="courses">
                                    <!-- <option value="" hidden>Select</option> -->

                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="">Date of Examination</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="exam_date" id="exam-date" autocomplete="off" placeholder="Date of Examination (dd/mm/yyyy)">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="">Date & time of Examination (Y-M-D h:m)</label>
                                <div class="input-group date" id="exam-date" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#exam-date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" name="exam_date" data-toggle="datetimepicker" class="form-control datetimepicker-input" autocomplete="off" data-target="#exam-date" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Don't allow login after (Y-M-D h:m)</label>
                                <div class="input-group date" id="login-restrict-time" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#login-restrict-time" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" name="login_restrict_time" data-toggle="datetimepicker" class="form-control datetimepicker-input" autocomplete="off" data-target="#login-restrict-time" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Exam Duration (in minute)</label>
                                <input type="text" class="form-control" name="duration" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Total Questions</label>
                                <input type="text" class="form-control" name="total_question" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Marks/Question</label>
                                <input type="text" class="form-control" name="marks" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Practical Marks</label>
                                <input type="number" class="form-control" name="practicalMarks" value="0">
                            </div>
                            <div class="form-group">
                                <label for="">Passing Percent(in %)</label>
                                <input type="number" class="form-control" name="passingPercent" placeholder="">
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
                                <!-- Students from the data base will be added here -->
                                <h4>
                                    <div class="badge badge-info">
                                        Select course to display the student list.
                                    </div>
                                </h4>
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
                            <p>
                                <span style="color:hsl(0, 75%, 60%);"><strong>READ VERY VERY CAREFULLY, DO NOT IGNORE ANY INFORMATION</strong></span>
                            </p>
                            <p><strong>Before beginning the exam:</strong></p>
                            <ol>
                                <li>Make sure you have a good internet connection.</li>
                                <li>Close all Instant Messaging tools (Skype, Whatsapp, Messenger) and Email programs as they can conflict with Exam Portal.</li>
                                <li>Enter the exam using Chrome Browser if possible.</li>
                                <li>Minimizing the browser window during the exam can prevent the submission of your exam.</li>
                                <li>Maximize your browser window before starting the exam.</li>
                            </ol>
                            <p><strong>During the exam:</strong></p>
                            <ol>
                                <li>Do not resize (minimize) the browser during the exam.</li>
                                <li>Never click the "Back" button on the browser. This will take you out of the exam.</li>
                                <li>Do not switch tabs or leave exam screen during exam. It will considered as malpractice and your exam will be submitted automatically at any time.</li>
                                <li>Answer all questions in the exam.</li>
                                <li>The countdown timer in the left bottom corner indicates the time left for the exam. Your exam will be submitted automatically on timeout.</li>
                                <li>Click the "Submit Examination" button to submit your exam. Do not press "Enter" on the keyboard to submit the exam.</li>
                            </ol>
                            <p><strong>All the best!!</strong>
                            </p>
                        </textarea>
                    </div>
                    <center>
                        <input type="submit" class="btn btn-lg btn-primary mb-3" name="submit" style="width:200px;" value="Create Exams">
                    </center>
                </div>
                <!-- </div> -->
            </form>

        </div>

    </section>
</div>


<?php include("includes/scripts.php") ?>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script> -->
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

        $('#courses').append('<option value="" hidden>Select department first</option>');

        //populating the courses on diploma select
        $('#department').on('change', function() {
            department = $('#department :selected').val();
            console.log(department);
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

        $('#courses').on('change', function() {
            course = $('#courses :selected').val();

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
        })



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


        //select all implementation for selecting all student checkbox
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
                    minlength: 1,
                },
                duration: {
                    required: true,
                    minlength: 1,
                },
                'students[]': "required",
            },
            messages: {

                'students[]': 'Please select students'
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

</body>

</html>