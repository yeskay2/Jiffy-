<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JIFFY</title>
    <link href="assets2/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets2/css/style.css">
    <link href="assets2/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets2/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper" id="login-form">
        <div class="logo">
            <img src="./../assets/images/Jiffy-favicon.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            JIFFY
            <p>Transforming Time into Value</p>
        </div>
        <form class="p-3 mt-3">
            <p>Log in to pose a query</p>
            <div class="form-field d-flex align-items-center">
                <input type="text" name="displayname" placeholder="Display name" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="userName" id="userName" placeholder="Enter your mail" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="pwd" placeholder="Enter your password" required>
            </div>
            <button class="btn mt-3">Login</button>
        </form>
        <div class="text-center fs-6">
            <a href="#" id="forgot-password-link">Forgot password?</a>
        </div><br>
        <div class="text-center fs-6">
            Don't have an account <br><a href="register.php">Sign Up</a>
        </div>
    </div>

    <div class="wrapper" id="forgot-password-form" style="display: none;">
        <div class="logo">
            <img src="./../assets/images/Jiffy-favicon.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            JIFFY
            <p>Transforming Time into Value</p>
        </div>
        <form class="p-3 mt-3">
            <p>Kindly provide your email ID. We will send your password recovery information to your email.</p>

            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="userName" id="userName2" placeholder="Enter your mail">
            </div>
            <button class="btn mt-3">Submit</button>
        </form>
    </div>

    <div class="confirmation-message" style="display: none;">
        <p class="text-center mt-3" id="confirmation-message">Check your email for further instructions.</p>
    </div>

    <script>
        const loginForm = document.getElementById('login-form');
        const forgotPasswordForm = document.getElementById('forgot-password-form');
        const forgotPasswordLink = document.getElementById('forgot-password-link');
        const confirmationMessage = document.querySelector('.confirmation-message');
        const recoveryForm = document.querySelector('#forgot-password-form form');

        function showAlert(message) {
            alert(message);
        }

        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.style.display = 'none';
            forgotPasswordForm.style.display = 'block';
            confirmationMessage.style.display = 'none';
        });

        recoveryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const confirmationText = document.getElementById('confirmation-message').textContent;
            showAlert(confirmationText);

            window.location.href = 'login.php';
        });
    </script>

</body>

</html>