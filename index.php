<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $contactNo = $_POST["contactNo"];
  $message = $_POST["message"];

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

    $jiffy_email = 'jayamani.mine@gmail.com';
    $jiffy_full_name = 'Jiffy Team';

    $mailer->addAddress($jiffy_email, $jiffy_full_name);
    $jiffy_subject = 'New Client Request for Jiffy Product: ' . $name;
    $mailer->Subject = $jiffy_subject;

    $jiffy_message = "<html>
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
                    <li><strong>Contact Number:</strong> $contactNo</li>
                </ul>
                <p><strong>Message:</strong></p>
                <p>" . nl2br($message) . "</p>
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

    if ($sent) {

      error_log("Email sent successfully: New Client Request for Jiffy Product - Name: $name, Email: $email, Contact Number: $contactNo");
      echo "<script>alert('Thank you! Your message has been sent to our Jiffy team. We will get back to you soon..');</script>";
    } else {

      error_log("Email sending failed: New Client Request for Jiffy Product - Name: $name, Email: $email, Contact Number: $contactNo");
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

  <title>MINE | JIFFY</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./../assets/images/dummy logo.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets2/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets2/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets2/css/style.css" rel="stylesheet">
  <style>
    @media(max-width:650px) {
      .center-text {
        text-align: center;
      }

      .demo-button {
        margin-bottom: 10px;
      }

      #upfeatures {
        margin-left: 1% !important;
        padding-right: 15px !important;
        text-align: justify;
      }

      .features .feature-icons .content .icon-box h4 {
        font-size: 18px;
      }
    }

    .webpopup-form {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: linear-gradient(90deg, rgba(250, 220, 235, 1) 35%, rgba(189, 184, 234, 1) 100%);
      padding: 20px;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      z-index: 9999;
      width: 50%;
    }

    @media(max-width:768px) {
      .webpopup-form {
        width: 85%;
      }

      .popup-header {
        font-size: 25px !important;
        margin-bottom: 0px !important;
      }

      .close-popupbtn {
        font-size: 15px !important;
      }

      .popup-text {
        padding: 9px !important;
      }

      .row>* {
        margin-bottom: 0px;
      }
    }

    .popup-header {
      font-weight: 900;
      font-size: 40px;
      font-family: Playfair Display semi bold;
      margin-bottom: 20px;
      text-align: center;
      width: 90%;
      color: transparent;
      background-image: linear-gradient(to right, #553c9a, #3d3399, #d03d87, #d276a4, #bc2d75);
      -webkit-background-clip: text;
      background-clip: text;
      background-size: 200%;
      background-position: -200%;
      animation: animated-gradient 5s infinite alternate-reverse;
    }

    .weboverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9998;
    }

    .close-popupbtn {
      position: absolute;
      top: 20px;
      right: 20px;
      cursor: pointer;
      font-size: 20px;
      font-weight: bold;
      background-color: #3d3399;
      color: white;
      padding: 0px 10px;
      border-radius: 16px;
    }

    .popup-text:hover {
      border: 1px solid #3d3399;
      padding: 12px;
      box-shadow: none;
    }

    .popup-text {
      border: none;
      padding: 12px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      ;
    }
  </style>
</head>

<body>

  <?php include './include/header.php'; ?>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">

          <h1 class="h2tag" data-aos="fade-up" data-aos-delay="400">Transforming <br>Time into Value</span>
          </h1><br>
          <h5 data-aos="fade-up" data-aos-delay="400" style="font-family: Montserrat Bold;">Powered by <a href="https://mineit.tech/" target="_blank;"><span style="color:#c72f2e;">Merry's Info-tech New-Gen Educare</span></a>
          </h5>
          <!-- <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
              <a href="#about"
                class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Get Started</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div> -->
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="assets2/img/hero-img.png" class="img-fluid animated-image" alt="hero-image">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">

      <div class="container" data-aos="fade-up">
        <header class="section-header">
          <h3>About Jiffy</h3>
        </header>

        <div class="container" data-aos="fade-up">
          <div class="row gx-0">

            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
              <div class="content">

                <p class="aboutjiffy">
                  &nbsp;&nbsp; &nbsp;&nbsp;<span>J</span>iffy is a cutting-edge digital office platform that revolutionizes workplace management across all departments. With dedicated panels for HR, Accounts, Management, Project Managers, Team Leads, and Employees, Jiffy offers a comprehensive suite of tools to streamline operations and enhance collaboration. From recruitment and performance management to project oversight and task tracking, Jiffy's unified platform simplifies workforce management. Features include real-time insights, leave management, financial monitoring, task assignment, time tracking, and seamless communication channels. Whether it's managing projects, monitoring financial status, or facilitating team collaboration, Jiffy empowers businesses to optimize their operations, saving time and unlocking the true potential of their workforce.
                </p>
              </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
              <img src="assets2/img/AboutUs.png" class="fluid" alt="About-Image" style="width:500px; height:300px">
            </div>

          </div>
        </div>

    </section><!-- End About Section -->

    <!-- ======= Features Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container" data-aos="fade-up">
        <header class="section-header">
          <h3>Features</h3>
        </header>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="10">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/task.png" class="features-img" alt="Task-Image">
                </div>
                <h3>Task Management</h3>
                <p class="text-justify">Jiffy's task management simplifies assignment, tracking, and collaboration. Users assign tasks, track
                  progress, and receive notifications, fostering efficient teamwork. Filtering and communication tools
                  enhance productivity.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/project.png" class="features-img" alt="project-Image">
                </div>
                <h3>Project Management</h3>
                <p class="text-justify">
                  Jiffy's project management streamlines planning, execution, and monitoring. Users create projects,
                  assign tasks, and track progress for efficient collaboration. Integrated tools ensure seamless
                  communication and oversight.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/attendance.png" class="features-img" alt="attendance-image">
                </div>
                <h3>Employee Attendance System</h3>
                <p class="text-justify">
                  Jiffy's attendance system enables easy tracking of employee work hours. Admins view login times,
                  manage late logins, and send notifications. Enhanced organization and efficiency through real-time
                  attendance monitoring.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/leave.png" class="features-img" alt="leave-Image">
                </div>
                <h3>Employee Leave Management</h3>
                <p class="text-justify">Jiffy's leave management simplifies tracking and approval of employee leaves. Admins manage leave
                  types, view requests, and grant approvals. Streamlined process enhances workforce management and
                  planning.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/timesheet.png" class="features-img" alt="Timesheet-Image">
                </div>
                <h3>Timesheet</h3>
                <p class="text-justify">Jiffy's timesheet feature offers precise work hour tracking. Users log hours, generating monthly
                  reports for efficient monitoring. Enhanced accuracy in time management and resource allocation.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/notification.png" class="features-img" alt="Notification-Image">
                </div>
                <h3>Notification System</h3>
                <p class="text-justify">Jiffy's notification system keeps users informed in real-time. It delivers task assignments, leave
                  approvals, and updates seamlessly. Enhancing communication and collaboration for effective workflow
                  management.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/monthly-report.png" class="features-img" alt="Report-Image">
                </div>
                <h3>Automatic Monthly Report Generator</h3>
                <p class="text-justify">Jiffy's automatic monthly report generator simplifies data compilation. It creates comprehensive
                  reports on tasks. Streamlining reporting processes for informed decision-making.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/logout.png" class="features-img" alt="Logout-Image">
                </div>
                <h3>Automatic Logout</h3>
                <p class="text-justify">
                  Jiffy's automatic logout feature enhances that users are automatically logged out after a specified idle time,
                  minimizing unauthorized access. Safeguarding data and promoting system integrity.</p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/event.png" class="features-img" alt="Event-Image">
                </div>
                <h3>Events & Notice Management</h3>
                <p class="text-justify">
                  Jiffy's events & notice management facilitates streamlined communication. Admins can create, share,
                  and manage company events and notices. Enhancing engagement and information dissemination within the
                  organization. </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/email.png" class="features-img" id="tab1-img" alt="Email-Image">
                </div>
                <h3>Email System</h3>
                <p class="text-justify">
                  Jiffy's integrated email system streamlines communication within the platform. Users can send alerts,
                  notifications, and reminders directly. Promoting efficient correspondence and task management. </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/calendar.png" class="features-img" alt="Calendar-Image">
                </div>
                <h3>Daily Calendar Management</h3>
                <p class="text-justify">
                  Jiffy's daily calendar management optimizes scheduling and organization. Users can view work
                  anniversaries, birthdays, and events seamlessly. Enhancing time management and fostering a
                  well-coordinated environment. </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/chat.png" class="features-img" alt="Chat-Image">
                </div>
                <h3>Chat</h3>
                <p class="text-justify">
                  Jiffy's chat feature promotes real-time communication and collaboration. Users can message colleagues,
                  share updates, and discuss tasks within the platform. Enhancing teamwork and information exchange for
                  efficient progress.</p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/videoconference.png" class="features-img" alt="Chat-Image">
                </div>
                <h3>Group Video Meeting</h3>
                <p class="text-justify">
                  The "Group Video Meeting" feature in Jiffy enables seamless real-time communication and collaboration
                  among users. It empowers teams to conduct efficient group video meetings, fostering effective progress
                  and information exchange within the platform.</p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/live.png" class="features-img" alt="Chat-Image">
                </div>
                <h3>Live Location Tracking</h3>
                <p class="text-justify">
                  With Jiffy's live location tracking feature, administrators can gain real-time visibility into the whereabouts of employees. Easily monitor employee locations to ensure safety, optimize work allocation, and enhance overall workforce management.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/payslip.png" class="features-img" alt="payslip-Image">
                </div>
                <h3>Payslip Generation</h3>
                <p class="text-justify">
                  Jiffy automates monthly payslip generation, ensuring accuracy and efficiency. Each payslip is customized with employee-specific information and emailed directly to employees, providing timely access to their individual salary details.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/invoice.png" class="features-img" alt="Invoice-Image">
                </div>
                <h3>Invoice Generation</h3>
                <p class="text-justify">
                  Jiffy streamlines invoice creation by automating the process. Personalized invoices, branded with your company logo, are generated for easy download and sending to your clients, ensuring prompt and professional delivery.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/income-expense.png" class="features-img" alt="Income&Expense-Image">
                </div>
                <h3>Income and Expense Tracking System</h3>
                <p class="text-justify">
                  With Jiffy, keeping track of your company's finances is a breeze. Easily monitor your income and expenses, know exactly how much you're spending, and stay on top of your financial status, all in one convenient platform.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/recruitment.png" class="features-img" alt="Recruitment-Image">
                </div>
                <h3>Recruitment Management</h3>
                <p class="text-justify">
                  Jiffy simplifies the recruitment process, allowing HR to easily manage candidate applications and statuses. From scheduling interview meetings to sending offer letters, every step of the hiring process is streamlined within the platform.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/issuetrack.png" class="features-img" alt="Issue Tracking-Image">
                </div>
                <h3>Issue Tracking System</h3>
                <p class="text-justify">
                  Jiffy's issue tracking system allows employees to report problems and make requests effortlessly. HR can also send memos and announcements through the platform, ensuring smooth communication across the organization.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/community.png" class="features-img" alt="Community-Image">
                </div>
                <h3>Community Hub</h3>
                <p class="text-justify">
                  Jiffy's community hub is the perfect place for employees to share their thoughts and ideas. Engage with posts by giving likes and stay updated with the latest updates and announcements.
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="profile">
                  <img src="assets2/img/features/clients.png" class="features-img" alt="Client Management-Image">
                </div>
                <h3>Clients Management</h3>
                <p class="text-justify">
                  Jiffy's client management feature allows you to easily add and manage client profiles. Monitor project progress, track payments, and maintain detailed client records all in one place. With Jiffy, you can ensure smooth communication and project delivery.
                </p>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination" id="swipe"></div>
        </div>

      </div>

      </div> <!-- / row -->
    </section>

    <!--Start task tracking Tabs -->

    <section id="features" class="features" style="margin-top: -100px;">
      <div class="row feture-tabs" data-aos="fade-up" id="upfeatures">
        <div class="col-lg-6 left" style="margin-top: 4%;">
          <h3 class="center-text">Task Time Tracking</h3>

          <!-- Tabs -->
          <ul class="nav nav-pills mb-3">
            <li>
              <a class="nav-link active" data-bs-toggle="pill" href="#tab1">HR</a>
            </li>
            <li>
              <a class="nav-link" data-bs-toggle="pill" href="#tab2">Project Manager</a>
            </li>
            <li>
              <a class="nav-link" data-bs-toggle="pill" href="#tab3">Employee</a>
            </li>
          </ul><!-- End Tabs -->

          <!-- Tab Content -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="tab1">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>View employees task work hours</h4>
              </div>
              <p>HR can able to view the individual performance of an employee for completing the task.</p>

              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Automatic report generation</h4>
              </div>
              <p>HR can able to generate whole employee's monthly report</p>

              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Download individual employee report</h4>
              </div>
              <p>HR can able to download individual employees monthly report</p>
            </div><!-- End Tab 1 Content -->

            <div class="tab-pane fade show" id="tab2">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>View work details in hourly basis</h4>
              </div>
              <p>The Project Manager can view their work details, such as the tasks they have completed on an hourly
                basis</p>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Can generate and download monthly wise report</h4>
              </div>
              <p>The Project Manager can generate and download their report on a monthly basis</p>
            </div><!-- End Tab 2 Content -->

            <div class="tab-pane fade show" id="tab3">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>View work details in hourly basis</h4>
              </div>
              <p>The Employee can view their work details, such as the tasks they have completed on an hourly basis</p>
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Can generate and download monthly wise report</h4>
              </div>
              <p>The Employee can generate and download their report on a monthly basis</p>
            </div><!-- End Tab 3 Content -->
          </div>
        </div>
        <div class="col-lg-6">
          <img src="assets2/img/emptask.png" class="img-fluid1" id="tab1-img" alt="Task-Time-Tracking Screenshot" style="width: 100%;">
        </div>
      </div>

      <!-- End task tracking Tabs -->

      <!--Start Progress tracking Tabs -->

      <div class="row feture-tabs" data-aos="fade-up" id="upfeatures">

        <div class="col-lg-6">
          <img src="assets2/img/protask.png" class="img-fluid1" id="tab1-img" alt="Progress-Tracking Screenshot" style="width: 100%;">
        </div>

        <div class="col-lg-6 left" style="margin-top: 6%;">
          <h3 class="center-text">Progress Tracking System</h3>

          <!-- Tabs -->
          <ul class="nav nav-pills mb-3">
            <li>
              <a class="nav-link active" data-bs-toggle="pill" href="#progress1">Project Manager</a>
            </li>
            <li>
              <a class="nav-link" data-bs-toggle="pill" href="#progress2">Employee</a>
            </li>
          </ul><!-- End Tabs -->

          <!-- Tab Content -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="progress1">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>View individual project status through Progress</h4>
              </div>
              <p>The project progress will be display based on the task completed by the project members</p>

              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>View individual task status through Progress</h4>
              </div>
              <p>The project manager can view all the employee's task progress through status</p>

            </div><!-- End Tab 1 Content -->

            <div class="tab-pane fade show" id="progress2">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>View individual task status through Progress</h4>
              </div>
              <p>The employee can view all their task progress through status</p>

            </div><!-- End Tab 2 Content -->

          </div>
        </div>
      </div>
      <!--End Progress tracking Tabs -->


      <!--Start Leave Tabs -->

      <div class="row feture-tabs" data-aos="fade-up" id="upfeatures">
        <div class="row">
          <div class="col-lg-6 left" style="margin-top: 4%;">
            <h3 class="center-text">Leave Management System</h3>

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#leave1">HR</a>
              </li>
              <li>
                <a class="nav-link" data-bs-toggle="pill" href="#leave2">Project Manager</a>
              </li>
              <li>
                <a class="nav-link" data-bs-toggle="pill" href="#leave3">Employee</a>
              </li>
            </ul><!-- End Tabs -->

            <!-- Tab Content -->
            <div class="tab-content">
              <div class="tab-pane fade show active" id="leave1">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Manage leave</h4>
                </div>
                <p>HR can add the leave types based on the company policies</p>

                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>View employees leave details</h4>
                </div>
                <p>HR can view individual employee leave details and set action for their leave if it is approved or not
                </p>

                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Get leave notifications</h4>
                </div>
                <p>HR can recieve notifications on their dashboard</p>


              </div><!-- End Tab 1 Content -->

              <div class="tab-pane fade show" id="leave2">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Apply leave</h4>
                </div>
                <p>The project Manager can apply leave and view status of the application that is approved or not</p>

              </div><!-- End Tab 2 Content -->

              <div class="tab-pane fade show" id="leave3">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Apply leave</h4>
                </div>
                <p>The employee can apply leave and view status of the application that is approved or not</p>
              </div>
            </div><!-- End Tab 2 Content -->
          </div>

          <div class="col-lg-6">
            <img src="assets2/img/manageleave.png" class="img-fluid1" id="tab1-img" alt="Leave Screenshot" style="width: 100%;">
          </div>

        </div>
      </div>
      <!--End leave Tabs -->


      <!--Start Email Tabs -->
      <div class="row feture-tabs" data-aos="fade-up" id="upfeatures">
        <div class="col-lg-6">
          <img src="assets2/img/Email Notification.png" class="img-fluid1" id="feature-img1" alt="Email Screenshot" style="width: 100%;">
        </div>
        <div class="col-lg-6 left" style="margin-top: 6%;">
          <h3 class="center-text">Email System</h3>
          <!-- Tabs -->
          <ul class="nav nav-pills mb-3">
            <li>
              <a class="nav-link active" data-bs-toggle="pill" href="#email1">HR</a>
            </li>
            <li>
              <a class="nav-link" data-bs-toggle="pill" href="#email2">Project Manager</a>
            </li>
            <li>
              <a class="nav-link" data-bs-toggle="pill" href="#email3">Employee</a>
            </li>
          </ul><!-- End Tabs -->

          <!-- Tab Content -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="email1">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Send Memo mail to late login employees</h4>
              </div>
              <p>With a single click, HR can send a memo email to the employees who have logged in late</p>

              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Leave Application</h4>
              </div>
              <p>HR can get the leave application of the employees and project manager through mail</p>

            </div><!-- End Tab 1 Content -->

            <div class="tab-pane fade show" id="email2">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Recieve task notifications and task details</h4>
              </div>
              <p>The Project Manager can receive task assignment notifications and task details through email</p>

              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Automatic leave mail</h4>
              </div>
              <p>If the project manager applies for leave in their dashboard, the leave email will be automatically
                sent to the HR mailbox</p>

            </div><!-- End Tab 2 Content -->

            <div class="tab-pane fade show" id="email3">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Recieve task notifications and task details</h4>
              </div>
              <p>The employees can receive task assignment notifications and task details through email</p>

              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>Automatic leave mail</h4>
              </div>
              <p>If the employees applies for leave in their dashboard, the leave email will be automatically sent to
                the HR mailbox</p>

            </div><!-- End Tab 3 Content -->
          </div>
        </div>
      </div>
      <!--End Email Tabs -->

      <!--Start Chat Tabs -->
      <div class="row feture-tabs" data-aos="fade-up" id="upfeatures">
        <div class="row">
          <div class="col-lg-6 left" style="margin-top: 2%;">
            <h3 class="center-text">Chat Communication</h3>
            <!-- Tab Content -->
            <div class="tab-content">
              <div class="tab-pane fade show active" id="leave1">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>In all three dashboards, HR, Project Manager, and employees can communicate with each other
                    through chat</h4>
                </div>
                <br>
                <p>
                  Chat communication is versatile and convenient, allowing people to exchange information, engage in
                  discussions, and build connections without the need for face-to-face interactions or voice
                  communication. It has become an integral part of both personal and professional communication in the
                  modern world.
                </p><br>
                <p>
                  Overall, chat communication has revolutionized the way people connect, collaborate, and communicate in
                  both personal and professional settings, offering convenience and flexibility for staying in touch and
                  exchanging information.
                </p>
              </div><!-- End Tab 1 Content -->
            </div>
          </div>
          <div class="col-lg-6">
            <img src="assets2/img/chat.png" class="img-fluid1" id="tab1-img" alt="Chat Screenshot" style="width: 100%;">
          </div>
        </div>
      </div>
      <!--End Chat Tabs -->

      <!--Start Video Call Tabs -->
      <div class="row feture-tabs" data-aos="fade-up" id="upfeatures">
        <div class="col-lg-6">
          <img src="assets2/img/videomeet.webp" class="img-fluid1" id="feature-img1" style="width: 100%;" alt="Video Meeting Screenshot">
        </div>

        <div class="col-lg-6 left" style="margin-top: 7%;">
          <h3 class="center-text">Group Video Meeting</h3><br>
          <!-- Tab Content -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="email1">
              <div class="d-flex align-items-center mb-2">
                <i class="bi bi-check2"></i>
                <h4>HR can establish video calls with all employees in the company for direct communication.</h4>
              </div><br>
              <p>All the employees can access video meetings using either a room ID or an invite link. Within these
                meetings,
                they can engage in screen sharing, group chat, voice communication, and video sharing, with a visible
                count of participants.</p>
            </div><!-- End Tab 1 Content -->
          </div>
        </div>
      </div>

      <!--End Video call Tabs -->


      <div class="container" data-aos="fade-up">
        <!-- Feature Icons -->
        <div class="row feature-icons" data-aos="fade-up">
          <header class="section-header">
            <h3>Upcoming Features</h3>
          </header>

          <div class="row">

            <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100">
              <img src="assets2/img/Upcoming.png" class="img-fluid p-4" alt="Upcoming feature image">
            </div>

            <div class="col-xl-8 d-flex content">
              <div class="row align-self-center gy-4">

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <img src="assets2/img/live-application.png" alt="live-application" class="upcoming" />
                  <div><br>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Live Application Tracking</h4>
                  </div>
                </div>

                <!-- <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <img src="assets2/img/payslip.png" alt="Payslip" class="upcoming" />
                  <div><br>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Auto Generate Payslip</h4>
                  </div>
                </div> -->

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <img src="assets2/img/facial-recognition.png" alt="Payslip" class="upcoming" />
                  <div><br>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Face Recognition</h4>
                  </div>
                </div>

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <img src="assets2/img/road.png" alt="Roadmap" class="upcoming" style="margin-top: 25px;" />
                  <div><br><br>
                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Automate Project Roadmap</h4>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div><!-- End Feature Icons -->
      </div>
    </section><!-- End Features Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>Our Services</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-box darkblue">
              <i class="ri-file-list-3-line icon"></i>
              <h3>Workforce Management Services</h3>
              <p class="text-justify">Jiffy's Workforce Management Services excel at streamlining and enhancing employee-related tasks, including attendance and leave management, to improve organizational efficiency and productivity.&nbsp;</p>
              <a href="services.php#filter-workforce" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-box darkpink">
              <i class="ri-bar-chart-2-fill icon"></i>
              <h3>Project Management Services</h3>
              <p class="text-justify">Jiffy's Project Management Services streamline task assignment and tracking, ensuring efficient project collaboration and communication, all in one place.&nbsp;&nbsp;&nbsp;</p>
              <a href="services.php#filter-project" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-box darkblue">
              <i class="ri-user-3-fill icon"></i>
              <h3> Employee Management Services</h3>
              <p class="text-justify">Jiffy's Employee Services empower individuals to manage tasks, leave requests, and communication efficiently, enhancing their productivity and engagement within the organization.</p>
              <a href="services.php#filter-employee" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-box darkpink">
              <i class="ri-settings-5-line icon"></i>
              <h3>Customize and Integrate</h3>
              <p class="text-justify">Customize Jiffy to your unique needs and seamlessly integrate it with your existing tools, creating a tailored and interconnected workflow that suits your organization perfectly.</p>
              <a href="services.php#filter-custom" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-box darkblue">
              <i class="ri-question-fill icon"></i>
              <h3>Support and Training</h3>
              <p class="text-justify">Jiffy's dedicated support team, ready to assist with your inquiries and technical needs, along with comprehensive training materials to ensure your team maximizes the platform's potential.</p>
              <a href="services.php#filter-support" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
            <div class="service-box darkpink">
              <i class="ri-shield-flash-fill icon"></i>
              <h3> Security and Compliance</h3>
              <p class="text-justify">Jiffy prioritizes data security with robust measures, and complies with industry standards and regulations, providing peace of mind for your organization's sensitive information.</p>
              <a href="services.php#filter-security" class="read-more"><span>Read More</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Services Section -->

    <!-- ======= Team Section ======= -->
    <!--- <section id="team" class="team">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>Our Jiffy Developers</p>
        </header>


        <div class="row gy-4">
          <!--<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="assets2/img/team/projectmanager.png" class="img-fluid" alt="Project Manager">
                <div class="social">
                  <a href="https://www.linkedin.com/in/akshatha-gaddi-4059b0249"><i class="bi bi-linkedin"></i></a>
                  <a href="mailto:akshathasgaddi@mineit.tech"><i class="bi bi-envelope"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Akshatha S Gaddi</h4>
                <span>Project Manager</span>
                <p class="text-justify">Our Project Manager ensures project success through efficient resource coordination and cross-functional teamwork.</p>
              </div>
            </div>
          </div>
          
          <div class="col-lg-2 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <div class="member-img">
                <img src="assets2/img/team/frontend.png" class="img-fluid" alt="Frontend developer">
                <div class="social">
                  <a href="https://www.linkedin.com/in/anusiya-m"><i class="bi bi-linkedin"></i></a>
                  <a href="mailto:anusiyam@mineit.tech"><i class="bi bi-envelope"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Anusiya M</h4>
                <span>Frontend & UI/UX Developer</span>
                <p class="text-justify">Our Frontend & UI/UX developer creating attractive and easy-to-use web applications by combining design and coding skills.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <div class="member-img">
                <img src="assets2/img/team/backend.png" class="img-fluid" alt="Backend developer">
                <div class="social">
                  <a href="https://www.linkedin.com/in/jayamani-m-050b031a7/"><i class="bi bi-linkedin"></i></a>
                  <a href="mailto:jayamanim@mineit.tech"><i class="bi bi-envelope"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Jayamani M</h4>
                <span>Backend Developer</span>
                <p class="text-justify">Our Backend developer powers the platform with robust logic, efficient data management, and rigorous security measures.</p>
              </div>
            </div>
          </div>
          
          <div class="col-lg-2 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          </div>


         <!-- <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
            <div class="member">
              <div class="member-img">
                <img src="assets2/img/team/designer.png" class="img-fluid" alt="Designer">
                <div class="social">
                  <a href="https://www.linkedin.com/in/rishikesh-ronith-911498185?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><i class="bi bi-linkedin"></i></a>
                  <a href="mailto:rishikeshp.mine@gmail.com"><i class="bi bi-envelope"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Rishikesh P</h4>
                <span>UI/UX Designer</span>
                <p class="text-justify">Our Designer transforms concepts into captivating visuals, defining the platform's aesthetic and user experience.</p>
              </div>
            </div>
          </div> 
        </div>
      </div>
    </section>--><!-- End Team Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2 style="font-size:22px;">Pricing</h2>
          <p>Get Our Product</p>
        </header>

        <div class="row gy-4" data-aos="fade-left">

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
              <span class="featured fw-bold">Free</span>
              <h3 style="color: #07d5c0;">Free Plan</h3>
              <div class="price"><span>For 15 days</span></div>
              <img src="assets2/img/pricing-free.webp" class="img-fluid" alt="Free plan">
              <ul>
                <li>Dashboard</li>
                <li>Project Management</li>
                <li>Task Assignment</li>
                <li>Attendance Tracking & Export</li>
                <li>Leave Management</li>
                <li>Profile Settings</li>
                <li>Timesheet and Reporting</li>
                <li>Chat Feature</li>
                <li>Notifications</li>
                <li>Calendar and Event Scheduling</li>
                <li>Search Functionality</li>
                <li>Mail Integration</li>
                <li>Video Meeting</li>
                <li>Employee Live Location Tracking</li>
                <li>Online Help</li>
              </ul>
              <a href="trial.php?cast=0" class="btn-buy btn-anim">Get for Free</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="box">
              <!-- <span class="featured">Featured</span> -->
              <h3 style="color: #65c600;">Basic Plan</h3>
              <div class="price"><sup>₹</sup>500<span> / Month</span></div>
              <img src="assets2/img/pricing-starter.webp" class="img-fluid" alt="Basic plan">
              <ul>
                <li>Dashboard</li>
                <li>Task Assignment & Management</li>
                <li>Attendance Tracking</li>
                <li>Leave Management</li>
                <li>Profile Settings</li>
                <li>Notifications</li>
                <li class="na">Project Management</li>
                <li class="na">Calendar and Event Scheduling</li>
                <li class="na">Advanced Search</li>
                <li class="na">Mail Integration</li>
                <li class="na">Timesheet and Reporting</li>
                <li class="na">Chat Feature</li>
              </ul>
              <a href="trial.php?cast=500" class="btn-buy" style="margin-top:109px;">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="box">
              <h3 style="color: #ff901c;">Pro Plan</h3>
              <div class="price"><sup>₹</sup>1,500<span> / Month</span></div>
              <img src="assets2/img/pricing-business.webp" class="img-fluid" alt="Pro plan">
              <ul>
                <li>Dashboard</li>
                <li>Project Management</li>
                <li>Task Assignment</li>
                <li>Attendance Tracking</li>
                <li>Leave Management</li>
                <li>Profile Settings</li>
                <li>Timesheet and Reporting</li>
                <li>Chat Feature</li>
                <li>Notifications</li>
                <li>Calendar and Event Scheduling</li>
                <li>Search Functionality</li>
                <li>Mail Integration</li>
                <li class="na">Attendance Export</li>
                <li class="na">Video Meeting</li>
                <li class="na">Employee Live Location Tracking</li>
              </ul>
              <a href="trial.php?cast=1500" class="btn-buy">Buy Now</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="box">
              <h3 style="color: #ff0071;">Enterprise Plan</h3>
              <div class="price"><sup>₹</sup>2,000<span> / Month</span></div>
              <img src="assets2/img/pricing-ultimate.webp" class="img-fluid" alt="Enterprise plan">
              <ul>
                <li>Dashboard</li>
                <li>Project Management</li>
                <li>Task Assignment</li>
                <li>Attendance Tracking & Export</li>
                <li>Leave Management</li>
                <li>Profile Settings</li>
                <li>Timesheet and Reporting</li>
                <li>Chat Feature</li>
                <li>Notifications</li>
                <li>Calendar and Event Scheduling</li>
                <li>Search Functionality</li>
                <li>Mail Integration</li>
                <li>Video Meeting</li>
                <li>Employee Live Location Tracking</li>
                <li>Online Help</li>
              </ul>
              <a href="trial.php?cast=2000" class="btn-buy">Buy Now</a>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Pricing Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>Contact Us</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">

              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p><a href="tel:+916382341074">+91 6382 341 074</a></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p><a href="mailto:jiffymine@gmail.com">jiffymine@gmail.com</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form action="#" method="post" class="php-email-form">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Enter name *" required pattern="[A-Za-z]+" minlength="3" title="Please enter letters only">
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" class="form-control" placeholder="Enter email *" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" title="Please enter a valid email address">
                </div>
                <div class="col-md-12">
                  <input type="text" name="contactNo" class="form-control" placeholder="Enter contact number *" required pattern="[0-9]{10}" title="Please enter 10 digits numbers">
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message *" required></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <div class="error-message"><?php echo $error_message ?? ''; ?></div>
                  <div class="sent-message"><?php echo $sent_message ?? ''; ?></div>
                  <button type="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </section><!-- End Contact Section -->


    <div class="weboverlay" id="overlay"></div>
    <div class="webpopup-form" id="popupForm">
      <div class="close-popupbtn" onclick="closePopup()">&times</div>
      <div class="col-lg-12">
        <form action="#" method="post" class="php-email-form">
          <div class="row gy-4">
            <h3 class="popup-header text-center">Engage with Us</h3>
            <div class="col-md-6">
              <input type="text" name="name" class="form-control popup-text" placeholder="Enter name *" required pattern="[A-Za-z]+" minlength="3" title="Please enter letters only">
            </div>
            <div class="col-md-6">
              <input type="email" name="email" class="form-control popup-text" placeholder="Enter email *" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" title="Please enter a valid email address">
            </div>
            <div class="col-md-6">
              <input type="text" name="contactNo" class="form-control popup-text" placeholder="Enter contact number *" required pattern="[0-9]{10}" title="Please enter 10 digits numbers">
            </div>
            <div class="col-md-6">
              <input type="text" name="organization" class="form-control popup-text" placeholder="Enter organization name *" required pattern="[A-Za-z]+" title="Please enter letters only">
            </div>
            <div class="col-md-12">
              <textarea class="form-control popup-text" name="message" rows="6" placeholder="Message *" required></textarea>
            </div>
            <div class="col-md-12 text-center">
              <div class="error-message"><?php echo $error_message ?? ''; ?></div>
              <div class="sent-message"><?php echo $sent_message ?? ''; ?></div>
              <button type="submit" id="btn-module">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>
  </main><!-- End #main -->

  <?php include './include/footer.php'; ?>

  <!-- Vendor JS Files -->
  <script src="assets2/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets2/vendor/aos/aos.js"></script>
  <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets2/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets2/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets2/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets2/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets2/js/main.js"></script>

  <script>
    function closePopup() {
      document.getElementById("popupForm").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }

    document.addEventListener("DOMContentLoaded", function() {
      // Show the popup form after 5 seconds
      setTimeout(function() {
        document.getElementById("popupForm").style.display = "block";
        document.getElementById("overlay").style.display = "block";
      }, 5000);

      // Close the popup form when clicking outside of it
      document.getElementById("overlay").addEventListener("click", closePopup);
    });
  </script>


</body>

</html>