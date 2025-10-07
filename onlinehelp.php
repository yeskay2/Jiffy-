<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>JIFFY</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/images/Jiffy-favicon.png" rel="icon">
    <link href="assets/images/Jiffy-favicon.png" rel="apple-touch-icon">

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
        /* .col-lg-12 {
    flex: 0 0 auto;
    width: 70%;
    margin-left: 250px;
} */

        .sub-header p {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #012970;
            font-family: "Nunito", sans-serif;
            margin-top: 3px;
        }

        .question {
            padding: 15px 15px 20px 0;
            font-weight: 600;
            border: 0;
            font-size: 18px;
            color: #444444;
            text-align: left;
        }

        .accordion-header {
            margin-bottom: 15px !important;
        }

        .sticky-button {
            position: fixed;
            top: 210px;
            right: 20px;
            z-index: 999;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include './include/header.php'; ?>
    <!-- End Header -->


    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li>Help Center</li>
                </ol>
                <h2>Online Help Center</h2>

                <div class="sticky-button">
                    <a href="login.php" class="btn btn-dark">Ask Your Question</a>
                </div>
            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= F.A.Q Section ======= -->
        <section id="faq" class="faq">

            <div class="container" data-aos="fade-up">

                <header class="section-header">
                    <p>Jiffy Help Center</p>
                </header>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- Help center1-->
                        <header class="sub-header">
                            <p>Getting Started</p>
                        </header>
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="helpdetails.php" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        What is Jiffy, and how can it benefit me?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How do I access Jiffy and log in to my account?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        What are the different user roles in Jiffy, and what are their responsibilities?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I navigate the Jiffy dashboard, and what can I find there?
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- Help center1-->
                        <header class="sub-header">
                            <p>Admin User Guide</p>
                        </header>
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How do I navigate the Admin Dashboard in Jiffy, and what tools are available?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I manage employee profiles within Jiffy as an Admin?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I create and oversee departments within my organization using Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I effectively monitor employee attendance and handle late logins as an
                                        Admin?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I set and manage company work schedules using Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I share important announcements and upcoming events with my team using
                                        Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I administer leave types and manage leave requests in Jiffy as an Admin?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I access work tracking reports and individual employee reports in Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I communicate via email with late login employees and receive
                                        leave-related emails in Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I stay informed about ongoing projects in my organization using Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I monitor the live locations of employees in Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I host video meetings, share screens, communicate via audio, and send
                                        messages within meetings using Jiffy's Video Meetings feature?
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- Help center1-->
                        <header class="sub-header">
                            <p>Project Manager User Guide</p>
                        </header>
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I effectively manage projects as a Project Manager in Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I assign and manage tasks for my team members using Jiffy's Task
                                        Management feature?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I apply for leave and manage leave requests as a Project Manager in
                                        Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I keep track of work details on an hourly basis and generate monthly
                                        work reports using Jiffy's Timesheet feature?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I stay informed about new tasks and project updates through
                                        notifications in Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I communicate with team members efficiently using Jiffy's Chat
                                        Functionality?
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- Help center1-->
                        <header class="sub-header">
                            <p>Employee User Guide</p>
                        </header>
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I efficiently manage my tasks as an employee using Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I apply for leave and track the status of my leave requests using
                                        Jiffy's Leave Management feature?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I keep a detailed record of my work hours and generate monthly work
                                        reports using Jiffy's Timesheet feature?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I stay updated on new tasks and project developments through
                                        notifications in Jiffy?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I engage in quick and efficient communication with colleagues using
                                        Jiffy's Chat Functionality?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I find specific employee details and department information quickly
                                        using Jiffy's Search Functionality?
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- Help center1-->
                        <header class="sub-header">
                            <p>General Features</p>
                        </header>
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I stay updated on important dates like work anniversaries and birthdays using Jiffy's Calendar Events feature?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I quickly find specific information about employees or tasks using Jiffy's Search Functionality?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I manage my profile information and update my password using Jiffy's Profile Management feature?
                                    </a>
                                </h2>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <a href="#" class="question">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;&nbsp;
                                        How can I collaborate effectively with colleagues through video meetings using Jiffy's Video Meetings feature?
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- End F.A.Q Section -->

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

    <!-- Template Main JS File -->
    <script src="assets2/js/main.js"></script>

</body>

</html>