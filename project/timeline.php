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
require_once "taskdata/insertdata.php";
require_once "taskdata/feach.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_GET["editid"])) {
        $taskManager->editTimeline($userid);
    } elseif (isset($_POST["add"])) {
        $taskManager->addtimeline($userid);
    } else {
        $meetingid = $_POST['meetingid'];
        $file = $_FILES['file'];
        $fileNameCmps = pathinfo($file['name']);
        $newFileName = md5(time() . $file['name']) . '.' . $fileNameCmps['extension'];
        $filePath = 'outputimage/' . $newFileName;
        
        if (in_array($fileNameCmps['extension'], ['doc', 'docx', 'pdf']) && move_uploaded_file($file['tmp_name'], $filePath)) {
            $stmt = $conn->prepare("UPDATE `timeline` SET `status`= 2, `momfile` = ? WHERE id = ?");
            $stmt->bind_param('si', $filePath, $meetingid);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = 'MOM updated successfully';
                header("Location: timeline.php");
                exit();
            } else {
                echo "Failed to update the database.";
            }
        } else {
            echo "Invalid file type or failed to move file.";
        }
    }
}


$timeline = $projectManager->timeline($userid);
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM `timeline` WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['success'] = 'Schedule deleted successfully';
        header("Location: timeline.php");
        exit();
    } else {      

        $_SESSION['error'] = 'Error deleting schedule: ' . mysqli_error($conn);
        header("Location: timeline.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Meetings | Jiffy</title>
    <!-- Favicon -->
    <link rel="icon" type="images/x-icon" href="./../assets/images/Jiffy-favicon.ico" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <style>
        .table-border td {
            border: 0.3px solid #CED4DA;
        }

        .thead-border td {
            border: 0.3px solid white;
        }

        .fw-bold {
            font-weight: bold;
        }
        .badge-todo {
            color: #fff !important;
            background-color: #FFA500 !important;
        }
        .badge-inprogress {
            color: #fff !important;
            background-color: #008000 !important;
        }
        .badge-complete {
            color: #fff !important;
            background-color: #808080 !important;
        }
    </style>
</head>

<body>
    <!-- Loader Start -->
  <div id="loading">
    <div id="loading-center"></div>
  </div>
  <!-- Loader END -->

    <!-- Wrapper Start -->
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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Meeting Schedule</h4>
                                </div>
                                <!-- <button class="btn btn-excel mx-2" id="exportButton" data-toggle="tooltip" data-placement="top" data-trigger="hover" 
                                title="Download excel sheet">Export Excel &nbsp;<i class="fas fa-arrow-alt-circle-up"></i></button> -->

                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new meeting schedule">
                                    <a href="#" class="custom-btn1 btn-2  text-center" data-target="#new-task-modal" data-toggle="modal">Schedule</a>
                                </div>
                            </div>
                            <div class="content"></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead class="thead-border">
                                            <tr class="fw-bold">
                                                <td>SI.No</td>
                                                <td>Day</td>
                                                <td>Schedule</td>                                                
                                                <td>Scheduled By</td>
                                                <td>Status</td>
                                                <td>MOM</td>
                                                <td>Action</td>                                                
                                            </tr>
                                        </thead>
                                        <tbody class="table-border">
                                            <?php if (!empty($timeline)) : ?>
                                                <?php $i = 1; ?>
                                                <?php foreach ($timeline as $timelineItem) : ?>
                                                    <?php
                                                    $day = date('Y-m-d', strtotime($timelineItem['start_t']));
                                                    $day1 = date('d-m-Y', strtotime($timelineItem['start_t']));
                                                    $starttime = date('h:i A', strtotime($timelineItem['start_time']));
                                                    $endtime = date('h:i A', strtotime($timelineItem['end_time']));
                                                    $modalId = "taskDetails{$i}";
                                                    ?>
                                                    <tr>
                                                        <td class="fw-bold"><?= $i++ ?></td>
                                                        <td><?= $day1 . ' (' . date('D', strtotime($day)) . ')' ?></td>
                                                        <td data-toggle="modal" data-target="#<?= $modalId ?>" style="cursor: pointer;">
                                                            <div><b>Project Name: </b><?= $timelineItem['project_name'] ?></div>
                                                            <div><b>Time: </b><?= $starttime. "-" .  $endtime ?></div>
                                                            <div style="display:none"><b>Task Description: </b><?= $timelineItem['task_description'] ?></div>
                                                        </td>                                                       
                                                        <td>
                                                            <div class="iq-media-group">
                                                                <a href="#" class="iq-media">
                                                                    <img src="./../uploads/employee/<?= $timelineItem['assigned_by'] ?>" class="img-fluid avatar-40 rounded-circle" alt="Image" 
                                                                    data-toggle="tooltip" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="<?= $timelineItem['assigned_name'] ?>">
                                                                </a>
                                                            </div>
                                                        </td>
                                                         <td>
                                                         <?php
                                                        if($timelineItem['status'] == 0){?>
                                                        <badge class="badge badge-todo">Not Started</badge>
                                                        <?php }elseif($timelineItem['status'] == 1){ ?>
                                                        <badge class="badge badge-inprogress" >In Progress</badge>
                                                        <?php }else{ ?>
                                                        <badge class="badge badge-complete" >End</badge></td>
                                                        <?php } ?>
                                                        <?php if ($timelineItem['emp_id'] == $userid) { ?>                                                       
                                                        <td>                                                       
                                                       <?php
                                                        if($timelineItem['status'] == 0){ ?>
                                                             <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Upload MOM To end the meeting">
                                                            <input type="file" id="fileInput" accept=".doc,.docx,.pdf" style="display:none;" />
                                                            <a href="#" id="uploadButton" class="btn btn-yes" style="border-radius:12px;" disabled>
                                                                <i class="fas fa-upload py-1"></i>
                                                            </a>
                                                        </div>
                                                      <?php  }elseif($timelineItem['status'] == 1){?>                                                    
                                                               <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Upload MOM To end the meeting">
                                                                    <form id="uploadForm" method="POST" enctype="multipart/form-data" action="#">
                                                                        <input type="file" id="fileInput" accept=".doc,.docx,.pdf" style="display:none;" name="file" />
                                                                        <input type="hidden" id="fileInput"  name="meetingid" value="<?= $timelineItem["id"] ?>"/>
                                                                        <a href="#" id="uploadButton" class="btn btn-yes" style="border-radius:12px;">
                                                                            <i class="fas fa-upload py-1"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>                                      
                                                       <?php }else{ ?>
                                                           <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Download MOM">
                                                                    <a href="./<?= htmlspecialchars($timelineItem['momfile'], ENT_QUOTES, 'UTF-8') ?>"  class="btn btn-yes" style="border-radius:12px;" download>
                                                                        <i class="fas fa-download py-1"></i>
                                                                    </a>
                                                                </div>
                                                       <?php } ?>
                                                        </td>
                                                            <td>
                                                                <div class="d-flex align-items-center justify-content-center">
                                                                    <div class="mr-2" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Start taking MOM">
                                                                    <a href="notes.php?meetingid=<?= $timelineItem["id"] ?>" class="btn btn-secondary <?= ($timelineItem['status'] == 2) ? 'disabled' : '' ?>" 
                                                                    style="border-radius: 12px; background-color: <?= ($timelineItem['status'] == 2) ? '#cccccc' : '#29bf12'; ?>; border-color: <?= ($timelineItem['status'] == 2) ? '#cccccc' : '#29bf12'; ?>;"
                                                                    <?php if ($timelineItem['status'] == 2) echo 'disabled'; ?>>
                                                                    <i class="fas fa-play"></i>
                                                                </a>
                                                                </div>
                                                                <div class="mr-2" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Edit schedule">
                                                                    <a href="timeline.php?id=<?= $timelineItem["id"] ?>" data-target="#editModal<?= $timelineItem['id'] ?>" 
                                                                    data-toggle="modal" class="btn btn-success <?= ($timelineItem['status'] == 2) ? 'disabled' : '' ?>" 
                                                                    onclick="editRow(<?= $i - 1 ?>)" <?php if ($timelineItem['status'] == 2) echo 'disabled'; ?>>
                                                                        <i class="ri-edit-line"></i>
                                                                    </a>
                                                                </div>
                                                                    <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Participants Status">
                                                                        <a href="#" data-target="#rejectModal<?= $timelineItem["id"] ?>" data-toggle="modal" class="btn btn-secondary" style="border-radius:12px; background-color:#f26a8d;">
                                                                            <i class="fas fa-user py-1"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td>
                                                            <?php
                                                                $disable = ($timelineItem['status'] == 0 || $timelineItem['status'] == 1 ) ? 'disabled' : '';
                                                                ?>
                                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Download MOM">                                                           
                                                             <a href="./<?= htmlspecialchars($timelineItem['momfile'], ENT_QUOTES, 'UTF-8') ?>"  class="btn btn-yes" style="border-radius:12px;" download <?=$disable?>>
                                                                <i class="fas fa-download py-1"></i>
                                                            </a>
                                                        </div>
                                                            <td>
                                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Start taking MOM">
                                                                <a href="notes.php?meetingid=<?= $timelineItem["id"] ?>" class="btn btn-secondary <?= ($timelineItem['status'] == 2) ? 'disabled' : '' ?>" 
                                                                    style="border-radius: 12px; background-color: <?= ($timelineItem['status'] == 2) ? '#cccccc' : '#29bf12'; ?>; border-color: <?= ($timelineItem['status'] == 2) ? '#cccccc' : '#29bf12'; ?>;"
                                                                    <?php if ($timelineItem['status'] == 2) echo 'disabled'; ?>>
                                                                    <i class="fas fa-play"></i>
                                                                </a>
                                                            </div>

                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <!-- Modal for each timeline item -->
                                                    <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Meeting Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><b>Project Name : </b><?= $timelineItem['project_name'] ?></p>
                                                                    <p><b>Type : </b><?= $timelineItem['meeting_type'] ?></p>
                                                                    <p class="text-justify"><b>Task Description : </b><?= $timelineItem['task_description'] ?></p>
                                                                    <?php if ($timelineItem["meeting_type"] == "online") : ?>
                                                                        <p><b>Meeting Link : </b><a href='<?= $timelineItem["meeting_link"] ?>' target=_blank;><?= $timelineItem["meeting_link"] ?></p></a>
                                                                    <?php endif; ?>
                                                                    <?php if ($timelineItem["meeting_type"] == "offline") : ?>
                                                                        <p><b>Location : </b><?= $timelineItem["meeting_location"] ?></p>
                                                                    <?php endif; ?>
                                                                    <div class="d-flex">
                                                                        <p class="mt-1 mr-2"><b>Participants :</b>
                                                                        <div class="iq-media-group" style="margin-top: -20px;">
                                                                            <div class="d-flex align-items-center justify-content-between pt-3">
                                                                                <div class="iq-media-group">
                                                                                    <?php
                                                                                    $profilePictures = explode(',', $timelineItem['profile_pictures']);
                                                                                    foreach ($profilePictures as $picture) {
                                                                                    ?>
                                                                                        <a href="#" class="iq-media" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Anusiya">
                                                                                            <img class="img-fluid avatar-40 rounded-circle" src="./../uploads/employee/<?= trim($picture) ?>" alt="image" >
                                                                                        </a>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!----End model view -->
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
                        <div class="col-lg-6">
                            <h3 class="modal-title" id="exampleModalCenterTitle">Add Schedule</h3>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="#" method="POST" id="timetableForm" name='add'>
    <div class="form-group mb-3">
        <label for="exampleInputText2" class="h5">Select Project Name<span class="text-danger" style="font-size:20px">*</span></label>
        <select name="projectid" class="selectpicker form-control" data-style="py-0" id="projectSelect" required>
            <option value="0">Others</option>
            <?php
            $query = "SELECT * FROM projects WHERE Company_id = $companyId ORDER BY project_name";
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
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="startTime" class="h5">Meeting Date<span class="text-danger" style="font-size:20px">*</span></label>
                <input class="form-control" type="date" name="startdate" id="startTime" required>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="endTime" class="h5">Start Time<span class="text-danger" style="font-size:20px">*</span></label>
                <input class="form-control" type="time" name="startTime" id="startTime" required>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="endTime" class="h5">End Time<span class="text-danger" style="font-size:20px">*</span></label>
                <input class="form-control" type="time" name="endTime" id="endTime" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 meetingType">
            <div class="form-group">
                <label for="example-text-input" class="h5">Select Meeting Type<span class="text-danger" style="font-size:20px">*</span></label>
                <select name="meetingType" class="selectpicker form-control" data-style="py-0" id="meetingType" required>
                    <option>Select Meeting Type</option>
                    <option value="offline">Offline</option>
                    <option value="online">Online</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 offlinefield" style="display: none;">
            <div class="form-group">
                <label for="location" class="h5">Enter Location<span class="text-danger" style="font-size:20px">*</span></label>
                <input type="text" name="location" id="location" class="form-control" placeholder="Enter location">
                <input type="hidden" name="activity" id="activity" class="form-control" value="meeting">
            </div>
        </div>
        <div class="col-lg-6 meeting-fields" style="display: none;">
            <div class="form-group">
                <label for="meetingLink" class="h5">Enter Meeting Link<span class="text-danger" style="font-size:20px">*</span></label>
                <input type="text" name="meetingLink" id="meetingLink" class="form-control" pattern="https?://\S+" placeholder="Enter meeting link">
            </div>
        </div>
        <div class="col-lg-6 employee-fields" style="display: none;">
            <div class="form-group">
                <label for="selectEmployee" class="h5">Select Employee<span class="text-danger" style="font-size:20px">*</span></label>
                <select id="selectEmployee" name="selectedMembers[]" class="selectpicker form-control" data-style="py-0" multiple required data-live-search='true'>
                    <option value="">Select Member</option>
                    <option value="all">Select All</option>
                    <?php
                    $query = "SELECT e.* FROM employee e WHERE e.active = 'active' AND e.Company_id = $companyId ORDER BY e.full_name";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $leavetype = $row['full_name'];
                            $roles = $row['user_role'];
                            echo '<option value="' . $id . '">' . $leavetype . '(' . $roles . ')' . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>No type found</option>';
                    }
                    ?>
                </select>
            </div>
            <p id="error" style='color: red;'></p>
        </div>
    </div>
    <div class="subject-fields" style="display: none;">
        <div class="form-group">
            <label for="subject" class="h5">Enter Subject<span class="text-danger" style="font-size:20px">*</span></label>
            <input type="text" name="meetingSubject" id="subject" class="form-control" placeholder="Enter the Subject" required pattern="[a-zA-Z]+(?:\s+[a-zA-Z]+)*">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
            <input type="submit" class="custom-btn1 btn-2 mr-3 text-center" value="Submit" name='add'>
        </div>
    </div>
</form>

<script>
document.getElementById('meetingType').addEventListener('change', function() {
    var meetingType = this.value;
    var locationField = document.getElementById('location');
    var meetingLinkField = document.getElementById('meetingLink');
    
    if (meetingType === 'offline') {
        locationField.required = true;
        meetingLinkField.required = false;
    } else if (meetingType === 'online') {
        locationField.required = false;
        meetingLinkField.required = true;
    } else {
        locationField.required = false;
        meetingLinkField.required = false;
    }
});
</script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php if (!empty($timeline)) : ?>
        <?php foreach ($timeline as $timelineItem) : ?>
         <!-- Rejections Modal -->
       
<div id="rejectModal<?= $timelineItem["id"] ?>" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="modal-title" id="exampleModalCenterTitle">Rejections List</h3>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div class="d-flex mb-5">
                    <button class="btn btn-yes mr-2" style="border-radius:12px;" onclick="filterResponses('all', <?= $timelineItem['id'] ?>)">All</button>
                    <button class="btn btn-success mr-2" style="background-color:green !important;" onclick="filterResponses('accepted', <?= $timelineItem['id'] ?>)">Accepted</button>
                    <button class="btn btn-danger" onclick="filterResponses('rejected', <?= $timelineItem['id'] ?>)">Rejected</button>
                </div>
                <?php 
                $sql = 'SELECT meetingaction.*, employee.id, employee.full_name 
                        FROM meetingaction 
                        JOIN employee ON meetingaction.user_id = employee.id
                        WHERE meetingaction.meeting_id = ' . $timelineItem['id'];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $title = $row['response'] == 'decline' ? 'Rejected' : 'Accepted';
                ?>
                    <div class="response-item" data-response="<?= $row['response'] == 'decline' ? 'rejected' : 'accepted' ?>">
                        <h6 class="mb-2"><b><?= $title ?> By</b> : <?= $row['full_name'] ?></h6>
                        <h6 class="text-justify"><b>Remark</b><br>&emsp;<?= $row['remark'] ?></h6>
                        <hr>
                    </div>
                <?php                    
                    }
                }
                ?>                    
            </div>
        </div>
    </div>
</div>

<script>
function filterResponses(filter, modalId) {
    var modal = document.getElementById('rejectModal' + modalId);
    var items = modal.getElementsByClassName('response-item');
    for (var i = 0; i < items.length; i++) {
        var item = items[i];
        if (filter === 'all') {
            item.style.display = 'block';
        } else if (filter === 'accepted' && item.getAttribute('data-response') === 'accepted') {
            item.style.display = 'block';
        } else if (filter === 'rejected' && item.getAttribute('data-response') === 'rejected') {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    }
}
</script>

           
            <!-- Rejections Modal -->           

            <?php
            $day = date('Y-m-d\TH:i', strtotime($timelineItem['start_time']));
            $day1 = date('d-m-Y', strtotime($timelineItem['start_time']));
            $modalId = "taskDetails{$i}";
            $end_time = ($timelineItem['end_time']);
            ?>

            <!-- Edit Schedule -->
            <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="editModal<?= $timelineItem['id'] ?>">
                <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-block text-center pb-3 border-bttom">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="modal-title" id="exampleModalCenterTitle">Edit Schedule</h3>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="timeline.php?editid=1" method="POST">
                                        <div class="form-group mb-3">
                                            <label for="exampleInputText2" class="h5">Project Name</label>
                                            <select name="projectid" class="selectpicker form-control" data-style="py-0" id="projectSelect" required>
                                                <option value="0">Others</option>
                                                <?php
                                                $query = "SELECT * FROM projects ORDER BY project_name";
                                                $result = mysqli_query($conn, $query);

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $projectId = $row['id'];
                                                        $projectName = $row['project_name'];
                                                        $selected = ($timelineItem['project_id'] == $projectId) ? 'selected' : '';

                                                        echo '<option value="' . $projectId . '"' . $selected . '>' . $projectName . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="" disabled>No projects found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>                                        
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="startDate" class="h5">Meeting Date<span class="text-danger" style="font-size:20px">*</span></label>
                                                    <input class="form-control" type="date" name="startdate" id="startDate" required value="<?= isset($timelineItem['end_time']) ? date('Y-m-d', strtotime($timelineItem['end_time'])) : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="startTime" class="h5">Start Time<span class="text-danger" style="font-size:20px">*</span></label>
                                                    <input class="form-control" type="time" name="startTime" id="startTime" required value="<?= isset($timelineItem['start_time']) ? date('H:i', strtotime($timelineItem['start_time'])) : ''; ?>">
                                                    <input type="hidden" name="timelineid" id="timelineId" value="<?= $timelineItem['id'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="endTime" class="h5">End Time<span class="text-danger" style="font-size:20px">*</span></label>
                                                    <input class="form-control" type="time" name="endTime" id="endTime" required value="<?= isset($timelineItem['end_time']) ? date('H:i', strtotime($timelineItem['end_time'])) : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php if ($timelineItem['activity'] == "meeting") { ?>
                                                <div class="col-lg-12 ">
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="h5">Select Meeting Type</label>
                                                        <select name="meetingType" class="selectpicker form-control" data-style="py-0" id="meetingType<?= $timelineItem['id'] ?>" required onchange="selectType<?= $timelineItem['id'] ?>(this.value)">
                                                            <option>Select Meeting Type</option>
                                                            <option <?php echo ($timelineItem['meeting_type'] == 'offline') ? 'selected' : ''; ?> value="offline">Offline</option>
                                                            <option <?php echo ($timelineItem['meeting_type'] == 'online') ? 'selected' : ''; ?> value="online">Online</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                selectType<?= $timelineItem['id'] ?>(document.getElementById('meetingType<?= $timelineItem['id'] ?>').value);
                                            });

                                            function selectType<?= $timelineItem['id'] ?>(selectedValue) {
                                                if (selectedValue == 'offline') {
                                                    $("#offline<?= $timelineItem['id'] ?>").show();
                                                    $("#online<?= $timelineItem['id'] ?>").hide();
                                                } else if (selectedValue == 'online') {
                                                    $("#offline<?= $timelineItem['id'] ?>").hide();
                                                    $("#online<?= $timelineItem['id'] ?>").show();
                                                }
                                            }
                                        </script>

                                        <div class="row">
                                            <div class="col-lg-12" id="offline<?= $timelineItem['id'] ?>">
                                                <div class="form-group">
                                                    <label for="meetingLink" class="h5">Enter Location(Optional)</label>
                                                    <input type="text" name="location" id="location" class="form-control" value="<?= isset($timelineItem["meeting_location"])?$timelineItem["meeting_location"]:'Enter location' ?>" >
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="online<?= $timelineItem['id'] ?>">
                                                <div class="form-group">
                                                    <label for="meetingLink" class="h5">Enter Meeting Link(Optional)</label>
                                                    <input type="text" name="meetingLink" id="meetingLink" class="form-control" value="<?= isset($timelineItem["meeting_link"])? $timelineItem["meeting_link"]:'https://meet.google.com/sqh-wiad-hyr' ?>" pattern="https?://(?:[\w-]+\.)+[a-zA-Z]{2,}(?:/[\w-./?%&=]*)?">
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $employees = array();
                                        $sqlEmployees = "SELECT * FROM employee ORDER BY full_name ASC";
                                        $resultEmployees = $conn->query($sqlEmployees);
                                        if ($resultEmployees->num_rows > 0) {
                                            while ($row = $resultEmployees->fetch_assoc()) {
                                                $employees[] = $row;
                                            }
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-12 employee-fields">
                                                <div class="form-group">
                                                    <label for="selectEmployee" class="h5">Select Employee</label>
                                                    <select id="selectEmployee" name="selectedMembers[]" class="selectpicker form-control" data-style="py-0" multiple required data-live-search='true'>
                                                        <option value="">Select Member</option>
                                                        <option value="all">Select All</option>
                                                        <?php
                                                        foreach ($employees as $employee) {
                                                            $participateIds = explode(',', $timelineItem["participate_id"]);
                                                            $selected = (in_array($employee['id'], $participateIds)) ? 'selected' : '';
                                                            echo '<option value="' . $employee['id'] . '" ' . $selected . '>' . $employee['full_name'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($timelineItem['activity'] == "meeting") { ?>
                                            <div class="subject-fields">
                                                <div class="form-group">
                                                    <label for="subject" class="h5">Enter Subject</label>
                                                    <input type="text" name="meetingSubject" id="subject" class="form-control" required value="<?= $timelineItem['task_description'] ?>" pattern="[a-zA-Z]+(?:\s+[a-zA-Z]+)*">
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="col-lg-12">
                                            <div class="d-flex flex-wrap align-items-center justify-content-center mt-4">
                                                <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- Include SheetJS library -->
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#exportButton").click(function() {
                $("#datatable").table2excel({
                    exclude: ".noExl",
                    name: "Time_Schedule",
                    filename: "time_schedule",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true
                });
            });
        });
    </script>    
    <script>
        $(document).ready(function() {
            // Script for handling activity selection
            $("#activitySelect").change(function() {
                var selectedActivity = $(this).val();
                $(".taskDetails, .meetingType").hide();

                if (selectedActivity === "meeting") {
                    $(".meetingType").show();
                } else if (selectedActivity === "task") {
                    $(".taskDetails").show();
                }
            });

            // Script for handling meeting type selection
            $('#meetingType').change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === 'offline') {
                    $('.offlinefield, .employee-fields, .subject-fields').show();
                    $('.meeting-fields').hide();
                } else if (selectedOption === 'online') {
                    $('.offlinefield').hide();
                    $('.meeting-fields, .employee-fields, .subject-fields').show();
                } else {
                    $('.offlinefield').hide();
                    $('.meeting-fields').hide();
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectEmployee').change(function() {
                if ($(this).val() == 'all') {
                    $(this).find('option').not(':first').prop('selected', function(i, value) {
                        return !value;
                    });
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectEmployee').change(function() {
                if ($(this).val() == 'all') {
                    $(this).find('option').not(':first').prop('selected', function(i, value) {
                        return !value;
                    });
                }
            });
        });
    </script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript to handle AJAX request -->
    <script>
        $(document).ready(function() {
            $('#selectEmployee').change(function() {
                var employeeId = $(this).val();
                var startDate = $('#startTime').val();
                var endTime = $('#endTime').val();
                if (employeeId && startDate && endTime) {
                    var data = {
                        employeeId: employeeId,
                        startDate: startDate,
                        endTime: endTime
                    };
                    $.ajax({
                        url: 'timelinecheack.php',
                        type: 'POST',
                        data: data,
                        success: function(response) {
                            $('#error').text(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

    <script>
    document.getElementById('uploadButton').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('fileInput').click();
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const fileInput = document.getElementById('fileInput');
    const uploadButton = document.getElementById('uploadButton');
    const uploadForm = document.getElementById('uploadForm');

    // Enable the upload button when a file is selected
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            uploadButton.removeAttribute('disabled');
        }
    });

    // Trigger file input click when the upload button is clicked
    uploadButton.addEventListener('click', (event) => {
        event.preventDefault();
        fileInput.click();
    });

    // Submit the form when a file is selected
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            uploadForm.submit();
        }
    });
});
    </script>
    <script>
        const startDateInput = document.getElementById('startTime');
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
</body>
</html>