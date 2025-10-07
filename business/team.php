<?php
session_start();
include "./../include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userid = $_SESSION["user_id"];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_SESSION["user_id"];
    $projectName = $_POST["projectName"];
    $leader = $_POST["teamLeader"];
    $assignMembers = isset($_POST['selectedMembers']) ? $_POST['selectedMembers'] : array();
    $employeeId = implode(", ", $assignMembers);

    $query = "INSERT INTO team (teamname,employee,leader,project_lead,Company_id) 
                    VALUES (?, ?,?,?,?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $projectName, $employeeId, $leader, $userid, $companyId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = 'Team added successfully';
            mysqli_stmt_close($stmt);
            header('location: team.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed, Try again';
            mysqli_stmt_close($stmt);
            header('location: team.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Statement preparation failed.';
        header('location: team.php');
        exit();
    }
}
if (isset($_GET['teamId'])) {
    $projectId = $_GET['teamId'];
    $query = "DELETE FROM team WHERE team_id=?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $projectId);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = 'Team deleted successfully';
            header('location: team.php');
            exit();
        } else {
            return 'Failed to delete project. Try again.';
        }
    } else {
        return 'Statement preparation failed.';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project | JIFFY</title>
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
    </style>
    <script>
        if (!<?php echo !empty($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
            // Redirect the user to index.php
            window.location.href = 'index.php';
        }
    </script>
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
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h5>Team</h5>
                                    <div class="d-flex flex-wrap align-items-center ">
                                        <?php if (isset($_GET['condition']) && $_GET['condition'] == '2') { ?>
                                        <?php } else { ?>
                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Create new team">
                                                <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-project-modal" data-toggle="modal">New Team</a>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
                    <div class="row">
                        <?php
                        $query = "SELECT team.teamname, team.team_id, team.employee, team.leader, 
                employee.full_name, employee.profile_picture,team.Company_id 
                FROM team JOIN employee ON team.employee = employee.id WHERE team.Company_id = $companyId";
                        if (isset($_GET['condition']) && $_GET['condition'] == '2') {
                            $userid = mysqli_real_escape_string($conn, $userid);
                            $query .= " AND team.leader = '$userid'";
                        }
                        $result = mysqli_query($conn, $query);
                        $progressClasses = array("circle-progress-primary", "circle-progress-secondary", "circle-progress-success", "circle-progress-info");
                        $classIndex = 0;
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $projectname = $row['teamname'];
                                $id = $row['team_id'];
                                $departments = $row['employee'];
                                $member = $row['employee'];
                                $departmentLogos = array();
                                $memberNames = array();
                                $progressClass = $progressClasses[$classIndex];
                                $classIndex = ($classIndex + 1) % count($progressClasses);
                                $leader = $row['leader'];

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
                                $progress = number_format($completionPercentage, 2) . "%";            ?>


                                <div class="col-lg-4 col-md-6 task-card1">
                                    <div class="card card-block card-stretch card-height">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div id="circle-progress-<?php echo $id; ?>" class="circle-progress-01 circle-progress <?php echo $progressClass; ?>" data-min-value="0" data-max-value="100" data-value="<?php echo $progress; ?>" data-type="percent"></div>
                                                <div class="dropdown">
                                                    <?php if ($_SESSION["id"]==1) { ?>
                                                        <a href="#" class="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="teamedit.php?id=<?php echo $id; ?>" data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit team details" >
                                                            <i class="ri-edit-line mr-2"></i>Edit
                                                            </a>
                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete team details">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteConfirmationModal">
                                                            <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                            </a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <h5 class="mb-1" onclick="window.location.href='task.php?teamid=<?php echo $id; ?>&condition';" style="cursor: pointer;">
                                                <?php echo $projectname; ?>
                                            </h5>
                                            <p class="mb-3">
                                                <?php echo implode(', ', $memberNames); ?>
                                            </p>
                                                                                     
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-xl-12">
                            <div class="card-transparent card-block card-stretch card-height">
                                <div class "card-body p-0">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>No Team found</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Modal list start -->
                <div class="modal fade" role="dialog" aria-modal="true" id="new-project-modal">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content modal-xl">
                            <div class="modal-header d-block text-center pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <h4 class="modal-title wordspace" id="exampleModalCenterTitle01">Create Team
                                        </h4>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="close" data-dismiss="modal">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body ">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText01">Team Name<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="text" class="form-control" id="exampleInputText01" placeholder=" Enter your team name" name="projectName" required>
                                            </div>
                                        </div>
                                        <?php
                                        $employees = array();
                                        $sqlEmployees = "SELECT * FROM employee WHERE active='active' AND Company_id = $companyId ORDER BY full_name";
                                        $resultEmployees = $conn->query($sqlEmployees);
                                        if ($resultEmployees->num_rows > 0) {
                                            while ($row = $resultEmployees->fetch_assoc()) {
                                                $employees[] = $row;
                                            }
                                        } ?>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="teamLeader">Select Team Leader<span class="text-danger" style="font-size:20px">*</span></label>
                                                <select class="form-control selectpicker" id="teamLeader" name="teamLeader" data-style="py-0" required data-live-search='true'>
                                                    <option value="" disabled selected hidden>Select Team Leader</option>
                                                    <?php
                                                    foreach ($employees as $employee) {

                                                        echo '<option value="' . $employee['id'] . '" >' . $employee['full_name'] . '(' . $employee['user_role'] . ')</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="exampleInputText2" class="h5">Select Team Members<span class="text-danger" style="font-size:20px">*</span></label>
                                                <select name="selectedMembers[]" class="selectpicker form-control" data-style="py-0" multiple required data-live-search='true'>
                                                    <?php
                                                    $query = "SELECT e.* FROM employee e where e.active='active' AND Company_id = $companyId ORDER BY e.full_name";
                                                    $result = mysqli_query($conn, $query);

                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $full_name = $row['full_name'];
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

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Team</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6>Are you sure you want to delete this team?</h6>
                                <form id="deleteForm" action="" method="post" id="delete">
                                    <input type="hidden" id="itemIdToDelete" name="projectId" value="">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-yes">Yes</button>
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
</html>