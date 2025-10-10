<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $userid;
    $leavetype = $_POST["leavetype"];
    $fromdate = $_POST["fromdate"];
    $todate = $_POST["todate"];
    $description = $_POST["description"];
    $sql = "INSERT INTO tblleaves (empid, leave_type, to_date, from_date, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (empty($description)) {
        echo '<script>alert(" description cannot be empty.");</script>';
        echo '<script>window.location.href = "leave.php";</script>';
        exit();
    }

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $user_id, $leavetype, $fromdate, $todate, $description);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            $employeeQuery = "SELECT * FROM employee WHERE id = $user_id";
            $employeeResult = mysqli_query($conn, $employeeQuery);
            $leaveTypeQuery = "SELECT * FROM tblleavetype WHERE id = $leavetype";
            $leaveTypeResult = mysqli_query($conn, $leaveTypeQuery);

            if ($employeeResult && mysqli_num_rows($employeeResult) > 0 && $leaveTypeResult && mysqli_num_rows($leaveTypeResult) > 0) {
                while ($employeeRow = mysqli_fetch_assoc($employeeResult)) {
                    $name = $employeeRow["full_name"];
                    $user_role = $employeeRow["user_role"];
                }
                while ($leaveTypeRow = mysqli_fetch_assoc($leaveTypeResult)) {
                    $LeaveType = $leaveTypeRow["LeaveType"];
                }
            } else {
            }

            $mailer = new PHPMailer(true);
            try {
                $mailer->isSMTP();
                $mailer->Host = 'smtp.gmail.com';
                $mailer->SMTPAuth = true;
                $mailer->Username = 'anusiyam52@gmail.com';
                $mailer->Password = 'ysimyraodahjdmus';
                $mailer->SMTPSecure = 'tls';
                $mailer->Port = 587;
                $mailer->setFrom('jayam4413@gmail.com', 'jayamani');

                $user_email = 'jayam4413@gmail.com';
                $user_full_name = $name;
                $taskName = 'hai';
                $dec = 'dsffdsf';
                $uploader = 'mani';
                $due_date = '21/02/2001';

                $mailer->addAddress($user_email, $user_full_name);
                $user_subject = 'New Leave Request : ' . $taskName;
                $mailer->Subject = $user_subject;
                $user_message = "<html>
                                    <head>
                                        <title>Leave Letter</title>
                                    </head>
                                    <body>
                                    <div class='container'>
                                    <p><strong>From:</strong></p>
                                    <p>$user_full_name</p>
                                    <p>$user_role</p>
                                    <p>MERRY'S INFO-TECH NEW-GEN EDUCARE</p>
                                    <p><strong>Subject: Leave Application</strong></p>
                                    <p>Dear Sir/Madam ,</p>
                                    <p>$description </p>
                                    <p>Sincerely,</p>
                                    <p>$user_full_name</p>
                                    <hr>
                                    <p><strong>Leave Application Details:</strong></p>
                                    <p><strong>Leave Type:</strong> $LeaveType</p>
                                    <p><strong>Start Date:</strong> $fromdate</p>
                                    <p><strong>End Date:</strong> $todate</p>
                                    </div>
                                    </body>
                                    </html>";
                $mailer->Body = $user_message;
                $mailer->isHTML(true);
                $mailer->send();
                echo '<script>alert("Leave applied successfully."); window.location.href = "leave.php";</script>';
            } catch (Exception $e) {
                echo json_encode(array('success' => false, 'message' => 'Leave application could not be sent. Mailer Error: ' . $mailer->ErrorInfo));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Something went wrong while adding'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error: Statement preparation failed.'));
    }
} else {
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Leave | Jiffy</title>

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

    <!-- loader END -->

    <?php
    include 'sidebar.php';
    include 'topbar.php';
    ?>

    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                <?php
                                $itemsPerPage = isset($_GET['itemperpage']) ? intval($_GET['itemperpage']) : 5;
                                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                                $offset = ($page - 1) * $itemsPerPage;
                                $i = 0;
                                $sql = "SELECT tblleavetype.id,tblleavetype.LeaveType, tblleaves.*
                                                        FROM tblleavetype
                                                        INNER JOIN tblleaves ON tblleavetype.id=tblleaves.leave_type where  tblleaves.empid='$userid' LIMIT $offset,$itemsPerPage";
                                $result = mysqli_query($conn, $sql);

                                ?>
                                <div class="d-flex flex-wrap align-items-center">
                                    Show &nbsp;
                                    <select id="itemperpage" onchange="updateItemsPerPage()">
                                        <option value="15" <?php if ($itemsPerPage == 5) echo 'selected'; ?>>5</option>
                                        <option value="25" <?php if ($itemsPerPage == 25) echo 'selected'; ?>>25</option>
                                        <option value="10000" <?php if ($itemsPerPage == 10000) echo 'selected'; ?>>All</option>
                                    </select>
                                    &nbsp;&nbsp;Entries
                                </div>
                                <h5>Apply Leave</h5>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-task-modal" data-toggle="modal">Apply</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
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
                </div>
                <!-- Display tasks here -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="dataTable" class="table table-hover progress-table text-center">
                                <thead class="text-center" style="background-color: #c72f2e; color:#fff;">
                                    <tr>
                                        <th>SI.No</th>
                                        <th width="150">Type</th>
                                        <th>Conditions</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th width="150">Applied</th>
                                        <th width="120">Admin's Remark</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {

                                            $i++;
                                    ?>
                                            <tr>
                                                <td> <?php echo htmlentities($i); ?></td>
                                                <td><?php echo htmlentities($row['LeaveType']); ?></td>
                                                <td><?php
                                                    $description = $row['description'];
                                                    $shortDescription = strlen($description) > 10 ? substr($description, 0, 50) . "..." : $eventDescription;
                                                    echo $shortDescription;
                                                    ?></td>
                                                
                                                <td><?php echo date('d-m-Y', strtotime($row['from_date'])); ?> 
                                                </td>
                                                <td><?php echo date('d-m-Y', strtotime($row['to_date'])); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row['posting_date'])); ?></td>
                                                <td>
                                                    <?php if ($row['admin_remark'] == "") {
                                                        echo htmlentities('Pending');
                                                    } else {
                                                        echo htmlentities(($row['admin_remark'] . " " . "at" . " " . $row['admin_remark']));
                                                    }
                                                    ?>
                                                </td>

                                                <td> <?php $stats = $row['status'];
                                                        if ($stats == 1) {
                                                        ?>
                                                        <span class="approve">Approved</span>
                                                    <?php }
                                                        if ($stats == 2) { ?>

                                                        <span class="reject">Declined</span>
                                                    <?php }
                                                        if ($stats == 0) { ?>

                                                        <span class="pending">Pending</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            $totalTasks = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tblleaves WHERE empid = $userid "));
                            $totalPages = ceil($totalTasks / $itemsPerPage);

                            if ($totalTasks > 0) {
                                echo '<div class="pagination justify-content-center mt-4">';

                                if ($page > 1) {
                                    echo '<a href="?page=' . ($page - 1) . '" class="btn btn-np mr-2">Previous</a>';
                                }

                                for ($i = 1; $i <= $totalPages; $i++) {
                                    if ($i == $page) {
                                        echo "<span class='btn btn-page active'>$i</span>";
                                    } else {
                                        echo "<a href=\"?page=$i\" class='btn btn-next'>$i</a>";
                                    }
                                }

                                if ($page < $totalPages) {
                                    echo '<a href="?page=' . ($page + 1) . '" class="btn btn-np ml-2">Next</a>';
                                }

                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper End-->

    <!-- Modal list start -->
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <h3 class="modal-title" id="exampleModalCenterTitle">Apply Leave</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="exampleInputText2" class="h5">Leave Type</label>
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
                                            <label for="example-date-input" class="h5">Starting Date</label>
                                            <input class="form-control" type="date" data-inputmask="'alias': 'date'" required name="fromdate">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="example-date-input" class="h5">End Date</label>
                                            <input class="form-control" type="date" data-inputmask="'alias': 'date'" required name="todate">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="h5">Describe Your Conditions</label>
                                    <textarea class="form-control" name="description" id="editor1" rows="5" required pattern="^(?!\s*$).+"></textarea>
                                </div>

                                <div class="col-lg-12">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                        <button type="submit" class="custom-btn btn-3 mr-3">Submit</button>
                                        <button type="button" class="custom-btn btn-3 mr-3" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href=" backend/privacy-policy.html">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href=" backend/terms-of-service.html">Terms of Use</a></li>
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

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <!-- Script file -->
    <script src="script/script.js"></script>

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

</body>

</html>