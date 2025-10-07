<?php
session_start();
include "./../include/config.php";
require_once "./../project/taskdata/insertdata.php";
require_once "./../project/taskdata/feach.php";
error_reporting(E_ALL);
ini_set('display_errors', 0);
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
if (isset($_GET['status'])) {
    $status = '100';
    $projects = $projectManager->getProjects($userid, 1, $status);
} else {
    $projects = $projectManager->getProjects($userid, '2');
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['projectId'])) {
        $taskManager->deleteProject($_POST['projectId']);
    } else {
        $taskManager->project($userid);
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Activities | JIFFY</title>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <?php if ($_SESSION["id"] != 2 && $_SESSION["id"] != 3) { ?>
                                        <h5>Activities</h5>
                                    <?php } else { ?>
                                        <h5>Projects Involved</h5>
                                    <?php } ?>
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <?php if ($_SESSION["id"] != 2 && $_SESSION["id"] != 3) { ?>
                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new activity">
                                                <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-project-modal" data-toggle="modal">New Activity</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
                    <!-- Modal card start -->
                    <div class="row">
                        <?php if (!empty($projects)) { ?>
                            <?php foreach ($projects as $project) { ?>
                                <div class="col-lg-4 col-md-6 task-card1">
                                    <div class="card card-block card-stretch card-height">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div id="circle-progress-<?php echo $project['id']; ?>" class="circle-progress-01 circle-progress <?php echo $project['progressClass']; ?>" data-min-value="0" data-max-value="100" data-value="<?php echo $project['progress']; ?>" data-type="percent"></div>
                                                <div class="dropdown">
                                                    <a href="#" class="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ri-more-fill"></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View activity details">
                                                            <a class="dropdown-item" href="viewproject.php?projectid=<?php echo $project['id']; ?>">
                                                                <i class="fa fa-eye mr-2"></i>View
                                                            </a>
                                                        </div>
                                                        <?php if ($_SESSION["id"] != 3) { ?>
                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit activity">
                                                                <a class="dropdown-item" href="projectedit.php?id=<?php echo $project['id']; ?>">
                                                                    <i class="ri-edit-line mr-2"></i>Edit
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($_SESSION["id"] != 2 && $_SESSION["id"] != 3) { ?>
                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete activity">
                                                                <a class="dropdown-item" href="#" onclick="viewProjectDelete(<?php echo $project['id']; ?>)">
                                                                    <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                                </a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <h5 class="mb-1">
                                                <?php echo $project['projectname']; ?>
                                            </h5>
                                            <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                                                <div class="iq-media-group">
                                                    <?php
                                                    foreach ($project['departmentLogos']['images'] as $index => $imagePath) {
                                                        $name = $project['departmentLogos']['full_name'][$index];
                                                    ?>
                                                        <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $name; ?>">
                                                            <img class="img-fluid avatar-40 rounded-circle" src="./../uploads/employee/<?php echo $imagePath; ?>" alt="<?php echo $name; ?>">
                                                        </a>
                                                    <?php } ?>


                                                </div>
                                                <span class="<?php echo $project['buttonClasses']; ?>">
                                                    <?php echo $project['priority']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="col-xl-12">
                                <div class="card-transparent card-block card-stretch card-height">
                                    <div class="card-body p-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512" style="margin-right: 10px;">
                                                        <path fill="#db0a0a" d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                    </svg>No activities found
                                                </h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- Modal card end -->
                <!-- View Project Details and edit Modal -->
                <div class="modal fade" id="viewProjectModal" tabindex="-1" role="dialog" aria-labelledby="viewProjectModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content modal-xl">
                            <div class="modal-header d-block text-center pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <h4 class="modal-title" id="taskDetailsModalLabel">Activity Details</h4>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body" id="projectDetailsContent"></div>
                        </div>
                    </div>
                </div>
                <!-- View Project Details and edit Modal -->
                <!-- Modal delete start -->
                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Activity</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this activity?</p>
                                <form id="deleteForm" action="" method="post" id="delete">
                                    <input type="hidden" id="itemIdToDelete" name="projectId" value="">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-no" data-dismiss="modal" onclick>Cancel</button>
                                <button type="button" class="btn btn-yes" onclick="submitDeleteForm()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal delete end -->
                <!-- Modal new start -->
                <div class="modal fade" role="dialog" aria-modal="true" id="new-project-modal">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content modal-xl">
                            <div class="modal-header d-block text-center pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <h4 class="modal-title wordspace" id="exampleModalCenterTitle01">New Activity
                                        </h4>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="close" data-dismiss="modal">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText01">Activity Name<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="text" class="form-control" id="exampleInputText01" placeholder="Enter activity name" name="projectName" required pattern="[A-Za-z]+[0-9\s_-.\s]*" title="Please use atleast one letter">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText01">Sub Activities Name</label>
                                                <input type="text" class="form-control" id="moduleInput" placeholder="Enter sub-activities name" pattern="[A-Za-z\s,]+" title="Please enter letters only">
                                                <p class="mt-1 text-danger" style="font-size:11px;"><i class="fa fa-exclamation-circle mr-1 text-danger"></i>Please enter names, separated by commas, and then press enter</p>
                                                <input type="hidden" name="moduleNames[]">
                                                <div id="pillContainer"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="budget" class="h5">Budget</label>
                                                <input type="text" class="form-control" id="budget" name="budget" placeholder="Enter budget" pattern="\d{4,}(\.\d+)?" title="Please enter numbers only" value="<?= $pd["budget"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText01">Task Name</label>
                                                <input type="text" class="form-control" id="moduleInput1" placeholder="Enter task name" pattern="[A-Za-z\s,]+" title="Please enter letters only">
                                                <p class="mt-1 text-danger" style="font-size:11px;"><i class="fa fa-exclamation-circle mr-1 text-danger"></i>Please enter names, separated by commas, and then press enter</p>
                                                <input type="hidden" name="tasks[]">
                                                <div id="pillContainer1"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText3" class="h5">Start Date<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="date" class="form-control" id="startDate" name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText3" class="h5">End Date<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="date" class="form-control" id="endDate" name="end_date" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="exampleInputText3" class="h5">Total Hours<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="number" class="form-control" id="totalHours" name="totalhours" placeholder="Enter total hours">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="budget" class="h5">Per Day<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="text" class="form-control" id="hoursPerDay" name="perday" placeholder="Enter hours per day">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputText2" class="h5">Select Department<span class="text-danger" style="font-size:20px">*</span></label>
                                                <select name="selecteddpt[]" class="selectpicker form-control" data-style="py-0" required multiple data-live-search="true">
                                                    <option value="" disabled>Select</option>
                                                    <?php
                                                    $query = "SELECT * FROM department WHERE Company_id = $companyId";
                                                    $result = mysqli_query($conn, $query);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $leavetype = $row['name'];
                                                            echo '<option value="' . $id . '" >' . $leavetype . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="" disabled>No type found</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputText2" class="h5" required>Select Activity Owner<span class="text-danger" style="font-size:20px">*</span></label>
                                                <select name="selectedproject" class="selectpicker form-control" data-style="py-0" required data-live-search="true">
                                                    <option value="" disable>Select</option>
                                                    <?php
                                                    $query = "SELECT * FROM employee WHERE active='active' AND user_role='Project Manager' AND Company_id = $companyId";
                                                    $result = mysqli_query($conn, $query);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $full_name = $row['full_name'];
                                                            $user_role = $row['user_role'];
                                                            echo '<option value="' . $id . '">' . $full_name . ' (' . $user_role . ')</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="" disabled>No owner found</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="selectedLeader" class="h5">Select Lead<span class="text-danger" style="font-size:20px">*</span></label>
                                                <select name="selectedleader[]" id="selectedLeader" class="selectpicker form-control" data-live-search="true" data-style="py-0" multiple required>
                                                    <option value="" disabled>Select</option>
                                                    <?php
                                                    $query = "SELECT e.* FROM employee e 
                                                        JOIN team ON e.id = team.leader
                                                        WHERE e.Company_id = $companyId";
                                                    $result = mysqli_query($conn, $query);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $full_name = $row['full_name'];
                                                            $user_role = $row['user_role'];
                                                            echo '<option value="' . $id . '">' . $full_name . ' (' . $user_role . ')</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="" disabled>No leaders found</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputText2" class="h5">Select Member</label>
                                                <select name="selectedMembers[]" class="selectpicker form-control" data-style="py-0" multiple data-live-search="true">
                                                    <option value="" disabled>Select</option>
                                                    <?php
                                                    $query = "SELECT e.* FROM employee e WHERE e.Company_id = $companyId  ORDER BY e.full_name ";
                                                    $result = mysqli_query($conn, $query);

                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $leavetype = $row['full_name'];
                                                            $user_role = $row['user_role'];

                                                            echo '<option value="' . $id . '" >' . $leavetype . '(' . $user_role . ')</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="" disabled>No members found</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="resources" class="h5">Resources<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="number" class="form-control" id="resources" name="resources" placeholder="Enter actual resource" pattern="\d+(\.\d+)?" title="Please enter numbers only">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="required-resource" class="h5">Required Resources<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="number" class="form-control" id="add-resources" name="add-resources" placeholder="Enter required resource" pattern="\d+(\.\d+)?" title="Please enter numbers only">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="priority" class="h5">Priority<span class="text-danger" style="font-size:20px">*</span></label>
                                                <select name="priority" class="form-control" id="priority">
                                                    <option value="">Select Priority</option>
                                                    <option value="High">High</option>
                                                    <option value="Normal">Normal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group mb-3">
                                                <label for="location" class="h5">Location<span class="text-danger" style="font-size:20px">*</span></label>
                                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter activity location" required pattern="^[A-Za-z0-9\s\-,.!@#$%^&*()_+=?<>{}[\]\/\\|~`':;]+$" title="Please enter valid location">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label for="shortDescription">Activity Description<span class="text-danger" style="font-size:20px">*</span></label>
                                                <textarea class="form-control" id="editor1" placeholder="Short Description" name="shortDescription"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3 custom-file-small">
                                                <label for="projectDocument">Attach File<span class="text-danger" style="font-size:20px">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="projectDocument" accept=".pdf,.docx" name="projectDocument" required>
                                                    <label class="custom-file-label" for="projectDocument">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                                <button type="submit" class="custom-btn1 btn-2 mr-3 text-center" id="project">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal new end -->
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


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectedDepartmentInput = document.getElementById("selectedDepartments");
            const selectedDepartmentButton = document.getElementById("selectedDepartmentsButton");
            const departmentDropdownMenu = document.querySelector(".custom-dropdown-department .dropdown-menu");

            departmentDropdownMenu.addEventListener("click", function(event) {
                if (event.target.classList.contains("form-check-input")) {
                    const selectedDepartmentOptions = Array.from(departmentDropdownMenu.querySelectorAll(
                            ".form-check-input:checked"))
                        .map(checkbox => checkbox.getAttribute('data-fullname'));

                    selectedDepartmentInput.textContent = selectedDepartmentOptions.join(", ");
                }
            });

            selectedDepartmentButton.addEventListener("click", function(event) {
                departmentDropdownMenu.classList.toggle("show");
            });

            document.addEventListener("click", function(event) {
                if (!selectedDepartmentButton.contains(event.target) && !departmentDropdownMenu.contains(
                        event.target)) {
                    departmentDropdownMenu.classList.remove("show");
                }
            });

            const selectedEmployeeInput = document.getElementById("selectedEmployees");
            const selectedEmployeeButton = document.getElementById("selectedEmployeesButton");
            const employeeDropdownMenu = document.querySelector(".custom-dropdown-employee .dropdown-menu");

            employeeDropdownMenu.addEventListener("click", function(event) {
                if (event.target.classList.contains("form-check-input")) {
                    const selectedEmployeeOptions = Array.from(employeeDropdownMenu.querySelectorAll(
                            ".form-check-input:checked"))
                        .map(checkbox => checkbox.getAttribute('data-fullname'));

                    selectedEmployeeInput.textContent = selectedEmployeeOptions.join(", ");
                }
            });

            selectedEmployeeButton.addEventListener("click", function(event) {
                employeeDropdownMenu.classList.toggle("show");
            });

            document.addEventListener("click", function(event) {
                if (!selectedEmployeeButton.contains(event.target) && !employeeDropdownMenu.contains(event
                        .target)) {
                    employeeDropdownMenu.classList.remove("show");
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        function performSearch() {
            const searchQuery = taskSearchInput.value.toLowerCase();
            const taskCards = document.querySelectorAll(".task-card1");

            taskCards.forEach(function(card) {
                const projectname = card.querySelector("h5.mb-1").textContent.toLowerCase();

                if (projectname.includes(searchQuery)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }
        const taskSearchInput = document.getElementById("taskSearchInput");
        taskSearchInput.addEventListener("input", performSearch);
    </script>

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
</body>
<script>
    var dueDateInput = document.getElementById("exampleInputText004");
    var currentDate = new Date();
    var currentDateString = currentDate.toISOString().slice(0, 10);
    dueDateInput.setAttribute("min", currentDateString);
</script>
<script>
    function viewProjectDelete(id) {
        $("#deleteConfirmationModal").modal("show");
        $("#itemIdToDelete").val(id);

    }

    function submitDeleteForm($id) {
        document.getElementById('deleteForm').submit();
    }

    function closeModal() {
        $('#deleteConfirmationModal').modal('hide');
    }


    $('.btn-secondary').click(function() {
        closeModal();
    });


    $('.close').click(function() {
        closeModal();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const selectElement = document.querySelector('select[name="selectedMembers[]"]');
        const resourcesInput = document.getElementById('resources');
        const remainingRequiredInput = document.getElementById("add-resources");

        const logCountAndResources = () => {
            console.clear();
            let selectedEmployeeCount = selectElement.selectedOptions.length;
            let totalRequiredEmployee = resourcesInput.value;
            let remainingRequired = totalRequiredEmployee - selectedEmployeeCount;
            remainingRequiredInput.value = remainingRequired; // Update the input field value
        };

        selectElement.addEventListener('change', logCountAndResources);
        resourcesInput.addEventListener('input', logCountAndResources);
        logCountAndResources();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const moduleInput = document.getElementById('moduleInput');
        const moduleNamesInput = document.querySelector('input[name="moduleNames[]"]');
        const pillContainer = document.getElementById('pillContainer');
        let updatedModules = [];

        moduleInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                event.preventDefault();
                const modules = moduleInput.value.split(',').map(module => module.trim());
                updatedModules = updatedModules.concat(modules); // Combine the modules with the existing updatedModules array
                moduleNamesInput.value = updatedModules.join(', '); // Update the value of moduleNames[] input field
                moduleInput.value = '';

                // Clear existing pills
                pillContainer.innerHTML = '';

                // Create and display pills for each module
                updatedModules.forEach(module => {
                    const pill = document.createElement('span');
                    pill.classList.add('pill');
                    pill.textContent = module;

                    const closeButton = document.createElement('button');
                    closeButton.textContent = 'x';
                    closeButton.addEventListener('click', function() {
                        // Remove the module from the updatedModules array
                        updatedModules = updatedModules.filter(m => m !== module);
                        moduleNamesInput.value = updatedModules.join(', '); // Update the value of moduleNames[] input field
                        pill.remove();
                        console.log(updatedModules); // Log the updated modules to the console
                    });

                    pill.appendChild(closeButton);
                    pillContainer.appendChild(pill);
                });
                console.log(updatedModules); // Log the updated modules to the console
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const moduleInput = document.getElementById('moduleInput1');
        const moduleNamesInput = document.querySelector('input[name="tasks[]"]');
        const pillContainer = document.getElementById('pillContainer1');
        let updatedModules = [];

        moduleInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                event.preventDefault();
                const modules = moduleInput.value.split(',').map(module => module.trim());
                updatedModules = updatedModules.concat(modules); // Combine the modules with the existing updatedModules array
                moduleNamesInput.value = updatedModules.join(', '); // Update the value of moduleNames[] input field
                moduleInput.value = '';

                // Clear existing pills
                pillContainer.innerHTML = '';

                // Create and display pills for each module
                updatedModules.forEach(module => {
                    const pill = document.createElement('span');
                    pill.classList.add('pill');
                    pill.textContent = module;

                    const closeButton = document.createElement('button');
                    closeButton.textContent = 'x';
                    closeButton.addEventListener('click', function() {
                        // Remove the module from the updatedModules array
                        updatedModules = updatedModules.filter(m => m !== module);
                        moduleNamesInput.value = updatedModules.join(', '); // Update the value of moduleNames[] input field
                        pill.remove();
                        console.log(updatedModules); // Log the updated modules to the console
                    });

                    pill.appendChild(closeButton);
                    pillContainer.appendChild(pill);
                });
                console.log(updatedModules); // Log the updated modules to the console
            }
        });
    });
</script>
<script>
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const today = new Date().toISOString().split('T')[0];
    startDateInput.min = today;
    startDateInput.addEventListener('input', function() {
        const startDateValue = startDateInput.value;
        endDateInput.min = startDateValue;
        if (endDateInput.value > startDateValue) {
            endDateInput.value = startDateValue;
        }
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function projectmanager(managerId) {
        $.ajax({
            url: 'memberfiler.php',
            type: 'POST',
            data: {
                manager_id: managerId
            },
            success: function(response) {
                console.log(response)
                $('#selectedLeader').html(response);
            }
        });
    }
</script>
<script>
    function teamlead(managerId) {
        $.ajax({
            url: 'memberfiler.php',
            type: 'POST',
            data: {
                leader_id: managerId
            },
            success: function(response) {
                console.log(response)
                $('#member').html(response);
            }
        });
    }
</script>
<script>
    function calculateHoursPerDay() {
        var startDate = new Date(document.getElementById("startDate").value);
        var endDate = new Date(document.getElementById("endDate").value);
        var totalHours = parseInt(document.getElementById("totalHours").value);

        var totalDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));

        var hoursPerDay = totalHours / totalDays;

        if (hoursPerDay > 24) {
            alert("The calculated hours per day exceed 24 hours. Please adjust the input values.");
            document.getElementById("hoursPerDay").value = "";
        } else {
            document.getElementById("hoursPerDay").value = hoursPerDay.toFixed(2);
        }
    }
    document.getElementById("startDate").addEventListener("change", calculateHoursPerDay);
    document.getElementById("endDate").addEventListener("change", calculateHoursPerDay);
    document.getElementById("totalHours").addEventListener("input", calculateHoursPerDay);
</script>






</html>