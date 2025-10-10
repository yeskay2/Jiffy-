<?php
session_start();
 date_default_timezone_set('Asia/Kolkata');
include "./../include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$userid = $_SESSION["user_id"];
if(isset($_GET['taskid'])){
    $taskid = isset($_GET['taskid']) ? base64_decode(urldecode($_GET['taskid'])) : null;
    $sql = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_uploader.full_name AS uploader_full_name, 
                      e_assigned.profile_picture AS assigned_profile_picture, e_uploader.profile_picture AS uploader_profile_picture, 
                      p.project_name,p.lead_id FROM tasks t 
                      LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
                      LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
                      LEFT JOIN objectives p ON t.projectid = p.id
                      WHERE t.id = $taskid";
                    $result = mysqli_query($conn, $sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $task = $row['task_name'];
                        $status = $row['status'];
                        $id = $row['id'];
                        $projectid =$row['projectid'];
                        $assigned  = $row['assigned_to'];
                        $lead = $row['uploaderid'];
                        $statuslead = $row["Approval"];
                        $project_name = $row["project_name"];
                        $due_date_time = $row['due_date'] ? date("d-m-Y", strtotime($row['due_date'])) : "nill";
                        $Actual_start_time = $row['Actual_start_time'] ? date("d-m-Y", strtotime($row['Actual_start_time'])) : "nill";
                        $start_time =  $row['start_time'] ? date("d-m-Y, h:i A", strtotime($row['start_time'])) : "nill";;
                        $uploadimage = $row['uploader_profile_picture'];
                        $assign_edimages = $row['assigned_profile_picture'];
                        $name_assign_by  = $row['uploader_full_name'];
                        $name_assign_to  = $row['assigned_full_name'];
                        $dec = $row['description'];
                        $outputFiles = $row['outputfilepath'];
                        $category = $row['category'];
                        $file = $row['document_attachment'];
                        $ticket = $row['ticket'];
                        $models = $row['modules_name'];
                        $start_time_formatted = date("h:i A", strtotime($row['perferstart_time']));
                        $end_time_formatted = date("h:i A", strtotime($row['perferend_time']));                        
                        
                        $due_time = strtotime($row['due_date']);
                        $today_time = strtotime('now');
                        $remaining_time_minutes = $due_time - $today_time;
                        $remaining_time_minute = round($remaining_time_seconds / 60);
                        $due_date = $row['end_time'] ? date("d-m-Y, h:i A", strtotime($row['end_time'])) : "nill";;
                        if($status=="Todo"){
                            $class1 ='#ed6f07';
                        }elseif($status=="InProgress"){
                             $class1 ='#3759e1';
                        }else{
                             $class1 ='#68d241';
                        }
                        
                        if($category=="Task"){
                            $class = "task";
                        }elseif($category=="Bug"){
                            $class = "bug";
                        }
                        else{
                            $class = "success";
                        }
                        
                        if(empty($project_name)){
                            $project_name = "Others";
                        }else{
                            $project_name = $project_name;
                        }
                        
                
                ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS</title>
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

        .img-thumb {
            max-height: 75px;
            border: 2px solid none;
            border-radius: 3px;
            padding: 1px;
            cursor: pointer;
        }

        .img-thumb-wrapper {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        .remove {
            display: block;
            background: #E20101;
            border: 1px solid none;
            color: white;
            text-align: center;
            cursor: pointer;
        }

        .remove:hover {
            background: black;
            color: white;
        }

        .slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide {
            min-width: 100%;
            overflow: hidden;
        }

        img {
            width: 100%;
            height: auto;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            z-index: 1;
        }
        .next1 {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            z-index: 1;
        }

        .prev {
            left: 0;
        }

        .next1 {
            right: 0;
        }

        .progress-circle {
            width: 100px;
            height: 100px;
            background-color: #fff;
            border-radius: 50%;
            border: 2px solid #c72f2e;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
        }

        .countdown-number {
            color: #333;
        }
        form {
    margin-top: 20px;
}
input[type="file"] {
    display: none;
}

label[for="image-url"] {
    cursor: pointer;
    background-color: #007bff; /* Adjust background color as needed */
    color: #fff; /* Adjust text color as needed */
    padding: 10px 15px;
    border-radius: 5px;
}

input[type="submit"] {
    margin-top: 10px;
    background-color: #28a745; /* Adjust background color as needed */
    color: #fff; /* Adjust text color as needed */
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover,
label[for="image-url"]:hover {
    opacity: 0.8;
}
.slider img {
            width: 100%;
            height: auto;
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
                                    <a href="javascript:history.back()">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                            <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"/>
                                        </svg>
                                    </a>
                                </div>
                                    <h3 class="text-center mx-auto"><?=$task?></h3>
                            </div>

                            <div class="mt-3 mx-2 mx-sm-3 mx-md-5 p-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex align-items-center mb-3">
                                    <h6 class="mt-2 mb-0 mr-2"><b>Status:</b></h6>
                                    <span class="badge " style="background-color:<?=$class1?>">
                                        <h5 class="text-white p-1 shadow mb-0" ><?=$status?></h5>
                                    </span>
                                </div>
                                  <?php if($assigned == $userid){ ?>
                                <div class="d-flex align-items-center mb-3">
                                    <h6 class="mb-0"><b>Select Status:</b></h6>
                                    <div class="col-md-2">
                                        <select name="status" class="Taskform-control" style="background-color: white; height:40px;" onchange="updateTaskStatus(this.value, '<?php echo $id; ?>', '<?php echo $projectid; ?>')">
                                        <?php if ($status == 'Todo'||$status == 'Completed' ): ?>
                                                <option value="" disable>Select Status</option>
                                                <option value="InProgress">In Progress</option>
                                            <?php elseif ($status == 'InProgress'): ?>
                                                <option value="" disable>Select Status</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Pause">Pause</option>
                                            <?php elseif ($status == 'Pause'): ?>
                                                <option value="" disable>Select Status</option>
                                                <option value="Continue">Continue</option>
                                            <?php endif; ?>
                                        </select>

                                    </div>
                                </div>
                                <?php } ?>
                                <?php if($lead == $userid){ ?>
                                <div class="d-flex align-items-center mb-3">
                                    <h6 class="mb-0 mr-2"><b>Select Approval:</b></h6>
                                    <div class="col-md-2">
                                        <select name="status" id="status" class="Taskform-control" style="background-color: white; height:40px;" onchange="updateTaskStatus1(this.value, '<?php echo $id; ?>')">
                                             <option disable value="">Select</option>
                                            <option value="Approved" <?php if($statuslead == 'Approved') echo "selected"; ?>>Approved</option>
                                            <option value="Rejected" <?php if($statuslead == 'Rejected') echo "selected"; ?>>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                 <?php } ?>
                            <!--Members End -->

                            <!--Other details start -->
                            <div class="container mb-3 projectDetails">
                                <div class="border rounded p-3 mb-3 shadow">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h6 class="ms-5 mb-4"><b>Objective Name&emsp;&emsp;:&emsp;</b><?=$project_name?></h6>
                                            <h6 class="ms-5 mb-4"><b>Strategies&emsp;&emsp;&emsp;&emsp;:&emsp;</b><?=$models?></h6>
                                            <h6 class="ms-5 mb-4"><b>Category&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;</b><span class="badge <?=$class?>">
                                                    <h5 class="text-white p-1 shadow"><?=$category?></h5>
                                                </span></h6>
                                            <h6 class="ms-5 mb-4"><b>Assigned By&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:&emsp;</b>
                                                <a href="#" data-toggle="tooltip" data-placement="right" data-trigger="hover" title="<?= $name_assign_by ?>">
                                                    <img src="./../uploads/employee/<?=$uploadimage?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                </a>
                                            </h6>
                                            <h6 class="ms-5 mb-4"><b>Assigned To&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:&emsp;</b>
                                                <a href="#" data-toggle="tooltip" data-placement="right" data-trigger="hover" title="<?= $name_assign_to ?>">
                                                    <img src="./../uploads/employee/<?=$assign_edimages?>" class="img-fluid avatar-40 rounded-circle" alt="">
                                                </a>
                                            </h6>
                                            <h6 class="ms-5 mb-4"><b>Actual Start Date&emsp;:&emsp;</b><?=$Actual_start_time?></h6>
                                            <h6 class="ms-5 mb-4"><b>Start Date&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp;</b><?=$start_time?></h6>
                                            <h6 class="ms-5 mb-4"><b>Actual End Date&emsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?=$due_date_time?></h6>
                                            <h6 class="ms-5 mb-4"><b>End Date&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?=$due_date?></h6>
                                            <h6 class="ms-5 mb-4"><b>Preferred Time&emsp;&nbsp;&nbsp;&nbsp;:&emsp;</b><?=$start_time_formatted.'-'.$end_time_formatted?></h6>                                            
                                            <h6 class="ms-5 mb-4">
                                                                   <?php
                                                            if (!empty($file)) {
                                                                echo "<b>Task Document&emsp;:&emsp;</b>";
                                                                $zipFolderPath = './../uploads/download/';
                                                                $random = $ticket;
                                                                $zipFileName = $zipFolderPath . 'downloaded_files_' . $random . '.zip';
                                                                $zip = new ZipArchive();
                                                                $mode = file_exists($zipFileName) ? ZipArchive::CREATE : (ZipArchive::OVERWRITE | ZipArchive::CREATE);
                                                                if ($zip->open($zipFileName, $mode) === true) {
                                                                    $existingFiles = [];
                                                                    for ($i = 0; $i < $zip->numFiles; $i++) {
                                                                        $existingFiles[] = $zip->getNameIndex($i);
                                                                    }
                                                                    $fileNames = explode(',', $file);
                                                                    foreach ($fileNames as $fileName) {
                                                                        $fileName = trim($fileName);
                                                                        $fileFullPath = './../uploads/task/' . $fileName;
                                                                        if (file_exists($fileFullPath)) {
                                                                            if (!in_array(basename($fileFullPath), $existingFiles)) {
                                                                                $zip->addFile($fileFullPath, basename($fileFullPath));
                                                                            }
                                                                        } else {
                                                                            echo 'File not found: ' . $fileFullPath . '<br>';
                                                                        }
                                                                    }
                                                                    $zip->close();
                                                                    echo '<a href="' . $zipFileName . '" download>Task_document.zip <i class="fa fa-download px-2"></i></a>';
                                                                } else {
                                                                    echo 'Failed to create ZIP file';
                                                                }
                                                            }
                                                            ?>
                                    </h6>
                                        </div>
                                        <div class="col-lg-6">
                                        <div class="slider-container">
                                            <div class="slider">
                                                <!-- Slides will be added dynamically here -->
                                            </div>
                                            <div class="prev" onclick="moveSlide(-1)">❮</div>
                                            <div class="next1" onclick="moveSlide(1)">❯</div>
                                        </div>
                                    
                                        <div>
                                            <form id="image-form" action="action.php" method="POST" enctype="multipart/form-data">
                                                <h6>Choose your finished task images or error images</h6>
                                                <label for="image-url">Select Image</label>
                                                <input type="file" id="image-url" name="image[]" accept="image/*" multiple onchange="updateImage()">
                                                <input type="submit" id="submitBtn" value="Image Submit">
                                            </form>
                                        </div>
                                    </div>

                        
                                    </div>
                                </div>
                            </div>
                            <!--Other details End -->
                            <!--Description start -->
                            <div class="container mb-3 projectDetails">
                                <h4 class="p-3 text-center">Task &nbsp; Description</h4>
                                <div class="project-description-container border rounded p-3 mb-3 shadow text-justify">
                                   <?=$dec?>
                                </div>
                            </div>
                            <!--Description End -->
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
    <script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>
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
        function updateTaskStatus1(status,taskId) {
            $.ajax({
                type: "POST",
                url: "update_status.php",
                data: {
                    taskId: taskId,
                    status: status,
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#image-form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this); 
            formData.append('taskid', <?=$taskid ?>); 
            $.ajax({
                url: $(this).attr('action'), 
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                     document.getElementById('submitBtn').value = 'Image Submitted';
                },
                error: function(xhr, status, error) {
                    console.error('Request failed with status', status, error); 
                }
            });
        });
    });
</script>

<!--Script for images scroll -->
<script>
    let slideIndex = 0;
    let totalSlides = 0;
    const slider = document.querySelector('.slider');
    const imageUrlInput = document.getElementById('image-url');
    const outputFiles = <?= json_encode($outputFiles) ?>;
    const outputFilesArray = outputFiles.split(',');

    function initializeSlider() {
        outputFilesArray.forEach(file => {
            const slide = createSlide(`./outputimage/${file}`);
            slider.appendChild(slide);
        });
        totalSlides = outputFilesArray.length;
        showSlide(slideIndex);
    }

    function createSlide(src) {
        const slide = document.createElement('div');
        slide.className = 'slide';
        slide.innerHTML = `<img src="${src}" alt="Image from Database">`;
        return slide;
    }

    function updateImage() {
        const files = imageUrlInput.files;
        const currentTotalSlides = document.querySelectorAll('.slide').length;

        for (let i = currentTotalSlides; i < files.length + currentTotalSlides; i++) {
            const file = files[i - currentTotalSlides];
            const reader = new FileReader();

            reader.onload = function(e) {
                const slide = createSlide(e.target.result);
                slider.appendChild(slide);
            };

            reader.readAsDataURL(file);
        }

        totalSlides += files.length;
        showSlide(slideIndex);
    }

    function moveSlide(n) {
        slideIndex += n;
        if (slideIndex >= totalSlides) {
            slideIndex = 0;
        }
        if (slideIndex < 0) {
            slideIndex = totalSlides - 1;
        }
        showSlide(slideIndex);
    }

    function showSlide(n) {
        const slides = document.querySelectorAll('.slide');
        slides.forEach((slide) => (slide.style.display = "none"));
        slides[n].style.display = "block";
    }

    initializeSlider(); 
</script>


</html>
<?php } } ?>