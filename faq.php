<?php
session_start();
include "include/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>JIFFY | F.A.Q</title>
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
      z-index:1;
    }
    @media(max-width:756px){
     .sticky-button {
        top: 180px;
        }
    }
    @media (max-width: 992px) {
  .breadcrumbs {
    margin-top: 73px;
  }
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
          <li>F.A.Q</li>
        </ol>
        <h2>F.A.Q</h2>
        <div class="sticky-button">
          <a href="post.php" class="btn btn-dark">Ask Your Question</a>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>Frequently Asked Questions</p>
        </header>
<div class="row">
    <div class="col-lg-6">
        <!-- F.A.Q List 1 -->
        <div class="accordion accordion-flush" id="faqlist1">
            <?php
            $sql = "SELECT * FROM posters WHERE PosterId % 2 != 0";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $questionDescription = $row['QuestionDescription'];
                    $answer = $row['answer'];
                    $id = $row['PosterId'];
                    $name = $row['Name'];
                    $date = $row['CreatedAt'];
                    $formattedDate = (new DateTime($date))->format("d-m-Y");
            ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-<?= $id ?>">
                            <?= $questionDescription ?>
                            </button>
                        </h2>
                        
                        <div id="faq-content-<?= $id ?>" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                            <div class="accordion-body">
                                <ul>
                                    <li><?= $answer ?></li>
                                </ul>
                                <div class="d-flex" style="float:right;">
                                <p>Questioner : <?= $name ?></p>&nbsp;
                                 <p> / <?= $formattedDate ?></p>
                            </div>
                            </div>
                        </div>
                    </div>

            <?php
                }

                mysqli_free_result($result);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            ?>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- F.A.Q List 2 -->
        <div class="accordion accordion-flush" id="faqlist2">
            <?php            
            $sql2 = "SELECT * FROM posters WHERE PosterId % 2 = 0";
            $result2 = mysqli_query($conn, $sql2);

            if ($result2) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $questionDescription2 = $row2['QuestionDescription'];
                    $answer2 = $row2['answer'];
                    $id1 = $row2['PosterId'];
                    $name = $row2['Name'];
                    $date = $row2['CreatedAt'];
                    $formattedDate = (new DateTime($date))->format("d-m-Y");
                    
            ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-<?= $id1 ?>">
                                <?= $questionDescription2 ?>
                            </button>
                        </h2>
                        <div id="faq2-content-<?= $id1 ?>" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                            <div class="accordion-body">
                                <ul>
                                    <li><?= $answer2 ?></li>
                                </ul>
                                <div class="d-flex" style="float:right;">
                                <p>Questioner : <?= $name ?></p>&nbsp;
                                 <p> / <?= $formattedDate ?></p>
                            </div>
                            </div>
                        </div>
                    </div>

            <?php
                }

                mysqli_free_result($result2);
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close the connection after all queries are executed
            mysqli_close($conn);
            ?>
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