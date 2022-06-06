<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login</title>
    <!-- meta-tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- //meta-tags -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/style1.css" rel="stylesheet" type="text/css" media="all" />
    <!-- font-awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
</head>

<body>
    <?php
    include("includes/db_config.php");

    session_start();


    $tablename = "";
    $url = '';
    $sqluser = '';
    $sql = '';

    if (isset($_GET['x_token'])) {
        $_SESSION['x_token'] = $_GET['x_token'];
    }
    if (isset($_GET['user'])) {
        $usr = $_GET['user'];
        $user = strval($usr);
        if ($user == 'admin') {
            $tablename = "admin";
            $url = "./admin/";
        }
        if ($user == 'student') {
            // if (isset($_GET['x_token']) && isset($_GET['user']))
            //     $url = "./students/admission.php?x_token=" . $_GET['x_token'];
            // else
            $url = "./students/";
            $tablename = "usrregistration";
        }
        if ($user == 'employee') {
            $url = "./employees/";
            $tablename = "usrregistration";
        }
        // check if users already logged in 
        if (isset($_SESSION)) {
            switch ($_GET['user']) {
                case 'admin':
                    if (isset($_SESSION['admin']))
                        header('location:./admin/');
                    break;
                case 'student':
                    if (isset($_SESSION['student']) && isset($_SESSION['x_token']))
                        header('location:./students/admission.php?x_token=' . $_SESSION['x_token']);
                    elseif (isset($_SESSION['student']))
                        header('location:./students/');
                    break;
                case 'employee':
                    if (isset($_SESSION['employee']))
                        header('location:./employees/');
                    break;
            }
        }

        if (!empty($_POST) && isset($_POST['submit'])) {
            $errors = array();
            // echo "<h1>inside Post</h1>";
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (empty($username) == true or empty($password) == true) {
                array_push($errors, 'Username/Password field is required');
            } else {
                // if username exists
                // $sqluser = "SELECT * FROM $user WHERE username = '$username'";
                // $sql = "SELECT * FROM $user WHERE username = '$username' AND password = '$password'";
                // $user = strval($user);

                $sql = "SELECT * FROM " . $tablename . " WHERE username = '$username'";
                $query = $connect->query($sql);

                if ($query &&  $query->num_rows > 0) {
                    // check username and password
                    $password = md5($password);

                    $sql = "SELECT * FROM " . $tablename . " WHERE username = '$username' AND password = '$password'";
                    $query = $connect->query($sql);
                    $result = $query->fetch_array();

                    $connect->close();

                    if ($query->num_rows == 1) {

                        $_SESSION['logged_in'] = true;
                        // $_SESSION['user'] = $user;
                        $_SESSION[$user] = $result['registrationId'];
                        // echo $_SESSION['user'];

                        header("location:$url");
                        // exit();
                    } else {
                        array_push($errors, ' Username/Password combination is incorrect');
                    }
                } else {
                    array_push($errors, 'Username doesn\'t exists');
                }
            }

            // echo $errors;
        }

    ?>


        <!-- header -->

        <div class="login-form-main pt-3">
            <div class="container">
                <?php if (isset($errors)) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong><?php foreach ($errors as $e) echo $e . "</br>" ?></strong>
                    </div>
                <?php  } ?>
                <div class="title-div">
                    <h3 class="tittle">
                        <span>L</span>ogin
                        <span>F</span>orm
                    </h3>
                    <div class="tittle-style">

                    </div>
                </div>
                <!-- <div class="login-form"> -->
                <form method="post" class="login-form">
                    <div class="">
                        <p>User Name </p>
                        <input type="text" class="name" name="username" required="" />
                    </div>
                    <div class="">
                        <p>Password</p>
                        <input type="password" class="password" name="password" required="" />
                    </div>
                    <!-- <label class="anim">
                        <input type="checkbox" class="checkbox">
                        <span> Remember me ?</span>
                    </label> -->
                    <?php if (!($_GET['user'] == 'admin')) { ?>
                        <div class="login-agileits-bottom wthree">
                            <h6>
                                <a href="#">Forgot password?</a>
                            </h6>
                        </div>
                    <?php } ?>

                    <input type="submit" name="submit" value="Login">

                    <?php if (!($_GET['user'] == 'admin')) { ?>
                        <div class="register-forming">
                            <p>Don't have an account ? --
                                <a href="register.php">Create new</a>
                            </p>
                        </div>
                    <?php } ?>
                </form>
                <!-- </div> -->

            </div>
        </div>
    <?php } elseif (!isset($_GET['user']) or !isset($_POST['user'])) { ?>
        <!-- <div class="row m-md-5">
        <div class="offset-md-3">
            <div class="card col-md-7" style="background-color: skyblue;">
                <div class="card-body ">
                   <h2>Student Login</h2>
                </div>
            </div>
        </div>
    </div> -->
        <div class="container">
            <div class="row">
                <div class="col offset-md-4" style="margin-top:20%">
                    <div class="card col-md-6" style="background-color: skyblue;">
                        <a href="./login.php?user=student" style="color:aliceblue">
                            <div class="card-body ">
                                <h2 class="text-center">Student Login</h2>

                            </div>
                        </a>
                    </div>
                    <div class="card col-md-6 mt-5" style="background-color: skyblue;">
                        <a href="./login.php?user=employee" style="color:aliceblue">
                            <div class="card-body ">
                                <h2 class="text-center">Employee Login</h2>

                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    <?php } ?>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>