<?php
session_start();
include "./../include/config.php";
require_once "./database/getdata.php";
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
if (isset($_GET['id'])) {
    $clientid = $_GET['id'];
    $clientdetials = $dataFetcher->clientprojectdetials($clientid);

?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Client Details | JIFFY</title>
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
        <style>
            @media (min-width:992px) {
                #selectedEmployeesButton {
                    height: 50px;
                }
            }

            .form-check-input {
                width: 15px;
                height: 15px;
                margin-right: 10px;
            }

            .styled-checkbox-label {
                font-size: 16px;
            }

            .btn-drop {
                height: 50px;
                background: #F8F7F7;
                font-size: 14px;
                color: #605C8D;
                border: 1px solid #ced4da;
                width: 360px;
                height: 50px;
            }

            .fas {
                float: right;
            }

            @media(max-width:650px) {
                h6 {
                    font-size: 10px;
                }
            }

            .pill {
                display: inline-block;
                background-color: #f0f0f0;
                color: #333;
                border-radius: 20px;
                padding: 5px 10px;
                margin: 5px;
            }

            .pill button {
                margin-left: 5px;
                background-color: transparent;
                border: none;
                cursor: pointer;
                color: #999;
            }

            .img-thumb {
                max-height: 75px;
                border: 2px solid none;
                border-radius: 3px;
                padding: 1px;
                cursor: pointer;
            }

            .img-thumb-wrapper {
                display: inline-block;
                margin: 10px 10px 0 0;
            }

            img {
                width: 100%;
                height: auto;
            }

            .circle-progress>svg {
                height: 180px;
                width: 180px;
            }

            @media(max-width:670px) {
                .mobileView {
                    display: block;
                }

                .desktopView {
                    display: none;
                }
            }

            @media(min-width:680px) {
                .mobileView {
                    display: none;
                }

                .desktopView {
                    display: block;
                }
            }
        </style>
    </head>

    <body>
        <div class="wrapper">

            <?php
            include 'topbar.php';
            include 'sidebar.php';
            ?>

            <div class="content-page">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex" style="border-bottom: none;">
                                    <div class="back-button">
                                        <a href="javascript:history.back()">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                                <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                            </svg>
                                        </a>
                                    </div>
                                    <h3 class="text-center mx-auto">Client Details</h3>
                                </div>
                                <!--Members End -->

                                <!--Other details start -->
                                <?php
                                if (!empty($clientdetials)) {
                                    foreach ($clientdetials as $clientdetials) { ?>
                                        <div class="container mb-3 projectDetails">
                                            <div class="border rounded p-3 mb-3 shadow">
                                                <div class="row">
                                                    <div class="col-lg-6 desktopView">
                                                        <h6 class="ms-5 mb-4"><b>Client Name&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?= $clientdetials['fullName'] ?></h6>
                                                        <h6 class="ms-5 mb-4"><b>Phone Number&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?= $clientdetials['phoneNumber'] ?></h6>
                                                        <h6 class="ms-5 mb-4"><b>Email&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;:&emsp;</b><?= $clientdetials['email'] ?>
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Company Address&emsp;&emsp;&emsp;:&emsp;</b><?= $clientdetials['address'] ?>
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Company GST Number&emsp;:&emsp;</b><?= $clientdetials['GSTNumber'] ?></h6>
                                                        <h6 class="ms-5 mb-4"><b>Project Name&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp;</b><?= $clientdetials['project_name'] ?></h6>
                                                        <h6 class="ms-5 mb-4"><b>Project Budget&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?= $clientdetials['budget'] ?></h6>
                                                        <h6 class="ms-5 mb-4"><b>Received Amount&emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp;</b><?php
                                                                                                                                            $sql = "SELECT invoices.*, SUM(invoice_services.unit_cost) AS total_cost
                                            FROM invoices
                                            JOIN invoice_services ON invoices.id = invoice_services.invoice_id
                                            WHERE invoices.project_name = 84
                                            GROUP BY invoices.id";
                                                                                                                                            $result = mysqli_query($conn, $sql);
                                                                                                                                            $row = mysqli_fetch_assoc($result);
                                                                                                                                            echo $row['total_cost'];
                                                                                                                                            ?></h6>
                                                        <h6 class="ms-5 mb-4"><b>Pending Amount&emsp;&emsp;&emsp;&emsp;:&emsp;</b>
                                                            <?php
                                                            echo $remainingamount = $clientdetials['budget'] + $row['total_cost'];
                                                            ?>
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Project Start Date&emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp;</b>
                                                            <?= date('d-m-Y', strtotime($clientdetials['start_date'])) ?>
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Project End Date&emsp;&emsp;&emsp;&emsp;&nbsp;:&emsp;</b>
                                                            <?= date('d-m-Y', strtotime($clientdetials['due_date'])) ?>
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Total Hours&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b>
                                                            <?= $clientdetials['totalhours'] ?>
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Resource Involved&emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp;</b>
                                                            <?= $clientdetials['no_resource'] ?>
                                                        </h6>
                                                    </div>
                                                    <div class="col-lg-6 mobileView">
                                                        <h6 class="ms-5 mb-4"><b>Client Name&nbsp;&nbsp;:&nbsp;&nbsp;</b>Client 1</h6>
                                                        <h6 class="ms-5 mb-4"><b>Phone Number&nbsp;&nbsp;:&nbsp;&nbsp;</b>8769567859</h6>
                                                        <h6 class="ms-5 mb-4"><b>Email&nbsp;&nbsp;:&nbsp;&nbsp;</b>client@gmail.com
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Company Address&nbsp;&nbsp;:&nbsp;&nbsp;</b>Address of the company
                                                        </h6>
                                                        <h6 class="ms-5 mb-4"><b>Company GST Number&nbsp;&nbsp;:&nbsp;&nbsp;</b>1234 4647 9896 3534</h6>
                                                        <h6 class="ms-5 mb-4"><b>Project Name&nbsp;&nbsp;:&nbsp;&nbsp;</b>JIFFY</h6>
                                                        <h6 class="ms-5 mb-4"><b>Project Budget&nbsp;&nbsp;:&nbsp;&nbsp;</b>3,00,000</h6>
                                                        <h6 class="ms-5 mb-4"><b>Received Amount&nbsp;&nbsp;:&nbsp;&nbsp;</b>2,00,000</h6>
                                                        <h6 class="ms-5 mb-4"><b>Pending Amount&nbsp;&nbsp;:&nbsp;&nbsp;</b>1,00,000</h6>
                                                        <h6 class="ms-5 mb-4"><b>Project Start Date&nbsp;&nbsp;:&nbsp;&nbsp;</b>15-01-2024</h6>
                                                        <h6 class="ms-5 mb-4"><b>Project End Date&nbsp;&nbsp;:&nbsp;&nbsp;</b>15-01-2024</h6>
                                                        <h6 class="ms-5 mb-4"><b>Total Hours&nbsp;&nbsp;:&nbsp;&nbsp;</b>250</h6>
                                                        <h6 class="ms-5 mb-4"><b>Resource Involved&nbsp;&nbsp;:&nbsp;&nbsp;</b>10</h6>
                                                    </div>
                                                    <div class="col-lg-6 mb-4 ms-3 my-4">
                                                        <div id="circle-progress-<?= $clientdetials['id'] ?>" class="circle-progress circle-progress-info d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value=" <?= $clientdetials['progress'] ?>" data-type="percent">
                                                            <b>
                                                                <h4 class="mb-5 text-center text-dark">Project Progress</h4>
                                                            </b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="col-xl-12">
                                        <h5 class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512" style="margin-right: 10px;">
                                                <path fill="#db0a0a" d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>No project details found
                                        </h5>
                                                  
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
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
        <!-- Rest of the form elements remain unchanged -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>

    </html>

<?php } ?>