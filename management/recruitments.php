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

$Total_Requirement = $dataFetcher->Total_Requirement();
$Status_request = $dataFetcher->Status_request();
$Status_Rejected = $dataFetcher->Status_Rejected();
$amount_spend = $dataFetcher->Amount_Spend();
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $Requirement_detials = $dataFetcher->Requirement_details($status);
} else {
    $Requirement_detials = $dataFetcher->Requirement_details();
}
$Requirement_details_others = $dataFetcher->Requirement_details_others();
$applydata = $dataFetcher->Apply();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $applydata = $dataFetcher->shortlist();
    }
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
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <style>
        #downloadButton:hover {
            border: 2px solid #dfdede;
            border-radius: 12px;
            padding: 3px;
            background-color: #F8F7F7;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .search-content {
            display: none;
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

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='requirement.php'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Hiring Request</h5>
                                </div>

                                <h4 class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" fill="#ff8800" />
                                    </svg>
                                    <span class="counter"><?php echo  $Total_Requirement; ?></span>
                                </h4>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3" onclick="window.location.href='requirement.php?status=Approve'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Approved Hiring Requests</h5>
                                </div>

                                <h4 class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#1e96fc" d="M112 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm40 304V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l44.9 74.7c-16.1 17.6-28.6 38.5-36.6 61.5c-1.9-1.8-3.5-3.9-4.9-6.3L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352H152zm136 16a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm211.3-43.3c-6.2-6.2-16.4-6.2-22.6 0L416 385.4l-28.7-28.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l40 40c6.2 6.2 16.4 6.2 22.6 0l72-72c6.2-6.2 6.2-16.4 0-22.6z" />
                                    </svg>
                                    <span class="counter"><?php echo $Status_request; ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3" onclick="window.location.href='requirement.php?status=Rejected'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Rejected</h5>

                                </div>
                                <h4 class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.1em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#ca0101" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L381.9 274c48.5-23.2 82.1-72.7 82.1-130C464 64.5 399.5 0 320 0C250.4 0 192.4 49.3 178.9 114.9L38.8 5.1zM545.5 512H528L284.3 320h-59C136.2 320 64 392.2 64 481.3c0 17 13.8 30.7 30.7 30.7H545.3l.3 0z" />
                                    </svg>
                                    <span class="counter"><?= $Status_Rejected ?></span>
                                </h4>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="top-block d-flex align-items-center justify-content-between mb-2">
                                    <h5 style="margin-bottom: 10px;">Amount Spend</h5>
                                </div>
                                <h4 class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#025602" d="M320 96H192L144.6 24.9C137.5 14.2 145.1 0 157.9 0H354.1c12.8 0 20.4 14.2 13.3 24.9L320 96zM192 128H320c3.8 2.5 8.1 5.3 13 8.4C389.7 172.7 512 250.9 512 416c0 53-43 96-96 96H96c-53 0-96-43-96-96C0 250.9 122.3 172.7 179 136.4l0 0 0 0c4.8-3.1 9.2-5.9 13-8.4zm84 88c0-11-9-20-20-20s-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V424c0 11 9 20 20 20s20-9 20-20V410.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l0 0-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V216z" />
                                    </svg>
                                    <span class="counter"><?= !isset($amount_spend) ? '0' : $amount_spend ?></span>
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
                            <?php if (!isset($_GET['status'])) { ?>
                                <div class="col-sm-12" id="totalrequirement1">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Hiring Request List</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table data-table table-striped text-center">
                                                    <thead>
                                                        <tr class="ligth">
                                                            <th>SI.No</th>
                                                            <th>Full Name</th>
                                                            <th>Email ID</th>
                                                            <th>Mobile No</th>
                                                            <th>Experience</th>
                                                            <th>Resume</th>
                                                            <th>Hiring Cost</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <?php if (!empty($applydata)) { ?>
                                                        <?php $id = 0 ?>
                                                        <?php foreach ($applydata as $rd) { ?>
                                                            <tbody>
                                                                <td><?= ++$id ?></td>
                                                                <td><?= $rd['full_name'] ?></td>
                                                                <td><?= $rd['email'] ?> </td>
                                                                <td><?= $rd['phone'] ?></td>
                                                                <td><?= $rd['work_experience'] ?></td>
                                                                <td>
                                                                    <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="View resume" style="cursor: pointer;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 640 512">
                                                                            <path fill="#3d3399" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                        </svg>
                                                                    </div>
                                                                </td>
                                                                <td><?= $rd['cost'] ?></td>
                                                                <td><?= $rd['status1'] ?></td>

                                                                <script>
                                                                    document.getElementById("downloadButton").addEventListener("click", function() {
                                                                        var filePath = "./../<?= $rd['resume_path'] ?>";
                                                                        window.open(filePath, "_blank");
                                                                    });
                                                                </script>

                                                                <td>
                                                                    <button type="button" class="btn btn-yes" data-toggle="modal" data-target="#updateStatus" style="border-radius:10px;">
                                                                        <div data-toggle="tooltip" data-placement="bottom" title="Update status">
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
                                                                                        <select class="custom-select" name="status" id="statusSelect" required>
                                                                                            <option value="" disabled selected hidden>Select Status</option>
                                                                                            <option value="Approve">Approved</option>
                                                                                            <option value="rejected">Rejected</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?= $rd['id'] ?>">
                                                                                    <div class="col-lg-12 mt-5 text-center">
                                                                                        <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit">
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
                            <?php if (isset($_GET['status']) && $_GET['status'] == 'Approve') { ?>
                                <div class="col-sm-12" id="totalrequirement1">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Hiring Approved List</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table data-table table-striped text-center">
                                                    <thead>
                                                        <tr class="ligth">
                                                            <th>SI.No</th>
                                                            <th>Full Name</th>
                                                            <th>Email ID</th>
                                                            <th>Mobile No</th>
                                                            <th>Experience</th>
                                                            <th>Resume</th>
                                                            <th>Hiring Costdd</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <?php if (!empty($Requirement_detials)) { ?>
                                                        <?php $id = 0 ?>
                                                        <?php foreach ($Requirement_detials  as $rd) { ?>
                                                            <tbody>
                                                                <td><?= ++$id ?></td>
                                                                <td><?= $rd['full_name'] ?></td>
                                                                <td><?= $rd['email'] ?> </td>
                                                                <td><?= $rd['phone'] ?></td>
                                                                <td><?= $rd['work_experience'] ?></td>
                                                                <td>
                                                                    <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="View resume" style="cursor: pointer;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 640 512">
                                                                            <path fill="#3d3399" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                        </svg>
                                                                    </div>
                                                                </td>

                                                                <td><?= $rd['cost'] ?></td>
                                                                <td><span class="badge badge-success" style="background-color: green !important;"><?= $rd['status1'] ?></span></td>

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
                            <?php if (isset($_GET['status']) && $_GET['status'] == 'Rejected') { ?>
                                <div class="col-sm-12" id="totalrequirement1">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Hiring Rejected List</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="datatable" class="table data-table table-striped text-center">
                                                    <thead>
                                                        <tr class="ligth">
                                                            <th>SI.No</th>
                                                            <th>Full Name</th>
                                                            <th>Email ID</th>
                                                            <th>Mobile No</th>
                                                            <th>Experience</th>
                                                            <th>Resume</th>
                                                            <th>Hiring Cost</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <?php if (!empty($Requirement_detials)) { ?>
                                                        <?php $id = 0 ?>
                                                        <?php foreach ($Requirement_detials  as $rd) { ?>
                                                            <tbody>
                                                                <td><?= ++$id ?></td>
                                                                <td><?= $rd['full_name'] ?></td>
                                                                <td><?= $rd['email'] ?> </td>
                                                                <td><?= $rd['phone'] ?></td>
                                                                <td><?= $rd['work_experience'] ?></td>
                                                                <td>
                                                                    <div id="downloadButton" data-toggle="tooltip" data-placement="bottom" title="View resume" style="cursor: pointer;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 640 512">
                                                                            <path fill="#3d3399" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                        </svg>
                                                                    </div>
                                                                </td>

                                                                <td><?= $rd['cost'] ?></td>
                                                                <td><span class="badge badge-danger" style="background-color: red !important;"><?= ucfirst($rd['status1']) ?></span></td>

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
                                                                                            <option value="" disabled selected hidden>Select Status</option>
                                                                                            <option value="Approve">Approve</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?= $rd['id'] ?>">
                                                                                    <div class="col-lg-12 mt-5 text-center">
                                                                                        <input type="submit" class="custom-btn1 btn-2 text-center" value="Submit" name="submit">
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