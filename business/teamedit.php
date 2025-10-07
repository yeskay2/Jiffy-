<?php
session_start();
include "./../include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userid = $_SESSION["user_id"];
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_SESSION["user_id"];
    $projectName = $_POST["projectName"];
    $leader = $_POST["teamLeader"];
    $assignMembers = isset($_POST['selectedMembers']) ? $_POST['selectedMembers'] : array();
    $employeeId = implode(", ", $assignMembers);
    $teamId = $_POST["team_id"];
    $query = "UPDATE team SET teamname = ?,employee = ?,leader=? WHERE team_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $projectName, $employeeId, $leader, $teamId);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = 'Team updated successfully';
            mysqli_stmt_close($stmt);
            header("Location: teamedit.php?id='$teamId'");
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update, please try again';
            mysqli_stmt_close($stmt);
            header('location: teamedit.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Statement preparation failed.';
        header('location: teamedit.php');
        exit();
    }
}
if (isset($_GET['id'])) {
    $projectId = $_GET['id'];
    $query = "SELECT team.teamname,team.leader,team.team_id,team.employee,employee.
    full_name,employee.profile_picture from team join employee ON 
    team.employee = employee.id Where team.team_id = $projectId";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $projectname = $row['teamname'];
        $id = $row['team_id'];
        $departments = $row['employee'];
        $member = $row['employee'];
        $leader = $row['leader'];
        $departmentLogos = array();
        $memberNames = array();
        $progressClasses = array("circle-progress-primary", "circle-progress-secondary", "circle-progress-success", "circle-progress-info");
        $progressClass = $progressClasses[0];
        $departmentIDs = explode(',', $departments);
        foreach ($departmentIDs as $departmentID) {
            $sql4 = "SELECT profile_picture FROM employee WHERE id = $departmentID";
            $result4 = mysqli_query($conn, $sql4);
            if ($result4 && mysqli_num_rows($result4) > 0) {
                $departmentRow = mysqli_fetch_assoc($result4);
                $departmentLogos[] = $departmentRow['profile_picture'];
            }
        }
        if ($member !== null) {
            $memberIDs = explode(',', $member);
            foreach ($memberIDs as $memberID) {
                $sql5 = "SELECT full_name FROM employee WHERE id = $memberID";
                $result5 = mysqli_query($conn, $sql5);

                if ($result5 && mysqli_num_rows($result5) > 0) {
                    $memberRow = mysqli_fetch_assoc($result5);
                    $memberNames[] = $memberRow['full_name'];
                }
            }
            $teamMemberIDs = explode(',', $member);
            $todoCount = 0;
            $inProgressCount = 0;
            $completedCount = 0;

            foreach ($teamMemberIDs as $memberID) {
                $currentDate = date('Y-m-d');
                $firstDayOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($currentDate)));
                $lastDayOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($currentDate)));
                $sqlTasks = "SELECT status FROM tasks 
                            WHERE assigned_to = $memberID 
                            AND due_date BETWEEN '$firstDayOfWeek' AND '$lastDayOfWeek'";

                $resultTasks = mysqli_query($conn, $sqlTasks);

                if ($resultTasks) {
                    while ($taskRow = mysqli_fetch_assoc($resultTasks)) {
                        $status = $taskRow['status'];

                        if ($status === 'Todo') {
                            $todoCount++;
                        } elseif ($status === 'InProgress') {
                            $inProgressCount++;
                        } elseif ($status === 'Completed') {
                            $completedCount++;
                        }
                    }
                }
            }
        }
        $totalTasks = $todoCount + $inProgressCount + $completedCount;
        $completionPercentage = ($totalTasks != 0) ? ($completedCount / $totalTasks) * 100 : 0;
        $progress = number_format($completionPercentage, 2) . "%";

?>

        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Objectives | JIFFY</title>
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

                .filter-option-inner-inner {
                    overflow: hidden;
                    overflow-wrap: break-word;
                    width: 100%;
                    display: inline-block;
                    white-space: pre-line;
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
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "<div class='modal fade' id='alertMessage' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content justify-content-center align-items-center d-flex'>
                        <div class='modal-body m-3'>
                            <i class='fa fa-exclamation-triangle' style='font-size: 25px; color:red;'></i>
                            <span class='ml-2' style='color: black !important; font-size: 18px; font-weight:bold'>" . $_SESSION['error'] . "</span>
                        </div>
                    </div>
                </div>
            </div>";
                                unset($_SESSION['error']);
                                echo "<script>
                $(document).ready(function(){
                    $('#alertMessage').modal('show');
                    setTimeout(function(){
                        $('#alertMessage').modal('hide');
                    }, 2000);
                });
            </script>";
                            }

                            if (isset($_SESSION['success'])) {
                                echo "<div class='modal fade' id='alertMessage' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content justify-content-center align-items-center d-flex'>
                        <div class='modal-body m-3'>
                            <i class='fa fa-check-circle' style='font-size: 25px; color:green;'></i>
                            <span class='ml-2' style='color: black !important; font-size: 18px; font-weight:bold;'>" . $_SESSION['success'] . "</span>
                        </div>
                    </div>
                </div>
            </div>";
                                unset($_SESSION['success']);
                                echo "<script>
                $(document).ready(function(){
                    $('#alertMessage').modal('show');
                    setTimeout(function(){
                        $('#alertMessage').modal('hide');
                    }, 2000);
                });
            </script>";
                            }
                            ?>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content text-center">
                                            <div class="back-button">
                                                <?php if ($_SESSION["id"] == 2) {
                                                    $url = 'team.php?condition=2';
                                                } else {
                                                    $url = 'team.php';
                                                } ?>
                                                <a href='<?= $url ?>'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                                        <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <h5 class="mx-auto">Edit Team Detials</h5>
                                        </div>
                                        <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
                                            <div class="row">
                                                <div class="modal-body">
                                                    <form action="teamedit.php" method="post" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-3">
                                                                    <label for="exampleInputText01">Team Name</label>
                                                                    <input type="text" class="form-control" id="exampleInputText01" placeholder=" Enter your project name" name="projectName" value="<?= $projectname ?>" requried>
                                                                    <input type="text" class="form-control" id="exampleInputText01" placeholder=" Enter your project name" name="team_id" value="<?= $id ?>" hidden>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $employees = array();
                                                            $sqlEmployees = "SELECT * FROM employee WHERE  Company_id = $companyId  AND Active = 'active' ORDER BY full_name ASC";
                                                            $resultEmployees = $conn->query($sqlEmployees);
                                                            if ($resultEmployees->num_rows > 0) {
                                                                while ($row = $resultEmployees->fetch_assoc()) {
                                                                    $employees[] = $row;
                                                                }
                                                            } ?>
                                                            <div class="col-lg-12">
                                                                <div class="form-group mb-3">
                                                                    <label for="teamLeader">Select Team Leader</label>
                                                                    <select class="form-control selectpicker" id="teamLeader" name="teamLeader" required data-style="py-0" data-live-search='true'>
                                                                        <option value="" disabled>Select Team Leader</option>
                                                                        <?php
                                                                        foreach ($employees as $employee) {
                                                                            $selected = ($employee['id'] == $leader) ? 'selected' : '';
                                                                            $roles = $employee['user_role'];
                                                                            echo '<option value="' . $employee['id'] . '" ' . $selected . '>' . $employee['full_name'] . ' (' . $roles . ')</option>';
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="exampleInputText2" class="h5">Select Member</label>
                                                                    <select name="selectedMembers[]" class="selectpicker form-control" data-style="py-0" multiple requried data-live-search='true'>
                                                                        <option value="">Select Member</option>
                                                                        <?php
                                                                        $query = "SELECT e.* FROM employee e where e.active='active' AND  Company_id = $companyId ORDER BY e.full_name";
                                                                        $result = mysqli_query($conn, $query);

                                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                                $id = $row['id'];
                                                                                $full_name = $row['full_name'];
                                                                                $selected = in_array($id, $memberIDs) ? 'selected' : '';
                                                                                $roles = $row['user_role'];

                                                                                echo '<option value="' . $id . '" ' . $selected . '>' . $full_name . ' (' . $roles . ')</option>';
                                                                            }
                                                                        } else {
                                                                            echo '<option value="" disabled>No members found</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="col-lg-12">
                                                                    <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                                                        <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
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
            <script>
                $(document).ready(function() {
                    setTimeout(function() {
                        $(".alert").alert('close');
                    }, 2000);
                });
            </script>
            <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('editor1');
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var selectedEmployeesButton = document.getElementById('selectedEmployeesButton');
                    var selectedEmployeesInput = document.getElementById('selectedEmployees');
                    selectedEmployeesButton.addEventListener('click', function() {
                        this.classList.toggle('show');
                    });
                    var checkboxes = document.querySelectorAll('input[name="selectedMembers[]"]');
                    checkboxes.forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                            var selectedNames = [];
                            checkboxes.forEach(function(cb) {
                                if (cb.checked) {
                                    selectedNames.push(cb.getAttribute('data-fullname'));
                                }
                            });
                            selectedEmployeesInput.textContent = selectedNames.join(', ');

                            selectedEmployeesButton.classList.remove('show');
                        });
                    });
                });
                window.addEventListener('click', function(event) {
                    var selectedEmployeesButton = document.getElementById('selectedEmployeesButton');
                    if (event.target !== selectedEmployeesButton) {
                        selectedEmployeesButton.classList.remove('show');
                    }
                });
            </script>
        </body>
<?php  } else {
    }
}
?>

        </html>