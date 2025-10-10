<?php
session_start();
include "./../include/config.php";

$userid = $_SESSION["user_id"];

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$sql = "SELECT * FROM `employee` WHERE (user_role='Business' OR user_role='CEO') AND Company_id = '$companyId'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    if ($userid == $row['id']) {
        $_SESSION["id"] = 1;
        header("Location: projectdashboard.php");
        exit();
    }
}

$sql = "SELECT * FROM `team` WHERE Company_id = '$companyId'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    if ($userid == $row['leader']) {
        $_SESSION["id"] = 2;
    }
}

if (empty($_SESSION["id"])) {
    $_SESSION["id"] = 3;
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
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <link rel="stylesheet" href="./chat/chat.css">
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
            border: 3px solid #c72f2e;
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

        <div class="content-page ">
        <?php
        include "./../include/call.php";
        ?>
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-6 col-lg-3" onclick="window.location.href='task.php?taskstatus=Todo&&period=All&&eid=<?= $userid ?>'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body anchor-card">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>New Action Plan</h5>
                                </div>
                                <h3><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                                    </svg>
                                    <span class="counter" style="color: #c72f2e;">&nbsp;<span id="newTasks"></span></span>
                                </h3>

                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Total New Action Plan</p>
                                    <span class="counter" style="color: #c72f2e;">&nbsp;<span id="newTasks2">0</span></span>
                                </div>

                                <div class="iq-progress-bar bg-primary-light mt-2">
                                    <span class="bg-primary iq-progress progress-1" data-percent='30'></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='task.php?taskstatus=Inprogress&&period=All&&eid=<?= $userid ?>'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body anchor-card">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>Inprogress Action Plan</h5>
                                </div>
                                <h3><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" fill="#cf9700" style="margin-right: 10px;">
                                        <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" />
                                    </svg>
                                    <span class="counter" id="inProgressTasks"></span>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Total Inprogress Action Plans</p>
                                    <span class="counter" style="color: #c72f2e;">&nbsp;<span id="inProgressTasks2"></span></span>
                                </div>
                                <div class="iq-progress-bar bg-warning-light mt-2">
                                    <span class="bg-warning iq-progress progress-1" data-percent="50"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='project.php';" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body anchor-card">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>Objectives Involved</h5>
                                </div>

                                <h3><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 448 512" fill="#007ece" style="margin-right: 10px;">
                                        <path d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H384c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                    </svg>
                                    <span class="counter" id="completedTasks"></span>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Total Involved Objectives</p>
                                    <span class="counter" style="color: #c72f2e;">&nbsp;<span id="completedTasks2"></span></span>
                                </div>
                                <div class="iq-progress-bar bg-info-light mt-2">
                                    <span class="bg-info iq-progress progress-1" data-percent="10"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='task.php?period=Today&eid=<?= $userid ?>';" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body anchor-card">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>Due Today</h5>
                                </div>
                                <h3>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" fill="#2f8f81" style="margin-right: 10px;">
                                        <path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                                    </svg>
                                    <span class="counter" id="today"></span>
                                </h3>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <p class="mb-0">Today's Due Action Plan</p>
                                    <span class="text-success"></span>
                                    <span class="counter" style="color: #c72f2e;">&nbsp;<span id="today2"></span></span>
                                </div>
                                <div class="iq-progress-bar bg-danger-light mt-2">
                                    <span class="bg-danger iq-progress progress-1" data-percent="80"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Overview Progress Section -->
                   <div class="col-xl-8">
                        <div class="card-transparent card-block card-stretch card-height">
                            <div class="card-body p-1">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h5 class="card-title">Today's&nbsp;&nbsp;Priority</h5>
                                           
                                           
                                        </div>
                                    </div>
                                </div>
                                <?php
                                function fetchAllProjects($conn, $userid)
                                {
                                    date_default_timezone_set('Asia/Kolkata');
                                    $today = new DateTime('now');
                                    $today_string = $today->format('Y-m-d');
                                    $time = date('H:i A');
                                    $query = "SELECT 
                                    tasks.*, 
                                    employee.full_name, 
                                    employee.profile_picture AS assigned_profile_picture, 
                                    e_uploader.profile_picture AS uploader_profile_picture 
                                FROM 
                                    tasks 
                                INNER JOIN 
                                    employee ON tasks.assigned_to = employee.id 
                                LEFT JOIN 
                                    employee AS e_uploader ON tasks.uploaderid = e_uploader.id 
                                WHERE 
                                    tasks.assigned_to = '$userid'
                                    AND (tasks.status = 'Todo' OR tasks.status = 'InProgress' OR tasks.status = 'Pause') 
                                    AND DATE_FORMAT(tasks.Actual_start_time, '%Y-%m-%d') <= '$today_string' 
                                    AND DATE_FORMAT(tasks.due_date, '%Y-%m-%d') >= '$today_string'
                                    AND STR_TO_DATE(tasks.perferstart_time, '%H:%i') <= STR_TO_DATE('$time', '%H:%i')  
                                    AND STR_TO_DATE(tasks.perferend_time, '%H:%i') >= STR_TO_DATE('$time', '%H:%i')                                    
                                     ORDER BY tasks.due_date LIMIT 4";
                                    $result = mysqli_query($conn, $query);
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $projectname = $row['task_name'];
                                                $taskid = $row['id'];
                                                $assignbyname = $row['full_name'];
                                                $due_time = strtotime($row['due_date']);
                                                $prefer_end_time1 =strtotime ($row['perferend_time']);
                                                $prefer_end_time = date('h:i A', strtotime($row['perferend_time']));
                                                $prefer_start_time = date('h:i A', strtotime($row['perferstart_time']));                                                
                                                $today_time = strtotime('now');
                                                $profile_assigned_profile_picture = $row['assigned_profile_picture'];
                                                $uploader_profile_picture = $row['uploader_profile_picture'];
                                                $remaining_time_seconds = $prefer_end_time1 - $today_time;
                                                $remaining_time_minutes = round($remaining_time_seconds / 60);
                                                $category = $row['category'];
                                                 if ($row['category'] === "Bug") {
                                                $buttonClass = "custom-button bug";
                                                } elseif ($row['category'] === "Improvement") {
                                                    $buttonClass = "custom-button success";
                                                } else {
                                                    $buttonClass = "custom-button task";
                                                }
                                ?>

                                                <div class="card task-card1" onclick="window.location.href='viewtask.php?taskid=<?=urlencode(base64_encode($taskid))?>';" style="cursor: pointer;">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-2">
                                                                        <div class="progress-circle">
                                                                            <div id="app_<?php echo $row['id']; ?>" class="timer"></div>
                                                                           <script>
                                                                            function countdown_<?php echo $row['id']; ?>() {
                                                                                var remainingTime_<?php echo $row['id']; ?> = <?php echo $remaining_time_seconds; ?>;
                                                                                var isBlinking_<?php echo $row['id']; ?> = false;
                                                                        
                                                                                var timer_<?php echo $row['id']; ?> = setInterval(function() {
                                                                                    var hours = Math.floor(remainingTime_<?php echo $row['id']; ?> / 3600);
                                                                                    var minutes = Math.floor((remainingTime_<?php echo $row['id']; ?> % 3600) / 60);
                                                                                    var seconds = remainingTime_<?php echo $row['id']; ?> % 60;
                                                                        
                                                                                    var displayTime = '';
                                                                                    if (hours > 0) {
                                                                                        displayTime += hours + ' : ';
                                                                                    }
                                                                                    displayTime += (minutes < 10 ? '0' + minutes : minutes) + ' : ';
                                                                                    displayTime += (seconds < 10 ? '0' + seconds : seconds);
                                                                        
                                                                                    if (remainingTime_<?php echo $row['id']; ?> <= 300 && remainingTime_<?php echo $row['id']; ?> > 0) {                                                                                       
                                                                                        document.getElementById('app_<?php echo $row['id']; ?>').style.animation = 'blinkAnimation 1s infinite';
                                                                                    } else {                                                                                       
                                                                                        document.getElementById('app_<?php echo $row['id']; ?>').style.animation = '';
                                                                                    }                                                                        
                                                                                    document.getElementById('app_<?php echo $row['id']; ?>').innerHTML = displayTime;                                                                        
                                                                                    if (remainingTime_<?php echo $row['id']; ?> <= 0) {
                                                                                        clearInterval(timer_<?php echo $row['id']; ?>);
                                                                                        document.getElementById('app_<?php echo $row['id']; ?>').innerHTML = '<span style="color:#C10000; font-weight:800;">Timeout</span>';
                                                                                    } else {
                                                                                        remainingTime_<?php echo $row['id']; ?>--;
                                                                                    }
                                                                                }, 1000);
                                                                            }
                                                                            countdown_<?php echo $row['id']; ?>();
                                                                        </script>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div class="mt-3 mt-md-0">
                                                                            <h5 class="mb-1"><?php echo $projectname; ?></h5>
                                                                            <p class="mb-3"><i class="fa fa-calendar-check mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>/
                                                                            <?=$prefer_start_time?>-<?=$prefer_end_time?>
                                                                        </p>                                                                           
                                                                            <div class="d-flex align-items-center justify-content-between">
                                                                                <div class="iq-media-group">
                                                                                    <a href="#" class="iq-media">
                                                                                        <img src="./../uploads/employee/<?=$profile_assigned_profile_picture?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                                    </a>
                                                                                    <a href="#" class="iq-media">
                                                                                        <img src="./../uploads/employee/<?=$uploader_profile_picture?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                                    </a>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="col-xl-12">
                                                <h5 class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512" style="margin-right: 10px;">
                                                        <path fill="#db0a0a" d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                                                    </svg>No action plans assigned</h5>
                                            </div>
                                <?php
                                        }
                                       
                                    }                                
                                fetchAllProjects($conn, $userid);
                                ?>
                                <div class="row mt-5 bg-white" style="border-radius:16px;">
                                    <div class="col-xl-6 pt-5">
                                        <div class="card card-block card-stretch card-height" style="height: calc(100% - 60px);">
                                            <div class="card-body">
                                                <div class="card shadow-none">
                                                    <div class="card-body text-center inln-date flet-datepickr">
                                                        <input type="text" id="inline-date" class="date-input basicFlatpickr" readonly="readonly">
                                                    </div>
                                                </div>                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 pt-5">
                                        <div id="result-container"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!----end---->
                   <?php
                    $query = "SELECT * FROM events WHERE Company_id = $companyId ORDER BY date ASC";
                    $result = mysqli_query($conn, $query);
                    $events = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row['title'];
                        $details = $row['detials'];
                        $date = $row['date'];
                        $start_time = $row['start_time'];
                        $end_time = $row['end_time'];
                        $location = $row['location'];
                        $events[] = array('title' => $title, 'dec' => $details, 'date' => $date, 'start_time' => $start_time, 'end_time' => $end_time, 'location' => $location);
                    }
                    $totalEvents = count($events);
                    ?>
                            <div class="col-xl-4">
                                <div class="card mt-1">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h5 class="card-title">Events&nbsp;&&nbsp;Notice</h5>
                                        </div>
                                    </div>
                                </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="card border-0 three" id="eventcard">
                            <div class="card-img-overlay two"><span
                                    class="badge badge-light text-uppercase">Events</span><br><br>
                                <h5 id="event-title">Upcoming Events</h5>
                            </div>
                            <div class="card-body">
                                <div class="slider-card" id="office-slider1">
                                    <div class="slider-content" style="font-weight: bold;">
                                        <?php if (!empty($events)) : ?>
                                        <?php foreach ($events as $event) : ?>
                                        <div class="slide">
                                            <a href="#" class="event-link read-more1"
                                                data-description="<?php echo $event['dec']; ?>"
                                                data-title="<?php echo $event['title']; ?>"
                                                data-date="<?php echo $event['date']; ?>"
                                                data-start_time="<?php echo $event['start_time']; ?>"
                                                data-end_time="<?php echo $event['end_time']; ?>"
                                                data-location="<?php echo $event['location']; ?>">
                                                <p class="blink"><?php echo $event['title']; ?></p>
                                            </a>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <div class="no-events-found">
                                            <p style="padding:20px;">No upcoming events..</p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($totalEvents > 1) : ?>
                                    <div class="slider-controls">
                                        <button class="pn-btn btn-prv mr-3 text-center" onclick="prevSlide()">
                                            <span>Previous</span>
                                        </button>
                                        <button class="pn-btn btn-nxt mr-3 text-center" onclick="nextSlide()">
                                            <span>Next</span>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog"
                        aria-labelledby="eventModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel">More Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="background-color: white;">
                                    <div id="eventModalContent"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = "SELECT * FROM announcements WHERE Company_id = $companyId ORDER BY announcement_date ASC";
                    $result = mysqli_query($conn, $query);

                    $announcements = array();
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $announcements[] = $row;
                        }
                    }
                    ?>

                    <div class="col-md-12 col-xl-12">
                        <div class="card border-0 three" id="eventcard">
                            <div class="card-img-overlay two"><span
                                    class="badge badge-light text-uppercase">Notice</span><br><br>
                                <h5 id="event-title">Announcements</h5>
                            </div>
                            <div class="card-body">
                                <div class="slider-card" id="office-slider">
                                    <div class="slider-content" style="font-weight: bold;">
                                        <?php if (!empty($announcements)) : ?>
                                        <?php foreach ($announcements as $announcement) : ?>
                                        <div class="slide">
                                            <a href="#" class="event-link read-more1"
                                                data-description="<?php echo $announcement['announcement_content']; ?>"
                                                data-date="<?php echo $announcement['announcement_date']; ?>">
                                                <p><?php echo $announcement['announcement_title']; ?></p>
                                            </a>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <div class="no-events-found">
                                            <p style="padding:20px;">No announcements available..</p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (count($announcements) > 1) : ?>
                                    <div class="slider-controls">
                                        <button class="pn-btn btn-prv mr-3 text-center" onclick="rulePrevSlide()">
                                            <span>Previous</span>
                                        </button>
                                        <button class="pn-btn btn-nxt mr-3 text-center" onclick="ruleNextSlide()">
                                            <span>Next</span>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
   <?php
    $today = date('Y-m-d');
    $selectedDate = $today;
    $formattedDate = date('m-d', strtotime($selectedDate));
    $selectedtable = date('Y-m-d', strtotime($selectedDate));

    $sql = "SELECT id, full_name, dob, doj, profile_picture, employee.Company_id,
            YEAR(CURDATE()) - YEAR(doj) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(doj, '%m%d')) AS working_years
            FROM employee
            WHERE (DATE_FORMAT(dob, '%m-%d') = ? OR DATE_FORMAT(doj, '%m-%d') = ?) AND employee.Company_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $formattedDate, $formattedDate, $companyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $status = 1;
    if ($result->num_rows > 0) {
        $names = [];
         $status = 0;
        while ($row = $result->fetch_assoc()) {           
            $names[] = $row["full_name"]; 
            $image = $row["profile_picture"];
            $dob = date('Y-m-d', strtotime($row["dob"]));
            $doj = date('Y-m-d', strtotime($row["doj"]));
            $currentDate = date('Y-m-d', strtotime($selectedDate));
            $workingYears = date_diff(date_create($doj), date_create($currentDate))->y;
            $isBirthday = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($dob)));
            $isWorkAnniversary = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($doj)));
        }

        
        $allNames = implode(' & ', $names);
    }
?>

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
                            <?php if (isset($isBirthday)): ?>
                                <img src="./../assets/images/celebration.gif" class="img-fluid" alt="celebration Image" width="230" height="230" />
                                <h5 class="text-center">Happy Birthday <?php echo $allNames; ?> 🎉🎂</h5>
                                <p class="text-justify p-2 mt-2">🎉 May your special day be filled with joy 😄, success 🏆, and memorable moments 📸. Wishing you continued growth 🌱 and prosperity 💰 in the coming year. 🎊✨</p>
                            <?php elseif (isset($isWorkAnniversary)): ?>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
        <script>
            var userid = <?php echo $userid; ?>;

            function updateDashboard(userid) {
                $.ajax({
                    url: 'get-count.php',
                    method: 'GET',
                    data: {
                        userid: userid
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#newTasks, #newTasks2').text(data.newTasks);
                        $('#inProgressTasks, #inProgressTasks2').text(data.inProgressTasks);
                        $('#completedTasks, #completedTasks2').text(data.completedTasks);
                        $('#today, #today2').text(data.totaltoday);
                    }
                });
            }

            var userid = userid;
            updateDashboard(userid);
            var throttleUpdate = _.throttle(function() {
                updateDashboard(userid);
            }, 100);
            setInterval(throttleUpdate, 100);

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
                xhr.open('GET', 'getevent.php?selectedDate=' + selectedDate, true);
                xhr.send();
            }
            var currentDate = new Date().toISOString().split('T')[0];
            document.getElementById('inline-date').value = currentDate;
            fetchEmployees(currentDate);
            document.getElementById('inline-date').addEventListener('change', function() {
                var selectedDate = this.value;
                fetchEmployees(selectedDate);
            });

            let currentRuleSlide = 0;
            const ruleSlides = document.querySelectorAll('#office-slider .slider-content .slide');
            const ruleSliderContent = document.querySelector('#office-slider .slider-content');

            function showRuleSlide(index) {
                ruleSliderContent.style.transform = `translateX(-${index * 300}px)`;
                currentRuleSlide = index;
            }

            function rulePrevSlide() {
                if (currentRuleSlide > 0) {
                    showRuleSlide(currentRuleSlide - 1);
                }
            }

            function ruleNextSlide() {
                if (currentRuleSlide < ruleSlides.length - 1) {
                    showRuleSlide(currentRuleSlide + 1);
                }
            }


            let currentSlide = 0;
            const slides = document.querySelectorAll('#office-slider1.slider-card .slider-content .slide');
            const sliderContent = document.querySelector('.slider-card .slider-content');

            function showRule(index) {
                sliderContent.style.transform = `translateX(-${index * 300}px)`;
                currentSlide = index;
            }

            function prevSlide() {
                if (currentSlide > 0) {
                    showRule(currentSlide - 1);
                }
            }

            function nextSlide() {
                if (currentSlide < slides.length - 1) {
                    showRule(currentSlide + 1);
                }
            }
            const eventLinks = document.querySelectorAll('.event-link');
            const popup = document.getElementById('event-details-popup');
            const popupTitle = document.getElementById('popup-title');
            const popupDetails = document.getElementById('popup-details');
            const popupdate = document.getElementById('popup-date');

            eventLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const title = this.getAttribute('data-title');
                    const details = this.getAttribute('data-details');
                    const date = this.getAttribute('data-date');
                    const start_time = this.getAttribute('data-start_time');
                    const end_time = this.getAttribute('data-end_time');
                    const location = this.getAttribute('data-location');
                    popupTitle.textContent = title;
                    popupDetails.textContent = details;
                    popupdate.textContent = date;
                    popup.style.display = 'block';
                });
            });


            function closePopup() {
                popup.style.display = 'none';
            }

            document.addEventListener("DOMContentLoaded", function() {
                const eventModalContent = document.getElementById('eventModalContent');
                const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));

                const readMoreLinks = document.querySelectorAll('.read-more1');
                readMoreLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        const description = this.getAttribute('data-description');
                        const date = this.getAttribute('data-date');
                        const start_time = this.getAttribute('data-start_time');
                        const end_time = this.getAttribute('data-end_time');
                        const location = this.getAttribute('data-location');

                        let content = '<p>' + description + '</p>' + '<p>' + 'Date: ' + date +
                            '</p>';

                        if (start_time) {
                            content += '<p>' + 'Time: ' + start_time + '</p>';
                        }

                        if (end_time) {
                            content += '<p>' + 'Endtime: ' + end_time + '</p>';
                        }

                        if (location) {
                            content += '<p>' + 'Location: ' + location + '</p>';
                        }

                        eventModalContent.innerHTML = content;
                        eventModal.show();
                    });
                });

                updateSliderControls();
            });



            function performSearch() {
                const searchQuery = taskSearchInput.value.toLowerCase();
                const taskCards = document.querySelectorAll(".task-card1");
                taskCards.forEach(function(card) {
                    const projectname = card.querySelector("h5.mb-1").textContent.toLowerCase();
                    if (projectname.includes(searchQuery)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            }
            const taskSearchInput = document.getElementById("taskSearchInput");
            taskSearchInput.addEventListener("input", performSearch);
            $(function() {
                $("#chat-circle").click(function() {
                    $("#chat-circle").toggle('scale');
                    $(".chat-box").toggle('scale');
                });
                $("#send-btn").on("click", function() {
                    $value = $("#chat-input").val();
                    $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + $value + '</p></div></div>';
                    $(".chat-logs").append($msg);
                    $("#chat-input").val('');
                    $.ajax({
                        url: './chat/message.php',
                        type: 'POST',
                        data: 'text=' + $value,
                        success: function(result) {
                            $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + result + '</p></div></div>';
                            $(".chat-logs").append($replay);
                            $(".chat-logs").scrollTop($(".chat-logs")[0].scrollHeight);
                        }
                    });
                });
                $(".chat-box-toggle").click(function() {
                    $("#chat-circle").toggle('scale');
                    $(".chat-box").toggle('scale');
                });
            });
        </script> 

        
        <!-- Google Tag Manager -->
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        alert.remove();
                    }, 5000);
                });
            });
        </script>
        <!-- End Google Tag Manager -->
</body>

</html>