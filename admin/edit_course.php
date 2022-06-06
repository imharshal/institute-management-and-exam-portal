<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/custom-view/bootstrap-table-custom-view.js"></script>
<!-- Main functionality -->
<?php
$success = false;
function generate_id($course_type)
{

    $str_result = '1234567890';
    $prefix = substr($course_type, 0, 1);
    $examId = $prefix . strval(substr(str_shuffle($str_result), 0, 5));
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
$success = [];
$file_name = $course_id = '';
if (!empty($_POST) && isset($_POST['submit'])) {
    $course_name = test_input($_POST['course_name']);
    $course_type = test_input($_POST['course_type']);
    $course_duration = test_input($_POST['course_duration']);
    $course_fees = test_input($_POST['course_fees']);
    $course_installments = test_input($_POST['course_installments']);
    $course_discount = test_input($_POST['course_discount']);
    $course_scholarship = test_input($_POST['course_scholarship']);
    $course_description = test_input($_POST['course_description']);
    $on_homepage = isset($_POST['on_homepage']) ? 1 : 0;

    $course_id = $_GET['courseid'];

    if (!($_FILES['course_image']['size'] < 1)) {
        global $course_id, $file_name;
        $errors = array();
        // $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['course_image']['size'];
        $file_tmp = $_FILES['course_image']['tmp_name'];
        $file_type = $_FILES['course_image']['type'];
        $fname = $_FILES['course_image']['name'];
        $file_ext = pathinfo($fname, PATHINFO_EXTENSION);
        $file_name = $course_id . '.' . $file_ext;
        $extensions = array("jpeg", "jpg", "png", "gif");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "Extension not allowed, please choose valid image file.";
        }
        if (empty($errors) == true) {
            global $file_name;
            $old_course_image = '..' . $_POST['old_course_image'];
            if (glob($old_course_image)) {
                unlink($old_course_image);
            }
            move_uploaded_file($file_tmp, "../uploads/courses/" . $file_name);
            global $image_ok;
            $image_ok = true;
            DB::update('courses', [
                'image' => 'uploads/courses/' . $file_name,
            ], "id=%s", $course_id);
        } else {
            print_r($errors);
        }
    }

    $result = DB::update('courses', [
        'name' => $course_name,
        'description' => $course_description,
        'fees' => $course_fees,
        'scholarship' => $course_scholarship,
        'installments' => $course_installments,
        'discount' => $course_discount,
        'duration' => $course_duration,
        'onHomepage' => $on_homepage,
    ], "id=%s", $course_id);
    if ($result) {
        // array_push($success, 'You will be redirected to courses page in 5 sec.');
        echo "<script>window.location.replace('./courses.php?s=edit_success'); </script>";
        // echo "<script>
        // setTimeout(function () {    
        //     window.location.href = 'courses.php'; 
        // },5000); // 5 seconds
        // </script>";
    }
}

?>

<!-- End -->
<?php
if (isset($_GET['courseid'])) {
    $course = DB::queryFirstRow("SELECT * FROM courses WHERE id = %s", $_GET['courseid']);
}

if (isset($course)) {
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php
        foreach ($success as $s) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong><?php echo $s ?> </strong>
            </div>
        <?php } ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Course</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <form id="courseform" method="POST" enctype="multipart/form-data">
                    <div class="card card-purple card-outline">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Course Name</label>
                                <input type="text" class="form-control" name="course_name" value="<?php echo $course['name'] ?>" id="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Course Type</label>
                                <input type="text" class="form-control" name="course_type" id="course-type" placeholder="" value="<?php echo $course['type'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Course Duration</label>
                                <select class="custom-select" name="course_duration" id="">
                                    <option selected hidden value="<?php echo $course['duration'] ?>"> <?php echo $course['duration'] ?></option>
                                    <option value="1 Year">1 Year</option>
                                    <option value="3 Months">3 Months</option>
                                    <option value="6 Months">6 Months</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Total Fees</label>
                                <input type="text" class="form-control" name="course_fees" value="<?php echo $course['fees'] ?>" id="" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="">No. Of Installments</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="course_installments" value="<?php echo $course['installments'] ?>" id="exam-date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Discount %</label>
                                <input type="text" class="form-control" name="course_discount" value="<?php echo $course['discount'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Scholorship %</label>
                                <input type="text" class="form-control" name="course_scholarship" value="<?php echo $course['scholarship'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea class="form-control" name="course_description" rows="3"><?php echo $course['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label">
                                    <strong>Display on Homepage </strong>
                                    <input type="checkbox" size="5" class="ml-5 form-check-input" name="on_homepage" value="1" <?php if ($course['onHomepage'] == 1) echo 'checked' ?> style="width:1.5rem;height:1.5rem">
                                </label>
                            </div>
                            <br>
                            <label for="">Course Image</label>
                            <div class="form-group">
                                <img src="/<?php echo $course['image']; ?>" class="img-fluid" alt="Course Image" width="500">
                                <input type=" text" value="/<?php echo $course['image']; ?>" name="old_course_image" hidden>
                            </div>

                            <div class=" form-group">
                                <label for="">Change Image</label>
                                <input type="file" class="form-control-file" accept="image/*" name="course_image">
                            </div>
                        </div>
                        <hr>
                        <div class="m-3 float-right">
                            <!-- TODO Submit this to Database -->
                            <input type="submit" name="submit" class="btn btn-primary float-right" value="Update Course">
                            <a href="courses.php" class="btn btn-default float-right mr-3">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <?php include("includes/scripts.php"); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }

            });
            $.validator.addMethod("requiredSelect", function(element) {
                return ($("select").val() != 'default');
            }, "You must select an option.");
            $("#courseform").validate({
                rules: {
                    course_name: "required",

                    course_type: {
                        required: true,
                    },
                    course_duration: {
                        required: true,
                        requiredSelect: true,
                    },
                    course_fees: {
                        required: true,
                    },
                    course_installments: {
                        required: true,
                        minlength: 1,
                    },
                    course_discount: {
                        required: true,
                    },
                    course_scholarship: {
                        required: true,
                    },
                    firstInstallment: {
                        required: true,
                    },
                   
                    course_image: {
                        required: true,
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
    </body>
<?php  } else {
?>
    <div class="content-wrapper">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>Invalid Course ID</h4>
        </div>
    </div>

    <script>
        $(".alert").alert();
    </script>
<?php  }
?>

</html>