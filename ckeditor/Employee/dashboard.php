<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard | Jiffy</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="./../assets/images/jiffy-favicon.ico" />
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

</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <?php
        include "sidebar.php";
        include "topbar.php";
        ?>
        <div class="content-page">
            <div class="container-fluid">
                <h3>Dashboard</h3><br>
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>New Task</h5>
                                </div><br>
                                <h3><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" fill="#ed6f07">
                                        <path d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                    </svg>
                                    <span class="counter" style="color: #bc2d75;">&nbsp;<span id="newTasks">Loading...</span></span>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>Inprogress Task</h5>
                                </div><br>
                                <h3><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512" fill="#3759e1">
                                        <path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z"></path>
                                    </svg>
                                    <span class="counter" style="color: #bc2d75;">&nbsp;<span id="inProgressTasks">Loading...</span></span>
                                </h3>
                            </div><br>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between">
                                    <h5>Completed Task</h5>
                                </div><br>
                                <h3><svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 448 512" fill="#68d241">
                                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"></path>
                                    </svg>
                                    <span class="counter" style="color: #bc2d75;">&nbsp;<span id="completedTasks">Loading...</span></span>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = "SELECT * FROM events ORDER BY date ASC";
                    $result = mysqli_query($conn, $query);
                    $events = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row['title'];
                        $details = $row['dec'];
                        $date = $row['date'];
                        $start_time = $row['start_time'];
                        $end_time = $row['end_time'];
                        $location = $row['location'];
                        $events[] = array('title' => $title, 'dec' => $details, 'date' => $date, 'start_time' => $start_time, 'end_time' => $end_time, 'location' => $location);
                    }
                    $totalEvents = count($events);
                    ?>

                    <div class="col-md-4 col-lg-4">
                        <div class="card border-0 three" id="eventcard">
                            <div class="card-img-overlay two"><span class="badge badge-light text-uppercase">Events</span><br><br>
                                <h5 id="event-title">Upcoming Events</h5>
                            </div>
                            <div class="card-body">
                                <div class="slider-card" id="office-slider1">
                                    <div class="slider-content" style="font-weight: bold;">
                                        <?php if (!empty($events)) : ?>
                                            <?php foreach ($events as $event) : ?>
                                                <div class="slide">
                                                    <a href="#" class="event-link read-more1" data-description="<?php echo $event['dec']; ?>" data-title="<?php echo $event['title']; ?>" data-date="<?php echo $event['date']; ?>" data-start_time="<?php echo $event['start_time']; ?>" data-end_time="<?php echo $event['end_time']; ?>" data-location="<?php echo $event['location']; ?>">
                                                        <p class="blink"><?php echo $event['title']; ?></p>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <div class="no-events-found">
                                                <p>No upcoming events..</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($totalEvents > 1) : ?>
                                        <div class="slider-controls">
                                            <button class="pn-btn btn-prv mr-3 text-center"  onclick="prevSlide()">
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

                    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel">More Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" style="color: white;">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="background-color: white;">
                                    <div id="eventModalContent"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $query = "SELECT * FROM announcements  ORDER BY announcement_date ASC";
                    $result = mysqli_query($conn, $query);

                    $announcements = array();
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $announcements[] = $row;
                        }
                    }
                    ?>

                    <div class="col-md-4 col-lg-4">
                        <div class="card border-0 three" id="eventcard">
                            <div class="card-img-overlay two"><span class="badge badge-light text-uppercase">Notice</span><br><br>
                                <h5 id="event-title">Office Rules</h5>
                            </div>
                            <div class="card-body">
                                <div class="slider-card" id="office-slider">
                                    <div class="slider-content" style="font-weight: bold;">
                                        <?php if (!empty($announcements)) : ?>
                                            <?php foreach ($announcements as $announcement) : ?>
                                                <div class="slide">
                                                    <a href="#" class="event-link read-more1" data-description="<?php echo $announcement['announcement_content']; ?>" data-date="<?php echo $announcement['announcement_date']; ?>">
                                                        <p><?php echo $announcement['announcement_title']; ?></p>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <div class="no-events-found">
                                                <p>No office rules available..</p>
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
        <!-- Wrapper End-->

        <footer class="iq-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="backend/privacy-policy.html">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="backend/terms-of-service.html">Terms of Use</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 text-right">
                        <span class="mr-1">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>©
                        </span> <a href="#" class="">MINE</a>
                    </div>
                </div>
            </div>
        </footer>
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

        <!-- Script file -->
        <script src="script/script.js"></script>

        <script>
            function updateDashboard(userid) {
                $.ajax({
                    url: 'get-count.php',
                    method: 'GET',
                    data: {
                        userid: userid
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#newTasks').text(data.newTasks);

                        $('#inProgressTasks').text(data.inProgressTasks);
                        $('#completedTasks').text(data.completedTasks);
                    }
                });
            }


            var userid = <?php echo $userid; ?>;
            updateDashboard(userid);

            setInterval(function() {
                updateDashboard(userid);
            }, 5000);
        </script>
</body>

</html>