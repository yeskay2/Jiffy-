<?php
$path = "./../assets2/img/Jiffy-logo.png";

if (!file_exists($path)) {
    $path = "assets2/img/Jiffy-logo.png"; 
}
?>
<header id="header" class="header fixed-top">
    <style>
        .ulhover:hover {
            color: red;
        }
        .header .container-fluid {
            padding: 0;
        }
        .logo {
            margin: 0;
            padding: 0;
        }
        .logo img {
            display: block;
            margin: -10px 0 0 -110px; /* Adjust the negative values to move the image */
            padding: 0;
            background-color: transparent;
        }
        @media (max-width: 1200px) {
            .logo img {
                margin: -10px 0 0 -90px; /* Adjust as needed for large tablets/small desktops */
            }
        }

        @media (max-width: 992px) {
            .logo img {
                margin: -10px 0 0 -70px; /* Adjust as needed for tablets */
            }
        }

        @media (max-width: 768px) {
            .logo img {
                margin: -10px 0 0 -50px; /* Adjust as needed for landscape phones */
            }
        }

        @media (max-width: 576px) {
            .logo img {
                margin: -10px 0 0 -30px; /* Adjust as needed for portrait phones */
                width: 150px; /* Adjust the width as needed for smaller screens */
            }
        }

        @media (max-width: 400px) {
            .logo img {
                margin: -10px 0 0 0; /* Center the logo for very small screens */
                width: 120px; /* Reduce the width further if needed */
            }
        }
    </style>
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center">
            <img src="<?=$path?>" alt="Logo">
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
                <li><a class="nav-link scrollto" href="index.php#about">About</a></li>

                <li><a class="nav-link scrollto" href="index.php#testimonials">Features</a></li>
                <li><a class="nav-link scrollto" href="index.php#services">Services</a></li>

                <li class="dropdown megamenu"><a href="#"><span>Who Can Use</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                       <li>
                          <a href="corporate.php">Corporate Offices</a>
                          <a href="itservice.php">Information Technology (IT)</a>
                          <a href="manufacturing.php">Manufacturing</a>
                        </li>
                        <li>
                            <a href="healthcare.php">Healthcare</a>
                            <a href="education.php">Education</a>
                            <a href="startup.php">Startup Companies</a>
                        </li>
                        <li>
                            <a href="building.php">Building and Construction Industry</a>
                            <a href="consulting.php">Consulting</a>
                            <a href="government.php">Government Agency Solutions</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown"><a href="#"><span>Resources</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="tutorial.php">Video Tutorials</a></li>
                        <li><a href="faq.php">FAQs (Frequently Asked Questions)</a></li>
                    </ul>
                </li>

                <li><a class="nav-link scrollto" href="index.php#team">Team</a></li>
                <li><a class="nav-link scrollto" href="index.php#contact">Contact us</a></li>

                <li><a class="demo-button scrollto d-inline-flex align-items-center justify-content-center align-self-center" href="demo.php"><span>Book Demo</span></a></li>
              
                <li><a class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center" id="btn-module" href="modules.php"><span>Get Started</span>
                <i class="bi bi-arrow-right"></i></a></li>               

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
<script>
    function logout() {
        document.cookie = "selectedCompany=; path=/;";
        document.cookie = "selectedCompanyname=; path=/;";
        document.cookie = "user_id=; path=/;";
        location.reload();
    }
</script>