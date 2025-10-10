<?php
session_start();
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $company = $_POST["company"];
    $country = $_POST["country"];
    $bookdate = (new DateTime($_POST["bookdate"]))->format('d-m-Y');
    $booktime = date("h:i A", strtotime($_POST["booktime"]));
    $mailer = new PHPMailer(true);
    $error_message = "";

    try {
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'jiffymine@gmail.com';
        $mailer->Password = 'holxypcuvuwbhylj';
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;
        $mailer->setFrom('jayam4413@gmail.com', $name);
        $recipients = [
            ['email' => 'nishar.mine@gmail.com', 'name' => $name],
            ['email' => 'akshathasg.mine@gmail.com', 'name' => 'Recipient 2'],
            ['email' => 'cdaniel.mine@gmail.com', 'name' => 'Recipient 3'],
            ['email' => 'anusiya.mine@gmail.com', 'name' => 'Recipient 4'],
            ['email' => 'jayamani.mine@gmail.com', 'name' => 'Recipient 5'],
        ];
        foreach ($recipients as $recipient) {
            $mailer->addAddress($recipient['email'], $recipient['name']);
        }
        $recipients = 'jayamani.mine@gmail.com';
        $jiffy_full_name = 'Jiffy Team';

        $mailer->addAddress($recipients, $jiffy_full_name);
        $jiffy_subject = 'New Client Demo Request for Jiffy Product: ' . $name;
        $mailer->Subject = $jiffy_subject;

        $jiffy_message = "<html>
                            <head>
                                <title>New  Client Demo Request</title>
                            </head>
                               <body style=\"font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;\">
    <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"background-color: #ffffff; max-width: 600px; margin: 0 auto; border-collapse: collapse;\">
        <tr>
            <td style=\"padding: 20px 0; text-align: center; background-color: #007BFF;\">
                <h1 style=\"color: #fff;\">Jiffy Product - New Client Demo Request</h1>
            </td>
        </tr>
        <tr>
            <td style=\"padding: 20px;\">
                <h2>Dear Jiffy Team,</h2>
                <p>You have received a new client request for the Jiffy product with the following details:</p>
                <ul>
                    <li><strong>Name:</strong> $name</li>
                    <li><strong>Email:</strong> $email</li>
                    <li><strong>Contact Number:</strong> $number</li>
                    <li><strong>Company:</strong> $company</li>
                    <li><strong>Country:</strong> $country</li>                    
                    <li><strong>bookdate:</strong> $bookdate</li>
                    <li><strong>booktime:</strong> $booktime</li>
                </ul>
                <p>Please contact the client with the above details.</p>
                <p>Thank you for your attention!</p>
                <p>Sincerely,<br>Your Jiffy Team</p>
            </td>
        </tr>
        <tr>
            <td style=\"padding: 20px; text-align: center; background-color: #007BFF;\">
                <p style=\"color: #fff; margin: 0;\">&copy; " . date("Y") . " Jiffy Product</p>
            </td>
        </tr>
    </table>
</body>
</html>";

        $mailer->Body = $jiffy_message;
        $mailer->isHTML(true);

        $sent = $mailer->send();

        $sent = true;

        if ($sent) {
            echo '<script>';
            echo 'alert("Thank you for your demo booking! Our Jiffy team will contact you as soon as possible.");';
            echo 'window.location.href = "demo.php";';
            echo '</script>';
            exit();
        } else {
            error_log("Email sending failed: New Client Request for Jiffy Product - Name: $name, Email: $email, Contact Number: $number");
            $error_message = "Error: Unable to send your message. Please try again later.";
        }
    } catch (Exception $e) {
        error_log("Exception occurred: " . $e->getMessage());
        $error_message = "Error: Unable to send your message. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>JIFFY | Book your demo</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets2/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets2/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets2/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets2/css/demo.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            overflow-x: hidden;
        }

        .book {
            font-weight: 900;
            font-size: 40px;
            font-family: Playfair Display semi bold;
            margin-bottom: 20px;
            text-align: center;
            padding-left: 130px;
            width: 90%;
            color: transparent;
            background-image: linear-gradient(to right, #553c9a, #3d3399, #d03d87, #d276a4, #bc2d75);
            -webkit-background-clip: text;
            background-clip: text;
            background-size: 200%;
            background-position: -200%;
            animation: animated-gradient 5s infinite alternate-reverse;
        }

        .month {
            cursor: pointer;
        }

        .events-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .form-container {
            text-align: center;
        }

        .card {
            cursor: pointer;
            width: 65%;
        }

        .dialog-header {
            color: #012970;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 10px;
            font-family: Montserrat Bold;
            margin: 30px;
        }

        .card:not(.selected-card):hover,
        .card:not(.selected-card):focus {
            border: 2px solid #c72f2e;
        }

        .selected-card {
            background-color: #3d3399;
            color: #fff;
            border: none;
        }

        #submit-button {
            display: block;
            position: absolute;
            right: 20px;
            bottom: 20px;
        }

        .checkbox-group {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .checkbox-container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 16px;
            user-select: none;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #eee;
            border-radius: 4px;
        }

        .checkbox-container:hover input~.checkmark {
            background-color: #ccc;
        }

        .checkbox-container input:checked~.checkmark {
            background-color: #c72f2e;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .checkbox-container input:checked~.checkmark:after {
            display: block;
        }

        .checkbox-container .checkmark:after {
            left: 8px;
            top: 4px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
    </style>

<body>
    <!--=======Header=======-->
    <?php include './include/header.php'; ?>
    <!-- End Header -->

    <!--=======Blog Single Section=======-->
    <div class="container" style="margin-top: 120px !important;" data-aos="fade-up">
        <h4 class="book text-center">Book your demo now !</h4>
    </div>
    <div class="row" data-aos="fade-up" id="slotForm">
        <div class="col-md-12">
            <div class="content w-100">
                <div class="calendar-container">
                    <div class="calendar">
                        <div class="year-header">
                            <span class="left-button fa fa-chevron-left" id="prev"></span>
                            <span class="year" id="label"></span>
                            <span class="right-button fa fa-chevron-right" id="next"></span>
                        </div>
                        <table class="months-table w-100">
                            <tbody>
                                <tr class="months-row">
                                    <td class="month">Jan</td>
                                    <td class="month">Feb</td>
                                    <td class="month">Mar</td>
                                    <td class="month">Apr</td>
                                    <td class="month">May</td>
                                    <td class="month">Jun</td>
                                    <td class="month">Jul</td>
                                    <td class="month">Aug</td>
                                    <td class="month">Sep</td>
                                    <td class="month">Oct</td>
                                    <td class="month">Nov</td>
                                    <td class="month">Dec</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="days-table w-100">
                            <td class="day">Sun</td>
                            <td class="day">Mon</td>
                            <td class="day">Tue</td>
                            <td class="day">Wed</td>
                            <td class="day">Thu</td>
                            <td class="day">Fri</td>
                            <td class="day">Sat</td>
                        </table>
                        <div class="frame">
                            <table class="dates-table w-100">
                                <tbody class="tbody">
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="events-container" style="background-color: #fff;"></div>

                <button class="button" id="add-button">Book</button>

                <div class="dialog" id="dialog">
                    <h2 class="dialog-header">Book 30 Minutes</h2>
                    <div class="card-container" style="display:flex; flex-direction:column; align-items:center; max-height: 300px; overflow-y: auto;">
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                10:00 AM - 10:30 AM
                            </div>
                        </div>
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                10:30 AM - 11:00 AM
                            </div>
                        </div>
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                11:00 AM - 11:30 AM
                            </div>
                        </div>
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                11:30 AM - 12:00 AM
                            </div>
                        </div>
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                12:00 PM - 12:30 PM
                            </div>
                        </div>
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                12:30 PM - 01:00 PM
                            </div>
                        </div>

                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                01:00 PM - 01:30 PM
                            </div>
                        </div>
                        <div class="card shadow mb-4" onclick="selectCard(this)">
                            <div class="card-body text-center fw-bold" style="padding: 12px;">
                                01:30 PM - 02:00 PM
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 20px; width: 100%; text-align: center;">
                        <input type="button" value="Cancel" class="button" id="cancel-button">
                        <input type="button" value="Next" class="button button-white" id="next-button" onclick="formnext();">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final form -->
    <div class="row" data-aos="fade-up" id="finalForm" style="display: none;">
        <div class="col-lg-12">
            <div class="finalForm w-100">
                <div class="final-container col-lg-4">
                    <p class="mb-3"><a href="#"><i class="bi bi-arrow-left-circle-fill" style="font-size: 30px;"></i></a></p>
                    <h6 class="fw-bold">Meet Our Team</h6>
                    <h2 class="fw-bold">JIFFY</h2>
                    <div class="contents mt-2"><br>
                        <h6><i class="bi bi-clock mr-2" style="font-size: 18px;"></i><span class="fw-bold" style="font-size: 15px;">11:00 AM - 11:30 AM</span></h6><br>
                        <h6><i class="bi bi-calendar mt-2 mr-2" style="font-size: 18px;"></i><span class="fw-bold" style="font-size: 15px;">Saturday, June 1, 2024</span></h6><br>
                        <h6><i class="bi bi-globe-americas mt-2 mr-2" style="font-size: 18px;"></i><span class="fw-bold" style="font-size: 15px;">Indian Standard Time</span></h6><br>
                        <p class="text-justify" style="font-size: 15px;">After submitting the form you will receive a web meeting invite</p>
                    </div>
                </div>

                <div class="events-container col-lg-8" style="background-color: #fff;"></div>
                <div class="detailsForm col-lg-8" id="detailsForm">
                    <h2 class="dialog-header">Enter Details</h2>
                    <div class="card-container align-items-center justify-content-center" style="max-height: 300px; overflow-y:auto;">
                        <label class="form-label" id="valueFromMyButton" for="name">Enter Name</label>
                        <input class="input" type="text" id="name" maxlength="36">
                        <label class="form-label" id="valueFromMyButton" for="count">Enter Email</label>
                        <input class="input" type="text" id="count" min="0" maxlength="7">
                        <label class="form-label" id="valueFromMyButton" for="count">Enter Contact Number</label>
                        <input class="input" type="number" id="count" min="10" maxlength="10">
                        <label style="margin-top: 20px;" class="form-label" id="valueFromMyButton" for="count">Select Module</label>
                        <label class="checkbox-container">Management
                            <input type="checkbox" name="module" value="Management">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Accounts
                            <input type="checkbox" name="module" value="Accounts">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">HR
                            <input type="checkbox" name="module" value="HR">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Sales
                            <input type="checkbox" name="module" value="Sales">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Project Manager
                            <input type="checkbox" name="module" value="Project Manager">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Team Lead
                            <input type="checkbox" name="module" value="Team Lead">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Employee
                            <input type="checkbox" name="module" value="Employee">
                            <span class="checkmark"></span>
                        </label>
                        <input type="button" value="Schedule" class="button" id="submit-button">
                    </div>
                    <div class="vertical-line"></div>
                </div>
            </div>
        </div>

        <!-- End Form -->
    </div>
    <!-- End #main -->

    <!--=======Footer=======-->
    <?php include './include/footer.php'; ?>
    <!-- End Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="assets2/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets2/vendor/aos/aos.js"></script>
    <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets2/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets2/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets2/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets2/vendor/php-email-form/validate.js"></script>
    <script src="assets2/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets2/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function selectCard(card) {
            card.classList.toggle('selected-card');
        }

        function formnext() {
            document.getElementById('slotForm').style.display = 'none';
            document.getElementById('add-button').style.display = 'none';
            document.getElementById('finalForm').style.display = 'block';
        }
    </script>

</body>

</html>