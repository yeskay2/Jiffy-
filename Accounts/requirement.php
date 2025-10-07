<?php
session_start();
include "./../include/config.php";
include './../././timezone.php';
$_SESSION['user_id'] = 9;

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
    <title>Requirements | Jiffy</title>

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
        .status {
            background: #3d3399;
            color: white;
            padding: 5px 10px 5px 10px;
            border-radius: 16px;
            text-align: center;
        }
    </style>
</head>
<body>   
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
                                    <h5 style="margin-bottom: 10px;">Total Requirement</h5>
                                </div>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM employee WHERE active ='active' ";
                                $result = mysqli_query($conn, $query);                                
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $total = $row['total'];

                                ?>

                                        <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                                <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" fill="#bc2d75" />
                                            </svg>
                                            <span class="counter"><?php echo !empty($total) ? $total : 0; ?></span>
                                        </h4>

                                        <!-- <div class="d-flex align-items-center justify-content-between mt-1">
                                            <p class="mb-0">Total Employees</p>
                                            <span class="text-primary"><?php echo  $total; ?></span>
                                        </div>

                                        <div class="iq-progress-bar bg-primary-light mt-2">
                                            <span class="bg-primary iq-progress progress-1" data-percent="<?php echo  $total; ?>"></span>
                                        </div> -->
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Approved Requests</h5>
                                    <?php

                                    $todayDate = date("d-m-Y");

                                    $query = "SELECT COUNT(*) as totalOnTime FROM attendance WHERE date = '$todayDate' AND TIME(time_in) <= (SELECT time_in FROM schedules )";

                                    $result = mysqli_query($conn, $query);

                                    $totalOnTime = 0;
                                    $totalEmployees = 0;
                                    $onTimePercentage = 0;

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $totalOnTime = $row['totalOnTime'];
                                    }


                                    $totalEmployeesQuery = "SELECT COUNT(*) as totalEmployees FROM employee WHERE active ='active' ";
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

                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">>
                                        <path fill="#f74c00" d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176H96V304c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128H544h40 40c8.8 0 16 7.2 16 16V352c0 17.7-14.3 32-32 32H576c-11.8 0-22.2-6.4-27.7-16H463.4c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384H32c-17.7 0-32-14.3-32-32V144c0-8.8 7.2-16 16-16H56 96h19.8c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64H259c4.4 0 8.9 .2 13.2 .6zM544 320V176H496c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1H544zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z" />
                                    </svg>
                                    <span class="counter"><?php echo $totalOnTime; ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Rejected Requests</h5>

                                </div>
                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">>
                                        <path fill="#FFD43B" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                    </svg>
                                    <span class="counter"><?php echo $totalOnTime; ?></span>
                                </h4>

                            </div>
                        </div>
                    </div>



                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Amount Spend</h5>
                                    <?php
                                    $today = date('d-m-Y');

                                    $sql = "SELECT time_in FROM attendance WHERE date = '$today' AND status = 1";
                                    $result = mysqli_query($conn, $sql);

                                    $lateCount = 0;

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeIn = strtotime($row['time_in']);

                                        $scheduleSql = "SELECT time_in FROM schedules";
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
                                <h4 class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#c60000" d="M448 256A192 192 0 1 0 64 256a192 192 0 1 0 384 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 80a80 80 0 1 0 0-160 80 80 0 1 0 0 160zm0-224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zM224 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                    </svg>
                                    <span class="counter"><?php echo $lateCount; ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Table of Contents -->

                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<div class='alert text-white bg-warning' role='alert'>
                                                <div class='iq-alert-text'>" . $_SESSION['error'] . "</div>
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                    <i class='ri-close-line'></i>
                                                </button>
                                            </div>";
                                unset($_SESSION['error']);
                            }
                            if (isset($_SESSION['success'])) {
                                echo "<div class='alert text-white bg-success' role='alert'>
                                            <div class='iq-alert-text'>" . $_SESSION['success'] . "</div>
                                                <button type='button' class='close'  data-dismiss='alert' aria-label='Close'>
                                                <i class='ri-close-line'></i>
                                            </button>
                                        </div>";
                                unset($_SESSION['success']);
                            }
                            ?>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="header-title">
                                            <h4 class="card-title">Requirements List</h4>
                                        </div>
                                        <button class="btn btn-excel" id="exportButton" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Download excel sheet">Export Excel &nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button>
                                        <!-- <div class="pl-3 btn-new">
                                    <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new department">
                                        <button type="button" class="custom-btn1 btn-2 mr-3 text-center" data-toggle="modal" data-target="#exampleModalCenteredScrollable">
                                            Add
                                        </button>
                                    </div>
                                </div> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table data-table table-striped text-center">
                                                <thead>
                                                    <tr class="ligth">
                                                        <th>S.No</th>
                                                        <th>Request From</th>
                                                        <th>Department</th>
                                                        <th>Request Type</th>
                                                        <th>Category</th>
                                                        <th>Quantity</th>
                                                        <th>Time to fill</th>
                                                        <th>Cost</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Anusiya</td>
                                                        <td>IT</td>
                                                        <td></td>
                                                        <td>Hardware</td>
                                                        <td>15</td>
                                                        <td>30-04-2024</td>
                                                        <td>1,00,000</td>
                                                        <td>
                                                            <select class="status" name="statusAmount">
                                                                <option value="paid">Paid</option>
                                                                <option value="unpaid">Unpaid</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</body>

</html>