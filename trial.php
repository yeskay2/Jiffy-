<?php
session_start();
   
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? htmlspecialchars($_POST["name"]) : '';
    $lastname = isset($_POST["lastname"]) ? htmlspecialchars($_POST["lastname"]) : '';
    $email = isset($_POST["email"]) ? filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : '';
    $number = isset($_POST["number"]) ? htmlspecialchars($_POST["number"]) : '';
    $company = isset($_POST["company"]) ? htmlspecialchars($_POST["company"]) : '';
    $country = isset($_POST["country"]) ? htmlspecialchars($_POST["country"]) : '';
    $companyaddress = isset($_POST["companyaddress"]) ? htmlspecialchars($_POST["companyaddress"]) : '';
    $value = isset($_GET["cast"]) ? htmlspecialchars($_GET["cast"]) : '';

    try {
        $sent = sendJiffyEmail($name, $email, $number, $company, $country, $companyaddress, $value);

        if ($sent) {
            echo "<script>
                    alert('Message sent successfully. We will get in touch with you soon.');
                    window.location.href = 'trial.php';
                </script>";
                exit;
        } else {
            $error_message = "Error: Unable to send your message. Please try again later.";
        }
    } catch (Exception $e) {
        error_log("Exception occurred: " . $e->getMessage());
        $error_message = "Error: Unable to send your message. Please try again later.";
    }
}

function sendJiffyEmail($name, $email, $number, $company, $country, $companyaddress, $value)
{


    $mailer = new PHPMailer(true);

    try {
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'jiffymine@gmail.com';
        $mailer->Password = 'holxypcuvuwbhylj';
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;
        $mailer->setFrom('jayam4413@gmail.com', $name);

        $jiffy_email = 'jayamani.mine@gmail.com';
        $jiffy_full_name = 'Jiffy Team';

        $mailer->addAddress($jiffy_email, $jiffy_full_name);
        $jiffy_subject = 'New Client Request for Jiffy Product: ' . $name;
        $mailer->Subject = $jiffy_subject;

        $jiffy_message = "
        <html>
            <head>
                <title>New Client Request</title>
            </head>
            <body style=\"font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;\">
            <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"background-color: #ffffff; max-width: 600px; margin: 0 auto; border-collapse: collapse;\">
            <tr>
                <td style=\"padding: 20px 0; text-align: center; background-color: #007BFF;\">
                    <h1 style=\"color: #fff;\">Jiffy Product - New Client Request</h1>
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
                        <li><strong>Company address:</strong> $companyaddress</li>
                        <li><strong>Plan Cast:</strong>$value</li>
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

        return $sent;
    } catch (Exception $e) {
        error_log("Exception occurred: " . $e->getMessage());
        return false;
    }
}
if (isset($_GET["cast"])) {
    $value = $_GET["cast"];

    if ($value == 0) {
        $title = "Get our free trial";
    } elseif ($value == 500) {
        $title = "Get our Basic Plan";
    } elseif ($value == 1500) {
        $title = "Get our Pro Plan";
    } else {
        $title = "Get our Enterprise Plan";
    }
} else {    
    $title = "Get our free trial";  
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
    <style>
        @media (max-width: 768px) {
            .row>* {
                margin-bottom: 107px;
            }

            .blog .blog-comments .reply-form {
                margin-top: 30%;
            }
        }

        .row>* {
            margin-bottom: 80px;
        }

        .h5 {
            font-size: 15px;
        }

        .mb-3 {
            margin-bottom: 40px !important;
        }

        h4 {
            font-family: Montserrat Bold !important;
            font-size: 30px !important;
            font-weight: 900;
            color: #3d3399;
            text-transform: uppercase;
            word-spacing: 6px;
        }
    </style>

<body>

    <!-- ======= Header ======= -->
    <?php include './include/header.php'; ?>
    <!-- End Header -->
    <main id="main">
        <!-- ======= Blog Single Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div class='modal fade' id='alertMessage' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content justify-content-center align-items-center d-flex'>
                        <div class='modal-body m-3'>
                            <i class='fa fa-exclamation-triangle' style='font-size: 25px; color:red;'></i>
                            <span class='ml-2' style='color: black !important; font-size: 18px; font-weight:bold'>" . $_SESSION['error'] . "</span>
                        </div>
                    </div>
                </div>
            </div>";
                        unset($_SESSION['error']);
                        echo "<script>
                $(document).ready(function(){
                    $('#alertMessage').modal('show');
                    setTimeout(function(){
                        $('#alertMessage').modal('hide');
                    }, 2000);
                });
            </script>";
                    }

                    if (isset($_SESSION['success'])) {
                        echo "<div class='modal fade' id='alertMessage' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content justify-content-center align-items-center d-flex'>
                        <div class='modal-body m-3'>
                            <i class='fa fa-check-circle' style='font-size: 25px; color:green;'></i>
                            <span class='ml-2' style='color: black !important; font-size: 18px; font-weight:bold;'>" . $_SESSION['success'] . "</span>
                        </div>
                    </div>
                </div>
            </div>";
                        unset($_SESSION['success']);
                        echo "<script>
                $(document).ready(function(){
                    $('#alertMessage').modal('show');
                    setTimeout(function(){
                        $('#alertMessage').modal('hide');
                    }, 2000);
                });
            </script>";
                    }
                    ?>
                    <div class="col-lg-12 entries">
                        <div class="blog-comments">
                            <div class="reply-form" style="background: #fafbff;">
                                <h4 class="text-center mb-3"><?=$title?></h4>
                                <form id="bookingForm" action="" Method="Post">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="exampleInputText05" class="h5">Enter First Name *</label>
                                            <input type="text" class="form-control" id="exampleInputText05" name="name" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="exampleInputText05" class="h5">Enter Last Name *</label>
                                            <input type="text" class="form-control" id="exampleInputText05"   name="lastname" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="exampleInputText05" class="h5">Enter Email *</label>
                                            <input type="text" class="form-control" id="exampleInputText05"   name="email" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="exampleInputText05" class="h5">Enter Phone Number *</label>
                                            <input type="tel" class="form-control" id="exampleInputText05"   name="number" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="exampleInputText05" class="h5">Enter Company Name *</label>
                                            <input type="text" class="form-control" id="exampleInputText05"   name="company" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="exampleInputText05" class="h5">Select Country</label>
                                            <select class="form-select" id="country" name="country" style="padding:8.5px;">
                                                <option>select</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AX">Aland Islands</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia</option>
                                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="BN">Brunei Darussalam</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo</option>
                                                <option value="CD">Congo, Democratic Republic of the Congo</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="CI">Cote D'Ivoire</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">Curacao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GU">Guam</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and Mcdonald Islands</option>
                                                <option value="VA">Holy See (Vatican City State)</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran, Islamic Republic of</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IE">Ireland</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KP">Korea, Democratic People's Republic of</option>
                                                <option value="KR">Korea, Republic of</option>
                                                <option value="XK">Kosovo</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Lao People's Democratic Republic</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libyan Arab Jamahiriya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao</option>
                                                <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia, Federated States of</option>
                                                <option value="MD">Moldova, Republic of</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="AN">Netherlands Antilles</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PW">Palau</option>
                                                <option value="PS">Palestinian Territory, Occupied</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="QA">Qatar</option>
                                                <option value="RE">Reunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russian Federation</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="BL">Saint Barthelemy</option>
                                                <option value="SH">Saint Helena</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="MF">Saint Martin</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="WS">Samoa</option>
                                                <option value="SM">San Marino</option>
                                                <option value="ST">Sao Tome and Principe</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="CS">Serbia and Montenegro</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SX">Sint Maarten</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syrian Arab Republic</option>
                                                <option value="TW">Taiwan, Province of China</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania, United Republic of</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="US">United States</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VE">Venezuela</option>
                                                <option value="VN">Viet Nam</option>
                                                <option value="VG">Virgin Islands, British</option>
                                                <option value="VI">Virgin Islands, U.s.</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                        <label for="exampleInputText05" class="h5">Enter Company Address *</label>
                                            <textarea  name="companyaddress" class="form-control" rows="4" required></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" id="bookButton">Submit</button>
                                </form>
                            </div>
                        </div><!-- End blog comments -->
                    </div><!-- End blog entries list -->
                </div>
            </div>
        </section><!-- End Blog Single Section -->
        <!-- Modal Container -->
        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingModalLabel">Status</h5>
                    </div>
                    <div class="modal-body">
                    We've got your request to access Jiffy, and we'll be sending your login details within the day. We'll keep you posted on any updates. Thanks for your interest in Jiffy!
                    </div>
                </div>
            </div>
        </div>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include './include/footer.php'; ?>
    <!-- End Footer -->

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
    

</body>

</html>