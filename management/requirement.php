<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    die;
}
$database = "mineit_jiffy";
$userid = $_SESSION["user_id"];

include "./../include/config.php";

include './../././timezone.php';

require_once "./../admin/database/feach.php";

$requirementdata = $projectManager->feachdatarequriedlist();

$totalapplydata = $projectManager->allfeachdatarequriedlist();
if(isset($_GET['model'])&&$_GET['model']=='todayinterview' ){
$shortlistapplydata = $projectManager->shortlistfeachdatarequriedlist('todayinterview');
}else{
    $shortlistapplydata = $projectManager->shortlistfeachdatarequriedlist();
}


$rejecteddata = $projectManager->rejecteddata();

$selected = $projectManager->selected();


$hired = $projectManager->hired();


if (isset($_GET['jobid'])) {
    $id = $_GET['jobid'];
    $applydata = $projectManager->feachdatarequriedlist1($id);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $applydata = $projectManager->shortlist($userid);
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recruitment | Jiffy</title>

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
    <style>
        .search-content {
            display: none;
        }

        #chartdiv {
            width: 50%;
            max-width: 500px;
            height: 400px;
            margin: 0 auto;
        }

        .amcharts-funnel-tick {
            stroke-dasharray: 5;
        }

        .amcharts-chart-div svg+a {
            display: none !important;
        }

        #applicationWise {
            height: 500px !important;
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
                    <div class="col-md-6 col-lg-4" onclick="window.location.href='recruitment.php?model=totalrequirement'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Total Requirement</h5>
                                    <div id="circle-progress-01" class="circle-progress circle-progress-success d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $percentageCompleted ?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-11%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z" />
                                    </svg>
                                    <span class="counter">
                                   <?php
                                        $stmt = $conn->prepare("SELECT SUM(number) AS count FROM teamrequried WHERE completed = 0 AND Company_id = ?");
                                        $stmt->bind_param("i", $companyId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();                                      
                                        if ($row && $row['count'] !== null) {
                                            echo $row['count'];
                                        } else {
                                            echo 0;
                                        }
                                        ?>                                  
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4" onclick="window.location.href='recruitment.php?model=applications'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Applications Received</h5>
                                    <div id="circle-progress-05" class="circle-progress circle-progress-pink d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $percentageapplication ?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-11%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#f98bc6" d="M128 64c0-35.3 28.7-64 64-64H352V128c0 17.7 14.3 32 32 32H512V448c0 35.3-28.7 64-64 64H192c-35.3 0-64-28.7-64-64V336H302.1l-39 39c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l39 39H128V64zm0 224v48H24c-13.3 0-24-10.7-24-24s10.7-24 24-24H128zM512 128H384V0L512 128z" />
                                    </svg>
                                    <span class="counter" id="application"></span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-6 col-lg-4" onclick="window.location.href='recruitment.php?model=todayinterview'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Today Interview</h5>
                                    <?php
                                        $today = date('Y-m-d');

                                        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM job_applications WHERE `status` = 'shortlist' AND DATE(`interviewdate`) = ? AND Company_id = ?");
                                        $stmt->bind_param("si", $today, $companyId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $hiredCount = ($row = $result->fetch_assoc()) ? $row["count"] : 0;

                                        $totalResult = $conn->query("SELECT COUNT(*) AS total FROM job_applications");
                                        $totalCount = ($totalRow = $totalResult->fetch_assoc()) ? $totalRow["total"] : 0;

                                        $percentage = $totalCount > 0 ? ($hiredCount / $totalCount) * 100 : 0;
                                        $progress = $percentage;
                                        ?>
                                    <div id="circle-progress-07" class="circle-progress circle-progress-green d-flex flex-column align-items-center justify-content-center" 
                                    data-min-value="0" data-max-value="100" data-value="<?=$progress?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-11%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#0a954f" d="M320 96H192L144.6 24.9C137.5 14.2 145.1 0 157.9 0H354.1c12.8 0 20.4 14.2 13.3 24.9L320 96zM192 128H320c3.8 2.5 8.1 5.3 13 8.4C389.7 172.7 512 250.9 512 416c0 53-43 96-96 96H96c-53 0-96-43-96-96C0 250.9 122.3 172.7 179 136.4l0 0 0 0c4.8-3.1 9.2-5.9 13-8.4zm84 88c0-11-9-20-20-20s-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V424c0 11 9 20 20 20s20-9 20-20V410.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l0 0-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V216z" />
                                    </svg>
                                    <span class="counter">
                                      <?=$hiredCount?>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>    

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='recruitment.php?model=shortlisted'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Shortlisted</h5>
                                    <div id="circle-progress-03" class="circle-progress circle-progress-warning d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $getCountshortlist ?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-16%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#ffcf52" d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                                    </svg>
                                    <span class="counter" id="Shortlisted"></span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='recruitment.php?model=selected'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Selected</h5>
                                    <div id="circle-progress-02" class="circle-progress circle-progress-info d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $hire ?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-16%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#51bbfe" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                    </svg>
                                    <span class="counter" id="selected"></span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='recruitment.php?model=rejected'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Rejected</h5>
                                    <div id="circle-progress-04" class="circle-progress circle-progress-danger d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $rejected ?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-16%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#ca0101" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L381.9 274c48.5-23.2 82.1-72.7 82.1-130C464 64.5 399.5 0 320 0C250.4 0 192.4 49.3 178.9 114.9L38.8 5.1zM545.5 512H528L284.3 320h-59C136.2 320 64 392.2 64 481.3c0 17 13.8 30.7 30.7 30.7H545.3l.3 0z" />
                                    </svg>
                                    <span class="counter" id="rejected"></span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='recruitment.php?model=hired'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Hired</h5>
                                    <?php
                                        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM job_applications WHERE `status` = 'hired' AND Company_id = ?");
                                        $stmt->bind_param("i", $companyId); $stmt->execute(); $result = $stmt->get_result();
                                        $hiredCount = ($row = $result->fetch_assoc()) ? $row["count"] : 0;

                                        $totalResult = $conn->query("SELECT COUNT(*) AS total FROM job_applications");
                                        $totalCount = ($totalRow = $totalResult->fetch_assoc()) ? $totalRow["total"] : 0;

                                        $percentage = $totalCount > 0 ? ($hiredCount / $totalCount) * 100 : 0;
                                        $progress = $percentage ;
                                        ?>
                                    <div id="circle-progress-06" class="circle-progress circle-progress-green d-flex flex-column align-items-center justify-content-center" 
                                    data-min-value="0" data-max-value="100" data-value="<?=$progress?>" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-16%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#0a954f" d="M320 96H192L144.6 24.9C137.5 14.2 145.1 0 157.9 0H354.1c12.8 0 20.4 14.2 13.3 24.9L320 96zM192 128H320c3.8 2.5 8.1 5.3 13 8.4C389.7 172.7 512 250.9 512 416c0 53-43 96-96 96H96c-53 0-96-43-96-96C0 250.9 122.3 172.7 179 136.4l0 0 0 0c4.8-3.1 9.2-5.9 13-8.4zm84 88c0-11-9-20-20-20s-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V424c0 11 9 20 20 20s20-9 20-20V410.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l0 0-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V216z" />
                                    </svg>
                                    <span class="counter" id="hire">
                                       <?php
                                        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM job_applications WHERE `status` = 'hired' AND Company_id = ?");
                                        $stmt->bind_param("i", $companyId); $stmt->execute(); $result = $stmt->get_result();
                                        echo ($row = $result->fetch_assoc()) ? $row["count"] : 0;
                                        ?>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>               
                </div>
                 
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                <h4 class="card-title">Reports</h4>
                                </div>
                            </div>
                        </div>

                <div class="row mt-5">
                    <div class="col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Department Wise</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title text-center">Application Received by Source</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="barChart" style="width:100%;max-width:600px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Recruitment Report</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="applicationWise"></canvas>
                    </div>
                </div>

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
                    <?php if (isset($_GET['model']) && $_GET['model'] == "totalrequirement") { ?>
                        <div class="col-sm-12" id="totalrequirement">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Requirements List</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Request Sender</th>
                                                    <th>Required Role</th>
                                                    <th>Required Experience</th>
                                                    <th>Required Resources</th>
                                                    <th>Time to Hire</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($requirementdata)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($requirementdata as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['RequiredRole'] ?> </td>
                                                        <td><?= $rd['RequiredExperience'] ?></td>
                                                        <td><?= $rd['number'] ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($rd['TimeToHire'])) ?></td>
                                                        <td style="font-weight: bold;">
                                                            <?= $rd['Status'] ?>
                                                        </td>
                                                       <td>
                                                        <button link="https://jiffy.mineit.tech/register.php?jobid=<?= base64_encode($rd['Id']) ?>&companyid=<?= base64_encode($rd['Company_id']) ?>" type="button" class="btn btn-info" onclick="copyLink('<?= $rd['Id'] ?>')" style="border-radius: 12px;">
                                                            <div data-toggle="tooltip" data-placement="bottom" title="Get link">
                                                                <i class="fas fa-link"></i>
                                                            </div>
                                                        </button>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewModal<?= $rd['Id'] ?>" style="border-radius: 12px;">
                                                            <div data-toggle="tooltip" data-placement="bottom" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </div>
                                                        </button>
                                                    </td>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="viewModal<?= $rd['Id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?= $rd['Id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="viewModalLabel<?= $rd['Id'] ?>">Job Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">          
                                                                    <p style='text-align:justify'><?= $rd['Message'] ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </tbody>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>                   
                    <?php if (isset($_GET['model']) && $_GET['model'] == "applications") { ?>
                        <div class="col-sm-12" id="applications">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Received Applications List</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Candidate Name</th>
                                                    <th>Applied Role</th>
                                                    <th>Email ID</th>
                                                    <th>Mobile No</th>
                                                    <th>Experience</th>
                                                    <th>Resume</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($totalapplydata)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($totalapplydata as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['RequiredRole'] ?></td>
                                                        <td><?= $rd['email'] ?> </td>
                                                        <td><?= $rd['phone'] ?></td>
                                                        <td><?= $rd['work_experience'] ?></td>
                                                        <td>
                                                            <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="Download file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                </svg>
                                                            </div>
                                                        </td>
                                                        <script>
                                                            document.getElementById("downloadButton").addEventListener("click", function() {
                                                                var filePath = "./../<?= $rd['resume_path'] ?>";
                                                                window.open(filePath, "_blank");
                                                            });
                                                        </script>

                                                        <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#updateStatus" style="background-color: green;">
                                                                <div data-toggle="tooltip" data-placement="bottom" title="Update Changes">
                                                                    Update
                                                                </div>
                                                            </button>
                                                        </td>

                                                        <!--Update modal -->
                                                        <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Candidate Status</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="" method="post" enctype="multipart/form-data">
                                                                            <div class="form-group">
                                                                                <label for="department">Select Status</label>
                                                                                <select class="form-control" name="status" id="statusSelect" required>
                                                                                    <option value="">Select</option>
                                                                                    <option value="shortlist">Shortlist</option>
                                                                                    <option value="rejected">Reject</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group" id="meetingDateTimeGroup" style="display: none;">
                                                                                <label for="meeting_datetime">Company Name</label>
                                                                                <input type="text" class="form-control mb-2" id="meeting_datetime" name="companyname" required>
                                                                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $rd['id'] ?>">

                                                                                <input type="hidden" class="form-control" id="id" name="InterviewerName" value="<?= $rd['full_name'] ?>">

                                                                                <input type="hidden" class="form-control" id="id" name="roles" value="<?= $rd['RequiredRole'] ?>">
                                                                                <label for="meeting_link">Meeting Link</label>
                                                                                <input type="text" class="form-control" id="meeting_link" name="meeting_link" required>
                                                                                
                                                                            </div>

                                                                            <div class="col-lg-12 mt-5 text-center">
                                                                                <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit"> <!-- corrected name to submit -->
                                                                            </div>

                                                                            <script>
                                                                                document.getElementById('statusSelect').addEventListener('change', function() {
                                                                                    var status = this.value;
                                                                                    var meetingDateTimeGroup = document.getElementById('meetingDateTimeGroup');

                                                                                    if (status === 'shortlist') {
                                                                                        meetingDateTimeGroup.style.display = 'block';
                                                                                    } else {
                                                                                        meetingDateTimeGroup.style.display = 'none';
                                                                                    }
                                                                                });
                                                                            </script>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </tbody>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>                  
                    <?php if (isset($_GET['model']) && $_GET['model'] == "selected") { ?>
                        <div class="col-sm-12" id="selected1">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Selected Candidates List</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Candidate Name</th>
                                                    <th>Role</th>
                                                    <th>Email ID</th>
                                                    <th>Mobile No</th>
                                                    <th>Experience</th>
                                                    <th>Cost Spend</th>
                                                    <th>Status</th>
                                                    <th>Update</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($selected)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($selected as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['RequiredRole'] ?></td>
                                                        <td><?= $rd['email'] ?> </td>
                                                        <td><?= $rd['phone'] ?></td>
                                                        <td><?= $rd['work_experience'] ?></td>
                                                        <td><?= $rd['cost'] ?></td>
                                                        <td style="font-weight: bold;">
                                                            <?= $rd['status1'] ?>
                                                        </td>
                                                        <?php
                                                        $disableButton = ($rd['status1'] == 'Pending') ? 'disabled' : ''; // Conditionally set the 'disabled' attribute
                                                        ?>

                                                        <td>
                                                            <button type="button" class="btn btn-success <?= $disableButton ?>" data-toggle="modal" data-target="#updateStatus" style="background-color: green;">
                                                                <div data-toggle="tooltip" data-placement="bottom" title="Update Changes">
                                                                    Update
                                                                </div>
                                                            </button>
                                                        </td>

                                                    </tbody>
                                                    <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Update Candidate Status</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="" method="post" enctype="multipart/form-data" id="applicationForm">
                                                                        <div class="form-group">
                                                                            <label for="department">Select Status</label>
                                                                            <select class="form-control" name="status" id="statusSelect" required>
                                                                                <option value="">Select</option>
                                                                                <option value="hired">Hire</option>
                                                                                <option value="rejected">Reject</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group" id="meetingDateTimeGroup" style="display: none;">
                                                                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $rd['id'] ?>">
                                                                            <label for="offer_letter">Upload Offer Letter</label>
                                                                            <input type="file" class="form-control mb-2" id="offer_letter" name="offer_letter">
                                                                            <label for="offer_letter">Time to Join</label>
                                                                            <input type="date" class="form-control" id="due" name="due">
                                                                        </div>


                                                                        <div class="col-lg-12 mt-5 text-center">
                                                                            <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit">
                                                                        </div>
                                                                    </form>
                                                                    <script>
                                                                        document.getElementById('statusSelect').addEventListener('change', function() {
                                                                            var status = this.value;
                                                                            if (status === 'hired') {
                                                                                document.getElementById('meetingDateTimeGroup').style.display = 'block';
                                                                                document.getElementById('costGroup').style.display = 'none';
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            document.getElementById('statusSelect').addEventListener('change', function() {
                                                                var status = this.value;
                                                                var meetingDateTimeGroup = document.getElementById('cost');

                                                                if (status === 'selected') {
                                                                    meetingDateTimeGroup.style.display = 'block';
                                                                } else {
                                                                    meetingDateTimeGroup.style.display = 'none';
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['model']) && $_GET['model'] == "rejected") { ?>
                        <div class="col-sm-12" id="rejected1">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Rejected Candidates List</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Candidate Name</th>
                                                    <th>Role</th>
                                                    <th>Email ID</th>
                                                    <th>Mobile No</th>
                                                    <th>Experience</th>
                                                    <th>Cost Spend</th>
                                                    <th>Resume</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($rejecteddata)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($rejecteddata as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['RequiredRole'] ?></td>
                                                        <td><?= $rd['email'] ?> </td>
                                                        <td><?= $rd['phone'] ?></td>

                                                        <td><?= $rd['work_experience'] ?></td>
                                                        <td><?= !empty($rd['cost']) ? $rd['cost'] : '0' ?></td>

                                                        <td>
                                                            <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="Download file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                </svg>
                                                            </div>
                                                        </td>
                                                        <script>
                                                            document.getElementById("downloadButton").addEventListener("click", function() {
                                                                var filePath = "./../<?= $rd['resume_path'] ?>";
                                                                window.open(filePath, "_blank");
                                                            });
                                                        </script>

                                                        <!--Update modal -->
                                                        <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Candidate Status</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="" method="post" enctype="multipart/form-data">
                                                                            <div class="form-group">
                                                                                <label for="department">Select Status</label>
                                                                                <select class="custom-select" name="status" id="statusSelect">
                                                                                    <option value="">Select Status</option>
                                                                                    <option value="selected">Select</option>

                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group" id="meetingDateTimeGroup" style="display: none;">
                                                                                <label for="meeting_datetime">Select Meeting Date and Time</label>
                                                                                <input type="datetime-local" class="form-control" id="meeting_datetime" name="meeting_datetime">
                                                                                <input type="hidden" class="form-control" id="meeting_datetime" name="id" value="<?= $rd['id'] ?>">
                                                                            </div>
                                                                            <div class="col-lg-12 mt-5 text-center">
                                                                                <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit"> <!-- corrected name to submit -->
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </tbody>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['model']) && $_GET['model'] == "hired") { ?>
                        <div class="col-sm-12" id="hired1">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Hired Candidates List</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Candidate Name</th>
                                                    <th>Email ID</th>
                                                    <th>Mobile No</th>
                                                    <th>Experience</th>
                                                    <th>Cost Spend</th>
                                                    <th>Resume</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($hired)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($hired as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['email'] ?> </td>
                                                        <td><?= $rd['phone'] ?></td>
                                                        <td><?= $rd['work_experience'] ?></td>
                                                        <td>
                                                            <?= $rd['cost'] ?>
                                                        </td>
                                                        <td>
                                                            <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="Download file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                </svg>
                                                            </div>
                                                        </td>
                                                        <script>
                                                            document.getElementById("downloadButton").addEventListener("click", function() {
                                                                var filePath = "./../<?= $rd['resume_path'] ?>";
                                                                window.open(filePath, "_blank");
                                                            });
                                                        </script>


                                                    </tbody>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['model']) && $_GET['model'] == "todayinterview") { ?>
                        <div class="col-sm-12" id="todayinterview">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Today Interview</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Candidate Name</th>
                                                    <th>Role</th>
                                                    <th>Email ID</th>
                                                    <th>Mobile No</th>
                                                    <th>Time</th>
                                                    <th>Resume</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($shortlistapplydata)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($shortlistapplydata as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['RequiredRole'] ?></td>
                                                        <td><?= $rd['email'] ?> </td>
                                                        <td><?= $rd['phone'] ?></td>
                                                        <td>
                                                            <?php
                                                            $interviewDate = new DateTime($rd['interviewdate']);
                                                            echo $interviewDate->format('h:i A');
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="Download file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                </svg>
                                                            </div>
                                                        </td>
                                                        <script>
                                                            document.getElementById("downloadButton").addEventListener("click", function() {
                                                                var filePath = "./../<?= $rd['resume_path'] ?>";
                                                                window.open(filePath, "_blank");
                                                            });
                                                        </script>

                                                        <<td>
                                                            <button type="button" class="btn btn-success" style="background-color:green;" data-toggle="modal" data-target="#updateStatus">
                                                                <div data-toggle="tooltip" data-placement="bottom" title="Update Changes">
                                                                    <i class="fas fa-edit"></i> Update
                                                                </div>
                                                            </button>
                                                            <button type="button" class="btn btn-primary" style="background-color:blue;"  onclick="window.open('<?= $rd['interviewlink'] ?>', '_blank')">
                                                                <div data-toggle="tooltip" data-placement="bottom" title="Join">
                                                                    <i class="fas fa-user-plus"></i> Join
                                                                </div>
                                                            </button>
                                                        </td>

                                                        <!--Update modal -->
                                                        <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Candidate Status</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="" method="post" enctype="multipart/form-data" id="applicationForm">
                                                                            <div class="form-group">
                                                                                <label for="department">Select Status</label>
                                                                                <select class="form-control" name="status" id="statusSelect" required>
                                                                                    <option value="">Select</option>
                                                                                    <option value="selected">Select</option>
                                                                                    <option value="rejected">Reject</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group" id="meetingDateTimeGroup" style="display: none;">
                                                                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $rd['id'] ?>">
                                                                                <label for="cost">Hiring Cost</label>
                                                                                <input type="number" class="form-control" id="cost" name="cost">

                                                                            </div>

                                                                            <div class="col-lg-12 mt-5 text-center">
                                                                                <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit">
                                                                            </div>
                                                                        </form>

                                                                        <script>
                                                                            document.getElementById('statusSelect').addEventListener('change', function() {
                                                                                var status = this.value;
                                                                                if (status === 'selected') {
                                                                                    document.getElementById('meetingDateTimeGroup').style.display = 'block';
                                                                                    document.getElementById('costGroup').style.display = 'none';
                                                                                }
                                                                            });
                                                                        </script>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                document.getElementById('statusSelect').addEventListener('change', function() {
                                                                    var status = this.value;
                                                                    var meetingDateTimeGroup = document.getElementById('cost');

                                                                    if (status === 'selected') {
                                                                        meetingDateTimeGroup.style.display = 'block';
                                                                    } else {
                                                                        meetingDateTimeGroup.style.display = 'none';
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </tbody>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['model']) && $_GET['model'] == "shortlisted") { ?>
                        <div class="col-sm-12" id="shortlisted">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Interview List</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table data-table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>SI.No</th>
                                                    <th>Candidate Name</th>
                                                    <th>Role</th>
                                                    <th>Email ID</th>
                                                    <th>Mobile No</th>
                                                    <th>Time</th>
                                                    <th>Resume</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php if (!empty($shortlistapplydata)) { ?>
                                                <?php $id = 0 ?>
                                                <?php foreach ($shortlistapplydata as $rd) { ?>
                                                    <tbody>
                                                        <td><?= ++$id ?></td>
                                                        <td><?= $rd['full_name'] ?></td>
                                                        <td><?= $rd['RequiredRole'] ?></td>
                                                        <td><?= $rd['email'] ?> </td>
                                                        <td><?= $rd['phone'] ?></td>
                                                        <td>
                                                            <?php
                                                            $interviewDate = new DateTime($rd['interviewdate']);
                                                            echo $interviewDate->format('d-m-Y/h:i A');
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="Download file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                </svg>
                                                            </div>
                                                        </td>
                                                        <script>
                                                            document.getElementById("downloadButton").addEventListener("click", function() {
                                                                var filePath = "./../<?= $rd['resume_path'] ?>";
                                                                window.open(filePath, "_blank");
                                                            });
                                                        </script>

                                                        <td>
                                                            <button type="button" class="btn btn-success" style="background-color:green;" data-toggle="modal" data-target="#updateStatus">
                                                                <div data-toggle="tooltip" data-placement="bottom" title="Update Changes">
                                                                    <i class="fas fa-edit"></i> Update
                                                                </div>
                                                            </button>
                                                            <button type="button" class="btn btn-primary" style="background-color:blue;"  onclick="window.open('<?= $rd['interviewlink'] ?>', '_blank')">
                                                                <div data-toggle="tooltip" data-placement="bottom" title="Join">
                                                                    <i class="fas fa-user-plus"></i> Join
                                                                </div>
                                                            </button>
                                                        </td>

                                                        <!--Update modal -->
                                                        <div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Candidate Status</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="" method="post" enctype="multipart/form-data" id="applicationForm">
                                                                            <div class="form-group">
                                                                                <label for="department">Select Status</label>
                                                                                <select class="form-control" name="status" id="statusSelect" required>
                                                                                    <option value="">Select</option>
                                                                                    <option value="selected">Select</option>
                                                                                    <option value="rejected">Reject</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group" id="meetingDateTimeGroup" style="display: none;">
                                                                                <input type="hidden" class="form-control" id="id" name="id" value="<?= $rd['id'] ?>">
                                                                                <label for="cost">Hiring Cost</label>
                                                                                <input type="number" class="form-control" id="cost" name="cost">

                                                                            </div>

                                                                            <div class="col-lg-12 mt-5 text-center">
                                                                                <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit">
                                                                            </div>
                                                                        </form>

                                                                        <script>
                                                                            document.getElementById('statusSelect').addEventListener('change', function() {
                                                                                var status = this.value;
                                                                                if (status === 'selected') {
                                                                                    document.getElementById('meetingDateTimeGroup').style.display = 'block';
                                                                                    document.getElementById('costGroup').style.display = 'none';
                                                                                }
                                                                            });
                                                                        </script>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                document.getElementById('statusSelect').addEventListener('change', function() {
                                                                    var status = this.value;
                                                                    var meetingDateTimeGroup = document.getElementById('cost');

                                                                    if (status === 'selected') {
                                                                        meetingDateTimeGroup.style.display = 'block';
                                                                    } else {
                                                                        meetingDateTimeGroup.style.display = 'none';
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </tbody>
                                                <?php } ?>
                                            <?php }  ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                   
                </div>
            </div>
        </div>





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
        <!--chart-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script>
            $(document).ready(function() {
                demartment();
            });

            function demartment() {
                $.ajax({
                    type: "GET",
                    url: "./../admin/getcount.php",
                    dataType: "json",
                    success: function(data) {
                        let market = data.department.Marketing_count;
                        let IT = data.department.IT_count;
                        let NonIT = data.department.Non_IT_count;
                        let Hr = data.department.HR_count;
                        let Management = data.department.Management_count;
                        let Accounts = data.department.Accounts_count;
                        const xValues = ["Marketing", "IT", "Non IT", "HR", "Management", "Accounts"];
                        const yValues = [market, IT, NonIT, Hr, Management, Accounts];
                        const barColors = [
                            "#2E388F",
                            "#009CE3",
                            "#ffae19",
                            "#E82428",
                            "#545456",
                            "#0EA64F"
                        ];
                        new Chart("myChart", {
                            type: "doughnut",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                source();
            });

            function source() {
                $.ajax({
                    type: "GET",
                    url: "./../admin/getcount.php",
                    dataType: "json",
                    success: function(data) {
                        let JobPortal = data.portal.jobPortal_count;
                        let SocialMedia = data.portal.socialMedia_count;
                        let Referral = data.portal.referral_count;
                        let OurPortal = data.portal.our_portal;
                        const x = ["Our Portal", "JobPortal", "SocialMedia", "Referral"];
                        const y = [JobPortal, SocialMedia, Referral, OurPortal];
                        const Colors = ["#18574F", "#9DCBF7", "#CC5468", "#F4E621"];

                        new Chart("barChart", {
                            type: "bar",
                            data: {
                                labels: x,
                                datasets: [{
                                    backgroundColor: Colors,
                                    data: y
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                sourcereport();
            });

            function sourcereport() {
                $.ajax({
                    type: "GET",
                    url: "./../admin/getcount.php",
                    dataType: "json",
                    success: function(data) {
                        // Retrieve data from the JSON response
                        var totalTasks = data.totalTasks;
                        var totalApplications = data.totalApplications;
                        var getCountApplicationNew2 = data.getCountApplicationNew2;
                        var shortlist = (getCountApplicationNew2 / data.shortlist) * 100;
                        var hire = data.hire;
                        var selected = data.selected;
                        var rejected = data.rejected;

                        // Calculate percentages for each category
                        var interviewedPercent = ((hire + rejected + selected) / getCountApplicationNew2) * 100;
                        var shortlistedPercent = (data.shortlist / getCountApplicationNew2) * 100;
                        var rejectedPercent = (rejected / getCountApplicationNew2) * 100;
                        var hiredPercent = (hire / getCountApplicationNew2) * 100;

                        // Prepare chart data
                        var xApplicant = ["Interviewed", "Shortlisted", "Rejected", "Hired"];
                        var yApplicant = [interviewedPercent, shortlistedPercent, rejectedPercent, hiredPercent];
                        var barColors = ["#0000F6", "#FFCF52", "#CA0101", "#0A954F"];

                        // Create a new horizontal bar chart
                        new Chart("applicationWise", {
                            type: "horizontalBar",
                            data: {
                                labels: xApplicant,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yApplicant
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    x: {
                                        min: 0,
                                        max: 100,
                                        ticks: {
                                            stepSize: 20 // Adjust step size as needed
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            }
        </script>

        <script>
            window.onload = function() {
                const urlParams = new URLSearchParams(window.location.search);
                const modelParam = urlParams.get('model');
                const jobIdParam = urlParams.get('jobid');

                if (modelParam === 'totalrequirement') {
                    console.log("Model parameter found: totalrequirement");
                    const totalRequirementElement = document.getElementById('totalrequirement');
                    if (totalRequirementElement) {
                        console.log("Element found: totalrequirement");
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: totalrequirement");
                    }
                } else if (jobIdParam) {
                    console.log("Job ID parameter found: 1");
                    const totalRequirementElement = document.getElementById('totalrequirement1');
                    if (totalRequirementElement) {
                        console.log("Element found: totalrequirement1");
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: totalrequirement1");
                    }
                } else if (modelParam === 'applications') {
                    console.log("Job ID parameter found: 1");
                    const totalRequirementElement = document.getElementById('applications');
                    if (totalRequirementElement) {
                        console.log("Element found: applications");
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: applications");
                    }
                } else if (modelParam === 'shortlisted') {

                    const totalRequirementElement = document.getElementById('shortlisted');
                    if (totalRequirementElement) {
                        console.log("Element found: shortlisted");
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: shortlisted");
                    }
                } else if (modelParam === 'selected') {

                    const totalRequirementElement = document.getElementById('selected1');
                    if (totalRequirementElement) {
                        console.log("Element found: selected");
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: selected");
                    }
                } else if (modelParam === 'rejected') {
                    console.log("Job ID parameter found: 1");
                    const totalRequirementElement = document.getElementById('rejected1');
                    if (totalRequirementElement) {
                        console.log("Element found: rejected");
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: rejected");
                    }
                } else if (modelParam === 'hired') {
                    console.log("Job ID parameter found: 1");
                    const totalRequirementElement = document.getElementById('hired1');
                    if (totalRequirementElement) {
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: rejected");
                    }
                }else if (modelParam === 'todayinterview') {
                    console.log("Job ID parameter found: 1");
                    const totalRequirementElement = document.getElementById('todayinterview');
                    if (totalRequirementElement) {
                        const offsetTop = totalRequirementElement.getBoundingClientRect().top;
                        window.scrollTo({
                            top: window.scrollY + offsetTop,
                            behavior: 'smooth'
                        });
                    } else {
                        console.log("Element not found: rejected");
                    }
                }
            };
        </script>

        <script>
            function copyLink(jobId) {
                const link = document.querySelector('button[onclick="copyLink(\'' + jobId + '\')"]').getAttribute('link');
                const tempInput = document.createElement('input');
                tempInput.value = link;
                document.body.appendChild(tempInput);
                tempInput.select();
                tempInput.setSelectionRange(0, 99999);
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                alert('Link copied!');
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                statusupdate();
            });

            function statusupdate() {
                $.ajax({
                    type: "GET",
                    url: "./../admin/getcount.php",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#teamrequried").text(data.totalTasks);
                        $("#application").text(data.totalApplications);
                        $("#Shortlisted").text(data.shortlist);
                        $("#selected").text(data.selected);
                        $("#hire").text(data.hire);
                        $("#rejected").text(data.rejected);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }
        </script>

        <script>
            function getUserLocationAndSend() {
                if ('geolocation' in navigator) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;

                            const locationData = {
                                latitude: latitude,
                                longitude: longitude
                            };

                            fetch('./../admin/locationupdate.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify(locationData)
                                })
                                .then(response => {
                                    if (response.ok) {
                                        return response.text();
                                    } else {
                                        throw new Error('Failed to update location.');
                                    }
                                })
                                .then(data => {

                                })
                                .catch(error => {
                                    console.error('Error updating location:', error);
                                });
                        },
                        function(error) {
                            console.log(`Error getting location: ${error.message}`);
                        }
                    );
                } else {
                    console.log('Geolocation is not supported by this browser.');
                }
            }

            setInterval(getUserLocationAndSend, 5000);
        </script>




</body>

</html>