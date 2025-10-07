<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];

// code for update the read notification status
$isread = 1;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $employeeId = intval($_GET['id']);
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
    $sql = "UPDATE tblleaves set is_read='$isread' where tblleaves.id='$employeeId'";
    $result = mysqli_query($conn, $sql);
}


if (isset($_POST['update'])) {
    $did = intval($_GET['id']);
    $description = $_POST['description'];
    $status = $_POST['status'];
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));
    $sql = "UPDATE tblleaves set admin_remark='$description',status='$status',remark_date='$admremarkdate' where id='$did'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['success'] = 'updated  successfully';
        header('location: leave.php');
        exit();
    } else {

        $_SESSION['error'] = 'Something went wrong while adding';
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Requirement Details | Jiffy</title>

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
        include 'topbar.php';
        include 'sidebar.php';
        ?>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex">
                                <div class="back-button">
                                    <a href="javascript:history.back()">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                            <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="header-title mx-3">
                                    <h4 class="card-title">Requirement Details</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row" style="width: 575px;">Employee Id</th>
                                            <td colspan="5" class="text-left">1</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Employee Name</th>
                                            <td colspan="5" class="text-left">Anusiya M</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Employee Role</th>
                                            <td colspan="5" class="text-left">Developer</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Employee Email</th>
                                            <td colspan="5" class="text-left">anusiya@gmail.com</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Request Type</th>
                                            <td colspan="5" class="text-left">Hiring</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Category</th>
                                            <td colspan="5" class="text-left">IT</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Quantity/Resource</th>
                                            <td colspan="5" class="text-left">2</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Required Amount</th>
                                            <td colspan="5" class="text-left">15,000</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Request On</th>
                                            <td colspan="5" class="text-left">04-04-2024</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Description</th>
                                            <td colspan="5" class="text-left" style="text-align: justify;">
                                                Need ReactJs developer for project1
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Status</th>
                                            <td colspan="5" class="text-left">Pending
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Admin Remark</th>
                                            <td colspan="5" class="text-left">Pending</td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Admin Action On</th>
                                            <td colspan="5" class="text-left">Nil</td>
                                        </tr>

                                        <tr>
                                            <td colspan="12">
                                                <div class="text-center">
                                                    <button type="button" class="custom-btn1 btn-2 mr-3 text-center" data-toggle="modal" data-target="#exampleModal">Set Action</button>
                                                </div>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header d-block text-center pb-3 border-bttom">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Set Action</h5>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                            ×
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <form method="POST" name="adminaction">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="action">Choose Action</label>
                                                                                <select class="custom-select" class="form-control" name="status" required="">
                                                                                    <option value="">Choose...</option>
                                                                                    <option value="1">Approve</option>
                                                                                    <option value="2">Decline</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="description">Action Description</label>
                                                                                <textarea id="textarea1" name="description" class="form-control" name="description" placeholder="Description" row="5" maxlength="500" required></textarea></p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3 ">
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-yes" name="update">Submit</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
        });
    </script>
    <script>
        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>

</body>

</html>