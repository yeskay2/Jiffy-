<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userid = $_SESSION["user_id"];
require_once "./../project/taskdata/insertdata.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskManager->applyLeave($userid);
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $taskManager->deleteLeave($id);
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Leave | Jiffy</title>

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
    <style>
        #searchbar1 {
            display: none;
        }
    </style>
</head>


<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center"></div>
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
                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
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
                                    <h4 class="card-title">Manage Leaves</h4>
                                </div>
                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Apply for leave">
                                    <a href="#" class="custom-btn1 btn-2  text-center" data-target="#new-task-modal" data-toggle="modal">Apply</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <td>SI.No</td>
                                                <td width="120">Employee Name</td>
                                                <td>Leave Type</td>
                                                <td>Applied On</td>
                                                <td>Current Status</td>
                                                <td>View</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT tblleaves.id AS lid, employee.full_name, employee.id, 
                tblleaves.leave_type, tblleaves.posting_date, tblleaves.status, tblleavetype.LeaveType,tblleaves.empid 
                FROM tblleaves
                JOIN employee ON tblleaves.empid = employee.id
                JOIN tblleavetype ON tblleaves.leave_type = tblleavetype.id WHERE tblleaves.Company_id = '$companyId'";

                                            $result = mysqli_query($conn, $sql);
                                            $i = 1;

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $status = ($row['status'] == 1) ? '<span class="approve">Approved</span>' : (($row['status'] == 2) ? '<span class="reject">Declined</span>' : '<span class="pending">Pending</span>');

                                                    $fullName = $row['full_name'];
                                                    $leaveType = $row['LeaveType'];
                                                    $postingDate = date("d-m-Y", strtotime($row['posting_date']));
                                                    $lid = $row['lid'];
                                                    $empid = $row['empid'];
                                            ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $fullName ?></td>
                                                        <td><?= $leaveType ?></td>
                                                        <td><?= $postingDate ?></td>
                                                        <td><?= $status ?></td>
                                                        <td>
                                                            <a href="getleavedetails.php?id=<?= $lid ?>" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="View leave details">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo '<tr><td colspan="7" class="text-center">No records found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page end  -->
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="modal-title" id="exampleModalCenterTitle">Apply Leave</h3>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="close" data-dismiss="modal">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="myForm" onsubmit="submitForm(event)">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText2" class="h5">Leave Type<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="leavetype" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="">Select Leave Type</option>
                                            <?php
                                            $query = "SELECT * FROM tblleavetype";
                                            $result = mysqli_query($conn, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id = $row['id'];
                                                    $leavetype = $row['LeaveType'];
                                                    echo '<option value="' . $id . '">' . $leavetype . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No type found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="example-date-input" class="h5">Leave From<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input class="form-control" type="date" data-inputmask="'alias': 'date'" required name="fromdate" id="fromdate">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="example-date-input" class="h5">Leave To<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input class="form-control" type="date" data-inputmask="'alias': 'date'" required name="todate" id="todate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="h5">Describe Your Reason<span class="text-danger" style="font-size:20px">*</span></label>
                                        <textarea class="form-control" name="description" id="editor1" rows="5" required pattern="^(?!\s*$).+"></textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center" id="submitButton">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
        <script src="script/script.js"></script>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 2000);
            });
        </script>

        <script>
            CKEDITOR.replace('editor1');

            function validateForm() {
                var editorData = CKEDITOR.instances.editor1.getData().trim();
                if (!editorData) {
                    alert("Description is required.");
                    return false;
                }
                return true;
            }
        </script>
        <script>
            const fromDateInput = document.getElementById('fromdate');
            const toDateInput = document.getElementById('todate');

            function setMinDateForEndDate() {
                toDateInput.setAttribute('min', fromDateInput.value);
            }

            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = (today.getMonth() + 1).toString().padStart(2, '0');
                const day = today.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Add an event listener to "Starting Date" input to update "End Date" minimum date
            fromDateInput.addEventListener('change', setMinDateForEndDate);
            document.getElementById('fromdate').setAttribute('min', getCurrentDate());
        </script>
        <script>
            function submitForm(event) {
                var element = document.getElementById("submitButton");
                element.classList.add("no-drop");
                element.disabled = true;
            }
        </script>




</body>

</html>