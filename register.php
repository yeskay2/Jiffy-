<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JIFFY</title>
    <link href="assets2/css/login.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper" id="login-form" action="login.php">
        <div class="logo">
            <img src="./../assets/images/Jiffy-favicon.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            JIFFY
            <p>Transforming Time into Value</p>
        </div>
        <form class="p-3 mt-3">
            <p>Create your account</p>

            <div class="form-field d-flex align-items-center">
                <input type="text" name="name" id="name" placeholder="Enter your full name" required pattern="[A-Za-z\s]+">
            </div>

            <div class="form-field d-flex align-items-center">
                <input type="text" name="organisation" id="organisation" placeholder="Enter your organisation name" required pattern="[A-Za-z\s]+">
            </div>

            <div class="form-field d-flex align-items-center">
                <input type="text" name="contactno" id="contactno" maxlength="10" placeholder="Enter your contact number" required pattern="[0-9]{10}" title="Enter numbers only">
            </div>

            <div class="form-field d-flex align-items-center">
                <input type="email" name="mailid" id="mailid" placeholder="Enter your email" required>
            </div>

            <div class="form-field d-flex align-items-center">
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <button class="btn mt-3">Register</button>
        </form>

    </div>

    <script>
        // Function to validate email address
        function isValidEmail(email) {
            // You can implement a more robust email validation here
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        // Function to validate the form
        function validateForm() {
            const nameInput = document.getElementById('name');
            const organisationInput = document.getElementById('organisation');
            const contactnoInput = document.getElementById('contactno');
            const mailidInput = document.getElementById('mailid');
            const passwordInput = document.getElementById('password');

            // Add your validation logic here
            if (!isValidEmail(mailidInput.value)) {
                alert('Please enter a valid email address.');
                return false;
            }
            // You can add more validation rules as needed

            return true;
        }

        // Event listener for form submission
        const registrationForm = document.getElementById('registration-form');
        registrationForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
            if (validateForm()) {
                // If the form is valid, redirect to login.php
                window.location.href = 'login.php';
            }
        });
    </script>

</body>

</html>