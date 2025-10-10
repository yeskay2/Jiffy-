<?php
session_start();
include "./../include/config.php";
include './../././timezone.php';
require_once "./../management/database/getdata.php";
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
    <link href="./../assets/images/gem.png" rel="icon">
    <link href="./../assets/images/gem.png" rel="apple-touch-icon">
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
                                    <h5 style="margin-bottom: 10px;">Company Growth</h5>
                                    <!-- <span class="badge badge-info">Annual</span> -->                                   
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

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='detials.php?details=Income'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Total Income</h5>                                   
                                </div>

                                <h4 class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#025602" d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z" />
                                    </svg>
                                    <span class="counter">
                                        <?php 
                                     $sql = "SELECT SUM(budget) as budget FROM projects WHERE payment_status = 'Paid' AND Company_id = $companyId";
                                     $result = mysqli_query($conn, $sql);
                                     $row = mysqli_fetch_assoc($result);
                                     $budget = $row['budget'];
                                     $Revenue_Collected = $Revenue_Collected + $budget;
                                    echo $Revenue_Collected; ?>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Current Balance</h5>
                                </div>                           
                                        <h4 class="mb-2">
                                            <i class="fas fa-wallet" style="font-size: 26px; color:#ff006e; margin-right: 10px;"></i>
                                            <span class="counter">Upcoming</span>
                                        </h4>                                    
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='detials.php?details=Expense'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Total Expense</h5>

                                </div>
                                <h4 class="mb-2">
                                    <i class="fas fa-donate" style="color:#ffc300; font-size: 28px; margin-right: 10px;"></i>
                                    <span class="counter">
                                        <?php 
                                        $sql  = "SELECT SUM(prize)AS expense FROM 
                                        monthly_expension WHERE Company_id = $companyId";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $expense = $row['expense'];
                                        echo !empty($expense)?$expense:0;
                                                    ?>
                                </span>
                                </h4>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='request.php?details=today'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Today's Requests</h5>
                                  
                                </div>
                                <h4 class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#122586" d="M128 64c0-35.3 28.7-64 64-64H352V128c0 17.7 14.3 32 32 32H512V448c0 35.3-28.7 64-64 64H192c-35.3 0-64-28.7-64-64V336H302.1l-39 39c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l39 39H128V64zm0 224v48H24c-13.3 0-24-10.7-24-24s10.7-24 24-24H128zM512 128H384V0L512 128z" />
                                    </svg>
                                    <span class="counter">
                                    <?php
                                    $today = date("Y-m-d");
                                    $sql  = "SELECT COUNT(*)AS expense FROM 
                                    teamrequried WHERE Company_id = $companyId 
                                    AND (`to`= $userid OR forward = $userid) and `type` != 'hiring' and currentdate ='$today' and `Status`!='Paid'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $expense = $row['expense'];
                                    echo $expense;
                                    ?>
                                    </span>
                                </h4>
                      
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='request.php?details=Unactioned'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Unactioned Requests</h5>                                    
                                </div>
                                <h4 class="mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                    <path fill="#C81E26" d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zm48 96a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 240a24 24 0 1 0 0-48 24 24 0 1 0 0 48zm0-192c-8.8 0-16 7.2-16 16v80c0 8.8 7.2 16 16 16s16-7.2 16-16V288c0-8.8-7.2-16-16-16z"/>
                            </svg>
                                    <span class="counter">
                                    <?php                                   
                                    $sql  = "SELECT COUNT(*)AS expense FROM 
                                    teamrequried WHERE Company_id = $companyId 
                                    AND (`to`= $userid OR forward = $userid) and `type` != 'hiring' and `Status` ='Pending'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $expense = $row['expense'];
                                    echo $expense;
                                    ?>
                                    </span>
                                </h4>
                      
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='request.php?details=Actioned'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Actioned Requests</h5>
                                    
                                </div>
                                <h4 class="mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                    <path fill="#9b5de5" d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM288 368a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm211.3-43.3c-6.2-6.2-16.4-6.2-22.6 0L416 385.4l-28.7-28.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l40 40c6.2 6.2 16.4 6.2 22.6 0l72-72c6.2-6.2 6.2-16.4 0-22.6z"/>
                            </svg>
                                    <span class="counter">
                                    <?php                                   
                                    $sql  = "SELECT COUNT(*)AS expense FROM 
                                    teamrequried WHERE Company_id = $companyId 
                                    AND (`to`= $userid OR forward = $userid)  AND `Status` !='Pending'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $expense = $row['expense'];
                                    echo $expense;
                                    ?>
                                    </span>
                                </h4>
                       
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='clients.php?project=Paid'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Project Income</h5>
                                    
                                </div>
                                <h4 class="mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1.6em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                    <path fill="#403D39" d="M290.7 311L95 269.7 86.8 309l195.7 41zm51-87L188.2 95.7l-25.5 30.8 153.5 128.3zm-31.2 39.7L129.2 179l-16.7 36.5L293.7 300zM262 32l-32 24 119.3 160.3 32-24zm20.5 328h-200v39.7h200zm39.7 80H42.7V320h-40v160h359.5V320h-40z"/>
                            </svg>
                                    <span class="counter">
                                   <?php
                                        $sql = "SELECT SUM(budget) as budget FROM projects WHERE payment_status = 'Paid' AND Company_id = $companyId";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $budget = $row['budget'];
                                        echo !empty($budget)?$budget:0;
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
   <!--chart-->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {         
            $.ajax({
                type: "GET",
                url: "./../management/chart.php",
                data: { incomechart: "monthly" },
                dataType: "json",
                success: function(data) {                                 
                   
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