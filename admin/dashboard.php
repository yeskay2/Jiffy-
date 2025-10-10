<?php
session_start();
include "./../include/config.php";
include './../././timezone.php';
date_default_timezone_set('Asia/Kolkata');
if (empty($_SESSION['user_id'])) {  
    header('Location: index.php');
    die;
}
$userid = $_SESSION["user_id"];
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
    <link href="./../assets/images/dummy logo.png" rel="icon">
    <link href="./../assets/images/dummy logo.png" rel="apple-touch-icon">
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
     #popup {
            width: 300px;
            margin: 0 auto;
            display: none;
            text-align: center;
            z-index: 999;
        }

        @keyframes blinkAnimation {
            0% {
                opacity: 1;
                color: #C10000;
            }

            50% {
                font-size: 10px;
            }

            100% {
                opacity: 1;
                font-size: 22px;
                color: #C10000;
            }
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .modal-body #eventModalContent {
            text-align: justify;
            padding: 25px;
            margin-top: -40px;

        }

        #chat1 {
            width: 50px;
            height: 50px;
            right: 11px;
            position: relative;
            top: -8px;
        }

        .progress-circle {
            width: 100px;
            height: 100px;
            background-color: #fff;
            border: 3px solid #bc2d75;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
        }

        .countdown-number {
            color: #333;
        }
        .anchor-card:hover{
            background-color: #fcf7fa;
            border-radius : 16px;
        }
    </style>
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
         .search-content{
            display:none;
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

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='employees.php'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">Registered Employees</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                </div>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM employee WHERE active ='active' AND Company_id = '$companyId'";
                                $result = mysqli_query($conn, $query);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $total = $row['total'];

                                ?>

                                        <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                                <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" fill="#bc2d75" />
                                            </svg>
                                            <span class="counter"><?php echo  $total; ?></span>
                                        </h4>

                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                            <p class="mb-0">Total Employees</p>
                                            <span class="text-primary"><?php echo  $total; ?></span>
                                        </div>

                                        <div class="iq-progress-bar bg-primary-light mt-2">
                                            <span class="bg-primary iq-progress progress-1" data-percent="<?php echo  $total; ?>"></span>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" >
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">On Time Percentage</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                            cursor:pointer;
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                    <?php

                                    $todayDate = date("d-m-Y");

                                     $query = "SELECT COUNT(*) as totalOnTime FROM attendance WHERE date = '$todayDate'
                                     AND TIME(time_in) <= (SELECT time_in FROM schedules WHERE Company_id = '$companyId' ) AND Company_id = '$companyId'";
                                    $result = mysqli_query($conn, $query);
                                    $totalOnTime = 0;
                                    $totalEmployees = 0;
                                    $onTimePercentage = 0;

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $totalOnTime = $row['totalOnTime'];
                                    }
                                    $totalEmployeesQuery = "SELECT COUNT(*) as totalEmployees FROM employee WHERE active ='active' AND Company_id = '$companyId'";
                                    $totalEmployeesResult = mysqli_query($conn, $totalEmployeesQuery);
                                    if ($totalEmployeesResult && mysqli_num_rows($totalEmployeesResult) > 0) {
                                        $row = mysqli_fetch_assoc($totalEmployeesResult);
                                        $totalEmployees = $row['totalEmployees'];
                                    }
                                    if ($totalEmployees > 0) {
                                        $onTimePercentage = ($totalOnTime / $totalEmployees) * 100;
                                    }
                                    ?>
                                </div>

                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 384 512" style="margin-right: 10px;">
                                        <path d="M374.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-320 320c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l320-320zM128 128A64 64 0 1 0 0 128a64 64 0 1 0 128 0zM384 384a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z" fill="#51bbfe" />
                                    </svg>
                                    <span class="counter"><?php echo $totalOnTime; ?></span>
                                </h4>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">On Time Percentage</p>
                                    <span class="text-info"><?php echo number_format($onTimePercentage, 2); ?>%</span>
                                </div>
                                <div class="iq-progress-bar bg-info-light mt-2">
                                    <span class="bg-info iq-progress progress-1" data-percent="<?php echo $onTimePercentage; ?>"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3" onclick="window.location.href='attendence.php?period=today'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">On Time Today</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>

                                </div>
                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" style="margin-right: 10px;">
                                        <path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" fill="#ffcf52" />
                                    </svg>
                                    <span class="counter"><?php echo $totalOnTime; ?></span>
                                </h4>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">On Time Today</p>
                                    <span class="text-warning"><?php echo $totalOnTime; ?></span>
                                </div>
                                <div class="iq-progress-bar bg-warning-light mt-2">
                                    <span class="bg-warning iq-progress progress-1" data-percent=""></span>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6 col-lg-3" onclick="window.location.href='attendence.php?period=late'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">Late Today</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                    <?php
                                    $today = date('d-m-Y');

                                    $sql = "SELECT time_in FROM attendance WHERE date = '$today' AND status = 1 AND Company_id = '$companyId'";
                                    $result = mysqli_query($conn, $sql);

                                    $lateCount = 0;

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeIn = strtotime($row['time_in']);

                                        $scheduleSql = "SELECT time_in FROM schedules WHERE Company_id = '$companyId'";
                                        $scheduleResult = mysqli_query($conn, $scheduleSql);

                                        if ($scheduleResult && mysqli_num_rows($scheduleResult) > 0) {
                                            $scheduleRow = mysqli_fetch_assoc($scheduleResult);
                                            $scheduleTimeIn = strtotime($scheduleRow['time_in']);

                                            if ($timeIn > $scheduleTimeIn) {
                                                $lateCount++;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 640 512" fill="#50c6b4" style="margin-right: 10px;">
                                        <path d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 352h8.2c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM320 352H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H360.2C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zM496 288c8.8 0 16 7.2 16 16v48h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V304c0-8.8 7.2-16 16-16z" />
                                    </svg><span class="counter"><?php echo $lateCount; ?></span></h4>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Late Today</p>
                                    <span class="text-danger"><?php echo $lateCount; ?></span>
                                </div>
                                <div class="iq-progress-bar bg-success-light mt-2">
                                    <span class="bg-primary iq-progress progress-1" data-percent="<?php echo  $lateCount; ?>"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3" onclick="window.location.href='department.php'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">Total Departments</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM department WHERE Company_id = '$companyId'";
                                    $result = mysqli_query($conn, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $total = $row['total'];

                                    ?>
                                </div>
                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 640 512" fill="#393a3f" style="margin-right: 10px;">
                                        <path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h89.9c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2V271.8 48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zM576 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM352 477.1c0 19.3 15.6 34.9 34.9 34.9H605.1c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1H445.1c-51.4 0-93.1 41.7-93.1 93.1z" />
                                    </svg>
                                    <span class="counter"><?php echo  $total; ?></span>
                                </h4>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Total Departments</p>
                                    <span class="text-dark"><?php echo  $total; ?></span>
                                </div>

                                <div class="iq-progress-bar bg-dark-light mt-2">
                                    <span class="bg-dark iq-progress progress-1" data-percent="<?php echo  $total; ?>"></span>
                                </div>
                        <?php
                                        }
                                    }
                        ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='addhoildays.php?date=Holidays'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">Available Leave Types</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                    <?php
                                    $query = "SELECT COUNT(*) as total FROM holiday WHERE Company_id = '$companyId'";
                                    $result = mysqli_query($conn, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $total = $row['total'];

                                    ?>
                                </div>
                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" fill="#931f1d" style="margin-right: 10px;">
                                        <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                                    </svg>
                                    <span class="counter"><?php echo  $total; ?></span>
                                </h4>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Total Leaves</p>
                                    <span class="text-danger"><?php echo  $total; ?></span>
                                </div>

                                <div class="iq-progress-bar bg-danger-light mt-2">
                                    <span class="bg-danger iq-progress progress-1" data-percent="<?php echo  $total; ?>"></span>
                                </div>
                        <?php
                                        }
                                    }
                        ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='leave.php?period=pending'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">Pending Leave Requests</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                    <?php
                                    $query = "SELECT count(id) as total from tblleaves WHERE Status = '0' AND Company_id = '$companyId'";
                                    $result = mysqli_query($conn, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $total = $row['total'];

                                    ?>
                                </div>
                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" fill="#f53d62" style="margin-right: 10px;">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM224 192V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V192c0-17.7 14.3-32 32-32s32 14.3 32 32zm128 0V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V192c0-17.7 14.3-32 32-32s32 14.3 32 32z" />
                                    </svg>
                                    <span class="counter"><?php echo  $total; ?></span>
                                </h4>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Pending leaves</p>
                                    <span style="color:#f53d62"><?php echo  $total; ?></span>
                                </div>

                                <div class="iq-progress-bar bg-light mt-2">
                                    <span class="bg-warning- iq-progress progress-1" data-percent="<?php echo  $total; ?>"></span>
                                </div>
                        <?php
                                        }
                                    }
                        ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='leave.php?period=approved'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5 style="margin-bottom: 10px;" class="hover-text">Approved Leaves</h5>
                                    <style>
                                        .hover-text{
                                            transition: color 0.3s ease; /* Smooth
                                            transition*/
                                        }
                                        .hover-text:hover{
                                            color:blue;
                                        }
                                    </style>
                                    <?php
                                    $query = "SELECT count(id) as total from tblleaves WHERE Status = '1' AND Company_id = '$companyId'";
                                    $result = mysqli_query($conn, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $total = $row['total'];

                                    ?>
                                </div>
                                <h4><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 448 512" fill="#3541e3" style="margin-right: 10px;">
                                        <path d="M342.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 178.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l80 80c12.5 12.5 32.8 12.5 45.3 0l160-160zm96 128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 402.7 54.6 297.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l256-256z" />
                                    </svg>
                                    <span class="counter"><?php echo  $total; ?></span>
                                </h4>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Approved Leaves</p>
                                    <span class="text-primary"><?php echo  $total; ?></span>
                                </div>

                                <div class="iq-progress-bar bg-primary-light mt-2">
                                    <span class="bg-primary iq-progress progress-1" data-percent="<?php echo  $total; ?>"></span>
                                </div>
                        <?php
                                        }
                                    }
                        ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <!-- First Column -->
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

                            <!-- Second Column -->
                            
                           
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    </div>
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="celebration">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <div class="row">
                    <div class="col-lg-10">
                        <h3 class="modal-title" id="exampleModalCenterTitle">Hurray!</h3>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="confetti">
                            <div class="squareOne"></div>
                            <div class="squareTwo"></div>
                            <div class="squareThree"></div>
                            <div class="squareFour"></div>
                            <div class="squareFive"></div>
                            <div class="squareSix"></div>
                            <div class="squareSeven"></div>
                            <div class="squareEight"></div>
                            <div class="squareNine"></div>
                            <div class="squareTen"></div>
                        </div>
                        <div class="text-center">
                            <?php if ($isBirthday): ?>
                                <img src="./../assets/images/celebration.gif" class="img-fluid" alt="celebration Image" width="230" height="230" />
                                <h5 class="text-center">Happy Birthday <?php echo $allNames; ?> 🎉🎂</h5>
                                <p class="text-justify p-2 mt-2">🎉 May your special day be filled with joy 😄, success 🏆, and memorable moments 📸. Wishing you continued growth 🌱 and prosperity 💰 in the coming year. 🎊✨</p>
                            <?php elseif ($isWorkAnniversary): ?>
                                <img src="./../assets/images/anniversary.gif" class="img-fluid" alt="celebration Image" width="250" height="250" />
                                <h5 class="text-center">🎊 Congratulations! It is your work anniversary! <?php echo $allNames; ?>  👏</h5>
                                <p class="text-justify p-2 mt-2">🎉 You have completed <?php echo $workingYears; ?> years in our company! 🎊 Marking another year of excellence, dedication, and professional growth. 🌟 Here's to many more successful years ahead! 🚀👏</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var modalShown = document.cookie.replace(/(?:(?:^|.*;\s*)modalShown\s*\=\s*([^;]*).*$)|^.*$/, "$1") === "true";
        var status = <?=$status?>;
        if (!modalShown && status === 0) {
            $('#celebration').modal('show');
            var date = new Date();
            date.setTime(date.getTime() + (24*60*60*1000)); 
            var expires = "expires=" + date.toUTCString();
            document.cookie = "modalShown=true;" + expires + ";path=/";
        }
    });
</script>

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
        document.getElementById('inline-date').value = currentDate;


        fetchEmployees(currentDate);


        document.getElementById('inline-date').addEventListener('change', function() {
            var selectedDate = this.value;
            fetchEmployees(selectedDate);
        });
    </script>


</body>

</html>