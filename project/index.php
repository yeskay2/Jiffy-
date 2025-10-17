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
    // Debug: Log POST data
    error_log("POST Data: " . print_r($_POST, true));
    
    if(!empty($_POST['logindata'])){
            $email = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';
            error_log("Login attempt for email: " . $email);
            
            if (empty($email) || empty($password)) {
                $_SESSION['errorr'] = 'Please fill in both email and password.';
                header('Location: index.php');
                exit;
            }
            
            try {
                $authenticator->authenticateUser($email, $password);
            } catch (Exception $e) {
                error_log("Authentication error: " . $e->getMessage());
                $_SESSION['errorr'] = 'Login system error. Please try again.';
                header('Location: index.php');
                exit;
            }
    }elseif(!empty($_POST['emailckeack'])){
        $email = $_POST["email1"];
        error_log("Password reset request for email: " . $email);
        $authenticator->authenticateotp($email);
    }elseif(!empty($_POST['otpverfy'])){
        $otp = $_POST["otp"];
        $email = $_SESSION['email'];
        error_log("OTP verification for email: " . $email);
        $authenticator->otpverfy($email,$otp);
    }
    elseif(!empty($_POST['password'])){
       $password =$_POST['password1'];
       $password1 = $_POST['password2'];
        $email = $_SESSION['email'];
        error_log("Password reset for email: " . $email);
        $authenticator->newpassword($email,$password,$password1);
    } else {
        error_log("No matching POST action found");
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
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* Modern Red-themed Login Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Subtle Background Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 20%, rgba(239, 68, 68, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(220, 38, 38, 0.05) 0%, transparent 50%);
            z-index: -1;
        }
        
        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        .modern-login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(220, 38, 38, 0.15),
                        0 15px 35px rgba(239, 68, 68, 0.1),
                        0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.1);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
            position: relative;
        }
        
        .login-header {
            text-align: center;
            padding: 48px 40px 32px;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.15) 50%, transparent 70%);
            animation: shimmer 4s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }
        
        .logo-container {
            margin-bottom: 24px;
            position: relative;
            z-index: 2;
        }
        
        .logo-container img {
            width: 140px;
            height: 140px;
            border-radius: 28px;
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 1);
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            object-fit: contain;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        
        .logo-container:hover img {
            transform: scale(1.08) rotate(1deg);
            box-shadow: 0 20px 50px rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 1);
        }
        
        .login-title {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            color: white;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            letter-spacing: -0.5px;
        }
        
        .login-subtitle {
            margin: 12px 0 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }
        
        .login-body {
            padding: 48px 40px;
            background: white;
        }
        
        .modern-form-group {
            margin-bottom: 28px;
            position: relative;
        }
        
        .modern-input {
            width: 100%;
            padding: 18px 24px;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 400;
            background: #fafbfc;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            color: #1f2937;
        }
        
        .modern-input:focus {
            border-color: #dc2626;
            background: white;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1),
                        0 8px 25px rgba(239, 68, 68, 0.15);
            transform: translateY(-2px);
        }
        
        .modern-input:hover:not(:focus) {
            border-color: #d1d5db;
            background: white;
        }
        
        .modern-label {
            position: absolute;
            left: 24px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            color: #6b7280;
            font-size: 16px;
            font-weight: 400;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .modern-input:focus + .modern-label,
        .modern-input:not(:placeholder-shown) + .modern-label {
            top: -14px;
            left: 20px;
            font-size: 13px;
            font-weight: 500;
            color: #dc2626;
            background: white;
            padding: 0 8px;
        }
        
        .eye-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            color: #9ca3af;
            font-size: 20px;
            transition: all 0.3s ease;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        .eye-icon:hover {
            color: #dc2626;
            background: rgba(220, 38, 38, 0.1);
        }
        
        .modern-btn {
            width: 100%;
            padding: 18px 24px;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        
        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .modern-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(220, 38, 38, 0.4);
        }
        
        .modern-btn:hover::before {
            left: 100%;
        }
        
        .modern-btn:active {
            transform: translateY(-1px);
        }
        
        .forgot-link {
            text-align: center;
            display: block;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .forgot-link:hover {
            color: #dc2626;
            text-decoration: none;
        }
        
        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #dc2626;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .forgot-link:hover::after {
            width: 100%;
        }
        
        .alert-modern {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #dc2626;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }
        
        .alert-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #dc2626;
        }
        
        /* Enhanced Loading Styles */
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #loading-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        
        #loading-center img {
            width: 96px;
            height: 96px;
            border-radius: 24px;
            background: white;
            padding: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: loadingPulse 2s ease-in-out infinite;
        }
        
        @keyframes loadingPulse {
            0%, 100% { 
                transform: scale(1) rotate(0deg);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }
            50% { 
                transform: scale(1.1) rotate(5deg);
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            }
        }
        

        
        /* Responsive Logo Sizing */
        @media (min-width: 1200px) {
            .logo-container img {
                width: 200px;
                height: 110px;
                padding: 1px;
                border-radius: 32px;
            }
        }
        
        @media (max-width: 768px) {
            .logo-container img {
                width: 120px;
                height: 120px;
                padding: 20px;
                border-radius: 24px;
            }
        }
        
        /* Responsive Enhancements */
        @media (max-width: 480px) {
            .modern-login-card {
                margin: 16px;
                border-radius: 20px;
                max-width: calc(100vw - 32px);
            }
            
            .login-header {
                padding: 40px 24px 28px;
            }
            
            .login-body {
                padding: 40px 24px;
            }
            
            .login-title {
                font-size: 28px;
            }
            
            .modern-input {
                padding: 16px 20px;
                font-size: 16px;
            }
            
            .modern-btn {
                padding: 16px 20px;
            }
            
            .logo-container img {
                width: 100px;
                height: 100px;
                padding: 18px;
                border-radius: 20px;
            }
        }
        
        /* Accessibility Improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Focus Visible for Better Accessibility */
        .modern-btn:focus-visible,
        .forgot-link:focus-visible {
            outline: 2px solid #dc2626;
            outline-offset: 2px;
        }
    </style>
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
            <img src="./../assets/images/gem.png" alt="Loading..." class="loading-logo">
        </div>
    </div>
    <!-- loader END -->
    <!--Login Start-->
    <?php if (empty($_GET["login"])) : ?>
        <div class="wrapper">
            <div class="modern-login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="./../assets/images/gem.png" alt="Jiffy Logo">
                    </div>
                    <h1 class="login-title">Welcome Back!</h1>
                    <p class="login-subtitle">Sign in to access your dashboard</p>
                </div>
                
                <div class="login-body">
                    <?php
                    if (isset($_SESSION['errorr'])) {
                        echo "<div class='alert-modern'>
                                <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                              </div>";
                        unset($_SESSION['errorr']);
                    }
                    ?>

                    <form method="POST" action="#" id="loginForm">
                        <div class="modern-form-group">
                            <input class="modern-input" type="email" placeholder=" " name="email" required>
                            <label class="modern-label">Enter your email</label>
                        </div>
                        
                        <div class="modern-form-group">
                            <input class="modern-input" type="password" placeholder=" " name="password" id="password" required>
                            <label class="modern-label">Enter your password</label>
                            <span toggle="#password" class="fa fa-fw fa-eye eye-icon toggle-password"></span>
                        </div>

                        <button type="submit" class="modern-btn" name="logindata" value="Sign In">
                            <span>Login</span>
                        </button>
                        
                        <a href="index.php?login=password" class="forgot-link">Forgot Password?</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- Login end -->
    <?php endif; ?>

    <!-- Forgot Password start -->
    <?php if (isset($_GET['login']) && $_GET['login'] == "password") : ?>
        <div class="wrapper">
            <div class="modern-login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="./../assets/images/gem.png" alt="Jiffy Logo">
                    </div>
                    <h1 class="login-title">Forgot Password?</h1>
                    <p class="login-subtitle">Don't worry, we'll help you reset it</p>
                </div>
                
                <div class="login-body">
                    <?php
                    if (isset($_SESSION['errorr'])) {
                        echo "<div class='alert-modern'>
                                <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                              </div>";
                        unset($_SESSION['errorr']);
                    }
                    ?>

                    <form method="POST" action="#" id="forgotForm">
                        <div class="modern-form-group">
                            <input class="modern-input" type="email" name="email1" placeholder=" " required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter valid email address">
                            <label class="modern-label">Enter your email address</label>
                        </div>

                        <button type="submit" class="modern-btn" name="emailckeack" value="Submit">
                            <span>Send Reset Link</span>
                        </button>
                        
                        <a href="index.php" class="forgot-link">← Back to Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- Forgot password end -->

    <!-- OTP start -->
    <?php if (isset($_GET['login']) && $_GET['login'] == "otp") : ?>
        <div class="wrapper">
            <div class="modern-login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="./../assets/images/gem.png" alt="Jiffy Logo">
                    </div>
                    <?php if(isset($_SESSION['profile_path'])): ?>
                        <div style="margin: 16px 0;">
                            <img src="./../uploads/employee/<?= $_SESSION['profile_path']?>" style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto; display: block; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.2);" alt="user-profile">
                        </div>
                    <?php endif; ?>
                    <h1 class="login-title">Hi <?= isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'There' ?>!</h1>
                    <p class="login-subtitle">We've sent a verification code to your email</p>
                </div>
                
                <div class="login-body">
                    <?php
                    if (isset($_SESSION['errorr'])) {
                        echo "<div class='alert-modern'>
                                <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                              </div>";
                        unset($_SESSION['errorr']);
                    }
                    ?>

                    <form method="post" action="#" id="otpForm">
                        <div class="modern-form-group">
                            <input type="text" class="modern-input" id="otpInput" placeholder=" " maxlength="5" pattern="[0-9]{5}" name="otp" required style="text-align: center; font-size: 24px; letter-spacing: 8px; font-weight: 600;">
                            <label class="modern-label">Enter 5-digit verification code</label>
                        </div>

                        <button type="submit" class="modern-btn" name="otpverfy" value="Reset">
                            <span>Verify & Continue</span>
                        </button>
                        
                        <a href="index.php" class="forgot-link">← Back to Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- OTP end -->

    <!--Reset Start-->
    <?php if (isset($_GET['login']) && $_GET['login'] == "reset") : ?>
        <div class="wrapper">
            <div class="modern-login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="./../assets/images/gem.png" alt="Jiffy Logo">
                    </div>
                    <h1 class="login-title">Create New Password</h1>
                    <p class="login-subtitle">Choose a strong password for your account</p>
                </div>
                
                <div class="login-body">
                    <?php
                    if (isset($_SESSION['errorr'])) {
                        echo "<div class='alert-modern'>
                                <div class='iq-alert-text'>" . $_SESSION['errorr'] . "</div>
                              </div>";
                        unset($_SESSION['errorr']);
                    }
                    ?>

                    <form method="post" action="#">
                        <div class="modern-form-group">
                            <input class="modern-input" type="password" id="newpassword" placeholder=" " required name="password1">
                            <label class="modern-label">New Password</label>
                            <span toggle="#newpassword" class="fa fa-fw fa-eye eye-icon toggle-password toggle-newpassword"></span>
                        </div>

                        <div class="modern-form-group">
                            <input class="modern-input" type="password" id="confirmpassword" placeholder=" " required name="password2">
                            <label class="modern-label">Confirm Password</label>
                            <span toggle="#confirmpassword" class="fa fa-fw fa-eye eye-icon toggle-password toggle-confirmpassword"></span>
                        </div>

                        <button type="submit" class="modern-btn" name="password" value="Submit">
                            Update Password
                        </button>
                        
                        <a href="index.php" class="forgot-link">Back to Sign In</a>
                    </form>
                </div>
            </div>
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
    // Enhanced password toggle with modern animations
    $('.toggle-password').on('click', function() {
        var input = $($(this).attr('toggle'));
        $(this).toggleClass('fa-eye fa-eye-slash');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
    
    // Enhanced loading animation with fade effect
    $(window).on('load', function() {
        setTimeout(function() {
            $('#loading').fadeOut(600, function() {
                $(this).remove();
            });
        }, 800);
    });
    
    // Form submission loading state (non-blocking)
    $('form').on('submit', function(e) {
        var btn = $(this).find('.modern-btn');
        var originalText = btn.find('span').text();
        
        // Don't prevent form submission, just show loading state
        btn.find('span').text('Signing in...');
        
        // Reset after a delay (in case of errors)
        setTimeout(function() {
            btn.find('span').text(originalText);
        }, 5000);
    });
    
    // Input focus animations
    $('.modern-input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        if (!$(this).val()) {
            $(this).parent().removeClass('focused');
        }
    });
    
    // OTP Input auto-formatting
    $('#otpInput').on('input', function() {
        var value = this.value.replace(/[^0-9]/g, '');
        if (value.length <= 5) {
            this.value = value;
        }
    });
    

    
    // Add subtle parallax effect to background
    $(window).on('scroll mousemove', function(e) {
        var x = (e.clientX || window.scrollX) / window.innerWidth;
        var y = (e.clientY || window.scrollY) / window.innerHeight;
        
        $('body::before').css({
            'transform': `translate(${x * 20}px, ${y * 20}px)`
        });
    });
</script>
</body>

</html>