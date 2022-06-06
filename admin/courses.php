<?php require("includes/header.php") ?>
<?php include("includes/menubar.php") ?>
<?php include("includes/sidebar.php") ?>
<?php include("../includes/dbmethods.php") ?>

<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/custom-view/bootstrap-table-custom-view.js"></script>
<!-- Main functionality -->
<?php
$success = [];
function generate_id($course_type)
{

    $str_result = '1234567890';
    $prefix = $course_type[0];
    $courseId = $prefix . strval(substr(str_shuffle($str_result), 0, 5));
    $result = DB::query("SELECT * FROM courses where id =%s", $courseId);
    if ($result) {
        $courseId = generate_id();
    }
    return $courseId;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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
    $firstInstallment = test_input($_POST['firstInstallment']);
    $on_homepage = isset($_POST['on_homepage']) ? 1 : 0;

    $course_id = generate_id($course_type);

    if (isset($_FILES['course_image'])) {
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
            move_uploaded_file($file_tmp, "../uploads/courses/" . $file_name);
        } else {
            print_r($errors);
        }
    }
    $result = DB::insert('courses', [
        'id' => $course_id,
        'name' => $course_name,
        'type' => $course_type,
        'cstatus' => 'Active',
        'onHomepage' => $on_homepage,
        'description' => $course_description,
        'fees' => $course_fees,
        'scholarship' => $course_scholarship,
        'installments' => $course_installments,
        'firstInstallment' => $firstInstallment,
        'discount' => $course_discount,
        'duration' => $course_duration,
        'image' => 'uploads/courses/' . $file_name
    ]);
    if ($result) {
        array_push($success, 'Course added successfully.');
    }
}

?>

<!-- End -->

<!-- Content Wrapper. Ctains page content -->
<div class="content-wrapper">

    <?php if (isset($_GET['s']) && $_GET['s'] == "edit_success") { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Course updated successfully.</strong>
        </div>
    <?php } ?>
    <?php if (isset($_GET['s']) && $_GET['s'] == "delete_success") { ?>
        <div id="delete-alert">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong id="delete-message">Selected course deleted successfully. </strong>
            </div>
        </div>
    <?php } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Courses</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php
    $diploma = DB::queryFirstRow("SELECT count(type) FROM courses  WHERE type=%s AND cstatus=%s", 'Diploma', 'Active');
    $certification = DB::queryFirstRow("SELECT count(type) FROM courses WHERE type=%s AND cstatus=%s", 'Certification', 'Active');

    $dipStud = DB::queryFirstRow("SELECT count(courseType) FROM courses_enrolled  WHERE courseType=%s", 'Diploma');
    $certStud = DB::queryFirstRow("SELECT count(courseType) FROM courses_enrolled WHERE courseType=%s", 'Certification');

    ?>




    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-dark">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Diploma</h3>
                                    <center>
                                        <div class="inner" style="display:inline-block;padding:10px;">
                                            <h1 class="text-center"><?php echo $diploma['count(type)'] ?> </h1>
                                            <h6>Total Courses</h6>
                                        </div>

                                        <div class="inner" style="display:inline-block;padding:10px;">
                                            <h1 class="text-center"><?php echo $dipStud['count(courseType)'] ?></h1>
                                            <h6>Total Students</h6>
                                        </div>
                                    </center>
                                </div>
                                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#add-course" onclick="document.getElementById('course-type').value = 'Diploma'">
                                    Add Diploma Course <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col col-sm-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Certification</h3>
                                    <center>
                                        <div class="inner" style="display:inline-block;padding:10px;">
                                            <h1 class="text-center"><?php echo $certification['count(type)'] ?> </h1>
                                            <h6>Total Courses</h6>
                                        </div>

                                        <div class="inner" style="display:inline-block;padding:10px;">
                                            <h1 class="text-center"><?php echo $certStud['count(courseType)'] ?></h1>
                                            <h6>Total Students</h6>
                                        </div>
                                    </center>
                                </div>
                                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#add-course" onclick="document.getElementById('course-type').value = 'Certification'">
                                    Add Certification Course <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row m-1">
                    <div class="col col-12">
                        <table id="example1" class="" data-toggle="table" data-search="true" sortable="true" data-pagination="true">
                            <thead class="">
                                <tr>
                                    <th data-sortable="true">Course Name</th>
                                    <th data-sortable="true">Course Type</th>
                                    <th data-sortable="true">Duration</th>
                                    <th data-sortable="true">Total Fees</th>
                                    <th data-sortable="true">Installments</th>
                                    <th data-sortable="true">Discount %</th>
                                    <th data-sortable="true">Scholorship %</th>
                                    <th data-sortable="true">On Homepage</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $courses = DB::query("SELECT * FROM courses WHERE cstatus=%s", 'Active');
                                foreach ($courses as $c) { ?>
                                    <tr>
                                        <td><?php echo $c['name'] ?></td>
                                        <td><?php echo $c['type'] ?> </td>
                                        <td><?php echo $c['duration'] ?></td>
                                        <td><?php echo $c['fees'] ?></td>
                                        <td><?php echo $c['installments'] ?></td>
                                        <td><?php echo $c['discount'] ?></td>
                                        <td><?php echo $c['scholarship'] ?></td>
                                        <td><?php echo ($c['onHomepage'] == 1) ? 'Yes' : 'No' ?></td>
                                        <td><a target="_BLANK" href="/<?php echo $c['image'] ?>"><img class="img-fluid" src="/<?php echo $c['image'] ?>" alt="Img" width="50" srcset=""></a></td>
                                        <td>
                                            <!-- Action Dropdown Menu -->
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-outline-info" data-search-align="left" data-toggle="dropdown" href="#">
                                                    Actions
                                                </a>
                                                <div class="dropdown-menu  dropdown-menu-left">
                                                    <a href="edit_course.php?courseid=<?php echo $c['id'] ?>" id="edit-btn" class="dropdown-item pb-0 pt-0" data-href="courses.php?msg=hello" data-target="#add-course">
                                                        <i class="fas fa-pen mr-2"></i> Edit Course
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="courses.php?delete=<?php echo $c['id'] ?>" data-url="courses.php?delete=<?php echo $c['id'] ?>" class="dropdown-item pb-0 pt-0">
                                                        <i class="fas fa-trash mr-2"></i> Delete Course
                                                    </a>
                                                    <!-- <a href="#" data-url="courses.php?delete=<?php echo $c['id'] ?>" data-toggle="modal" data-target="#delete-course" class="delete-menu dropdown-item pb-0 pt-0">
                                                        <i class="fas fa-trash mr-2"></i> Delete Course
                                                    </a> -->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </section>


    <!-- Modal Starts Here -->

    <div class="modal fade" id="add-course">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Course</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="courseform" action="courses.php" method="POST" enctype="multipart/form-data">
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Course Name</label>
                                    <input type="text" class="form-control" name="course_name" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Course Type</label>
                                    <input type="text" class="form-control" name="course_type" id="course-type" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="">Course Duration</label>
                                    <select class="custom-select" name="course_duration">
                                        <option selected hidden value="default">Select one</option>
                                        <option value="12 Months">12 Months</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="6 Months">6 Months</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Total Fees</label>
                                    <input type="text" class="form-control" name="course_fees" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label for="">No. Of Installments</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="course_installments" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Discount %</label>
                                    <input type="text" class="form-control" name="course_discount" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Scholorship %</label>
                                    <input type="text" class="form-control" name="course_scholarship" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">First Installment</label>
                                    <input type="text" class="form-control" name="firstInstallment" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" name="course_description" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-check-label">
                                        <strong>Display on Homepage </strong>
                                        <input type="checkbox" size="5" class="ml-5 form-check-input" name="on_homepage" value="1" style="width:1.5rem;height:1.5rem">
                                    </label>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="">Course Image</label>
                                    <input type="file" class="form-control-file" accept="image/*" name="course_image" aria-describedby="fileHelpId">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <!-- TODO Submit this to Database -->
                            <input type="submit" class="btn btn-primary" name="submit" value="Add Course">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal Ends Here -->
</div>

<div class="modal fade" id="delete-course">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger text-bold">Are you sure?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <strong>This will delete all the details in the course.</strong>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No, Cancel</button>
                <button type="button" id="course-delete-btn" data-dismiss="modal" class="btn btn-danger">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>



<?php include("includes/scripts.php"); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script type="text/javascript">
    //this will show modal on page load if there is delete parameter in url
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    $(window).on('load', function() {
        if (urlParams.has('delete')) {
            $('#delete-course').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }
    });

    $('#course-delete-btn').on('click', function() {
        $.get("api.php", {
            delete: urlParams.get('delete')
        }, function(data) {
            if (data == true)
                window.location.replace("./courses.php?s=delete_success");
        });
    })
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
        },
        submitHandeler: function(form) {
            form.submit()
        }
    })

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>

</html>