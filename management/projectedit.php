<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./../include/config.php";

$userid = $_SESSION["user_id"];
require_once "./../project/taskdata/insertdata.php";
require_once "./../project/taskdata/feach.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
if (isset($_GET['id'])) {
    $projectedit = $projectManager->editproject();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $resultMessage = $taskManager->updateProject();
    $_SESSION['success'] = $resultMessage;
     header("Location: projectedit.php?id=" . $_POST['projectId']);
    exit();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Activity | JIFFY</title>
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
                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content text-center">
                    <div class="back-button">
                                    <a href="activity.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                            <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"/>
                                        </svg>
                                    </a>
                                </div>
                                <?php  foreach($projectedit as $pd) : ?>
                    <h5 class="mx-auto">Edit <?=$pd['projectname']?> Details</h5>
                    <?php endforeach ;?>
                </div>

                <div id="grid" class="item-content animate__animated animate__fadeIn active" data-toggle-extra="tab-content">
                    <!-- Modal card start -->
                <div class="row">
                    <div class="modal-body">    
                   <?php  foreach($projectedit as $pd) : ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01">Activity Name<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="text" class="form-control" id="exampleInputText01" placeholder="Enter activity name"
                                            name="projectName" required pattern="[A-Za-z]+[0-9\s_-.\s]*" title="Please use atleast one letter" value="<?=$pd['projectname']?>">
                                            <input type="hidden" class="form-control" id="exampleInputText01" placeholder="Enter your project name"
                                        name="projectId" value="<?=$pd['projectId']?>"required>
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
                                        <input type="text" class="form-control" id="budget" name="budget" placeholder="Enter budget" required pattern="[0-9]+" title="Please enter numbers only" value="<?=$pd["budget"]?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText01">Task Name</label>
                                        <input type="text" class="form-control" id="moduleInput1" placeholder="Enter task name" required>
                                        <p class="mt-1 text-danger" style="font-size:11px;"><i class="fa fa-exclamation-circle mr-1 text-danger"></i>Please enter names, separated by commas, and then press enter</p>
                                        <input type="hidden" name="tasks[]">
                                        <div id="pillContainer1"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText3" class="h5">Start Date<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="date" class="form-control" id="startDate" name="start_date" required value="<?=$pd["startDate"]?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText3" class="h5">End Date<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="date" class="form-control" id="endDate" name="end_date" required value="<?=$pd["dueDate"]?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText3" class="h5">Total Hours<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="number" class="form-control" id="totalHours" name="totalhours" required value="<?=$pd["hours"]?>" placeholder="Enter total hours" pattern="[0-9]+" title="Enter numbers only">
                                    </div>                                    
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="budget" class="h5">Per Day<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="text" class="form-control" id="hoursPerDay" name="perday" value='<?=$pd['perday_hours']?>' placeholder="Enter hours per day">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputText2" class="h5">Select Department<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="selecteddpt[]" class="selectpicker form-control" data-style="py-0" required multiple data-live-search="true">
                                            <option value="" disabled>Select</option>
                                             <?php
                                                $query = "SELECT * FROM department WHERE Company_id =$companyId";
                                                $result = mysqli_query($conn, $query);
                                            
                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = $row['id'];
                                                        $leavetype = $row['name'];
                                                        $selected = (in_array($id, $pd['departmentNames'])) ? 'selected' : '';
                                            
                                                        echo '<option value="' . $id . '" ' . $selected . '>' . $leavetype . '</option>';
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
                                            <label for="exampleInputText2" class="h5" required>Select Task Owner<span class="text-danger" style="font-size:20px">*</span></label>
                                            
                                        <select name="selectedproject" class="selectpicker form-control" data-style="py-0" required onchange="projectmanager(this.value)" data-live-search="true">                                                    <option value="">Select Project Manager</option>
                                                    <?php
                                                    $query = "SELECT * FROM employee WHERE active='active' AND user_role='Project Manager' AND Company_id =$companyId";
                                                    $result = mysqli_query($conn, $query);
                                                    if ($result && mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $id = $row['id'];
                                                            $full_name = $row['full_name'];
                                                            $user_role = $row['user_role'];
                                                            $selected = ($id == $pd['project_manager_id']) ? 'selected' : ''; 
                                                            echo '<option value="' . $id . '"' . $selected . '>' . $full_name . ' (' . $user_role . ')</option>'; 
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
                                                        $selected = (in_array($id, $pd['lead_id'])) ? 'selected' : '';
                                                        echo '<option value="' . $id . '" ' . $selected . '>' . $full_name . '(' . $user_role . ')</option>';
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
                                        <label for="exampleInputText2" class="h5">Select Member<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="selectedMembers[]" class="selectpicker form-control" data-style="py-0" multiple required data-live-search="true">
                                            <option value="" disabled>Select</option>
                                            <?php
                                            $query = "SELECT e.* FROM employee e ORDER BY e.full_name";
                                            $result = mysqli_query($conn, $query);
                                        
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id = $row['id'];
                                                    $fullName = $row['full_name'];
                                                    $user_role = $row['user_role'];
                                                    $selected = (in_array($id, $pd['memberNames'])) ? 'selected' : '';
                                        
                                                    echo '<option value="' . $id . '" ' . $selected . '>' . $fullName . '(' . $user_role . ')</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No type found</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>                               
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="priority" class="h5">Priority<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="priority" class="form-control" id="priority" required>
                                        <option value="">Select Priority</option>
                                        <option <?php echo $pd["priority"]=="High" ? "selected" : "" ?> value="High">High</option>
                                        <option <?php echo $pd["priority"]=="Normal" ? "selected" : "" ?> value="Normal">Normal</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="location" class="h5">Location<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required value="<?=$pd['location']?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="resources" class="h5">Resources<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="number" class="form-control" id="resources" name="resources" placeholder="Enter actual resource" required pattern="\d+(\.\d+)?" title="Please enter numbers only" value="<?=$pd['no_resource']?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="required-resource" class="h5">Required Resources<span class="text-danger" style="font-size:20px">*</span></label> 
                                        <input type="number" class="form-control" id="add-resources" name="add-resources" placeholder="Enter required resource" required pattern="\d+(\.\d+)?" title="Please enter numbers only"> 
                                    </div>
                                </div>                                                             
                                
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="shortDescription">Activity Description<span class="text-danger" style="font-size:20px">*</span></label>
                                        <textarea class="form-control" id="editor1" placeholder="Short Description" name="shortDescription"
                                            required value="<?=$pd["description"]?>"><?=$pd["description"]?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3 custom-file-small">
                                        <label for="projectDocument">Attach File<span class="text-danger" style="font-size:20px">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="projectDocument" accept=".pdf,.docx"
                                                name="projectDocument" >
                                            <label class="custom-file-label" for="projectDocument">Choose file</label>
                                        </div>
                                        <a class="" href="./../uploads/projects/<?=$pd["documentAttachment"]?>" download><i class="fa fa-download px-2"></i>Download activity document</a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                        <button type="submit" class="custom-btn1 btn-2 mr-3 text-center" id="project">Submit</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        <?php  endforeach;  ?>
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
        $(document).ready(function () {
            setTimeout(function () {
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
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const moduleInput = document.getElementById('moduleInput1');
        const moduleNamesInput = document.querySelector('input[name="tasks[]"]');
        const pillContainer = document.getElementById('pillContainer1');
        let updatedModules = <?= json_encode($pd['tasks']) ?>; 

        
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
</html>