<?php
include "./../include/config.php";
require_once("./loginverify.php");
date_default_timezone_set('Asia/Kolkata');

error_reporting(E_ALL);
ini_set('display_errors', 1);
$date = date("d-m-Y");

if (isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])) {
    $_SESSION["user_id"] = base64_decode($_COOKIE['user_id']);
    $sql = "SELECT * FROM employee WHERE id ='{$_SESSION["user_id"]}'   AND active = 'active' AND status != 'Offline' AND FIND_IN_SET('Employee', Allpannel)";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $row = mysqli_fetch_assoc($result);
        if($row) {
            $email = $row['email'];
            $existingAttendanceQuery = "SELECT * FROM attendance WHERE employee_id = '$email' AND date = '$date'";
            $result = mysqli_query($conn,$existingAttendanceQuery);
            if ($result && mysqli_num_rows($result) > 0) {
                header('Location: dashboard.php');
                exit;
            }
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!empty($_POST['logindata'])){
            $email = $_POST["email"];
            $password = $_POST["password"];                        
            $authenticator->authenticateUser($email, $password);
    }elseif(!empty($_POST['emailckeack'])){
        $email = $_POST["email1"];
        $authenticator->authenticateotp($email);
    }elseif(!empty($_POST['otpverfy'])){
        $otp = $_POST["otp"];
        $email = $_SESSION['email'];
        $authenticator->otpverfy($email,$otp);
    }
    elseif(!empty($_POST['password'])){
       $password =$_POST['password1'];
       $password1 = $_POST['password2'];
        $email = $_SESSION['email'];
        $authenticator->newpassword($email,$password,$password1);
    }

}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GGS | Thalam</title>
    <!-- Favicon -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">

    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        .eye-icon {
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            color: black;
        }
    </style>
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!--Login Start-->
    <?php if (empty($_GET["login"])) : ?>
        <div class="wrapper">
            <section class="login-content">
                <div class="container">
                    <div class="row align-items-center justify-content-center height-self-center">
                        <div class="col-lg-8">
                            <div class="card auth-card">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center auth-content">
                                        <div class="col-lg-6 bg-primary content-left">
                                            <div class="p-3">
                                                <img src="./../assets/images/Jiffy-logo2.png" alt="Image description" class="img-fluid mb-3">
                                                <h2 class="mb-2 text-white text-center">Sign In</h2>
                                                <p class="text-center">Login to stay connected.</p>

                                                <?php
                                                if (isset($_SESSION['errorr'])) {
                                                    echo "<div class='alert text-white bg-warning' role='alert'>
                                                         <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                            <i class='ri-close-line'></i>
                                                         </button>
                                                   </div>";
                                                    unset($_SESSION['errorr']);
                                                }
                                                ?>

                                                <form method="POST" action="#" name="logindata">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="floating-label form-group">
                                                                <input class="floating-input form-control" type="email" placeholder=" " name="email" required>
                                                                <label>Email</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="floating-label form-group">
                                                                <input class="floating-input form-control" type="password" placeholder=" " name="password" id="password" required>
                                                                <label for="password">Password</label>
                                                                <span toggle="#password" class="fa fa-fw fa-eye eye-icon toggle-password"></span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 d-flex">
                                                            <div class="col-lg-6">
                                                                <input type="submit" class="custom-btn btn-3 text-center" name="logindata" value="Sign In">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a href="index.php?login=password" class="text-white float-right mt-1">Forgot Password?</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 content-right">
                                            <img src="./../assets/images/login/login-img2.png" class="img-fluid image-right" alt="Loginimage">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Login end -->
    <?php endif; ?>

    <!-- Forgot Password start -->
    <?php if (isset($_GET['login']) && $_GET['login'] == "password") : ?>
        <div class="wrapper">
            <section class="login-content">
                <div class="container">
                    <div class="row align-items-center justify-content-center height-self-center">
                        <div class="col-lg-8">
                            <div class="card auth-card">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center auth-content">
                                        <div class="col-lg-6 bg-primary content-left">
                                            <div class="p-3">
                                                <img src="./../assets/images/Jiffy-logo2.png" alt="Image description" class="img-fluid mb-3">
                                                <h2 class="mb-2 text-white">Forgot Password</h2>
                                                <p>Kindly provide your email address to proceed with the password reset process.</p>
                                                  <?php
                                                if (isset($_SESSION['errorr'])) {
                                                    echo "<div class='alert text-white bg-warning' role='alert'>
                                                         <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                            <i class='ri-close-line'></i>
                                                         </button>
                                                   </div>";
                                                    unset($_SESSION['errorr']);
                                                }
                                                ?>
                                                <form method="POST" action="#" name="emailckeack">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="floating-label form-group">
                                                                <input class="floating-input form-control" type="email" name="email1" placeholder=" " required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter valid email address">
                                                                <label>Email</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="custom-btn btn-3 text-center"  value="Submit" name="emailckeack"> 
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 content-right">
                                            <img src="../assets/images/login/01.png" class="img-fluid image-right" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
    <!-- Forgot password end -->

    <!-- OTP start -->
    <?php if (isset($_GET['login']) && $_GET['login'] == "otp") : ?>
        <div class="wrapper">
            <section class="login-content">
                <div class="container">
                    <div class="row align-items-center justify-content-center height-self-center">
                        <div class="col-lg-8">
                            <div class="card auth-card">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center auth-content">
                                        <div class="col-lg-6 bg-primary content-left">
                                            <div class="p-3">
                                                <img src="./../assets/images/Jiffy-logo2.png" alt="Image description" class="img-fluid mb-3">
                                                <img src="./../uploads/employee/<?= $_SESSION['profile_path']?>" class="rounded avatar-80 mb-3" alt="user-img">
                                                <h2 class="mb-2 text-white">Hi ! <?=$_SESSION['full_name']?></h2>
                                                <p>Enter OTP to reset the password.</p>
                                                  <?php
                                                if (isset($_SESSION['errorr'])) {
                                                    echo "<div class='alert text-white bg-warning' role='alert'>
                                                         <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                            <i class='ri-close-line'></i>
                                                         </button>
                                                   </div>";
                                                    unset($_SESSION['errorr']);
                                                }
                                                ?>
                                                <form method="post" action="#" name="otpverfy">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="floating-label form-group">
                                                                <input type="text" class="floating-input form-control" id="otpInput" placeholder=" " maxlength="5" pattern="[0-9]{5}" name="otp" required>
                                                                <label>OTP</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="custom-btn btn-3 text-center" value="Reset" name="otpverfy">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 content-right">
                                            <img src="../assets/images/login/01.png" class="img-fluid image-right" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
    <!-- OTP end -->

    <!--Reset Start-->
    <?php if (isset($_GET['login']) && $_GET['login'] == "reset") : ?>
        <div class="wrapper">
            <section class="login-content">
                <div class="container">
                    <div class="row align-items-center justify-content-center height-self-center">
                        <div class="col-lg-8">
                            <div class="card auth-card">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center auth-content">
                                        <div class="col-lg-6 bg-primary content-left">
                                            <div class="p-3">
                                                <img src="./../assets/images/Jiffy-logo2.png" alt="Image description" class="img-fluid mb-3">
                                                <h2 class="mb-2 text-white">Reset Password</h2>
                                                <p>Set a new password for your account.</p>
                                                  <?php
                                                if (isset($_SESSION['errorr'])) {
                                                    echo "<div class='alert text-white bg-warning' role='alert'>
                                                         <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                            <i class='ri-close-line'></i>
                                                         </button>
                                                   </div>";
                                                    unset($_SESSION['errorr']);
                                                }
                                                ?>
                                                <form method="post" action="#" name="password">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="floating-label form-group">
                                                                <input class="floating-input form-control" type="password" id="newpassword" placeholder=" " required name="password1">
                                                                <label for="newpassword">New Password</label>
                                                                <span toggle="#newpassword" class="fa fa-fw fa-eye eye-icon toggle-password toggle-newpassword"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="floating-label form-group">
                                                                <input class="floating-input form-control" type="password" id="confirmpassword" placeholder=" " required name="password2">
                                                                <label for="confirmpassword">Confirm Password</label>
                                                                <span toggle="#confirmpassword" class="fa fa-fw fa-eye eye-icon toggle-password toggle-confirmpassword"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="submit" class="custom-btn btn-3 text-center" value="Submit" name="password">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 content-right">
                                            <img src="../assets/images/login/01.png" class="img-fluid image-right" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
    <!--Reset End-->

    <!-- Backend Bundle JavaScript -->
    <script src="./../assets/js/backend-bundle.min.js"></script>
    <!-- Table Treeview JavaScript -->
    <script src="./../assets/js/table-treeview.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="./../assets/js/customizer.js"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="./../assets/js/chart-custom.js"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="./../assets/js/slider.js"></script>
    <!-- app JavaScript -->
    <script src="./../assets/js/app.js"></script>
    <script src="./../assets/vendor/moment.min.js"></script>
    <script>
        const error = "<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>";
        if (error) {
            alert(error);
        }
    </script>
<script>
    $('.toggle-password').on('click', function() {
        var input = $($(this).attr('toggle'));
        $(this).toggleClass('fa-eye fa-eye-slash');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
</script>
</body>

</html>