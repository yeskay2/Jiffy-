<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


if (isset($_GET["trainid"]) && !empty($_GET["trainid"])) {

    $trainid = $_GET["trainid"];



    $query = "DELETE FROM tasks WHERE id = $trainid";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo '<script>alert("Task successfully deleted!"); window.location.href = "task.php";</script>';
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong while deleting';
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploaderid = $userid;
    $project = $_POST["projectid"];
    $taskName = $_POST["taskName"];
    $assignedTo = $_POST["assignedTo"];
    $dueDate = $_POST["dueDate"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $checklist = $_POST["checklist"];
    $todo = "Todo";


    $fileName = "";

    if (!empty($_FILES["projectDocument"]["name"])) {

        $targetDir = "./../uploads/task/";
        $fileName = basename($_FILES["projectDocument"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["projectDocument"]["tmp_name"], $targetFilePath)) {
        } else {
            echo "Error: File upload failed.";
            error_log("File upload failed.");
        }
    }


    $sql = "INSERT INTO tasks (projectid, uploaderid, task_name, assigned_to, due_date, category, description, checklist, document_attachment, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssss", $project, $uploaderid, $taskName, $assignedTo, $dueDate, $category, $description, $checklist, $fileName, $todo);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            $_SESSION['success'] = 'Task has been added successfully.';
            header('location: demo.php');
            exit;
        } else {
            $_SESSION['error'] = 'Something went wrong while adding';
        }
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
    <title>PMS</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./../assets/images/jiffy-favicon.ico" />
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
        .projectname {
            display: none;
        }
        .assigned {
            display: none;
        }


        
        .assigned-full-name {
            display: none;
        }
    </style>

</head>

<body>
    <!-- loader Start -->

    <!-- loader END -->

    <!-- Wrapper Start -->
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
                    $query = "SELECT t.*, 
                                     e_assigned.full_name AS assigned_full_name, 
                                     e_uploader.full_name AS uploader_full_name, 
                                     e_assigned.profile_picture AS assigned_profile_picture, 
                                     e_uploader.profile_picture AS uploader_profile_picture, 
                                     p.project_name
                              FROM tasks t 
                              LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
                              LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
                              LEFT JOIN projects p ON t.projectid = p.id
                              WHERE (t.assigned_to = $userid OR t.uploaderid = $userid) AND t.status = 'Todo'
                              ORDER BY t.created_at DESC"; 
                   
                                $sql = "SELECT full_name FROM employee";
                                $result = $conn->query($sql);

                                $employeeNames = array();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $employeeNames[] = $row["full_name"];
                                    }
                                }
                                $sqlProjects = "SELECT DISTINCT project_name FROM projects";
                                $projectNames = array();
                                $resultProjects = $conn->query($sqlProjects);

                                if ($resultProjects->num_rows > 0) {
                                    while ($rowProject = $resultProjects->fetch_assoc()) {
                                        $projectNames[] = $rowProject["project_name"];
                                    }
                                }
                                $result = mysqli_query($conn, $query);
                                $row_count = mysqli_num_rows($result);
                                ?>


                                <h5>Your Task</h5>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="employeeDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body">
                                                <span class="h6">Employee :</span>
                                                <span id="selectedEmployee"><i class="ri-arrow-down-s-line ml-2 mr-0"></i></span>
                                            </div>
                                        </div>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="employeeDropdown">
                                            <a class="dropdown-item" href="#" onclick="filterTasksByEmployee('<?php echo date('Y-m-d'); ?>')">Today's Tasks</a>
                                            <?php
                                            foreach ($employeeNames as $name) {
                                                echo '<a class="dropdown-item" href="#" onclick="filterTasksByEmployee(\'' . $name . '\')">' . $name . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body">
                                                <span class="h6">Project :</span>
                                                <span id="selectedproject"><i class="ri-arrow-down-s-line ml-2 mr-0"></i></span>
                                            </div>
                                        </div>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="projectDropdown">
                                            <?php
                                            foreach ($projectNames as $name) {
                                                echo '<a class="dropdown-item" href="#" onclick="filterTasksByProject(\'' . $name . '\')">' . $name . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-task-modal" data-toggle="modal">Add Task</a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-transparent mb-0 desk-info">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5><i class="fas fa-reply-all mr-2"></i>To Do<i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#ed6f07;"></i> ( <?php echo $row_count;    ?> )</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {


                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $taskId = $row['id'];
                                            $uploaderid = $row['uploaderid'];
                                            $projectId = $row['projectid'];
                                            $projectname = $row['project_name'];
                                            $taskName = $row['task_name'];
                                            $assignedFullName = $row['assigned_full_name'];
                                            $uploaderFullName = $row['uploader_full_name'];
                                            $dueDate = $row['due_date'];
                                            $category = $row['category'];
                                            $description = $row['description'];
                                            $checklist = $row['checklist'];
                                            $document_attachment = $row['document_attachment'];
                                            $status = $row['status'];
                                            $assignedProfilePicture = $row['assigned_profile_picture'];
                                            $uploaderProfilePicture = $row['uploader_profile_picture'];
                                            $dueDate = date("d-m-Y", strtotime($dueDate));
                                            $projectname = $row['project_name'];
                                           $date = substr($row['created_at'], 0, 10);

                                            

                                            $statusClass = strtolower(str_replace(' ', '-', $status));
                                            if ($category === "Bug") {
                                                $buttonClass = "custom-button bug";
                                            } elseif ($category === "Improvement") {
                                                $buttonClass = "custom-button success";
                                            } else {
                                                $buttonClass = "custom-button task";
                                            }


                                    ?>

                                            <div class="col-lg-12 task-card1">
                                                <div class="card" id="card1">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-3"><?php echo $taskName; ?></h5>
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                    <i class="ri-more-fill"></i>
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#taskDetailsModal<?php echo $taskId; ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                    <?php
                                                                    if ($uploaderid == $userid) {
                                                                        echo '<a class="dropdown-item" href="task.php?trainid=' . $taskId . '"><i class="ri-delete-bin-5-line mr-2"></i>Delete</a>';
                                                                    } else {
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mb-3"><i class="fa fa-calendar-check-o mr-2"></i><?php echo $dueDate; ?></p>
                                                        <div class="iq-progress-bar bg-success-light mb-4">
                                                            <span class=" iq-progress progress-1" data-percent="4" style="transition: width 2s ease 0s; width: 65%; background-color: #ed6f07;"></span>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $assignedProfilePicture ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $uploaderProfilePicture ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <p class="assigned"><?php echo $date; ?></p>
                                                                <p class="projectname"><?php echo $projectname; ?></p>
                                                                <p class="assigned-full-name"><?php echo $assignedFullName; ?></p>

                                                            </div>
                                                            <div>
                                                                <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $category; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="taskDetailsModal<?php echo $taskId; ?>" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="taskDetailsModalLabel"><?php echo $taskName; ?> Details</h5>
                                                        </div>
                                                        <div class="modal-body1">
                                                            <label>Select Status</label>
                                                            <div class="col-md-6">
                                                                <select name="status" class="form-control" onchange="updateTaskStatus(this.value, '<?php echo $taskId; ?>', '<?php echo $projectId; ?>')">
                                                                    <option value="To Do">To Do</option>
                                                                    <option value="InProgress">InProgress</option>
                                                                    <option value="Completed">Completed</option>
                                                                </select><br>
                                                            </div>
                                                            <p><strong>Status:</strong> <?php echo $status; ?></p>
                                                            <p><strong>projectname:</strong> <?php echo $projectname; ?></p>
                                                            <p><strong>Assigned By:</strong> <?php echo $uploaderFullName; ?></p>
                                                            <p><strong>Assigned To:</strong> <?php echo $assignedFullName; ?></p>
                                                            <p><strong>Due Date:</strong> <?php echo $dueDate; ?></p>
                                                            <p><strong>Category:</strong> <?php echo $category; ?></p>
                                                            <p><strong>Description:</strong> <?php echo $description; ?></p>
                                                            <p><strong>Checklist:</strong> <?php echo $checklist; ?></p>
                                                            <p><strong>Download:</strong> <a href="./../uploads/task/<?php echo $document_attachment; ?>" download>Click here to download the document</a></p>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="custom-btn btn-3 mr-3" data-dismiss="modal" onClick="window.location.reload();">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php

                                        }
                                    } else {
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                   <?php
                    $query = "SELECT t.*, 
                                     e_assigned.full_name AS assigned_full_name, 
                                     e_uploader.full_name AS uploader_full_name, 
                                     e_assigned.profile_picture AS assigned_profile_picture, 
                                     e_uploader.profile_picture AS uploader_profile_picture, 
                                     p.project_name
                              FROM tasks t 
                              LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
                              LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
                              LEFT JOIN projects p ON t.projectid = p.id
                              WHERE (t.assigned_to = $userid OR t.uploaderid = $userid) AND t.status = 'InProgress'
                              ORDER BY t.created_at DESC"; 
                    $result = mysqli_query($conn, $query);
                    $row_count = mysqli_num_rows($result);
                    ?>
                    <div class="col-lg-4">
                        <div class="card-transparent mb-0 desk-info">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5> <i class="fas fa-spinner fa-pulse mr-2"></i>In Progress <i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#3759e1;"></i> ( <?php echo $row_count;    ?> )</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $taskId = $row['id'];
                                            $uploaderid = $row['uploaderid'];
                                            $projectId = $row['projectid'];
                                            $taskName = $row['task_name'];
                                            $assignedFullName = $row['assigned_full_name'];
                                            $uploaderFullName = $row['uploader_full_name'];
                                            $dueDate = $row['due_date'];
                                            $category = $row['category'];
                                            $description = $row['description'];
                                            $checklist = $row['checklist'];
                                            $document_attachment = $row['document_attachment'];
                                            $status = $row['status'];
                                            $assignedProfilePicture = $row['assigned_profile_picture'];
                                            $uploaderProfilePicture = $row['uploader_profile_picture'];
                                            $dueDate = date("d-m-Y", strtotime($dueDate));
                                            $projectname = $row['project_name'];
                                            $date = substr($row['created_at'], 0, 10);
                                            $statusClass = strtolower(str_replace(' ', '-', $status));
                                            if ($category === "Bug") {
                                                $buttonClass = "custom-button bug";
                                            } elseif ($category === "Improvement") {
                                                $buttonClass = "custom-button success";
                                            } else {
                                                $buttonClass = "custom-button task";
                                            }
                                    ?>
                                            <div class="col-lg-12 task-card1 ">
                                                <div class="card" id="card1">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-3"><?php echo $taskName; ?></h5>
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                    <i class="ri-more-fill"></i>
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#taskDetailsModal<?php echo $taskId; ?>"><i class="fa fa-eye mr-2"></i>View</a>

                                                                    <?php
                                                                    if ($uploaderid == $userid) {
                                                                        echo '<a class="dropdown-item" href="task.php?trainid=' . $taskId . '"><i class="ri-delete-bin-5-line mr-2"></i>Delete</a>';
                                                                    } else {
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mb-3"><i class="fa fa-calendar-check-o mr-2"></i><?php echo $dueDate; ?></p>
                                                        <div class="iq-progress-bar bg-success-light mb-4">
                                                            <span class=" iq-progress progress-1" data-percent="50" style="transition: width 2s ease 0s; width: 65%;background-color: #3759e1;"></span>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $assignedProfilePicture ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $uploaderProfilePicture ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <p class="assigned"><?php echo $date; ?></p>
                                                                <p class="projectname"><?php echo $projectname; ?></p>
                                                                <p class="assigned-full-name"><?php echo $assignedFullName; ?></p>
                                                            </div>
                                                            <div>
                                                                <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $category; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="taskDetailsModal<?php echo $taskId; ?>" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="taskDetailsModalLabel"><?php echo $taskName; ?> Details</h5>
                                                        </div>
                                                        <div class="modal-body1">
                                                            <label>Select Status</label>
                                                            <div class="col-md-6">
                                                                <select name="status" class="form-control" onchange="updateTaskStatus(this.value, '<?php echo $taskId; ?>', '<?php echo $projectId; ?>')">
                                                                    <option value="To Do">To Do</option>
                                                                    <option value="InProgress">InProgress</option>
                                                                    <option value="Completed">Completed</option>
                                                                </select><br>
                                                            </div>
                                                            <p><strong>Status:</strong> <?php echo $status; ?></p>
                                                            <p><strong>projectname:</strong> <?php echo $projectname; ?></p>
                                                            <p><strong>Assigned By:</strong> <?php echo $uploaderFullName; ?></p>
                                                            <p><strong>Assigned To:</strong> <?php echo $assignedFullName; ?></p>
                                                            <p><strong>Due Date:</strong> <?php echo $dueDate; ?></p>
                                                            <p><strong>Category:</strong> <?php echo $category; ?></p>
                                                            <p><strong>Description:</strong> <?php echo $description; ?></p>
                                                            <p><strong>Checklist:</strong> <?php echo $checklist; ?></p>
                                                            <p><strong>Download:</strong> <a href="./../uploads/task/<?php echo $document_attachment; ?>" download>Click here to download the document</a></p>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="custom-btn btn-3 mr-3" data-dismiss="modal" onClick="window.location.reload();">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                                       <?php
                    $query = "SELECT t.*, 
                                     e_assigned.full_name AS assigned_full_name, 
                                     e_uploader.full_name AS uploader_full_name, 
                                     e_assigned.profile_picture AS assigned_profile_picture, 
                                     e_uploader.profile_picture AS uploader_profile_picture, 
                                     p.project_name
                              FROM tasks t 
                              LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
                              LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
                              LEFT JOIN projects p ON t.projectid = p.id
                              WHERE (t.assigned_to = $userid OR t.uploaderid = $userid) AND t.status = 'Completed'
                              ORDER BY t.created_at DESC"; 
                    $result = mysqli_query($conn, $query);
                    $row_count = mysqli_num_rows($result);
                    ?>


                    <div class="col-lg-4">
                        <div class="card-transparent mb-0 desk-info">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5><i class="fas fa-calendar-check mr-2"></i>Compeleted <i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#68d241;"></i> ( <?php echo $row_count;    ?> )</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $taskId = $row['id'];
                                            $uploaderid = $row['uploaderid'];
                                            $projectId = $row['projectid'];
                                            $taskName = $row['task_name'];
                                            $assignedFullName = $row['assigned_full_name'];
                                            $uploaderFullName = $row['uploader_full_name'];
                                            $dueDate = $row['due_date'];
                                            $category = $row['category'];
                                            $description = $row['description'];
                                            $checklist = $row['checklist'];
                                            $document_attachment = $row['document_attachment'];
                                            $status = $row['status'];
                                            $assignedProfilePicture = $row['assigned_profile_picture'];
                                            $uploaderProfilePicture = $row['uploader_profile_picture'];
                                            $dueDate = date("d-m-Y", strtotime($dueDate));
                                            $projectname = $row['project_name'];
                                            $date = substr($row['created_at'], 0, 10);


                                            $statusClass = strtolower(str_replace(' ', '-', $status));
                                            if ($category === "Bug") {
                                                $buttonClass = "custom-button bug";
                                            } elseif ($category === "Improvement") {
                                                $buttonClass = "custom-button success";
                                            } else {
                                                $buttonClass = "custom-button task";
                                            }
                                    ?>
                                            <div class="col-lg-12 task-card1">
                                                <div class="card" id="card1">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="mb-3"><?php echo $taskName; ?> </h5>
                                                            <div class="dropdown">
                                                                <span class="dropdown-toggle py-2" id="dropdownMenuButton06" data-toggle="dropdown">
                                                                    <i class="ri-more-fill"></i>
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton06">
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#taskDetailsModal<?php echo $taskId; ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                    <?php
                                                                    if ($uploaderid == $userid) {
                                                                        echo '<a class="dropdown-item" href="task.php?trainid=' . $taskId . '"><i class="ri-delete-bin-5-line mr-2"></i>Delete</a>';
                                                                    } else {
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mb-3"><i class="fa fa-calendar-check-o mr-2"></i><?php echo $dueDate; ?></p>
                                                        <div class="iq-progress-bar bg-success-light mb-4">
                                                            <span class=" iq-progress progress-1" data-percent="100" style="transition: width 2s ease 0s; width: 65%;background-color: #68d241;"></span>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $uploaderProfilePicture ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $assignedProfilePicture ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <p class="assigned"><?php echo $date; ?></p>
                                                                <p class="projectname"><?php echo $projectname; ?></p>
                                                                <p class="assigned-full-name"><?php echo $assignedFullName; ?></p>
                                                            </div>
                                                            <div>
                                                                <a href="#" class="<?php echo $buttonClass; ?>"><?php echo $category; ?></a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="taskDetailsModal<?php echo $taskId; ?>" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="taskDetailsModalLabel"><?php echo $taskName; ?> Details</h5>
                                                        </div>
                                                        <div class="modal-body1">
                                                            <label>Select Status</label>
                                                            <div class="col-md-6">
                                                                <select name="status" class="form-control" onchange="updateTaskStatus(this.value, '<?php echo $taskId; ?>', '<?php echo $projectId; ?>')">
                                                                    <option value="To Do">To Do</option>
                                                                    <option value="InProgress">InProgress</option>
                                                                    <option value="Completed">Completed</option>
                                                                </select><br>
                                                            </div>
                                                            <p><strong>Status:</strong> <?php echo $status; ?></p>
                                                            <p><strong>projectname:</strong> <?php echo $projectname; ?></p>
                                                            <p><strong>Assigned By:</strong> <?php echo $uploaderFullName; ?></p>
                                                            <p><strong>Assigned To:</strong> <?php echo $assignedFullName; ?></p>
                                                            <p><strong>Due Date:</strong> <?php echo $dueDate; ?></p>
                                                            <p><strong>Category:</strong> <?php echo $category; ?></p>
                                                            <p><strong>Description:</strong> <?php echo $description; ?></p>
                                                            <p><strong>Checklist:</strong> <?php echo $checklist; ?></p>
                                                            <p><strong>Download:</strong> <a href="./../uploads/task/<?php echo $document_attachment; ?>" download>Click here to download the document</a></p>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="custom-btn btn-3 mr-3" data-dismiss="modal" onClick="window.location.reload();">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
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
                    <h3 class="modal-title" id="exampleModalCenterTitle">New Task</h3>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="exampleInputText2" class="h5">Project</label>
                                    <select name="projectid" class="selectpicker form-control" data-style="py-0" id="projectSelect">
                                        <option value="0">Others</option>
                                        <?php
                                        $query = "SELECT * FROM projects";
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
                                    <input type="text" class="form-control" id="exampleInputText2" placeholder="Enter project name" name="otherProjectName">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="exampleInputText02" class="h5">Task Name</label>
                                    <input type="text" class="form-control" id="exampleInputText02" placeholder="Enter task Name" name="taskName" required>
                                    <a href="#" class="task-edit text-body"></a>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText2" class="h5">Assign to</label>
                                            <select name="assignedTo" class="selectpicker form-control" data-style="py-0">
                                                <?php
                                                $query = "SELECT * FROM employee";
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
                                            <input type="date" class="form-control" id="exampleInputText05" value="" name="dueDate" required>
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
                                        <textarea class="form-control" id="editor1" rows="2" name="description" required></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText005" class="h5">Checklist</label>
                                            <input type="text" class="form-control" id="exampleInputText005" placeholder="Add List" name="checklist" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-0">
                                            <label for="exampleInputText01" class="h5">Attachments</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputGroupFile003" name="projectDocument">
                                                <label class="custom-file-label" for="inputGroupFile003">Upload media</label>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Script file -->
    <script src="script/script.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('editor1');
    </script>

    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['error'])) : ?>
                alert('<?php echo $_SESSION['error']; ?>');
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])) : ?>
                alert('<?php echo $_SESSION['success']; ?>');
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        };
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
        function performSearch() {
            const searchQuery = taskSearchInput.value.toLowerCase();
            const taskCards = document.querySelectorAll(".task-card1");

            taskCards.forEach(function(card) {
                const projectname = card.querySelector("h5.mb-3").textContent.toLowerCase();

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

    <script>
        function filterTasksByEmployee(employeeName) {
            const tasks = document.querySelectorAll('#card1');

            tasks.forEach(task => {
                const taskAssignedFullNameElements = task.querySelectorAll('.assigned-full-name, .assigned');
                let displayTask = false;

                taskAssignedFullNameElements.forEach(element => {
                    if (employeeName === '' || element.textContent === employeeName) {
                        displayTask = true;
                    }
                });

                task.style.display = displayTask ? 'block' : 'none';
            });

            const selectedEmployeeSpan = document.getElementById('selectedEmployee');
            selectedEmployeeSpan.textContent = employeeName === '' ? 'All Employees' : employeeName;
        }

        function filterTasksByProject(projectName) {
            const tasks = document.querySelectorAll('#card1');

            tasks.forEach(task => {
                const taskProjectName = task.querySelector('.projectname').textContent;

                if (projectName === '' || taskProjectName === projectName) {
                    task.style.display = 'block';
                } else {
                    task.style.display = 'none';
                }
            });

            const selectedProjectSpan = document.getElementById('selectedproject');
            selectedProjectSpan.textContent = projectName === '' ? 'All Projects' : projectName;
        }
    </script>


</body>

</html>