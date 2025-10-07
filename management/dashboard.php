<?php
session_start();
include "./../include/config.php";
include './../././timezone.php';
require_once "./database/getdata.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    die;
}
$userid = $_SESSION["user_id"];
$totalEmployees = $dataFetcher->totalEmployees();
$totalclient = $dataFetcher->totalClients();
$totalprojects = $dataFetcher->totalProjects();
$monthly_expension = $dataFetcher->monthly_expension();
$status = $monthly_expension['status'];
$percentage = number_format($monthly_expension['percentage'], 2);
$Revenue_Collected = $dataFetcher->Revenue_Collected();
$Project_Collected = $dataFetcher->Project_Collected();
$total_collection = $Revenue_Collected + $Project_Collected ;
$Requirement = $dataFetcher->Requirement();
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard | Jiffy</title>

    <!-- Favicon -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'www.googletagmanager.com/gtm5445.html?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WNGH9RL');
        window.tag_manager_event = 'dashboard-free-preview';
        window.tag_manager_product = 'Webkit';
    </script>

    <!-- End Google Tag Manager -->
    <style>
        .search-content {
            display: none;
        }
    </style>
</head>

<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <?php
        include 'sidebar.php';
        include 'topbar.php';
        ?>

        <!--start dashboard--->
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Total Employees</h5>
                                </div>
                                        <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                                <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" fill="#bc2d75" />
                                            </svg>
                                            <span class="counter"><?php echo  $totalEmployees; ?></span>
                                        </h4>                                       
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='clients.php'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2"
                                onmouseover="this.querySelector('h5').style.color='blue';" 
            onmouseout="this.querySelector('h5').style.color='';">
                                    <h5 style="margin-bottom: 10px;">Our Clients</h5>                                  
                                </div>
                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">>
                                        <path fill="#f74c00" d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176H96V304c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128H544h40 40c8.8 0 16 7.2 16 16V352c0 17.7-14.3 32-32 32H576c-11.8 0-22.2-6.4-27.7-16H463.4c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384H32c-17.7 0-32-14.3-32-32V144c0-8.8 7.2-16 16-16H56 96h19.8c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64H259c4.4 0 8.9 .2 13.2 .6zM544 320V176H496c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1H544zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z" />
                                    </svg>
                                    <span class="counter"><?php echo $totalclient; ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3" onclick="window.location.href='projects.php'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2"
                                onmouseover="this.querySelector('h5').style.color='blue';" 
            onmouseout="this.querySelector('h5').style.color='';">
                                    <h5 style="margin-bottom: 10px;">Total Projects</h5>

                                </div>
                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">>
                                        <path fill="#FFD43B" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                    </svg>
                                    <span class="counter"><?php echo $totalprojects; ?></span>
                                </h4>

                            </div>
                        </div>
                    </div>



                    <div class="col-md-6 col-lg-3">
    <div class="card card-block card-stretch card-height">
        <div class="card-body">
            <div class="top-block d-flex align-items-center justify-content-between mb-2"
                onmouseover="this.querySelector('h5').style.color='blue';" 
                onmouseout="this.querySelector('h5').style.color='';">
                <h5 style="margin-bottom: 10px; cursor: pointer;">Our Target</h5>
                <span class="badge badge-info">Annual</span>
            </div>
            <h4 class="mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                    <path fill="#c60000" d="M448 256A192 192 0 1 0 64 256a192 192 0 1 0 384 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 80a80 80 0 1 0 0-160 80 80 0 1 0 0 160zm0-224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zM224 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                </svg>
                <span class="counter" style="cursor: pointer;">Upcoming</span>
            </h4>
        </div>
    </div>
</div>


                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2"
                                onmouseover="this.querySelector('h5').style.color='blue';" 
            onmouseout="this.querySelector('h5').style.color='';">
                                    <h5 style="margin-bottom: 10px;cursor: pointer;">Revenue Collected</h5>
                                   
                                </div>
                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#025602" d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z" />
                                    </svg>
                                    <span class="counter"><?php echo  $total_collection ; ?></span>
                                </h4>                        
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2"
                                onmouseover="this.querySelector('h5').style.color='blue';" 
            onmouseout="this.querySelector('h5').style.color='';">
                                    <h5 style="margin-bottom: 10px;cursor: pointer;">Financial Status</h5>
                                    
                                </div>
                                <h4 class="mb-2">
                                <?php if ($status == 1): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#009400" d="M151.6 42.4C145.5 35.8 137 32 128 32s-17.5 3.8-23.6 10.4l-88 96c-11.9 13-11.1 33.3 2 45.2s33.3 11.1 45.2-2L96 146.3V448c0 17.7 14.3 32 32 32s32-14.3 32-32V146.3l32.4 35.4c11.9 13 32.2 13.9 45.2 2s13.9-32.2 2-45.2l-88-96zM320 480h32c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32zm0-128h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32zm0-128H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32zm0-128H544c17.7 0 32-14.3 32-32s-14.3-32-32-32H320c-17.7 0-32 14.3-32 32s14.3 32 32 32z" />
                                    </svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#f70000" d="M151.6 469.6C145.5 476.2 137 480 128 480s-17.5-3.8-23.6-10.4l-88-96c-11.9-13-11.1-33.3 2-45.2s33.3-11.1 45.2 2L96 365.7V64c0-17.7 14.3-32 32-32s32 14.3 32 32V365.7l32.4-35.4c11.9-13 32.2-13.9 45.2-2s13.9 32.2 2 45.2l-88 96zM320 480c-17.7 0-32-14.3-32-32s14.3-32 32-32h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H320zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H320zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H320zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32H544c17.7 0 32 14.3 32 32s-14.3 32-32 32H320z" />
                                    </svg>
                                <?php endif; ?>
                                <span class="counter"><?=$percentage?></span>
                            </h4>

                      
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='requirement.php'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2"
                                onmouseover="this.querySelector('h5').style.color='blue';" 
            onmouseout="this.querySelector('h5').style.color='';">
                                    <h5 style="margin-bottom: 10px;">Requirement Requests</h5>                                   
                                </div>
                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#1968f0" d="M128 0C110.3 0 96 14.3 96 32V224h96V192c0-35.3 28.7-64 64-64H480V32c0-17.7-14.3-32-32-32H128zM256 160c-17.7 0-32 14.3-32 32v32h96c35.3 0 64 28.7 64 64V416H576c17.7 0 32-14.3 32-32V192c0-17.7-14.3-32-32-32H256zm240 64h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zM64 256c-17.7 0-32 14.3-32 32v13L187.1 415.9c1.4 1 3.1 1.6 4.9 1.6s3.5-.6 4.9-1.6L352 301V288c0-17.7-14.3-32-32-32H64zm288 84.8L216 441.6c-6.9 5.1-15.3 7.9-24 7.9s-17-2.8-24-7.9L32 340.8V480c0 17.7 14.3 32 32 32H320c17.7 0 32-14.3 32-32V340.8z" />
                                    </svg>
                                    <span class="counter"><?php echo  $Requirement; ?></span>
                                </h4>                       
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='request.php?myself'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2"
                                onmouseover="this.querySelector('h5').style.color='blue';" 
            onmouseout="this.querySelector('h5').style.color='';">
                                    <h5 style="margin-bottom: 10px;">Requests</h5>                                   
                                </div>
                                <h4 class="mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                    <path fill="#fe6d73" d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/>
                            </svg>
                                    <span class="counter">
                                        <?php
                                        $sql = "SELECT *  FROM teamrequried WHERE Company_id = $companyId AND (to = $userid OR forward = $userid) AND type != 'hiring'";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        echo $count;
                                        ?>
                                    </span>
                                </h4>                       
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <!-- First Column -->
                            <div class="col-xl-8">
                                <div class="card-transparent card-block card-stretch card-height">
                                    <div class="card-body p-0">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <div class="header-title">
                                                    <h4 class="card-title p-2">Financial Progress</h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="linechart" class="chartjs"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body">
                                        <div class="card border-bottom pb-2 shadow-none">
                                            <div class="card-body text-center inln-date flet-datepickr">
                                                <input type="text" id="inline-date" class="date-input basicFlatpickr" readonly="readonly">
                                            </div>
                                        </div>
                                        <div id="result-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Wrapper End-->

    <?php
    include 'footer.php';
    ?>
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
        function fetchEmployees(selectedDate) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {

                        var resultContainer = document.getElementById('result-container');
                        resultContainer.innerHTML = xhr.responseText;
                    } else {
                        console.error('Error occurred during AJAX request.');
                    }
                }
            };
            xhr.open('GET', './../project/getevent.php?selectedDate=' + selectedDate, true);
            xhr.send();
        }

        var currentDate = new Date().toISOString().split('T')[0];
        document.getElementById('inline-date').value = currentDate; // Set the date picker input to the current date


        fetchEmployees(currentDate);


        document.getElementById('inline-date').addEventListener('change', function() {
            var selectedDate = this.value;
            fetchEmployees(selectedDate);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // AJAX call to fetch data from chart.php
            $.ajax({
                type: "GET",
                url: "./chart.php",
                data: { incomechart: "monthly" },
                dataType: "json",
                success: function(data) {
                    console.log('======================================');
                    console.log(data);
                    console.log('======================================');                
                   
                    updateChart(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching data:", textStatus, errorThrown);
                }
            });

            function updateChart(data) {
                var ctx = document.getElementById('linechart');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(data), 
                        datasets: [{
                            label: "",
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(82, 136, 255)',
                            data: Object.values(data), 
                            lineTension: 0.3,
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(255,255,255,1)',
                            pointHoverBackgroundColor: 'rgba(255,255,255,0.6)',
                            pointHoverRadius: 10,
                            pointHitRadius: 30,
                            pointBorderWidth: 2,
                            pointStyle: 'rectRounded'
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true
                                },
                                ticks: {
                                    callback: function(value) {
                                        var ranges = [{
                                                divider: 1e6,
                                                suffix: 'M'
                                            },
                                            {
                                                divider: 1e3,
                                                suffix: 'k'
                                            }
                                        ];

                                        function formatNumber(n) {
                                            for (var i = 0; i < ranges.length; i++) {
                                                if (n >= ranges[i].divider) {
                                                    return (n / ranges[i].divider).toString() + ranges[i].suffix;
                                                }
                                            }
                                            return n;
                                        }
                                        return '$' + formatNumber(value);
                                    }
                                },
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                title: function(tooltipItem, data) {
                                    return data['labels'][tooltipItem[0]['index']];
                                },
                                label: function(tooltipItem, data) {
                                    return '$' + data['datasets'][0]['data'][tooltipItem['index']];
                                },
                            },
                            backgroundColor: '#606060',
                            titleFontSize: 14,
                            titleFontColor: '#ffffff',
                            bodyFontColor: '#ffffff',
                            bodyFontSize: 18,
                            displayColors: false
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>