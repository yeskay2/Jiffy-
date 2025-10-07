<?php
session_start();
include "./../include/config.php";
require_once "taskdata/insertdata.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$taskData = [
    'projectid' => 0,
    'otherProjectName' => '',
    'taskName' => '',
    'assigned_to' => 0,
    'dueDate' => '',
    'category' => 'Task',
    'description' => '',
    'checklist' => '',
    'Actual_start_time' => '',
];

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];
    $query = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_uploader.full_name AS uploader_full_name, 
        e_assigned.profile_picture AS assigned_profile_picture, e_uploader.profile_picture AS uploader_profile_picture, 
        p.project_name
        FROM tasks t
        LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
        LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
        LEFT JOIN projects p ON t.projectid = p.id
        WHERE t.id = $taskId";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $taskData = mysqli_fetch_assoc($result);
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskManager->updateTask($userid);
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
                                        <a href="task.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                                <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                            </svg>
                                        </a>
                                    </div>
                                    <h4 class="mx-auto my-3">Edit Task Details</h4>
                                </div>

                                <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
                                    <!-- Modal card start -->
                                    <div class="row">
                                        <div class="modal-body">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                                <div class="form-group mb-3">
                                                    <label for="exampleInputText2" class="h5">Project Name<span class="text-danger" style="font-size:20px">*</span></label>
                                                    <select name="projectid" class="form-control selectpicker" data-style="py-0" id="projectSelect" onchange="project1(this.value)">
                                                        <option value="0" <?php if ($taskData['projectid'] == 0) echo 'selected'; ?>>Others</option>
                                                        <?php
                                                        $query = "SELECT * FROM projects ORDER BY project_name";
                                                        $result = mysqli_query($conn, $query);

                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $projectId = $row['id'];
                                                                $projectName = $row['project_name'];
                                                                echo '<option value="' . $projectId . '" ' . ($taskData['projectid'] == $projectId ? 'selected' : '') . '>' . $projectName . '</option>';
                                                            }
                                                        } else {
                                                            echo '<option value="" disabled>No projects found</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="exampleInputText2" class="h5">Select Module</label>
                                                    <select name="modules" class="form-control" data-style="py-0" id="projectmodules1">
                                                        <option value="nill">No modules found</option>

                                                    </select>
                                                </div>
                                                <script>
                                                    function project1(projectId, modules) {
                                                        $.ajax({
                                                            url: 'memberfiler.php',
                                                            type: 'POST',
                                                            data: {
                                                                projectId: projectId,
                                                                projectmodules: modules
                                                            },
                                                            success: function(response) {
                                                                console.log(response);
                                                                $('#projectmodules1').html(response);
                                                            }
                                                        });
                                                    }
                                                    $(document).ready(function() {
                                                        var projectId = <?php echo json_encode($taskData['projectid']) ?>;
                                                        var modules = <?php echo json_encode($taskData['modules_name']) ?>;
                                                        project1(projectId, modules);
                                                    });
                                                </script>



                                                <div class="form-group mb-3">
                                                    <label for="exampleInputText02" class="h5">Task Name<span class="text-danger" style="font-size:20px">*</span></label>
                                                    <input type="hidden" class="form-control" name="path" required value="<?php echo $_GET["cod"]; ?>">
                                                    <input type="text" class="form-control" id="exampleInputText02" placeholder="Enter task Name" name="taskName" required value="<?php echo htmlspecialchars($taskData['task_name']); ?>">
                                                    <a href="#" class="task-edit text-body"></a>
                                                </div>
                                                <input type="text" name="id" value="<?= $taskId ?>" hidden>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText2" class="h5">Assign to<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <select name="assignedTo" class="form-control selectpicker" data-style="py-0" data-live-search=true>
                                                                <?php
                                                                $query = "SELECT * FROM employee ORDER BY full_name";
                                                                $result = mysqli_query($conn, $query);

                                                                if ($result && mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $employeeId = $row['id'];
                                                                        $employeeName = $row['full_name'];
                                                                        $roles = $row['user_role'];

                                                                        $selected = ($taskData['assigned_to'] == $employeeId) ? 'selected' : '';

                                                                        echo '<option value="' . $employeeId . '" ' . $selected . '>' . $employeeName . ' (' . $roles . ')</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option value="" disabled>No employees found</option>';
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($_SESSION["id"] == 1 || $_SESSION["id"] == 2) {
                                                        $class = "";
                                                    } elseif ($_SESSION["id"] == 3) {
                                                        $class = "readonly";
                                                    }
                                                    ?>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText05" class="h5">Actual Start Date<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <input type="date" class="form-control" id="exampleInputText05_start" value="<?php echo htmlspecialchars($taskData['Actual_start_time']); ?>" name="startdate" required placeholder="Select start date">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText05" class="h5">Actual Due Date<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <input type="date" class="form-control" id="exampleInputText05" value="<?php echo htmlspecialchars($taskData['due_date']); ?>" name="dueDate" required min="<?php echo date('Y-m-d'); ?>" <?= $class ?>>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText05_start" class="h5">Select Start Time<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <input type="time" class="form-control" id="exampleInputText05_start" name="startperTime" required value="<?php echo date('H:i', strtotime($taskData['perferstart_time'])); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText05_end" class="h5">Select Due Time<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <input type="time" class="form-control" id="exampleInputText05_end" name="endperTime" required value="<?php echo date('H:i', strtotime($taskData['perferend_time'])); ?>">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText2" class="h5">Type<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <select name="category" class="form-control selectpicker" data-style="py-0">
                                                                <option value="Task" data-icon="fas fa-tasks" <?php if ($taskData['category'] == 'Task') echo 'selected'; ?>>Task</option>
                                                                <option value="Bug" data-icon="far fa-dot-circle" <?php if ($taskData['category'] == 'Bug') echo 'selected'; ?>>Bug</option>
                                                                <option value="Improvement" data-icon="fas fa-lightbulb" <?php if ($taskData['category'] == 'Improvement') echo 'selected'; ?>>Improvement</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText040" class="h5">Description<span class="text-danger" style="font-size:20px">*</span></label>
                                                            <textarea class="form-control" id="editor2" rows="2" name="description" value="<?php echo htmlspecialchars($taskData['description']); ?>" required>

                    <?php echo htmlspecialchars($taskData['description']); ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputText005" class="h5">Checklist</label>
                                                            <input type="text" class="form-control" id="exampleInputText005" placeholder="Enter reference link" name="checklist" value="<?php echo htmlspecialchars($taskData['checklist']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-0">
                                                            <label for="inputGroupFile" class="h5">Attachments</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="inputGroupFile" name="projectDocument[]" multiple>
                                                                <label class="custom-file-label" id="fileLabel" for="inputGroupFile">Upload media</label>
                                                            </div>
                                                            <small class="text-muted">Maximum file size: 5 MB</small>
                                                        </div>
                                                        <div>
                                                            <?php echo htmlspecialchars($taskData['document_attachment']); ?>
                                                            <div id="selected"></div>
                                                        </div>
                                                    </div>

                                                    <div id="selected"></div>

                                                    <div class="col-lg-12">
                                                        <div class="d-flex flex-wrap align-items-center justify-content-center mt-4">
                                                            <button type="submit" class="custom-btn1 btn-2 mt-3 mt-lg-0 mr-3 text-center">Submit</button>
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
        let updatedModules = <?= json_encode($pd['modules']) ?>;


        moduleNamesInput.value = updatedModules.join(', ');


        updatedModules.forEach(module => {
            const pill = createPill(module);
            pillContainer.appendChild(pill);
        });

        moduleInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                event.preventDefault();
                const modules = moduleInput.value.split(',').map(module => module.trim());
                updatedModules = updatedModules.concat(modules);
                moduleNamesInput.value = updatedModules.join(', ');
                moduleInput.value = '';


                pillContainer.innerHTML = '';


                updatedModules.forEach(module => {
                    const pill = createPill(module);
                    pillContainer.appendChild(pill);
                });

                console.log(updatedModules);
            }
        });

        function createPill(module) {
            const pill = document.createElement('span');
            pill.classList.add('pill');
            pill.textContent = module;

            const closeButton = document.createElement('button');
            closeButton.textContent = 'x';
            closeButton.addEventListener('click', function() {
                updatedModules = updatedModules.filter(m => m !== module);
                moduleNamesInput.value = updatedModules.join(', ');
                pill.remove();
                console.log(updatedModules);
            });
            pill.appendChild(closeButton);
            return pill;
        }
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>


<script>
    CKEDITOR.replace('editor2');
</script>

</html>