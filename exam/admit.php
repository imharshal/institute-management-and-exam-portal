<?php
include("../includes/dbmethods.php");

session_start();
if (isset($_SESSION['submitted'])) {
    unset($_SESSION['submitted']);
}


$user = $exam = $allowedStudents = $errors = $exam = $examiner = [];
$url = '';
$examid;
//function to get data from database
function get_data_from_database($examid)
{
    global $exam, $allowedStudents;
    global $examiner;
    $exam = DB::queryFirstRow("SELECT id,status,students,loginRestrictTime FROM exams WHERE id=%s", $examid);
    DB::disconnect();
    // $examiner = DB::queryFirstRow("SELECT name FROM usrregistration WHERE registraionId=%s", $studentid);
}
//Function to verify inputs
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirect_to_exam()
{
    global $allowedStudents, $exam, $errors;
    get_data_from_database($_GET['e']);

    $allowedStudents = explode(",", $exam['students']);
    $alreadyGiven = DB::queryFirstRow("SELECT id FROM exam_report WHERE examId=%s and studentId=%s", $exam['id'], $_SESSION['student']);
    if (isset($alreadyGiven))
        array_push($errors, 'You have already submitted exam. Re-attempt is not allowed');
    //check if login restrict time pass
    $login_allowed = (date("Y-m-d H:i:s") < $exam['loginRestrictTime']) ? true : false;
    if (in_array($_SESSION['student'], $allowedStudents) && $exam['status'] == 'Active' && !isset($alreadyGiven) && $login_allowed) {
        header('location:./instructions.php?e=' . $exam['id']);
    } else {
        $GLOBALS['NOT_ALLOWED'] = true;
    }
}
if (isset($_GET)) {
    global $exam, $examid;
    $examid = $_GET['e']; //examid
    // $rollno = $_GET['r']; //rollno
    if (isset($_SESSION['examid'])) unset($_SESSION['examid']);
    if (isset($_SESSION['student'])) {
        redirect_to_exam();
    }
    $exam = DB::queryFirstRow("SELECT status,id  FROM exams WHERE id=%s", $examid);
    DB::disconnect();
    // check if users already logged in 
    if (isset($_GET['logout'])) {
        // unset($_SESSION["logged_in"]);
        unset($_SESSION["student"]);
        $errors = [];
        header("location:./admit.php?e=" . $examid);
    }
}


// $username = '';
if (!empty($_POST['username']) && isset($_POST['submit'])) {
    global $errors;
    get_data_from_database($examid);
    // global $username;
    // $errors = array();
    // echo "<h1>inside Post</h1>";
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    if (empty($username) == true or empty($password) == true) {
        array_push($errors, 'Username/Password field is required');
    } else {

        // global $username;
        //check if username exists 
        $exist = DB::queryFirstRow("SELECT * FROM usrregistration WHERE username = %s", $username);

        if ($exist) {
            // check username and password
            $password = md5($password);
            $user = DB::queryFirstRow("SELECT * FROM usrregistration WHERE username = %s AND password = %s ", $username, $password);
            DB::disconnect();
            if (!empty($user)) {
                global $exam;
                // $_SESSION['logged_in'] = true;
                // $_SESSION['user'] = $user;
                $_SESSION['student'] = $user['registrationId'];
                // array_push($errors, 'Username doesn\'t exists');
                if (isset($_SESSION['examid']))
                    $_SESSION['examid'] = $exam['id'];
                if ($exam['status'] == 'Active')
                    redirect_to_exam();
                else
                    array_push($errors, 'Exam is not active. Kindly contact examiner for more details.');
            } else {
                array_push($errors, ' Username/Password combination is incorrect');
            }
        } else {
            array_push($errors, 'Username doesn\'t exists.');
        }
    }

    // echo $errors;
}

?>

<!DOCTYPE html>

<head>
    <title>Exam Login</title>
    <!-- meta-tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- //meta-tags -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" /> -->
    <link href="../css/style1.css" rel="stylesheet" type="text/css" media="all" />
    <!-- font-awesome -->
    <link href="../css/font-awesome.css" rel="stylesheet">

    <!-- fonts -->
    <!-- <link href="fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> -->
</head>

<body>
    <!-- header -->
    <div class="register-form-main pt-3">
        <!-- <div class="row" style="background-color: blue;height:40px"></div> -->
        <div class="container">
            <?php
            if (isset($GLOBALS['NOT_ALLOWED'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>You are not allowed to give exam. Please contact your examiner for more details.</strong>
                </div>
            <?php } ?>
            <?php
            if ($errors) { ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong><?php foreach ($errors as $e) echo $e . "</br>" ?></strong>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['student']) && isset($_SESSION['logged_in'])) { ?>
                <h4 class="card-title">Logged is as:</h4>
                <div class="card text-left">
                    <div class="card-body m-3">
                        <span class="card-text h5 ">
                            <?php
                            $examiner = DB::queryFirstRow("SELECT name FROM usrregistration WHERE registrationId=%s", $_SESSION['student']);
                            echo $examiner['name'] ?>
                        </span>
                        <a class="btn btn-warning float-right" href="./admit.php?e=<?php echo $examid ?>&logout" role="button">Logout</a>
                        <a class="btn btn-secondary mr-5 float-right" href="../students/" role="button">Go to Dashboard</a>

                    </div>
                </div>

            <?php } else { ?>
                <div class="title-div">
                    <h3 class="tittle">
                        <span>E</span>xam
                        <span>L</span>ogin
                    </h3>
                    <div class="tittle-style">

                    </div>
                </div>
                <div class="login-form">
                    <form method="post">
                        <div class="">
                            <p>User Name </p>
                            <input type="text" class="name" name="username" required="" />
                        </div>
                        <div class="">
                            <p>Password</p>
                            <input type="password" class="password" name="password" required="" />
                        </div>

                        <div class="login-agileits-bottom wthree">
                            <h6>
                                <a href="#">Forgot password?</a>
                            </h6>
                        </div>
                        <input type="submit" name="submit" value="Login">

                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

</html>