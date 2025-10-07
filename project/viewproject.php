<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "./../include/config.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$userid = $_SESSION["user_id"];
$modulesArray = [];

if (isset($_GET['projectid'])) {
    $projectId = $_GET['projectid'];
    $sqlProject = "SELECT * FROM projects WHERE id = ?";
    $stmtProject = $conn->prepare($sqlProject);
    $stmtProject->bind_param("i", $projectId);
    $stmtProject->execute();
    $resultProject = $stmtProject->get_result();

    if ($resultProject->num_rows > 0) {
        $row = $resultProject->fetch_assoc();
        $projectname = htmlspecialchars($row['project_name']);
        $description = strip_tags($row['description']);
        $progress = htmlspecialchars($row['progress']);
        $priority = htmlspecialchars($row['priority']);
        $documentAttachment = htmlspecialchars($row['document_attachment']);
        $dueDate = date('d-m-Y', strtotime(htmlspecialchars($row['due_date'])));
        $startDate = date('d-m-Y', strtotime(htmlspecialchars($row['start_date'])));
        $budget = htmlspecialchars($row['budget']);
        $member = $row['members'];
        $department = $row['department'];
        $memberslead = $row['lead_id'];
        $projectid = $row['id'];
        $leadname = "";
        $leadprofile = "";
        $no_resource = $row['no_resource'];
        $no_resources_requried = $row['no_resources_requried'];
        $no_resources_avaiable = (intval($no_resource) ?? 0) - (intval($no_resources_requried) ?? 0);
        $projectpanagerid = $row['project_manager_id'];
        $location = isset($row['location']) ? $row['location'] : 'Office';
        $totalhours = $row['totalhours'];
        $perday = $row['perday'];
        $client = $row['client_id'];



        if (!empty($memberslead)) {
            $sql = "SELECT * FROM employee WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $memberslead);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $leadRow = $result->fetch_assoc();
                $leadname = htmlspecialchars($leadRow['full_name']);
                $leadprofile = htmlspecialchars($leadRow['profile_picture']);
            }
        }

        if (!empty($row['modules'])) {
            $modulesArray = explode(',', $row['modules']);
        }

        $id = $row['id'];
        $profile = explode(',', $row['members']);
        $profilelead = explode(',', $row['lead_id']);

        $members = array();
        $lead = array();
        foreach ($profile as $profile_id) {
            $sqlEmployee = "SELECT * FROM employee WHERE FIND_IN_SET(?, id) ORDER BY full_name";
            $stmtEmployee = $conn->prepare($sqlEmployee);
            $stmtEmployee->bind_param("i", $profile_id);
            $stmtEmployee->execute();
            $resultEmployee = $stmtEmployee->get_result();

            if ($resultEmployee->num_rows > 0) {
                while ($rowEmployee = $resultEmployee->fetch_assoc()) {
                    $members[] = [
                        'id' => $rowEmployee['id'],
                        'name' => $rowEmployee['full_name'],
                        'image' => $rowEmployee['profile_picture']
                    ];
                }
            }
        }
        foreach ($profilelead as $profile_id) {
            $sqlEmployee = "SELECT * FROM employee WHERE FIND_IN_SET(?, id) ORDER BY full_name";
            $stmtEmployee = $conn->prepare($sqlEmployee);
            $stmtEmployee->bind_param("i", $profile_id);
            $stmtEmployee->execute();
            $resultEmployee = $stmtEmployee->get_result();

            if ($resultEmployee->num_rows > 0) {
                while ($rowEmployee = $resultEmployee->fetch_assoc()) {
                    $lead[] = [
                        'id' => $rowEmployee['id'],
                        'name' => $rowEmployee['full_name'],
                        'image' => $rowEmployee['profile_picture']
                    ];
                }
            }
        }

        $departments = array();
        $departmentIdsArray = explode(',', $department);
        foreach ($departmentIdsArray as $deptId) {
            $sqlDepartment = "SELECT * FROM department WHERE id = ?";
            $stmtDepartment = $conn->prepare($sqlDepartment);
            $stmtDepartment->bind_param("i", $deptId);
            $stmtDepartment->execute();
            $resultDepartment = $stmtDepartment->get_result();

            if ($resultDepartment->num_rows > 0) {
                while ($rowDepartment = $resultDepartment->fetch_assoc()) {
                    $departments[] = [
                        'name' => $rowDepartment['name'],
                        'image' => $rowDepartment['logo']
                    ];
                }
            }
        }

        $totalModulesCompletedPercentage = array();
        foreach ($modulesArray as $module) {
            $sql = "SELECT 
                    COUNT(*) AS total_tasks,
                    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks
                    FROM tasks WHERE projectid = ? AND modules_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $projectId, $module);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalTasks = $row['total_tasks'];
                $completedTasks = $row['completed_tasks'];
                $completionPercentage = ($totalTasks > 0) ? (($completedTasks / $totalTasks) * 100) : 0;
                $totalModulesCompletedPercentage[$module] = $completionPercentage;
            }
        }

        $sql = "SELECT 
                SUM(CASE WHEN status = 'Todo' THEN 1 ELSE 0 END) AS todo_count,
                SUM(CASE WHEN status = 'InProgress' THEN 1 ELSE 0 END) AS in_progress_count,
                SUM(CASE WHEN status = 'Pause' THEN 1 ELSE 0 END) AS pause_count,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed_count
                FROM tasks WHERE projectid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $todoCount = $row['todo_count'];
            $inProgressCount = $row['in_progress_count'];
            $pauseCount = $row['pause_count'];
            $completedCount = $row['completed_count'];
        }

        $sql = "SELECT * FROM employee WHERE id = $projectpanagerid";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $projectmanagerid = $row['id'];
            $projectmanagername = $row['full_name'];
            $projectmagerprofile = $row['profile_picture'];
        }

         $sql = "SELECT * FROM `clientinformation` WHERE id = '$client'";
        $result = mysqli_query($conn, $sql);
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $clientid = $row['id'];
            $clentname= $row['fullName'];
           
        }

?>

        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Projects | JIFFY</title>
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

                .todoCard {
                    background-color: #f29a51;
                }

                .inProgressCard {
                    background-color: #738aea;
                }

                .completedCard {
                    background-color: #4ca64c;
                }

                .pausedCard {
                    background-color: #e3615b;
                }

                @media(max-width:720px) {
                    .iq-media-group {
                        margin-left: 35px;
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
                                    <div class="card-header d-flex">
                                        <div class="back-button">
                                            <a href="project.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                                    <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                                </svg>
                                            </a>
                                        </div>
                                        <h3 class="text-center mx-auto"><?= $projectname ?></h3>
                                    </div>
                                    <!--Modules Card -->
                                    <div class="card-body">
                                        <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-6">
                                                    <div class="container">
                                                        <div class="d-flex flex-wrap">
                                                            <?php $ids = 1; ?>
                                                            <?php $colors = array('circle-progress-primary', 'circle-progress-secondary', 'circle-progress-success', 'circle-progress-danger', 'circle-progress-warning', 'circle-progress-info'); ?>
                                                            <?php if (!empty($totalModulesCompletedPercentage)) { ?>
                                                                <?php foreach ($totalModulesCompletedPercentage as $moduleName => $completionPercentage) { ?>
                                                                    <div class="col-lg-3 mb-4 ms-3" onclick="window.location.href='task.php?modules=<?= $moduleName ?>&&project_id=<?= $projectId ?>&&condition=1&&period=All'" style="cursor: pointer;">
                                                                        <div id="circle-progress-<?= $ids++ ?>" class="circle-progress <?= $colors[array_rand($colors)] ?> d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $completionPercentage ?>" data-type="percent">
                                                                            <h5 class="mb-3 text-center"><?= $moduleName ?></h5>
                                                                        </div>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                            <div class="col-lg-3 mb-4 ms-3" onclick="window.location.href='task.php?project_id=<?= $projectId ?>&&period=All&&&&condition=1'" style="cursor: pointer;">
                                                                <div id="circle-progress-<?= $ids++ ?>" class="circle-progress <?= $colors[array_rand($colors)] ?> d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="<?= $progress ?>" data-type="percent">
                                                                    <h5 class="mb-3 text-center">Total Module</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Modules Card ends -->

                                    <!--task Card -->
                                    <div class="container">
                                        <h4 class="p-3 text-center">Task Status</h4>
                                        <div class="row px-5 pt-2">
                                            <div class="col-lg-3 mb-2">
                                                <div class="card todoCard shadow" onclick="window.location.href='task.php?taskstatus=Todo&&condition=1&&period=All&&project_id=<?= $projectId ?>'" style="cursor: pointer;">
                                                    <div class="card-body projectCard text-center">
                                                        <h5 class="mb-3 text-white">To Do</h5>
                                                        <h5 class="text-white"><?php echo isset($todoCount) ? $todoCount : 0 ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="card inProgressCard shadow" onclick="window.location.href='task.php?taskstatus=Inprogress&&condition=1&&period=All&&project_id=<?= $projectId ?>'" style="cursor: pointer;">
                                                    <div class="card-body projectCard text-center">
                                                        <h5 class="mb-3 text-white">In Progress</h5>
                                                        <h5 class="text-white"><?php echo isset($inProgressCount) ? $inProgressCount : 0 ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="card pausedCard shadow" onclick="window.location.href='task.php?taskstatus=Pause&&condition=1&&period=All&&project_id=<?= $projectId ?>'" style="cursor: pointer;">
                                                    <div class="card-body projectCard text-center">
                                                        <h5 class="mb-3 text-white">Paused</h5>
                                                        <h5 class="text-white"><?php echo isset($pauseCount) ? $pauseCount : 0 ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2">
                                                <div class="card completedCard shadow" onclick="window.location.href='task.php?taskstatus=Completed&&condition=1&&period=All&&project_id=<?= $projectId ?>'" style="cursor: pointer;">
                                                    <div class="card-body projectCard text-center">
                                                        <h5 class="mb-3 text-white">Completed</h5>
                                                        <h5 class="text-white"><?php echo isset($completedCount) ? $completedCount : 0 ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--task Card ends -->
                                    <!--Description start -->
                                    <div class="container mb-3 projectDetails">
                                        <h4 class="p-3 text-center">Project Description</h4>
                                        <div class="project-description-container border rounded p-3 mb-3 shadow text-justify">
                                            <?= $description ?>
                                        </div>
                                    </div>
                                    <!--Description End -->
                                    <!--Members start -->
                                    <div class="row d-flex">
                                        <div class="col-lg-3 container mb-3">
                                            <h4 class="p-3 text-center fw-bold">Project Manager</h4>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="iq-media-group">
                                                        <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?= $projectmanagername ?>">
                                                            <img src="./../uploads/employee/<?= $projectmagerprofile ?>" class="img-fluid avatar-40 rounded-circle" alt=""></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 container mb-3">
                                            <h4 class="p-3 text-center fw-bold">Team Lead</h4>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="iq-media-group">
                                                        <?php
                                                        foreach ($lead as $profileRow) { ?>
                                                            <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?= $profileRow['name'] ?>" onclick="window.location.href='task.php?project_id=<?= $projectId ?>&employeeid=<?= $profileRow['id'] ?>&&condition=1&&period=All'">
                                                                <img src="./../uploads/employee/<?= $profileRow['image'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 container mb-3">
                                            <h4 class="p-3 text-center fw-bold">Members Involved</h4>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-flex align-items-center justify-content-between" style="cursor: pointer;">
                                                    <div class="iq-media-group">
                                                        <?php
                                                        foreach ($members as $profileRow) { ?>
                                                            <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?= $profileRow['name'] ?>" onclick="window.location.href='task.php?project_id=<?= $projectId ?>&employeeid=<?= $profileRow['id'] ?>&&condition=1&&period=All'">
                                                                <img src="./../uploads/employee/<?= $profileRow['image'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 container mb-3">
                                            <h4 class="p-3 text-center fw-bold">Department Involved</h4>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="iq-media-group">
                                                        <?php
                                                        foreach ($departments as $department) { ?>
                                                            <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?= $department['name'] ?>">
                                                                <img src="./<?= $department['image'] ?>" class="img-fluid avatar-40 rounded-circle" alt=""></a>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Members End -->
                                    <!--Other details start -->
                                    <div class="container mb-3 projectDetails">
                                        <h4 class="p-3 text-center fw-bold">Other Details</h4>
                                        <div class="border rounded p-3 mb-3 shadow">
                                            <h6 class="ms-5 mb-4"><b>Location&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;:&emsp;</b><?= $location ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Actual Start Date&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;</b><?= $startDate ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Client Name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;</b><?= $clentname ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Actual End Date&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?= $dueDate ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Total Project Hours&emsp;&emsp;&emsp;&emsp;&nbsp;:&emsp;</b><?= $totalhours . " " . "hours" ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Hours/Day &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?= $perday . " " . "hours" ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Budget&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;</b><?= $budget ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Total Resources Requried&emsp;:&emsp;</b><?= intval($no_resource ?? 0) ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Total Resources Avaiable&emsp;&nbsp;&nbsp;:&emsp;</b><?= $no_resources_avaiable ?></h6>
                                            <h6 class="ms-5 mb-4"><b>Requried Resources&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?= $no_resources_requried ?></h6>
                                            <h6 class="ms-5 mb-4">
                                                <b>Project Document&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b>
                                                <a href="./../uploads/projects/<?= $documentAttachment ?>" download>
                                                    Project_document.pdf<i class="fa fa-download px-2"></i>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                    <!--Other details End -->
                                    <!-- <div class="d-flex justify-content-center align-items-center text-center">
                                        <a href="#" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Download Project Report">
                                            <button class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center mb-4" id="projectReport" data-toggle="modal" data-target="#noProjectReport" onclick="projectreport('<?php echo $projectid; ?>','<?php echo $projectname; ?>')">Project Report</button>
                                        </a>
                                    </div> -->
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
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                function projectreport(id, name) {
                    $.ajax({
                        type: "POST",
                        url: "projectreport.php",
                        data: {
                            projectid: id,
                            projectname: name
                        },
                        dataType: "json", // Adjusted dataType to handle JSON response
                        success: function(response) {
                            if (response.filename) {
                                var downloadLink = document.createElement('a');
                                downloadLink.href = response.filename;
                                downloadLink.download = response.filename;
                                downloadLink.style.display = 'none';
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                            } else {
                                console.error("PDF generation failed");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                }
            </script>
            <script>
                $(document).ready(function() {
                    $('#projectReport').click(function() {
                        $('#noProjectReport').modal('show');
                        // Hide the modal after 3 seconds
                        setTimeout(function() {
                            $('#noProjectReport').modal('hide');
                        }, 3000);
                    });
                });
            </script>

        </html>
<?php  }
} ?>