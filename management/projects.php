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

$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
$projects = $dataFetcher->projects();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Projects | Jiffy</title>

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

        .circle-progress>svg {
            height: 130px;
            width: 130px;
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

                    <div class="col-md-6 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">To Do Projects</h5>
                                </div>                            

                                <h4 class="mb-2"><i class="fas fa-reply-all mr-2" style="color:#f77f00;"></i>
                                    <span class="counter">
                                        <?php
                                        $sql = "SELECT * FROM `projects` WHERE `progress` = '0' AND `Company_id` = '$companyId'";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        echo $count;

                                        ?>
                                    </span>
                                </h4>

                                        
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Ongoing Projects</h5>                                  

                                </div>

                                <h4 class="mb-2">
                                <i class="fas fa-spinner fa-pulse mr-2" style="color: #3772ff;"></i>
                                    <span class="counter">
                                    <?php
                                        $sql = "SELECT * FROM `projects` WHERE `progress` > '0' AND `progress` !=100  AND `Company_id` = '$companyId'";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        echo $count;

                                        ?>
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Completed Projects</h5>

                                </div>
                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">>
                                        <path fill="#38b000" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                    </svg>
                                    <span class="counter">
                                    <?php
                                        $sql = "SELECT * FROM `projects` WHERE `progress` = '100' AND `Company_id` = '$companyId'";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        echo $count;

                                        ?>
                                    </span>
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
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="align-items-center justify-content-center">
                                                <h5 style="font-size: 23px;">Projects</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
    <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
        <div class="row">
        <?php foreach ($projects as $project) { ?>
            <div class="col-lg-4 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="mb-2 text-center" style="font-weight: bold;"><?= htmlspecialchars($project['project_name']) ?></h4>
                            <span class="badge badge-danger link-shadow"><?= htmlspecialchars($project['priority']) ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="m-2 mb-3 text-center">Project Progress</h5>
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <div id="circle-progress-<?=$project['id']?>" class="circle-progress-<?=$project['id']?> circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="<?= htmlspecialchars($project['progress']) ?>" data-type="percent"></div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center pt-3 border-top">
                            <a href="#" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View project details">
                                <button class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center" data-toggle="modal" data-target="#projectDetails<?= htmlspecialchars($project['id']) ?>">View More</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>  
            <?php } ?>          
        </div>
    </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php foreach ($projects as $project) { ?>
<!-- Project Details Modal -->
<div class="modal fade" aria-modal="true" id="projectDetails<?= htmlspecialchars($project['id']) ?>">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-block text-center pb-3 border-bottom">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h4 class="modal-title"><?= htmlspecialchars($project['project_name']) ?> Details</h4>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="background-color: white; color:black;">
                            <h4 class="mb-4 text-center"><?= htmlspecialchars($project['project_name']) ?></h4>
                            <p><b>Project Manager :</b> <?=$project['project_manager'] ?> </p>
                            <p><b>Total Hours :</b> <?= ($project['totalhours']) ?> </p>
                            <p><b>Start Date :</b>  <?= date('d-m-Y', strtotime($project['start_date'])) ?> </p>
                            <p><b>End Date :</b>  <?= date('d-m-Y', strtotime($project['due_date'])) ?> </p>
                            <p><b>Budget :</b> <?= number_format($project['budget']) ?> </p>                           
                                                        <?php
                            $membersString = $project['members'];
                            $membersArray = explode(',', $membersString);
                            $resourceCount = count($membersArray);
                            ?>
                            <p><b>Resource Involved :</b> <?= htmlspecialchars($resourceCount) ?> </p>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Project Details Modal -->
<?php } ?>
    
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