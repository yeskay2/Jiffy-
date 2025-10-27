<?php
session_start();
include "./../include/config.php";
require_once "taskdata/insertdata.php";
$userid = $_SESSION["user_id"];
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskManager->addTask($userid);
}
if (!empty($_GET['employeeid'])) {
    $employee = intval($_GET['employeeid']);
    $sqlTeams = "SELECT * FROM employee WHERE id = $employee";
    $resultTeams = $conn->query($sqlTeams);
    if ($resultTeams && $resultTeams->num_rows > 0) {
        $teamData = $resultTeams->fetch_assoc();
        $employee = $teamData['full_name'];
    } else {
        $employee = 'Employee';
    }
} else {
    $employee = 'Employee';
}
if (isset($_GET['project_id'])) {
    $project_id = intval($_GET['project_id']);
    $sqlTeams = "SELECT * FROM projects WHERE id = $project_id";
    $resultTeams = $conn->query($sqlTeams);
    if ($resultTeams && $resultTeams->num_rows > 0) {
        $teamData = $resultTeams->fetch_assoc();
        $project_id = $teamData['project_name'];
    }
} else {
    $project_id = 'All Projects';
}
$condition =  $_SESSION["id"];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS</title>

    <!-- Favicon -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./../assets/css/viewicon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @media (max-width:767px) {
            .card .text-center {
                display: flex;
                justify-content: center;
                margin-left: 94px
            }
        }

        #filter {
            display: none
        }

        @media (max-width:768px) {
            #filter {
                display: block;
            }

            .modal-header .close {
                margin-top: -67px;
            }

            .bg-success {
                color: #fff !important;
                background-color: #50C6B4 !important;
                padding-left: 8px;
                padding-right: 8px;
                padding-bottom: 8px;
                padding-top: 8px;
                left: 8%;
            }
        }

        .no-drop {
            cursor: no-drop;
        }

        .confirmation-card {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .bg-body {
            background: #f8f7f7;
            border: 1px solid #CED4DA;
            height: 35px;
            }
        .bg-body:focus, .bg-body:active {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); 
            background: #fff;
            border: 2px solid #3d3399;
}
input, select, textarea, button {
        cursor: pointer;
    }

    /* Custom file input hand cursor */
    .custom-file-input {
        cursor: pointer;
    }

    </style>
</head>

<body>

    <!-- Wrapper Start -->
    <?php
    include 'sidebar.php';
    include 'topbar.php';
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
                                                <button type='button' class='close'  data-dismiss='alert' aria-label='Close'>
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
                                <?php include("./filter.php"); ?>
                                <h4 class="card-title">Your Task</h4>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="dropdown dropdown-project mr-3" id="filter">
                                        <div class="dropdown-toggle" id="statusDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Status">
                                                <span class="h6" id="selectedStatus" style="float:left;">Status </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>
                                        <div class="dropdown-menu selectpicker" aria-labelledby="statusDropdown">
                                            <?php
                                            foreach ($statuses as $status) {
                                                echo '<a class="dropdown-item" href="#" onclick="filtertypestatus(\'' . $status . '\')">' . $status . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="employeeDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" tabindex="0" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Employee">
                                                <span class="h6" id="selectedEmployee" style="float:left;"><?= $employee ?> </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>

                                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="employeeDropdown">
                                       <div class="dropdown-header">Select employee</div>
                                                <div class="dropdown-menu-scrollable selectpicker" style="max-height: 200px; overflow-y: auto;">
                                                    <input type="text" id="employeeSearch" class="form-control" style="line-height:30px;" placeholder="Search Employee..." onkeyup="filterEmployeeList()">
                                                    <?php foreach ($employeeData as $employee) { ?>
                                                        <a class="dropdown-item" href="task.php?<?php echo isset($_GET['project_id']) ? 'project_id=' . $_GET['project_id'] . '&' : ''; ?><?php echo isset($_GET['period']) ? 'period=' . $_GET['period'] . '&' : ''; ?><?php echo isset($_GET['condition']) ? 'condition=' . $_GET['condition'] . '&' : ''; ?>employeeid=<?php echo $employee['id']; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>" onclick="filterTasksByEmployee(<?php echo $employee['id']; ?>)">
                                                            <?php echo $employee['full_name']; ?>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <script>
                                            function filterEmployeeList() {
                                                var input, filter, dropdown, items, a, i, txtValue;
                                                input = document.getElementById("employeeSearch");
                                                filter = input.value.toUpperCase();
                                                dropdown = document.querySelector(".dropdown-menu-scrollable");
                                                items = dropdown.getElementsByTagName("a");

                                                for (i = 0; i < items.length; i++) {
                                                    a = items[i];
                                                    txtValue = a.textContent || a.innerText;
                                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                        items[i].style.display = "";
                                                    } else {
                                                        items[i].style.display = "none";
                                                    }
                                                }
                                            }
                                            </script>
                                    </div>

                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" tabindex="0" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Project">
                                                <span class="h6" id="selectedproject" style="float:left;"><?= $project_id ?> </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="projectDropdown">
                                        <div class="dropdown-header">Select project</div>
                                            <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                                <?php foreach ($projectNames as $name) { ?>
                                                    <a class="dropdown-item" href="task.php?<?php echo isset($_GET['period']) ? 'period=' . $_GET['period'] . '&' : ''; ?><?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] . '&' : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] . '&' : ''; ?>project_id=<?php echo $name['project_id']; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>"><?php echo $name['project_name']; ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" tabindex="0" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select rows length">
                                                <span class="h6" style="float:left;">
                                                    <?php echo isset($_GET['period']) ? $_GET['period'] : '10'; ?>
                                                </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="projectDropdown">
                                            <div class="dropdown-header">Select rows length</div>
                                            <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                                <a class="dropdown-item" href="task.php?period=10<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">10</a>
                                                <a class="dropdown-item" href="task.php?period=50<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">50</a>
                                                <a class="dropdown-item" href="task.php?period=100<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">100</a>
                                                <a class="dropdown-item" href="task.php?period=All<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">All</a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" tabindex="0" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Period">
                                                <span class="h6" style="float:left;">
                                                    <?php echo isset($_GET['assignedby']) ? $_GET['assignedby'] : 'All'; ?>
                                                </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="projectDropdown">
                                            <div class="dropdown-header">Select Period</div>
                                            <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                            <a class="dropdown-item" href="task.php?assignedby=Myself<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">Myself</a>
                                                <a class="dropdown-item" href="task.php?assignedby=Others<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">Others</a>
                                                <a class="dropdown-item" href="task.php?assignedby=All<?php echo isset($_GET['employeeid']) ? '&employeeid=' . $_GET['employeeid'] : ''; ?><?php echo isset($_GET['teamid']) ? '&teamid=' . $_GET['teamid'] : ''; ?><?php echo isset($_GET['teamid2']) ? '&teamid2=' . $_GET['teamid2'] : ''; ?><?php echo isset($_GET['project_id']) ? '&project_id=' . $_GET['project_id'] : ''; ?><?php echo isset($_GET['condition']) ? '&condition=' . $_GET['condition'] : ''; ?>&taskstatus=<?php echo isset($_GET['taskstatus']) ? $_GET['taskstatus'] : ''; ?>">All</a>
                                            </div>

                                        </div>
                                    </div>
                                    <?php if (isset($_GET['condition']) && $_GET['condition'] == '2') { ?>
                                        <a href="team.php?condition=2" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View Team Progress">
                                            <button class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center">Team Progress</button>
                                        </a>
                                    <?php }  ?>
                                        <a href="#" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new task">
                                            <button class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center" data-toggle="modal" data-target="#new-task-modal">Add Task</button>
                                        </a>                                 

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4" id="Todo">
                        <div class="card-transparent mb-0 desk-info">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5><i class="fas fa-reply-all mr-2"></i>To Do<i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#ed6f07;"></i> (<span id="filteredTaskCount1"></span>)</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if (!empty($statusData["Todo"])) {
                                        $todo = $statusData["Todo"];
                                        if ($todo['row_count'] > 0) {
                                            $row_count1 = $todo['row_count'];
                                            while ($row = mysqli_fetch_assoc($todo['data'])) {

                                                if ($row['category'] === "Bug") {
                                                    $buttonClass = "custom-button bug";
                                                } elseif ($row['category'] === "Improvement") {
                                                    $buttonClass = "custom-button success";
                                                } else {
                                                    $buttonClass = "custom-button task";
                                                }
                                    ?>
                                                <div class="col-lg-12 task-card1" data-status="<?php echo $row['status']; ?>">
                                                    <div class="card" id="card1">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h5 class="mb-3" onclick="window.location.href='viewtask.php?taskid=<?php echo urlencode(base64_encode($row['id'])); ?>';" style="cursor: pointer;"><?php echo $row['task_name']; ?></h5>
                                                                <div class="dropdown">
                                                                    <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                        <a href="#"><i class="ri-more-fill"></i></a>
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View task details">
                                                                            <a class="dropdown-item" href="viewtask.php?taskid=<?php echo urlencode(base64_encode($row['id'])); ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                        </div>
                                                                        <?php
                                                                        if ($row['uploaderid'] == $userid || isset($_GET["condition"])) {
                                                                        ?>
                                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit task">
                                                                                <a class="dropdown-item" href="edittask.php?id=<?php echo $row['id']; ?>&cod=<?= $condition ?>">
                                                                                    <i class="ri-edit-line mr-2"></i>Edit
                                                                                </a>
                                                                            </div>
                                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete task">
                                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteConfirmationModal_<?php echo $row['id']; ?>">
                                                                                <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                                            </a>
                                                                        </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <p class="mb-3"><i class="fa fa-calendar-o mr-2" style="color:#E58B0E;"></i>
                                                                        <?php echo date("d-m-Y", strtotime($row['Actual_start_time'])); ?></p>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-3"><i class="fa fa-calendar-check-o mr-2" style="color: #007C00;"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="iq-progress-bar bg-success-light mb-4">
                                                                <span class=" iq-progress progress-1" data-percent="4" style="transition: width 2s ease 0s; width: 65%; background-color: #ed6f07;"></span>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="iq-media-group">
                                                                    <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $row['assigned_full_name'] ?>">
                                                                        <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                    </a>
                                                                    <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $row['uploader_full_name'] ?>">
                                                                        <img src="./../uploads/employee/<?php echo $row['uploader_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                    </a>
                                                                    <p class="projectname"><?php echo $row['project_name']; ?></p>
                                                                    <p class="projectname" id="name1">
                                                                        <?php echo $row['assigned_full_name']; ?></p>
                                                                    <p class="projectname" id="name2">
                                                                        <?php echo $row['uploader_full_name']; ?></p>
                                                                    <p class="projectname" id="date">
                                                                        <?php echo date("d-m-Y", strtotime($row['created_at'])); ?>
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal delete start -->
                                            <div class="modal fade" id="deleteConfirmationModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Team</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to delete this Task?</h6>                                                           
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                            <button type="button" class="btn btn-yes" onclick="window.location.href='task.php?trainid=<?php echo $row['id']; ?>'">Yes</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Modal delete end -->
                                    <?php

                                            }
                                        }
                                    } else {
                                        echo '<div class="container text-center mt-5">
                                        <p class="h9">No Task Found</p>
                                    </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4" id="Inprogress">
                        <div class="card-transparent mb-0 desk-info">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5><i class="fas fa-spinner fa-pulse mr-2"></i>In Progress <i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#3759e1;"></i>(<span id="filteredTaskCount2"></span>)</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($statusData["InProgress"]) || isset($statusData["Pause"])) {
                                        $inProgressTasks = isset($statusData["InProgress"]) ? $statusData["InProgress"] : null;
                                        $pass = isset($statusData["Pause"]) ? $statusData["Pause"] : null;

                                        if (($inProgressTasks && $inProgressTasks['row_count'] > 0) || ($pass && $pass['row_count'] > 0)) {
                                            $row_count2 = $inProgressTasks ? $inProgressTasks['row_count'] : 0;
                                            $row_count4 = $pass ? $pass['row_count'] : 0;

                                            while (($inProgressTasks && $row = mysqli_fetch_assoc($inProgressTasks['data'])) || ($pass && $row = mysqli_fetch_assoc($pass['data']))) {
                                                if ($row['category'] === "Bug") {
                                                    $buttonClass = "custom-button bug";
                                                } elseif ($row['category'] === "Improvement") {
                                                    $buttonClass = "custom-button success";
                                                } else {
                                                    $buttonClass = "custom-button task";
                                                }

                                    ?>
                                                <div class="col-lg-12 task-card2" data-status="<?php echo $row['status']; ?>">
                                                    <div class="card" id="card2">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h5 class="mb-3" onclick="window.location.href='viewtask.php?taskid=<?php echo urlencode(base64_encode($row['id'])); ?>';" style="cursor: pointer;"><?php echo $row['task_name']; ?></h5>
                                                                <div class="dropdown">
                                                                    <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                        <a href="#"><i class="ri-more-fill"></i></a>
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View task details">
                                                                            <a class="dropdown-item" href="viewtask.php?taskid=<?php echo urlencode(base64_encode($row['id'])); ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                        </div>
                                                                        <?php
                                                                        if ($row['uploaderid'] == $userid || isset($_GET["condition"])) {
                                                                        ?>
                                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit task">
                                                                                <a class="dropdown-item" href="edittask.php?id=<?php echo $row['id']; ?>&cod=<?= $condition ?>">
                                                                                    <i class="ri-edit-line mr-2"></i>Edit
                                                                                </a>
                                                                            </div>
                                                                            <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete task">
                                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteConfirmationModal_<?php echo $row['id']; ?>">
                                                                                <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                                            </a>
                                                                        </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <p class="mb-3"><i class="fa fa-calendar-o mr-2" style="color:#E58B0E;"></i>
                                                                        <?php echo date("d-m-Y", strtotime($row['Actual_start_time'])); ?></p>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-3"><i class="fa fa-calendar-check-o mr-2" style="color: #007C00;"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="iq-progress-bar bg-success-light mb-4">
                                                                <span class=" iq-progress progress-1" data-percent="50" style="transition: width 2s ease 0s; width: 65%; background-color: #3759e1;"></span>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="iq-media-group">
                                                                <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $row['assigned_full_name'] ?>">
                                                                        <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                    </a>
                                                                    <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $row['uploader_full_name'] ?>">
                                                                        <img src="./../uploads/employee/<?php echo $row['uploader_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                    <p class="projectname"><?php echo $row['project_name']; ?></p>
                                                                    <p class="projectname" id="name1">
                                                                        <?php echo $row['assigned_full_name']; ?></p>
                                                                    <p class="projectname" id="name2">
                                                                        <?php echo $row['uploader_full_name']; ?></p>
                                                                    <p class="projectname" id="date">
                                                                        <?php echo date("d-m-Y", strtotime($row['created_at'])); ?>
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <?php if ($row['Approval'] == null) { ?>
                                                                        <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                                    <?php } else { ?>
                                                                        <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $row['Approval']; ?></a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="deleteConfirmationModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Team</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to delete this Task?</h6>                                                           
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                            <button type="button" class="btn btn-yes" onclick="window.location.href='task.php?trainid=<?php echo $row['id']; ?>'">Yes</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                            }
                                        }
                                    } else {
                                        echo '<div class="container text-center mt-5">
                                        <p class="h9">No Task Found</p>
                                    </div>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4" id="Completed">
                        <div class="card-transparent mb-0 desk-info">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5><i class="fas fa-calendar-check mr-2"></i>Completed <i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#68d241;"></i> (<span id="filteredTaskCount3"></span>)</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if (!empty($statusData["Completed"])) {
                                        $Compeleted = $statusData["Completed"];
                                        if ($Compeleted['row_count'] > 0) {
                                            $row_count3 = $Compeleted['row_count'];
                                            while ($row = mysqli_fetch_assoc($Compeleted['data'])) {

                                                if ($row['category'] === "Bug") {
                                                    $buttonClass = "custom-button bug";
                                                } elseif ($row['category'] === "Improvement") {
                                                    $buttonClass = "custom-button success";
                                                } else {
                                                    $buttonClass = "custom-button task";
                                                }
                                    ?>
                                                <div class="col-lg-12 task-card3" data-status="<?php echo $row['status']; ?>">
                                                    <div class="card" id="card3">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <h5 class="mb-3" onclick="window.location.href='viewtask.php?taskid=<?php echo urlencode(base64_encode($row['id'])); ?>';" style="cursor: pointer;"><?php echo $row['task_name']; ?></h5>
                                                                <div class="dropdown">
                                                                    <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                        <a href="#"><i class="ri-more-fill"></i></a>
                                                                    </span>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View task details">
                                                                            <a class="dropdown-item" href="viewtask.php?taskid=<?php echo urlencode(base64_encode($row['id'])); ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                        </div>                                                                       

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div>
                                                                    <p class="mb-3"><i class="fa fa-calendar-o mr-2" style="color:#E58B0E;"></i>
                                                                        <?php echo date("d-m-Y", strtotime($row['Actual_start_time'])); ?>
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <p>
                                                                        <i class="fa fa-calendar-check-o mr-2" style="color: #007C00;"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                                    </p>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="iq-progress-bar bg-success-light mb-4">
                                                                <span class=" iq-progress progress-1" data-percent="100" style="transition: width 2s ease 0s; width: 65%; background-color: #68d241;"></span>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="iq-media-group">
                                                                <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $row['assigned_full_name'] ?>">
                                                                        <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                    </a>
                                                                    <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?php echo $row['uploader_full_name'] ?>">
                                                                        <img src="./../uploads/employee/<?php echo $row['uploader_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                    <p class="projectname"><?php echo $row['project_name']; ?></p>
                                                                    <p class="projectname" id="name1">
                                                                        <?php echo $row['assigned_full_name']; ?></p>
                                                                    <p class="projectname" id="name2">
                                                                        <?php echo $row['uploader_full_name']; ?></p>
                                                                    <p class="projectname" id="date">
                                                                        <?php echo date("d-m-Y", strtotime($row['created_at'])); ?>
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    <?php if ($row['Approval'] == null) { ?>
                                                                        <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                                    <?php } else { ?>
                                                                        <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $row['Approval']; ?></a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Task</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to delete this Task?</h6>                                                           
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                            <button type="button" class="btn btn-yes" onclick="window.location.href='task.php?trainid=<?php echo $row['id']; ?>'">Yes</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                      
                                    <?php

                                            }
                                        }
                                    } else {
                                        echo '<div class="container text-center mt-5">
                                        <p class="h9">No Task Found</p>
                                    </div>';
                                    }
                                    ?>

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

    <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <div class="row">
                        <div class="col-lg-10">
                            <h3 class="modal-title" id="exampleModalCenterTitle">New Task</h3>
                        </div>
                        <div class="col-lg-2">
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
                                    <label for="exampleInputText2" class="h5">Project Name<span class="text-danger" style="font-size:20px">*</span></label>
                                    <select name="projectid" class="selectpicker form-control" data-style="py-0" id="projectSelect" onchange="project(this.value)" data-live-search="true" required>
                                        <option disabled selected hidden  value="">Others</option>
                                        <option value="0">Others</option>
                                        <?php
                                        $query = "SELECT * FROM projects  WHERE  Company_id=$companyId  ORDER BY project_name";
                                        $result = mysqli_query($conn, $query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $projectId = $row['id'];
                                                $projectName = $row['project_name'];

                                                echo '<option value="' . $projectId . '">' . $projectName . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>No projects found</option>';
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="form-group mb-3" id="otherProjectInput" style="display: none;">
                                    <label for="exampleInputText2" class="h5">Other Project Name</label>
                                    <input type="text" class="selectpicker form-control" id="exampleInputText2" placeholder="Enter project name" name="otherProjectName">
                                </div>


                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText2" class="h5">Select Module</label>
                                            <select name="modules" class="form-control" data-style="py-0" id="projectmodules" data-live-search="true">
                                                <option value="" disabled selected hidden>Select module</option>
                                                <option value="" class="dropdown-item" disabled>No modules found</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="combinedInput" class="h5">Task Name<span class="text-danger" style="font-size:20px">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="combinedInput" name="taskName" placeholder="Enter task or select task" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="dropdownToggle1" aria-haspopup="true" aria-expanded="false" onclick="tasksdata()">
                                                        Tasklist
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownToggle1" id="drop-down">


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText2" class="h5">Type<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select name="category" class="selectpicker form-control" data-style="py-0">
                                                <option data-icon="fas fa-tasks">Task</option>
                                                <option data-icon="far fa-dot-circle">Bug</option>
                                                <option data-icon="fas fa-lightbulb">Improvement</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText05" class="h5">Actual Start Date<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input type="date" class="form-control" id="startDate" value="" name="startdate" required placeholder="Select start date">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText05" class="h5">Actual Due Date<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input type="date" class="form-control" id="endDate" value="" name="dueDate" required placeholder="Select due date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText05_start" class="h5">Select Start Time<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input type="time" class="form-control" id="starttime" name="startperTime" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText05_end" class="h5">Select Due Time<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input type="time" class="form-control" id="endtime" name="endperTime" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText2" class="h5">Assign To<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select id="selectEmployee" name="assignedTo" class="selectpicker form-control" data-style="py-0" data-live-search="true" required>
                                                <option value="" disabled selected>Select Assign To</option>
                                                <?php
                                                $query = "SELECT * FROM employee WHERE active = 'active' AND Company_id = $companyId ORDER BY full_name";
                                                $result = mysqli_query($conn, $query);

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $employeeId = $row['id'];
                                                        $employeeName = $row['full_name'];
                                                        $roles = $row['user_role'];
                                                        echo '<option value="' . $employeeId . '">' . $employeeName . ' (' . $roles . ')</option>';
                                                    }
                                                } else {
                                                    echo '<option value="" disabled>No employees found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <p id="error" style="color: red;"></p>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputText040" class="h5">Description<span class="text-danger" style="font-size:20px"></span></label>
                                    <textarea class="form-control" id="editor1" rows="2" name="description" required></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="exampleInputText005" class="h5">Checklist</label>
                                    <input type="text" class="form-control" id="exampleInputText005" placeholder="Enter reference link" name="checklist">
                                </div>

                                <div class="form-group mb-0">
                                    <label for="exampleInputText01" class="h5">Attachments</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile003" name="projectDocument[]" multiple>
                                        <label class="custom-file-label" for="inputGroupFile003">Upload multiple files</label>
                                    </div>
                                    <small class="text-muted">Maximum file size: 5 MB</small>
                                    <div id="fileSizeError" class="text-danger d-none">File size exceeds 5 MB.</div>
                                </div>



                                <div id="selectedFiles"> </div>
                                    <div class="col-lg-12">
                                         <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                        <button type="submit" id="submitButton" class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete task modal -->
    

    <!-- Task busy popup modal
    <div class="modal fade" id="taskBusyNotify" tabindex="-1" role="dialog" aria-labelledby="TaskBusy" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color:white">
                <div class="modal-header d-block text-center border-bottom">
                    <div class="row">
                        <div class="col-lg-10">
                            <h4 class="modal-title">Busy Task Doer</h4>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                ×
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <p>$Employee is busy during the specified time period</p>
                    <p><b>Details of current task</b></p>
                    <p>Task Name&emsp;:&nbsp;</p>
                    <p>Start Date&emsp;&nbsp;&nbsp;:&nbsp;</p>
                    <p>End Date&emsp;&nbsp;&nbsp;&nbsp;:&nbsp;</p>
                    <p>Do you want to send a high-priority request to this employee?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div> -->

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
    <!-- Script file -->
    <script src="script/script.js"></script>
    <script src="./../ckeditor/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
    <script>
        CKEDITOR.replace('editor1', {
            // Security configurations
            allowedContent: true, // Allow all content but with filtering
            disallowedContent: 'script; *[on*]', // Block script tags and event handlers
            forcePasteAsPlainText: false,
            pasteFromWordPromptCleanup: true,
            pasteFromWordRemoveFontStyles: true,
            // Remove HTML5 video/audio to prevent XSS
            removePlugins: 'flash',
            // Enable additional security
            entities: true,
            basicEntities: true,
            entities_latin: true,
            entities_greek: true,
            // Toolbar configuration for security
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
                { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize'] }
            ]
        });
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut();
            }, 2000);
        });
    </script>
    <script>
        function updateTaskStatus(status, taskId, projectId) {
            $.ajax({
                type: "POST",
                url: "update_status.php",
                data: {
                    taskId: taskId,
                    status: status,
                    projectId: projectId,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("Task status updated successfully.");
                        console.log("New progress: " + response.progress + "%");
                    } else {
                        console.error("Error updating task status:", response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                },
            });
        }
    </script>
    <script>
        function updateFilteredTaskCount(count, countSpanId) {
            const taskCountSpan = document.getElementById(countSpanId);
            taskCountSpan.textContent = `${count}`;
        }

        function performSearch() {
            const searchQuery = taskSearchInput.value.toLowerCase();
            const taskCards1 = document.querySelectorAll(".task-card1");
            const taskCards2 = document.querySelectorAll(".task-card2");
            const taskCards3 = document.querySelectorAll(".task-card3");

            let filteredTaskCount1 = 0;
            let filteredTaskCount2 = 0;
            let filteredTaskCount3 = 0;

            taskCards1.forEach(function(card) {
                const projectName = card.querySelector("h5.mb-3").textContent.toLowerCase();
                const projectDescription = card.querySelector(".projectname").textContent.toLowerCase();
                const name1 = card.querySelector("#name1").textContent.toLowerCase();
                const name2 = card.querySelector("#name2").textContent.toLowerCase();
                const date = card.querySelector("#date").textContent.toLowerCase();

                if (projectName.includes(searchQuery) || projectDescription.includes(searchQuery) || name1.includes(
                        searchQuery) ||
                    name2.includes(searchQuery) || date.includes(searchQuery)
                ) {
                    card.style.display = "block";
                    filteredTaskCount1++;
                } else {
                    card.style.display = "none";
                }
            });


            taskCards2.forEach(function(card) {
                const projectName = card.querySelector("h5.mb-3").textContent.toLowerCase();
                const projectDescription = card.querySelector(".projectname").textContent.toLowerCase();
                const name1 = card.querySelector("#name1").textContent.toLowerCase();
                const name2 = card.querySelector("#name2").textContent.toLowerCase();
                const date = card.querySelector("#date").textContent.toLowerCase();

                if (projectName.includes(searchQuery) || projectDescription.includes(searchQuery) || name1.includes(
                        searchQuery) ||
                    name2.includes(searchQuery) || date.includes(searchQuery)
                ) {
                    card.style.display = "block";
                    filteredTaskCount2++;
                } else {
                    card.style.display = "none";
                }
            });

            taskCards3.forEach(function(card) {
                const projectName = card.querySelector("h5.mb-3").textContent.toLowerCase();
                const projectDescription = card.querySelector(".projectname").textContent.toLowerCase();
                const name1 = card.querySelector("#name1").textContent.toLowerCase();
                const name2 = card.querySelector("#name2").textContent.toLowerCase();
                const date = card.querySelector("#date").textContent.toLowerCase();

                if (projectName.includes(searchQuery) || projectDescription.includes(searchQuery) || name1.includes(
                        searchQuery) ||
                    name2.includes(searchQuery) || date.includes(searchQuery)
                ) {
                    card.style.display = "block";
                    filteredTaskCount3++;
                } else {
                    card.style.display = "none";
                }
            });

            updateFilteredTaskCount(filteredTaskCount1, 'filteredTaskCount1');
            updateFilteredTaskCount(filteredTaskCount2, 'filteredTaskCount2');
            updateFilteredTaskCount(filteredTaskCount3, 'filteredTaskCount3');
            if (filteredTaskCount1 === 0 && filteredTaskCount2 === 0 && filteredTaskCount3 === 0) {
                showNoTasksFoundMessage();
            } else {
                hideNoTasksFoundMessage();
            }
        }

        function showNoTasksFoundMessage() {
            const noTasksFoundMessage = document.getElementById('noTasksFoundMessage');
            if (noTasksFoundMessage) {
                noTasksFoundMessage.style.display = 'block';
            }
        }

        function hideNoTasksFoundMessage() {
            const noTasksFoundMessage = document.getElementById('noTasksFoundMessage');
            if (noTasksFoundMessage) {
                noTasksFoundMessage.style.display = 'none';
            }
        }

        const taskSearchInput = document.getElementById("taskSearchInput");
        if (taskSearchInput) {
            taskSearchInput.addEventListener("input", performSearch);
        }


        function filterTasksByProject(projectName) {
            const tasks1 = document.querySelectorAll('#card1');
            const tasks2 = document.querySelectorAll('#card2');
            const tasks3 = document.querySelectorAll('#card3');
            let filteredTaskCount1 = 0;
            let filteredTaskCount2 = 0;
            let filteredTaskCount3 = 0;

            tasks1.forEach(task => {
                const taskProjectName = task.querySelector('.projectname').textContent;

                if (projectName === '' || taskProjectName === projectName) {
                    task.style.display = 'block';
                    filteredTaskCount1++;
                } else {
                    task.style.display = 'none';
                }
            });
            tasks2.forEach(task => {
                const taskProjectName = task.querySelector('.projectname').textContent;

                if (projectName === '' || taskProjectName === projectName) {
                    task.style.display = 'block';
                    filteredTaskCount2++;
                } else {
                    task.style.display = 'none';
                }
            });
            tasks3.forEach(task => {
                const taskProjectName = task.querySelector('.projectname').textContent;

                if (projectName === '' || taskProjectName === projectName) {
                    task.style.display = 'block';
                    filteredTaskCount3++;
                } else {
                    task.style.display = 'none';
                }
            });

            updateFilteredTaskCount(filteredTaskCount1, 'filteredTaskCount1');
            updateFilteredTaskCount(filteredTaskCount2, 'filteredTaskCount2');
            updateFilteredTaskCount(filteredTaskCount3, 'filteredTaskCount3');
            if (filteredTaskCount1 === 0 && filteredTaskCount2 === 0 && filteredTaskCount3 === 0) {
                showNoTasksFoundMessage();
            } else {
                hideNoTasksFoundMessage();
            }
        }
        filterTasksByProject('');
    </script>

    <script>
        function filtertypestatus(status) {
            const allTaskCards = document.querySelectorAll('.task-card1, .task-card2, .task-card3');

            allTaskCards.forEach(card => {
                card.style.display = 'none';
            });

            const tasksWithStatus1 = document.querySelectorAll(`.task-card1[data-status="${status}"]`);
            const tasksWithStatus2 = document.querySelectorAll(`.task-card2[data-status="${status}"]`);
            const tasksWithStatus3 = document.querySelectorAll(`.task-card3[data-status="${status}"]`);

            tasksWithStatus1.forEach(task => {
                task.style.display = 'block';
            });

            tasksWithStatus2.forEach(task => {
                task.style.display = 'block';
            });

            tasksWithStatus3.forEach(task => {
                task.style.display = 'block';
            });
        }
    </script>
    <script>
        const fileInput = document.getElementById('inputGroupFile003');
        const selectedFilesContainer = document.getElementById('selectedFiles');

        fileInput.addEventListener('change', function() {
            const files = fileInput.files;
            selectedFilesContainer.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const fileName = files[i].name;
                const fileSize = (files[i].size / 1024 / 1024).toFixed(2);
                const fileItem = document.createElement('div');
                fileItem.textContent = `File ${i + 1}: ${fileName} (${fileSize} MB)`;
                selectedFilesContainer.appendChild(fileItem);
            }
        });
    </script>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this task?");
        }
    </script>



    <script>
        function submitForm(event) {
            var element = document.getElementById("submitButton");
            element.classList.add("no-drop");
            element.disabled = true;
        }
    </script>
    <script>
        $(document).ready(function() {
            function updatePeriodName(name) {
                $('#Period').text(name);
            }

            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            };
            var period = getUrlParameter('period');
            if (!period) {
                period = 'Week';
            }
            updatePeriodName(period);
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function project(projectId) {
            $.ajax({
                url: 'memberfiler.php',
                type: 'POST',
                data: {
                    projectId: projectId
                },
                success: function(response) {
                    $('#projectmodules').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function tasksdata() {
            // Get projectId outside of the $.ajax function
            let projectId = $("#projectSelect").val();

            $.ajax({
                url: 'memberfiler.php',
                type: 'POST',
                data: {
                    taskdataid: projectId
                },
                success: function(response) {
                    $('#drop-down').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
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

    <!-- JavaScript to handle AJAX request -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
// <script>
//     $(document).ready(function() {
//         var isRequestInProgress = false;
//         $('#selectEmployee').change(function() {
//             if (isRequestInProgress) {
//                 return;
//             }
//             var employeeId = $(this).val();
//             var startDate = $('#startDate').val();
//             var endDate = $('#endDate').val();
//             var startTime = $('#starttime').val();
//             var endTime = $('#endtime').val();

//             if (employeeId && startDate && endDate && startTime && endTime) {
//                 var data = {
//                     employeeId: employeeId,
//                     startDate: startDate,
//                     endDate: endDate,
//                     starttime: startTime,
//                     endtime: endTime
//                 };
//                 isRequestInProgress = true;
//                 $.ajax({
//                     url: 'employeeavailability.php',
//                     type: 'POST',
//                     data: data,
//                     dataType: 'json',
//                     success: function(response) {
//                         if (response.message) {
//                             $('#error').text(response.message);
//                             $('#submitButton').prop('disabled', true);
//                         } else {
//                             $('#error').text("");
//                             $('#submitButton').prop('disabled', false);
//                         }
//                         isRequestInProgress = false;
//                     },
//                     error: function(xhr, status, error) {
//                         console.error(xhr.responseText);
//                         $('#error').text("An error occurred while processing your request");
//                         isRequestInProgress = false;
//                     }
//                 });
//             } else {
//                 $('#error').text("Please fill out all fields");
//                 $('#submitButton').prop('disabled', false); 
//             }
//         });     
//         $('#selectEmployee, #startDate, #endDate, #starttime, #endtime').keyup(function() {
//             var employeeId = $('#selectEmployee').val();
//             var startDate = $('#startDate').val();
//             var endDate = $('#endDate').val();
//             var startTime = $('#starttime').val();
//             var endTime = $('#endtime').val();

//             if (employeeId && startDate && endDate && startTime && endTime) {
//                 $('#error').text("");
//                 $('#submitButton').prop('disabled', false);
//             }
//         });
//     });
// </script>
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const combinedInput = document.getElementById('combinedInput');
            const dropdownToggle = document.getElementById('dropdownToggle1');
            const dropdownMenu = document.getElementById('drop-down');

            // Handle click on dropdown menu items
            dropdownMenu.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default anchor link behavior
                if (e.target && e.target.nodeName === 'A') {
                    const selectedModule = e.target.getAttribute('data-module');
                    combinedInput.value = selectedModule;
                    combinedInput.focus(); // Keep focus on input after selection
                    dropdownMenu.classList.remove('show'); // Hide dropdown after selection
                }
            });

            // Handle click on dropdown toggle button
            dropdownToggle.addEventListener('click', function() {
                dropdownMenu.classList.toggle('show'); // Toggle dropdown menu visibility
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show'); // Close dropdown if clicked outside
                }
            });

            // Handle typing in the combined input field
            combinedInput.addEventListener('input', function() {
                dropdownMenu.classList.remove('show'); // Close dropdown on input
            });
        });
    </script>
    <script>
    document.getElementById('inputGroupFile003').addEventListener('change', function() {
        var files = this.files;
        var fileSizeLimit = 5 * 1024 * 1024;

        for (var i = 0; i < files.length; i++) {
            if (files[i].size > fileSizeLimit) {
                document.getElementById('inputGroupFile003').value = '';
                document.getElementById('fileSizeError').classList.remove('d-none'); 
                return;
            }
        }      
        document.getElementById('fileSizeError').classList.add('d-none');
    });
</script>

</body>

</html>