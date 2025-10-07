<?php
session_start();
include "include/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $questionType = filter_input(INPUT_POST, "question-type", FILTER_SANITIZE_STRING);
    $questionDescription = filter_input(INPUT_POST, "question-description", FILTER_SANITIZE_STRING);
    // Use the correct variable name for "name"
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);

    if (empty($questionType) || empty($questionDescription)) {
        $_SESSION["error_message"] = "Please fill in all required fields.";
        header("Location: your-form-page.php");
        exit();
    }

    $sql = "INSERT INTO posters (QuestionType, QuestionDescription, PosterId, Name) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $questionType, $questionDescription, $userid, $name);
        
       if ($stmt->execute()) {
    echo '<script>';
    echo 'alert("Thank you for your question. Our team will review it carefully and respond promptly with a professional solution tailored to your needs.");';
    echo 'window.location.href = "post.php";'; 
    echo '</script>';
    exit();
}
 else {
            $_SESSION["error_message"] = "Error: " . $stmt->error;
            header("Location: your-form-page.php");
            exit();
        }
    } else {
        $_SESSION["error_message"] = "Error: " . $conn->error;
        header("Location: your-form-page.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Post your question</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
  <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
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
                    <div class="col-lg-12 entries">
                        <div class="blog-comments">
                            <div class="reply-form" style="background: #fafbff;">
                                <h4>Ask Your Question</h4>
                                <form action="" Method="post">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="text" class="form-control" rows="4" placeholder="Enter Display Name" name="name"required/>
                                        </div>
                                    
                                        <div class="col-md-6 form-group">
                                            <select id="question-type" name="question-type" class="form-select" required  style="padding:8px;">
                                                <option value="">Select Question Type</option>
                                                <option value="1">Admin User Guide</option>
                                                <option value="2">Project Manager User Guide</option>
                                                <option value="3">Employee User Guide</option>
                                                <option value="4">General Features</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <textarea id="question-description" name="question-description" class="form-control" rows="4" id="editor1" placeholder="Describe Your Question" required></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div><!-- End blog comments -->
                    </div><!-- End blog entries list -->
                </div>
            </div>
        </section><!-- End Blog Single Section -->
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

</body>

</html>