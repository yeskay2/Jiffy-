<?php
session_start();
include "./../include/config.php";
require_once "./taskdata/insertdata.php";
$userid = $_SESSION["user_id"];
if (empty($_SESSION['user_id'])) {
header('Location: index.php');
exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$taskManager->addTask($userid);
}
 
if (!empty($_GET['teamid'])) {
    $teamid = intval($_GET['teamid']);
    $sqlTeams = "SELECT * FROM team WHERE team_id = $teamid";
    $resultTeams = $conn->query($sqlTeams);
    if ($resultTeams && $resultTeams->num_rows > 0) {
        $teamData = $resultTeams->fetch_assoc();
        $teamName = $teamData['teamname'];
    } else {
        $teamName = 'Team';
    }
}else{
     $teamName = 'Team';
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
}else{
     $employee = 'Employee';
}
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
.no-drop {
        cursor: no-drop;
    }
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
        display: block
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
    left:8%;
    }}
</style>

</head>

<body>




<!-- Wrapper Start -->
<?php
include 'sidebar.php';
include 'topbar.php';
?>

<div class="content-page">
    <?php
    include "./../include/call.php";
    
    ?>
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
                                <?php
                                if (isset($_GET["employeeid"])) {
                                    $selectedid = [(int)$_GET["employeeid"]];
                                } elseif (isset($_GET["teamid"])) {
                                    $teamid = (int)$_GET["teamid"];
                                    $sql = "SELECT * FROM team WHERE team_id ='$teamid'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $selectedid = [];
                                        while ($rowEmployee = $result->fetch_assoc()) {
                                            $selectedid[] = $rowEmployee["employee"];
                                        }
                                    }
                                } else {
                                    $selectedid = null;
                                }
                                
                                $user = ($_SESSION["user_id"] ?? 0);
                                $uploaderid = $user;
                                $whereCondition = empty($selectedid) ? null : "AND t.assigned_to IN (" . implode(',', $selectedid) . ")";
                                
                                $statuses = ["Todo", "InProgress", "Completed", "Pause"];
                                
                                    $startOfWeek = null;
                                    $endOfWeek = null;
                                    
                                    if (isset($_GET['period']) && $_GET['period'] == 'week') {
                                        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
                                        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
                                    } elseif (isset($_GET['period']) && $_GET['period'] == 'month') {
                                        $startOfWeek = date('Y-m-d', strtotime('first day of this month'));
                                        $endOfWeek = date('Y-m-d', strtotime('last day of this month'));
                                    }elseif(empty($_GET['period'])){
                                         $startOfWeek = date('Y-m-d', strtotime('monday this week'));
                                         $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
                                    }
                               
                                $sqlEmployees = "SELECT id, full_name FROM employee WHERE active='active' ORDER BY full_name";
                                $resultEmployees = $conn->query($sqlEmployees);
                                $employeeData = array();
                                if ($resultEmployees->num_rows > 0) {
                                    while ($rowEmployee = $resultEmployees->fetch_assoc()) {
                                        $employeeData[] = array(
                                            "id" => $rowEmployee["id"],
                                            "full_name" => $rowEmployee["full_name"]
                                        );
                                    }
                                }
                                $sqlTeams = "SELECT * FROM team";
                                $resultTeams = $conn->query($sqlTeams);
                                $teamData = array();
                                if ($resultTeams->num_rows > 0) {
                                    while ($rowTeam = $resultTeams->fetch_assoc()) {
                                        $teamData[] = array(
                                            "id" => $rowTeam["team_id"],
                                            "teamname" => $rowTeam["teamname"]
                                        );
                                    }
                                }
                                
                                $sqlProjects = "SELECT DISTINCT project_name FROM objectives ORDER BY project_name";
                                $projectNames = array();
                                $resultProjects = $conn->query($sqlProjects);
                                if ($resultProjects->num_rows > 0) {
                                    while ($rowProject = $resultProjects->fetch_assoc()) {
                                        $projectNames[] = $rowProject["project_name"];
                                    }
                                }
                                
                                $statusData = array();
                                foreach ($statuses as $status) {
                                    $statusCondition = "AND t.status = '$status'";
                                
                                    $query = "SELECT t.*, e_assigned.full_name AS assigned_full_name,  e_uploader.full_name AS uploader_full_name, 
                                            e_assigned.profile_picture AS assigned_profile_picture, 
                                            e_uploader.profile_picture AS uploader_profile_picture, 
                                            p.project_name FROM tasks t 
                                            LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
                                            LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
                                            LEFT JOIN objectives p ON t.projectid = p.id
                                            WHERE 1 $whereCondition $statusCondition";
                                            if ($startOfWeek !== null && $endOfWeek !== null) {
                                                $query .= " AND t.due_date BETWEEN '$startOfWeek' AND '$endOfWeek'";
                                            }
                                            $query .= " ORDER BY t.created_at DESC";
                                
                                    $result = mysqli_query($conn, $query);
                                    $statusData[$status] = array(
                                        'data' => $result,
                                        'row_count' => mysqli_num_rows($result)
                                    );
                                }
                                ?>


                            <h5>Your Action Plan</h5>
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="dropdown dropdown-project mr-3" id="filter">
                                    <div class="dropdown-toggle" id="statusDropdown" data-toggle="dropdown">
                                        <div class="btn bg-body" data-toggle="tooltip" data-placement="top"
                                            data-trigger="hover" title="Select Status">
                                            <span class="h6" style="float:left;" id="selectedStatus">Status </span>
                                            <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                        </div>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="statusDropdown">
                                        <?php
                                        foreach ($statuses as $status) {
                                            echo '<a class="dropdown-item" href="#" onclick="filtertypestatus(\'' . $status . '\')">' . $status . '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="dropdown dropdown-project mr-3">
                                    <div class="dropdown-toggle" id="employeeDropdown" data-toggle="dropdown">
                                        <div class="btn bg-body" data-toggle="tooltip" data-placement="top"
                                            data-trigger="hover" title="Select Employee">
                                            <span class="h6" id="selectedEmployee" style="float:left;"><?=$employee?></span>
                                            <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                        </div>
                                    </div>
                                
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="employeeDropdown">
                                        <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                        <?php foreach ($employeeData as $employee) { ?>
                                            <a class="dropdown-item"
                                                href="teamtask.php?employeeid=<?php echo $employee['id']; ?>"
                                                ><?php echo $employee['full_name']; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                                <div class="dropdown dropdown-project mr-3">
                                    <div class="dropdown-toggle" id="employeeDropdown" data-toggle="dropdown">
                                        <div class="btn bg-body" data-toggle="tooltip" data-placement="top"
                                            data-trigger="hover" title="Select Employee">
                                            <span class="h6" id="selectedEmployee" style="float:left;"><?=$teamName?></span>
                                            <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                        </div>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="employeeDropdown">
                                        <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                        <?php foreach ($teamData as $team) { ?>
                                            <a class="dropdown-item"
                                                href="teamtask.php?teamid=<?php echo $team['id']; ?>"
                                                ><?php echo $team['teamname']; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown dropdown-project mr-3">
                                    <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                        <div class="btn bg-body" data-toggle="tooltip" data-placement="top"
                                            data-trigger=" hover" title="Select Project">
                                            <span class="h6" id="selectedproject" style="float:left;">Project </span>
                                            <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                        </div>
                                    </div>
                                
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="projectDropdown">
                                        <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                        <?php
                                        foreach ($projectNames as $name) {
                                            echo '<a class="dropdown-item" href="#" onclick="filterTasksByProject(\'' . $name . '\')">' . $name . '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                </div>
                            <div class="dropdown dropdown-project mr-3">
                                    <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                        <div class="btn bg-body" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Period">
                                            <span class="h6" id="Period" style="float:left;">
                                                <?php
                                                if (!empty($_GET['employeeid'])) {
                                                    echo "Week";
                                                } elseif (!empty($_GET['teamid'])) {
                                                    echo "Week";
                                                } else {
                                                    echo "Week";
                                                }
                                                ?>
                                            </span>
                                            <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                        </div>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="projectDropdown">
                                        <div class="dropdown-header">Select Period</div>
                                        <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                            <?php if (!empty($_GET['employeeid'])) { ?>
                                                <a class="dropdown-item" href="teamtask.php?employeeid=<?php echo $_GET['employeeid']; ?>&period=week">Week</a>
                                                <a class="dropdown-item" href="teamtask.php?employeeid=<?php echo $_GET['employeeid']; ?>&period=month">Month</a>
                                                <a class="dropdown-item" href="teamtask.php?employeeid=<?php echo $_GET['employeeid']; ?>&period=all">All</a>
                                            <?php } elseif (!empty($_GET['teamid'])) { ?>
                                                <a class="dropdown-item" href="teamtask.php?teamid=<?=$_GET['teamid']?>&period=week">Week</a>
                                                <a class="dropdown-item" href="teamtask.php?teamid=<?=$_GET['teamid']?>&period=month">Month</a>
                                                <a class="dropdown-item" href="teamtask.php?teamid=<?=$_GET['teamid']?>&period=all">All</a>
                                            <?php } else { ?>
                                                <a class="dropdown-item" href="teamtask.php?period=week">Week</a>
                                                <a class="dropdown-item" href="teamtask.php?period=month">Month</a>
                                                <a class="dropdown-item" href="teamtask.php?period=all">All</a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
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
                                                <h5><i class="fas fa-reply-all mr-2"></i>To Do<i
                                                        class="fa fa-arrow-circle-right mr-2 ml-3"
                                                        style="color:#ed6f07;"></i> (<span
                                                        id="filteredTaskCount1"></span>)</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
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
                                                <h5 class="mb-3"><?php echo $row['task_name']; ?></h5>
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle py-2" id="dropdownMenuButton04"
                                                        data-toggle="dropdown">
                                                        <a href="#"><i class="ri-more-fill"></i></a>
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton04">
                                                        <div data-toggle="tooltip" data-placement="right"
                                                            data-trigger="hover" title="View action plan details">
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#taskDetailsModal<?php echo $row['id']; ?>"><i
                                                                    class="fa fa-eye mr-2"></i>View</a>
                                                        </div>
                                                        <?php
                                                    if ($row['uploaderid'] == $userid || $_SESSION["id"]='1') {
                                                        ?>
                                                        <a class="dropdown-item" href="#" onclick="editProject(<?php echo $row['id']; ?>)">
                                                            <i class="ri-edit-line mr-2"></i>Edit
                                                        </a>
                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete task">
                                                            <a class="dropdown-item" href="task.php?trainid=<?php echo $row['id']; ?>" onclick="return confirmDelete()">
                                                                <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-3"><i
                                                    class="fa fa-calendar-check-o mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                            </p>
                                            <div class="iq-progress-bar bg-success-light mb-4">
                                                <span class=" iq-progress progress-1" data-percent="4"
                                                    style="transition: width 2s ease 0s; width: 65%; background-color: #ed6f07;"></span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="iq-media-group">
                                                    <a href="#" class="iq-media">
                                                        <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>"
                                                            class="img-fluid avatar-40 rounded-circle" alt="">
                                                    </a>
                                                    <a href="#" class="iq-media">
                                                        <img src="./../uploads/employee/<?php echo $row['uploader_profile_picture'] ?>"
                                                            class="img-fluid avatar-40 rounded-circle" alt="">
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
                                                    <a href="#"
                                                        class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="taskDetailsModal<?php echo $row['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-block text-center pb-3 border-bttom">
                                                <div class="row">
                                                    <div class="col-lg-10">
                                                        <h5 class="modal-title" id="taskDetailsModalLabel">
                                                            <?php echo $row['task_name']; ?> Details</h5>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            onClick="window.location.reload();">
                                                            ×
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-body1">

                                                <?php
                                                    if ($row['assigned_to'] == $userid || $_SESSION["id"]='1')  { ?>
                                                <label>Select Status</label>
                                                <div class="col-md-6">
                                                    <select name="status" class="form-control"
                                                        onchange="updateTaskStatus(this.value, '<?php echo $row['id']; ?>', '<?php echo $row['projectid']; ?>')">
                                                        <option value="To Do">To Do</option>
                                                        <option value="InProgress">InProgress</option>
                                                    </select><br>
                                                </div>
                                                <?php } ?>


                                                <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                                                <p><strong>Project Name:</strong> <?php echo $row['project_name']; ?>
                                                </p>
                                                <p><strong>Assigned By:</strong>
                                                    <?php echo $row['uploader_full_name']; ?></p>
                                                <p><strong>Assigned To:</strong>
                                                    <?php echo $row['assigned_full_name']; ?></p>
                                                <p><strong>Due
                                                        Date:</strong> <?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                </p>
                                                <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                                                <p><strong>Description:</strong> <?php echo $row['description']; ?>
                                                </p>
                                                <?php
                                            if (!empty($row['checklist'])) {
                                                echo '<p><strong>Checklist:</strong> ' . $row['checklist'] . '</p>';
                                            }
                                            
                                            if (!empty($row['document_attachment'])) {
                                                $zipFolderPath = './../uploads/download/';
                                                $random = $row['ticket'];
                                                $zipFileName = $zipFolderPath . 'downloaded_files_' . $random . '.zip';
                                            
                                                // Open the existing ZIP archive if it exists or create a new one
                                                $zip = new ZipArchive();
                                                if (file_exists($zipFileName)) {
                                                    $zip->open($zipFileName, ZipArchive::CREATE);
                                                } else {
                                                    $zip->open($zipFileName, ZipArchive::OVERWRITE | ZipArchive::CREATE);
                                                }
                                            
                                                // Get the list of existing files in the ZIP
                                                $existingFiles = [];
                                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                                    $existingFiles[] = $zip->getNameIndex($i);
                                                }
                                            
                                                // Split the comma-separated file names into an array
                                                $fileNames = explode(',', $row['document_attachment']);
                                                
                                                foreach ($fileNames as $fileName) {
                                                    $fileName = trim($fileName); // Remove any leading/trailing whitespace
                                                    $fileFullPath = './../uploads/task/' . $fileName;
                                                    
                                                    // Check if the file is not already in the ZIP, then add it
                                                    if (!in_array(basename($fileFullPath), $existingFiles)) {
                                                        if (file_exists($fileFullPath)) {
                                                            $zip->addFile($fileFullPath, basename($fileFullPath));
                                                        } else {
                                                            echo 'File not found: ' . $fileFullPath . '<br>';
                                                        }
                                                    } else {
                                                        
                                                    }
                                                }
                                            
                                                $zip->close();
                                            
                                                echo '<p><strong>Download All:</strong> <a href="' . $zipFileName . '" download>' . 'Download' . '</a></p>';
                                            }
                                            ?>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="noTasksFoundMessage" class="container text-center mt-5"
                                    style="display: none;">
                                    <p class="h9">No Task Found</p>
                                </div>
                                <?php

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
                                                <h5><i class="fas fa-spinner fa-pulse mr-2"></i>In Progress <i
                                                        class="fa fa-arrow-circle-right mr-2 ml-3"
                                                        style="color:#3759e1;"></i>(<span
                                                        id="filteredTaskCount2"></span>)</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $inProgressTasks = $statusData["InProgress"];
                                if ($inProgressTasks['row_count'] > 0) {
                                    $row_count2 = $inProgressTasks['row_count'];
                                    while ($row = mysqli_fetch_assoc($inProgressTasks['data'])) {

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
                                                <h5 class="mb-3"><?php echo $row['task_name']; ?></h5>
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle py-2" id="dropdownMenuButton04"
                                                        data-toggle="dropdown">
                                                        <a href="#"><i class="ri-more-fill"></i></a>
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton04">
                                                        <div data-toggle="tooltip" data-placement="right"
                                                            data-trigger="hover" title="View task details">
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#taskDetailsModal<?php echo $row['id']; ?>"><i
                                                                    class="fa fa-eye mr-2"></i>View</a>
                                                        </div>
                                                        <?php
                                                    if ($row['uploaderid'] == $userid || $_SESSION["id"]='1') {
                                                        ?>
                                                        <a class="dropdown-item" href="#" onclick="editProject(<?php echo $row['id']; ?>)">
                                                            <i class="ri-edit-line mr-2"></i>Edit
                                                        </a>
                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete task">
                                                            <a class="dropdown-item" href="task.php?trainid=<?php echo $row['id']; ?>" onclick="return confirmDelete()">
                                                                <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-3"><i
                                                    class="fa fa-calendar-check-o mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                            </p>
                                            <div class="iq-progress-bar bg-success-light mb-4">
                                                <span class=" iq-progress progress-1" data-percent="50"
                                                    style="transition: width 2s ease 0s; width: 65%; background-color: #3759e1;"></span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="iq-media-group">
                                                    <a href="#" class="iq-media">
                                                        <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>"
                                                            class="img-fluid avatar-40 rounded-circle" alt="">
                                                    </a>
                                                    <a href="#" class="iq-media">
                                                        <img src="./../uploads/employee/<?php echo $row['uploader_profile_picture'] ?>"
                                                            class="img-fluid avatar-40 rounded-circle" alt="">
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
                                                    <a href="#"
                                                        class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="taskDetailsModal<?php echo $row['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-block text-center pb-3 border-bttom">
                                                <div class="row">
                                                    <div class="col-lg-10">
                                                        <h5 class="modal-title" id="taskDetailsModalLabel">
                                                            <?php echo $row['task_name']; ?> Details</h5>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            onClick="window.location.reload();">
                                                            ×
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-body1">

                                                <?php
                                                        if ($row['assigned_to'] == $userid || $_SESSION["id"]='1') { ?>
                                                <label>Select Status</label>
                                                <div class="col-md-6">
                                                    <select name="status" class="form-control"
                                                        onchange="updateTaskStatus(this.value, '<?php echo $row['id']; ?>', '<?php echo $row['projectid']; ?>')">
                                                        <option value="InProgress">InProgress</option>
                                                        <option value="Completed">Completed</option>
                                                    </select><br>
                                                </div>
                                                <?php } ?>
                                                <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                                                <p><strong>Project name:</strong> <?php echo $row['project_name']; ?>
                                                </p>
                                                <p><strong>Assigned By:</strong>
                                                    <?php echo $row['uploader_full_name']; ?></p>
                                                <p><strong>Assigned To:</strong>
                                                    <?php echo $row['assigned_full_name']; ?></p>
                                                <p><strong>Due
                                                        Date:</strong><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                </p>
                                                <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                                                <p><strong>Description:</strong> <?php echo $row['description']; ?>
                                                </p>
                                                <?php
                                        if (!empty($row['checklist'])) {
                                            echo '<p><strong>Checklist:</strong> ' . $row['checklist'] . '</p>';
                                        }
                                        
                                        if (!empty($row['document_attachment'])) {
                                            $zipFolderPath = './../uploads/download/';
                                            $random = $row['ticket'];
                                            $zipFileName = $zipFolderPath . 'downloaded_files_' . $random . '.zip';
                                        
                                            // Open the existing ZIP archive if it exists or create a new one
                                            $zip = new ZipArchive();
                                            if (file_exists($zipFileName)) {
                                                $zip->open($zipFileName, ZipArchive::CREATE);
                                            } else {
                                                $zip->open($zipFileName, ZipArchive::OVERWRITE | ZipArchive::CREATE);
                                            }
                                        
                                            // Get the list of existing files in the ZIP
                                            $existingFiles = [];
                                            for ($i = 0; $i < $zip->numFiles; $i++) {
                                                $existingFiles[] = $zip->getNameIndex($i);
                                            }
                                        
                                            // Split the comma-separated file names into an array
                                            $fileNames = explode(',', $row['document_attachment']);
                                            
                                            foreach ($fileNames as $fileName) {
                                                $fileName = trim($fileName); // Remove any leading/trailing whitespace
                                                $fileFullPath = './../uploads/task/' . $fileName;
                                                
                                                // Check if the file is not already in the ZIP, then add it
                                                if (!in_array(basename($fileFullPath), $existingFiles)) {
                                                    if (file_exists($fileFullPath)) {
                                                        $zip->addFile($fileFullPath, basename($fileFullPath));
                                                    } else {
                                                        echo 'File not found: ' . $fileFullPath . '<br>';
                                                    }
                                                } else {
                                                    
                                                }
                                            }
                                        
                                            $zip->close();
                                        
                                            echo '<p><strong>Download All:</strong> <a href="' . $zipFileName . '" download>' . 'Download' . '</a></p>';
                                        }
                                        ?>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="noTasksFoundMessage" class="container text-center mt-5"
                                    style="display: none;">
                                    <p class="h9">No Task Found</p>
                                </div>
                                <?php

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
                                                <h5><i class="fas fa-calendar-check mr-2"></i>Completed <i
                                                        class="fa fa-arrow-circle-right mr-2 ml-3"
                                                        style="color:#68d241;"></i> (<span
                                                        id="filteredTaskCount3"></span>)</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
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
                                                <h5 class="mb-3"><?php echo $row['task_name']; ?></h5>
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle py-2" id="dropdownMenuButton04"
                                                        data-toggle="dropdown">
                                                        <a href="#"><i class="ri-more-fill"></i></a>
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton04">
                                                        <div data-toggle="tooltip" data-placement="right"
                                                            data-trigger="hover" title="View task details">
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#taskDetailsModal<?php echo $row['id']; ?>"><i
                                                                    class="fa fa-eye mr-2"></i>View</a>
                                                        </div>
                                                        <?php
                                                    if ($row['uploaderid'] == $userid || $_SESSION["id"]='1') {
                                                        ?>
                                                        <a class="dropdown-item" href="#" onclick="editProject(<?php echo $row['id']; ?>)">
                                                            <i class="ri-edit-line mr-2"></i>Edit
                                                        </a>
                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete task">
                                                            <a class="dropdown-item" href="task.php?trainid=<?php echo $row['id']; ?>" onclick="return confirmDelete()">
                                                                <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-3"><i
                                                    class="fa fa-calendar-check-o mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                            </p>
                                            <div class="iq-progress-bar bg-success-light mb-4">
                                                <span class=" iq-progress progress-1" data-percent="100"
                                                    style="transition: width 2s ease 0s; width: 65%; background-color: #68d241;"></span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="iq-media-group">
                                                    <a href="#" class="iq-media">
                                                        <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>"
                                                            class="img-fluid avatar-40 rounded-circle" alt="">
                                                    </a>
                                                    <a href="#" class="iq-media">
                                                        <img src="./../uploads/employee/<?php echo $row['uploader_profile_picture'] ?>"
                                                            class="img-fluid avatar-40 rounded-circle" alt="">
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
                                                    <a href="#"
                                                        class="<?php echo $buttonClass; ?>"><?php echo $row['category']; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="taskDetailsModal<?php echo $row['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-block text-center pb-3 border-bttom">
                                                <div class="row">
                                                    <div class="col-lg-10">
                                                        <h5 class="modal-title" id="taskDetailsModalLabel">
                                                            <?php echo $row['task_name']; ?> Details</h5>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            onClick="window.location.reload();">
                                                            ×
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-body1">

                                                <?php
                                                        if ($row['assigned_to'] == $userid || $_SESSION["id"]='1') { ?>
                                                <label>Select Status</label>
                                                <div class="col-md-6">
                                                    <select name="status" class="form-control"
                                                        onchange="updateTaskStatus(this.value, '<?php echo $row['id']; ?>', '<?php echo $row['projectid']; ?>')">
                                                        <option value="Completed">Completed</option>
                                                        <option value="InProgress">InProgress</option>

                                                    </select><br>
                                                </div>
                                                <?php } ?>
                                                <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                                                <p><strong>projectname:</strong> <?php echo $row['project_name']; ?>
                                                </p>
                                                <p><strong>Assigned By:</strong>
                                                    <?php echo $row['uploader_full_name']; ?></p>
                                                <p><strong>Assigned To:</strong>
                                                    <?php echo $row['assigned_full_name']; ?></p>
                                                <p><strong>Due
                                                        Date:</strong><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                </p>
                                                <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                                                <?php
                                            if (!empty($row['checklist'])) {
                                                echo '<p><strong>Checklist:</strong> ' . $row['checklist'] . '</p>';
                                            }
                                            
                                            if (!empty($row['document_attachment'])) {
                                                $zipFolderPath = './../uploads/download/';
                                                $random = $row['ticket'];
                                                $zipFileName = $zipFolderPath . 'downloaded_files_' . $random . '.zip';
                                            
                                                // Open the existing ZIP archive if it exists or create a new one
                                                $zip = new ZipArchive();
                                                if (file_exists($zipFileName)) {
                                                    $zip->open($zipFileName, ZipArchive::CREATE);
                                                } else {
                                                    $zip->open($zipFileName, ZipArchive::OVERWRITE | ZipArchive::CREATE);
                                                }
                                            
                                                // Get the list of existing files in the ZIP
                                                $existingFiles = [];
                                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                                    $existingFiles[] = $zip->getNameIndex($i);
                                                }
                                            
                                                // Split the comma-separated file names into an array
                                                $fileNames = explode(',', $row['document_attachment']);
                                                
                                                foreach ($fileNames as $fileName) {
                                                    $fileName = trim($fileName); // Remove any leading/trailing whitespace
                                                    $fileFullPath = './../uploads/task/' . $fileName;
                                                    
                                                    // Check if the file is not already in the ZIP, then add it
                                                    if (!in_array(basename($fileFullPath), $existingFiles)) {
                                                        if (file_exists($fileFullPath)) {
                                                            $zip->addFile($fileFullPath, basename($fileFullPath));
                                                        } else {
                                                            echo 'File not found: ' . $fileFullPath . '<br>';
                                                        }
                                                    } else {
                                                        
                                                    }
                                                }
                                            
                                                $zip->close();
                                            
                                                echo '<p><strong>Download All:</strong> <a href="' . $zipFileName . '" download>' . 'Download' . '</a></p>';
                                            }
                                            ?>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="noTasksFoundMessage" class="container text-center mt-5"
                                    style="display: none;">
                                    <p class="h9">No Task Found</p>
                                </div>
                                <?php

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

    <!-- Page end  -->
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
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                            enctype="multipart/form-data" id="myForm" onsubmit="submitForm(event)">
                            <div class="form-group mb-3">
                                <label for="exampleInputText2" class="h5">Project</label>
                                <select name="projectid" class="selectpicker form-control" data-style="py-0"
                                    id="projectSelect">
                                    <option value="0">Others</option>
                                    <?php
                                    $query = "SELECT * FROM objectives ORDER BY project_name";
                                    $result = mysqli_query($conn, $query);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $projectId = $row['id'];
                                            $projectName = $row['project_name'];

                                            echo '<option value="' . $projectId . '">' . $projectName . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" disabled>No objectives found</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3" id="otherProjectInput" style="display: none;">
                                <label for="exampleInputText2" class="h5">Other Project Name</label>
                                <input type="text" class="form-control" id="exampleInputText2"
                                    placeholder="Enter project name" name="otherProjectName">
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleInputText02" class="h5">Task Name</label>
                                <input type="text" class="form-control" id="exampleInputText02"
                                    placeholder="Enter task Name" name="taskName" required>
                                <a href="#" class="task-edit text-body"></a>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText2" class="h5">Assign to</label>
                                        <select name="assignedTo" class="selectpicker form-control"
                                            data-style="py-0">
                                            <?php
                                            $query = "SELECT * FROM employee WHERE active='active' ORDER BY full_name";
                                            $result = mysqli_query($conn, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $employeeId = $row['id'];
                                                    $employeeName = $row['full_name'];
                                                    echo '<option value="' . $employeeId . '">' . $employeeName . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No employees found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText05" class="h5">Due Date</label>
                                        <input type="date" class="form-control" id="exampleInputText05" value=""
                                            name="dueDate" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText2" class="h5">Type</label>
                                        <select name="category" class="selectpicker form-control" data-style="py-0">
                                            <option data-icon="fas fa-tasks">Task</option>
                                            <option data-icon="far fa-dot-circle">Bug</option>
                                            <option data-icon="fas fa-lightbulb">Improvement</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="exampleInputText040" class="h5">Description</label>
                                    <textarea class="form-control" id="editor1" rows="2" name="description"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="exampleInputText005" class="h5">Checklist</label>
                                    <input type="text" class="form-control" id="exampleInputText005"
                                        placeholder="Add List" name="checklist" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <label for="exampleInputText01" class="h5">Attachments</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile003"
                                            name="projectDocument[]" multiple>
                                        <label class="custom-file-label" for="inputGroupFile003">Upload multiple files</label>
                                    </div>
                                    <small class="text-muted">Maximum file size: 5 MB</small>
                                </div>
                            </div>

                            <div id="selectedFiles"></div>

                            <div class="col-lg-12">
                                <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                    <button type="submit" id="submitButton"
                                        class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            <div class="modal fade" id="viewProjectModal" tabindex="-1" role="dialog" aria-labelledby="viewProjectModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content" style="background-color:white">
                                        <div class="modal-header d-block text-center pb-3 border-bottom">
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <h4 class="modal-title" id="taskDetailsModalLabel">Edit task</h4>
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

<!-- Add jQuery -->


<!-- Script file -->
<script src="script/script.js"></script>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace('editor1');
</script>

<script>
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").alert('close');
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
    noTasksFoundMessage.style.display = 'block';
}

function hideNoTasksFoundMessage() {
    const noTasksFoundMessage = document.getElementById('noTasksFoundMessage');
    noTasksFoundMessage.style.display = 'none';
}

const taskSearchInput = document.getElementById("taskSearchInput");
taskSearchInput.addEventListener("input", performSearch);


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

    const selectedProjectSpan = document.getElementById('selectedproject');
    selectedProjectSpan.textContent = projectName === '' ? 'All Objectives' : projectName;

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

var dueDateInput = document.getElementById("exampleInputText05");    
var currentDate = new Date();     
var currentDateString = currentDate.toISOString().slice(0, 10);   
dueDateInput.setAttribute("min", currentDateString);
</script>
<script>
function editProject(projectId) {
    $.ajax({
        type: "GET",
        url: "edittask.php",
        data: {
            id: projectId
        },
        dataType: "html",
        success: function(data) {
            $("#projectDetailsContent").html(data);
            $("#viewProjectModal").modal("show");
        },
        error: function() {
            alert("Failed to load the project editing form.");
        },
    });
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
    $(document).ready(function(){
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




</body>

</html>