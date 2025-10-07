<?php
include "./../include/config.php";
{?>


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
                                    $selectedid = (int)$_GET["employeeid"];
                                } else {
                                    $selectedid = 0;
                                }
                                $user = ($_SESSION["user_id"] ?? 0);
                                $uploaderid = $user;
                                $whereCondition = ($selectedid == 0) ? "AND (t.assigned_to = $user OR t.uploaderid = $user)" : "AND t.assigned_to = $selectedid AND t.uploaderid = $user";
                                $statuses = ["Todo", "InProgress", "Completed"];
                                $sql = "SELECT full_name,id FROM employee WHERE active= 'active' ORDER BY full_name";
                                $result = $conn->query($sql);
                                $employeeData = array();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $employeeData[] = array(
                                            "id" => $row["id"],
                                            "full_name" => $row["full_name"]
                                        );
                                    }
                                }
                                $sqlProjects = "SELECT DISTINCT project_name FROM projects ORDER BY project_name ";
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
                                    p.project_name FROM tasks t LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
                                    LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
                                    LEFT JOIN projects p ON t.projectid = p.id
                                    WHERE 1 $whereCondition $statusCondition
                                    ORDER BY t.created_at DESC";

                                    $result = mysqli_query($conn, $query);
                                    $statusData[$status] = array(
                                        'data' => $result,
                                        'row_count' => mysqli_num_rows($result)
                                    );
                                }
                                ?>

                                <h5>Your Task</h5>
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="dropdown dropdown-project mr-3" id="filter">
                                        <div class="dropdown-toggle" id="statusDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Status">
                                                <span class="h6" id="selectedStatus" style="float:left;">Status </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>
                                        <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                            <?php
                                            foreach ($statuses as $status) {
                                                echo '<a class="dropdown-item" href="#" onclick="filtertypestatus(\'' . $status . '\')">' . $status . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="employeeDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Employee">
                                                <span class="h6" id="selectedEmployee" style="float:left;">Employee </span>
                                                <span><i class="ri-arrow-down-s-line ml-2 mr-0" style="float:right;"></i></span>
                                            </div>
                                        </div>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="employeeDropdown">
                                            <div class="dropdown-menu-scrollable" style="max-height: 200px; overflow-y: auto;">
                                                <?php foreach ($employeeData as $employee) { ?>
                                                    <a class="dropdown-item" href="task.php?employeeid=<?php echo $employee['id']; ?>" onclick="filterTasksByEmployee(<?php echo $employee['id']; ?>)"><?php echo $employee['full_name']; ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown dropdown-project mr-3">
                                        <div class="dropdown-toggle" id="projectDropdown" data-toggle="dropdown">
                                            <div class="btn bg-body" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Project">
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

                                    <a href="#" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new task">
                                        <button class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center" data-toggle="modal" data-target="#new-task-modal">Add Task</button></a>
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
                                                                <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                    <a href="#"><i class="ri-more-fill"></i></a>
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                    <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View task details">
                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#taskDetailsModal<?php echo $row['id']; ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                    </div>
                                                                    <?php
                                                                    if ($row['uploaderid'] == $userid) {
                                                                    ?>
                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit task">
                                                                            <a class="dropdown-item" href="#" onclick="editProject(<?php echo $row['id']; ?>)">
                                                                                <i class="ri-edit-line mr-2"></i>Edit
                                                                            </a>
                                                                        </div>
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
                                                        <p class="mb-3"><i class="fa fa-calendar-check-o mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                        </p>
                                                        <div class="iq-progress-bar bg-success-light mb-4">
                                                            <span class=" iq-progress progress-1" data-percent="4" style="transition: width 2s ease 0s; width: 65%; background-color: #ed6f07;"></span>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <a href="#" class="iq-media">
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
                                            <div class="modal fade" id="taskDetailsModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-block text-center pb-3 border-bttom">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    <h5 class="modal-title" id="taskDetailsModalLabel">
                                                                        <?php echo $row['task_name']; ?> Details</h5>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                        ×
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body1">

                                                            <?php
                                                            if ($row['assigned_to'] == $userid) { ?>
                                                                <label>Select Status</label>
                                                                <div class="col-md-6">
                                                                    <select name="status" class="form-control" onchange="updateTaskStatus(this.value, '<?php echo $row['id']; ?>', '<?php echo $row['projectid']; ?>')">
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
                                            <div id="noTasksFoundMessage" class="container text-center mt-5" style="display: none;">
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
                                                    <h5><i class="fas fa-spinner fa-pulse mr-2"></i>In Progress <i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#3759e1;"></i>(<span id="filteredTaskCount2"></span>)</h5>

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
                                                                <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                    <a href="#"><i class="ri-more-fill"></i></a>
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                    <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View task details">
                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#taskDetailsModal<?php echo $row['id']; ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                    </div>
                                                                    <?php
                                                                    if ($row['uploaderid'] == $userid) {
                                                                    ?>
                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit task">
                                                                            <a class="dropdown-item" href="#" onclick="editProject(<?php echo $row['id']; ?>)">
                                                                                <i class="ri-edit-line mr-2"></i>Edit
                                                                            </a>
                                                                        </div>
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
                                                        <p class="mb-3"><i class="fa fa-calendar-check-o mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                        </p>
                                                        <div class="iq-progress-bar bg-success-light mb-4">
                                                            <span class=" iq-progress progress-1" data-percent="50" style="transition: width 2s ease 0s; width: 65%; background-color: #3759e1;"></span>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <a href="#" class="iq-media">
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
                                            <div class="modal fade" id="taskDetailsModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-block text-center pb-3 border-bttom">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    <h5 class="modal-title" id="taskDetailsModalLabel">
                                                                        <?php echo $row['task_name']; ?> Details</h5>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                        ×
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body1">

                                                            <?php
                                                            if ($row['assigned_to'] == $userid) { ?>
                                                                <label>Select Status</label>
                                                                <div class="col-md-6">
                                                                    <select name="status" class="form-control" onchange="updateTaskStatus(this.value, '<?php echo $row['id']; ?>', '<?php echo $row['projectid']; ?>')">
                                                                        <option value="InProgress">InProgress</option>
                                                                        <option value="Completed">Completed</option>
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
                                            <div id="noTasksFoundMessage" class="container text-center mt-5" style="display: none;">
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
                                                    <h5><i class="fas fa-calendar-check mr-2"></i>Completed <i class="fa fa-arrow-circle-right mr-2 ml-3" style="color:#68d241;"></i> (<span id="filteredTaskCount3"></span>)</h5>
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
                                                                <span class="dropdown-toggle py-2" id="dropdownMenuButton04" data-toggle="dropdown">
                                                                    <a href="#"><i class="ri-more-fill"></i></a>
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton04">
                                                                    <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="View task details">
                                                                        <a class="dropdown-item" data-toggle="modal" data-target="#taskDetailsModal<?php echo $row['id']; ?>"><i class="fa fa-eye mr-2"></i>View</a>
                                                                    </div>
                                                                    <?php
                                                                    if ($row['uploaderid'] == $userid) {
                                                                    ?>
                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Edit task">
                                                                            <a class="dropdown-item" href="#" onclick="editProject(<?php echo $row['id']; ?>)">
                                                                                <i class="ri-edit-line mr-2"></i>Edit
                                                                            </a>
                                                                        </div>


                                                                        <div data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Delete task">
                                                                            <a class="dropdown-item" href="#" onclick="showConfirmationCard()">
                                                                                <i class="ri-delete-bin-5-line mr-2"></i>Delete
                                                                            </a>
                                                                        </div>

                                                                        <div id="confirmationCard" class="confirmation-card">
                                                                            <p>Are you sure you want to delete this task?</p>
                                                                            <button onclick="deleteTask()">Yes</button>
                                                                            <button onclick="hideConfirmationCard()">No</button>
                                                                        </div>
                                                                        <div id="overlay" class="overlay"></div>

                                                                        <script>
                                                                            function showConfirmationCard() {
                                                                                document.getElementById('confirmationCard').style.display = 'block';
                                                                                document.getElementById('overlay').style.display = 'block';
                                                                            }

                                                                            function hideConfirmationCard() {
                                                                                document.getElementById('confirmationCard').style.display = 'none';
                                                                                document.getElementById('overlay').style.display = 'none';
                                                                            }

                                                                            function deleteTask() {
                                                                                hideConfirmationCard();
                                                                            }
                                                                        </script>

                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mb-3"><i class="fa fa-calendar-check-o mr-2"></i><?php echo date("d-m-Y", strtotime($row['due_date'])); ?>
                                                        </p>
                                                        <div class="iq-progress-bar bg-success-light mb-4">
                                                            <span class=" iq-progress progress-1" data-percent="100" style="transition: width 2s ease 0s; width: 65%; background-color: #68d241;"></span>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?php echo $row['assigned_profile_picture'] ?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                                </a>
                                                                <a href="#" class="iq-media">
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
                                            <div class="modal fade" id="taskDetailsModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-block text-center pb-3 border-bttom">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    <h5 class="modal-title" id="taskDetailsModalLabel">
                                                                        <?php echo $row['task_name']; ?> Details</h5>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                        ×
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-body1">

                                                            <?php
                                                            if ($row['assigned_to'] == $userid || $row['category'] === "Bug" || $row['category'] === "Improvement") { ?>
                                                                <label>Select Status</label>
                                                                <div class="col-md-6">
                                                                    <select name="status" class="form-control" onchange="updateTaskStatus(this.value, '<?php echo $row['id']; ?>', '<?php echo $row['projectid']; ?>')">
                                                                        <option value="Completed">Completed</option>
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
                                                                $zip = new ZipArchive();
                                                                if (file_exists($zipFileName)) {
                                                                    $zip->open($zipFileName, ZipArchive::CREATE);
                                                                } else {
                                                                    $zip->open($zipFileName, ZipArchive::OVERWRITE | ZipArchive::CREATE);
                                                                }
                                                                $existingFiles = [];
                                                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                                                    $existingFiles[] = $zip->getNameIndex($i);
                                                                }
                                                                $fileNames = explode(',', $row['document_attachment']);

                                                                foreach ($fileNames as $fileName) {
                                                                    $fileName = trim($fileName);
                                                                    $fileFullPath = './../uploads/task/' . $fileName;
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
                                            <div id="noTasksFoundMessage" class="container text-center mt-5" style="display: none;">
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
               

';
<?php }

?>
