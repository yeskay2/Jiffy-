<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userid = $_SESSION["user_id"];
require_once "./taskdata/insertdata.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskManager->applyLeave($userid);
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $taskManager->deleteLeave($id);
}elseif(isset($_GET["approve"])){
    $leaveid = $_GET["approve"];
    $status = 1;
    $sql = "UPDATE tblleaves set status='$status' where id='$leaveid '";
    $result = mysqli_query($conn, $sql);
    if($result ){
    $sql = "UPDATE tblleaves set status='$status' where id='$leaveid '";
    $result = mysqli_query($conn, $sql);
    }
    header('location:leave.php?date=manageleave');
    exit();
}elseif(isset($_GET["decline"])){
    $leaveid = $_GET["decline"];
    $status = 2;
    $sql = "UPDATE tblleaves set status='$status' where id='$leaveid '";
    $result = mysqli_query($conn, $sql);
    header('location:leave.php?date=manageleave');
    exit();
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Holidays | Jiffy</title>

    <!-- Favicon -->
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
          .search-content{
            display:none;
        }
    </style>
</head>

<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

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
                            <div class="col-md-6 col-lg-4" onclick="window.location.href='leave.php?date=date'" style="cursor: pointer;">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body p-4">
                                        <div class="top-block d-flex justify-content-between">
                                            <h5>Government Leave</h5>                    
                                        </div>
                                        <h4 class="mt-3 d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                                <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z"/>
                                            </svg>
                                            <span class="counter" id="teamrequried">
                                                <?php
                                                    $stmt = $conn->prepare("SELECT count(*) AS count FROM holiday WHERE leave_type = '1' AND Company_id = ?");
                                                    $stmt->bind_param("i", $companyId);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    echo ($row = $result->fetch_assoc()) ? $row["count"] : 0;
                                                ?>
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-6 col-lg-4" onclick="window.location.href='leave.php?date=Holidays'" style="cursor: pointer;">
                                    <div class="card card-block card-stretch card-height">
                                        <div class="card-body p-4">
                                            <div class="top-block d-flex justify-content-between">
                                                <h5>Company leave</h5>                   
                                            </div>
                                            <h4 class="mt-3 d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                                    <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z"/>
                                                </svg>
                                                <span class="counter" id="teamrequried">
                                                    <?php
                                                        $stmt = $conn->prepare("SELECT count(*) AS count FROM holiday WHERE leave_type != '1' AND Company_id = ?");
                                                        $stmt->bind_param("i", $companyId);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        echo ($row = $result->fetch_assoc()) ? $row["count"] : 0;
                                                    ?>
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4" onclick="window.location.href='leave.php?date=manageleave'" style="cursor: pointer;">
                                    <div class="card card-block card-stretch card-height">
                                        <div class="card-body p-4">
                                            <div class="top-block d-flex justify-content-between">
                                                <h5>Manage Leave</h5>                   
                                            </div>
                                            <h4 class="mt-3 d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                                    <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z"/>
                                                </svg>
                                                <span class="counter" id="teamrequried">
                                                    <?php                                                        
                                                      if ($_SESSION["id"] != 1) {
                                                        $stmt = $conn->prepare("SELECT count(*) AS count FROM tblleaves WHERE status = '0' AND Company_id = ? AND empid = ?");
                                                        $stmt->bind_param("ii", $companyId, $userid);
                                                    } elseif ($_SESSION["id"] == 2) {
                                                        $sql = "SELECT * FROM team WHERE leader = '$userid' AND Company_id = '$companyId'";
                                                        $resultTeam = $conn->query($sql);                                                                
                                                        if ($resultTeam && $resultTeam->num_rows > 0) {
                                                            $selectedid2 = [];
                                                            while ($rowEmployee = $resultTeam->fetch_assoc()) {
                                                                $selectedid2[] = $rowEmployee["employee"];
                                                            }
                                                            $selectedid2 = implode(',', $selectedid2);
                                                            $stmt = $conn->prepare("SELECT count(*) AS count FROM tblleaves WHERE status = '0' AND Company_id = ? AND empid IN ($selectedid2)");
                                                            $stmt->bind_param("i", $companyId);
                                                        } else {
                                                            echo 0;
                                                            exit;
                                                        }
                                                    } else {
                                                        $stmt = $conn->prepare("SELECT count(*) AS count FROM tblleaves WHERE status = '0' AND Company_id = ?");
                                                        $stmt->bind_param("i", $companyId);
                                                    }

                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    echo ($row = $result->fetch_assoc()) ? $row["count"] : 0;

                                                    $stmt->close();
                                                    ?>
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                   <?php if (isset($_GET['date']) && $_GET['date'] == 'date') { ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h4 class="card-title">Holidays List</h4>
                                </div>                               
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>holiday Name</th>       
                                                <th>startDate</th>                                          
                                                <th>endDate</th>                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM holiday WHERE Company_id='$companyId' AND leave_type = '1'";
                                            $result = mysqli_query($conn, $query);
                                            $i = 1;
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $title = $row['title'];
                                                    $date = date('d-m-Y',strtotime($row['start_date'])); 
                                                    $endDate = date('d-m-Y',strtotime($row['end_date'])); 
                                                    $id = $row['id'];                                              

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $title; ?></td>     
                                                        <td><?php echo $date; ?></td>   
                                                        <td><?php echo $endDate ; ?></td>                                                 
                                                        
                                                    </tr>                                                    
                                                   
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php } ?>
                    <?php if (isset($_GET['date']) && $_GET['date'] == 'Holidays') { ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h4 class="card-title">Holidays List</h4>
                                </div>                             
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>holiday Name</th>       
                                                <th>leave_range</th>                                          
                                                <th>Available leave</th>
                                                <th>Pending leave</th>                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php 
                                                    $currentMonth = date('Y-m');
                                                    $sql = "SELECT * FROM `holiday` WHERE company_id = $companyId AND leave_type = 2";
                                                    $result = $conn->query($sql);
                                                    if ($result) {
                                                        $i = 1;
                                                        while ($row = $result->fetch_assoc()) {
                                                            $leavetypeid = $row['id'];
                                                            $available_leave = $row['days_count']; 
                                                            $hours = $row['hours_per_duration'];                                             
                                                            $leave_sql = "SELECT SUM(days_count) AS count 
                                                                        FROM tblleaves 
                                                                        WHERE company_id = '$companyId' 
                                                                        AND leave_type = '$leavetypeid' 
                                                                        AND empid = '$userid' 
                                                                        AND MONTH(from_date) = MONTH(CURRENT_DATE()) 
                                                                        AND YEAR(from_date) = YEAR(CURRENT_DATE())";
                                                            $leave_result = $conn->query($leave_sql);

                                                            if ($leave_result && $leave_result->num_rows > 0) {
                                                                $leave_row = $leave_result->fetch_assoc();
                                                                $already_taken_leave_count = $leave_row['count'] ? $leave_row['count'] : 0;
                                                                $remaining_leave = $available_leave - $already_taken_leave_count;
                                                                
                                                                if ($remaining_leave <= 0) {
                                                                    $leave_sql2 = "SELECT * 
                                                                                FROM tblleaves  
                                                                                WHERE company_id = '$companyId'  
                                                                                AND leave_type = '$leavetypeid'  
                                                                                AND empid = '$userid' 
                                                                                AND MONTH(starttime) = MONTH(CURRENT_DATE())  
                                                                                AND YEAR(starttime) = YEAR(CURRENT_DATE())";
                                                                    $leave_result2 = $conn->query($leave_sql2);
                                                                    
                                                                    if ($leave_result2 && $leave_result2->num_rows > 0) {
                                                                        $leave_row2 = $leave_result2->fetch_assoc();
                                                                        $remaining_leave =0;
                                                                    } else {
                                                                        $remaining_leave = $hours??0;
                                                                    }
                                                                } else {
                                                                    $remaining_leave = $remaining_leave . ' Days';
                                                                }
                                                            } else {
                                                                $remaining_leave = $available_leave . ' Days';
                                                            }

                                                            $leave_range = $row['leave_range'];
                                                            $days = !empty($row['days_count']) ? $row['days_count'] . ' Days' : $row['hours_per_duration'] . ' Hours';     
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?= htmlspecialchars($row['title']) ?></td>      
                                                                <td><?php echo htmlspecialchars($leave_range); ?></td>   
                                                                <td><?php echo htmlspecialchars($days); ?></td>
                                                                <td><?php echo htmlspecialchars($remaining_leave); ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php } ?>
                     <?php if (isset($_GET['date']) && $_GET['date'] == 'manageleave') { ?>
                <div class="col-sm-12" id="applyLeave">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Manage Leaves</h4>
                            </div>
                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Apply for leave">
                                <a href="#" class="custom-btn1 btn-2  text-center" data-target="#new-task-modal" data-toggle="modal">Apply</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table data-table table-striped text-center">
                                    <thead class="thead-border">
                                        <tr class="fw-bold">
                                            <td>SI.No</td>
                                            <td width="120">Employee Name</td>
                                            <td>Leave Type</td>
                                            <td>Applied On</td>
                                            <td>Current Status</td>
                                            <td>View</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <?php
                                        $employeeArrayQuery = "SELECT employee FROM team WHERE leader = $userid AND Company_id = $companyId";
                                        $result = $conn->query($employeeArrayQuery);
                                        $employeeArray = [];

                                        while ($row = $result->fetch_assoc()) {
                                            $employeeArray[] = $row['employee'];
                                        }
                                        $employeeList = implode(',', $employeeArray);

                                        if ($_SESSION["id"] == 1) {
                                                    $sql = "SELECT tblleaves.id AS lid, employee.full_name, employee.empid, employee.id, tblleaves.empid as applyerid,
                                                            tblleaves.leave_type, tblleaves.posting_date, tblleaves.description, tblleaves.status, 
                                                            CASE WHEN holiday.id IS NULL THEN 'Others' ELSE holiday.title END AS title,
                                                            tblleaves.Company_id,
                                                            tblleaves.from_date, tblleaves.to_date, tblleaves.starttime, tblleaves.endtime  
                                                            FROM tblleaves
                                                            JOIN employee ON tblleaves.empid = employee.id 
                                                            LEFT JOIN holiday ON tblleaves.leave_type = holiday.id
                                                            WHERE tblleaves.Company_id = $companyId
                                                            ORDER BY lid DESC";
                                                } elseif ($_SESSION["id"] == 2) {
                                                    $sql = "SELECT tblleaves.id AS lid, employee.full_name, employee.id, tblleaves.empid as applyerid, employee.empid,
                                                            tblleaves.leave_type, tblleaves.posting_date, tblleaves.status, tblleaves.description, 
                                                            CASE WHEN holiday.id IS NULL THEN 'Others' ELSE holiday.title END AS title,
                                                            tblleaves.Company_id,
                                                            tblleaves.from_date, tblleaves.to_date, tblleaves.starttime, tblleaves.endtime
                                                            FROM tblleaves 
                                                            JOIN employee ON tblleaves.empid = employee.id 
                                                            LEFT JOIN holiday ON tblleaves.leave_type = holiday.id 
                                                            JOIN team ON tblleaves.empid IN ($employeeList)
                                                            WHERE team.leader = $userid AND tblleaves.Company_id = $companyId
                                                            ORDER BY lid DESC";
                                                } else {
                                                    $sql = "SELECT tblleaves.id AS lid, employee.full_name, employee.id,  tblleaves.empid as applyerid, employee.empid,
                                                            tblleaves.leave_type, tblleaves.posting_date, tblleaves.status, 
                                                            CASE WHEN holiday.id IS NULL THEN 'Others' ELSE holiday.title END AS title,
                                                            tblleaves.Company_id, tblleaves.description,
                                                            tblleaves.from_date, tblleaves.to_date, tblleaves.starttime, tblleaves.endtime
                                                            FROM tblleaves 
                                                            JOIN employee ON tblleaves.empid = employee.id
                                                            LEFT JOIN holiday ON tblleaves.leave_type = holiday.id 
                                                            WHERE tblleaves.empid = $userid AND tblleaves.Company_id = $companyId                               
                                                            ORDER BY lid DESC";
                                                }
                                        $result = mysqli_query($conn, $sql);
                                        $i = 1;
                                                ?>

                                    <tbody>
                                        <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row['full_name']; ?></td>
                                                    <td><?php echo $row['title']; ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($row['posting_date'])); ?></td>
                                                    <td>
                                                        <?php
                                                        $stats = $row['status'];
                                                        if ($stats == 1) {
                                                            echo '<span class="approve">Approved</span>';
                                                        } elseif ($stats == 2) {
                                                            echo '<span class="reject">Declined</span>';
                                                        } elseif ($stats == 0) {
                                                            echo '<span class="pending">Pending</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="#collapseDetails<?php echo $row['lid']; ?>" data-toggle="collapse" aria-expanded="false" aria-controls="collapseDetails<?php echo $row['lid']; ?>" class="leave-details-link">
                                                            <img class="img-fluid default-img" src="../assets/images/eyebrow.png" alt="eyeclose" style="width:40px;"/>
                                                            <img class="img-fluid hover-img" src="../assets/images/visibility.png" alt="eyeopen" style="width:40px; display:none;"/>
                                                        </a>
                                                    </td>
                                                    <?php if ($row['applyerid'] != $userid): ?>
                                                        <td>
                                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Approve or Decline leave">
                                                                <button type="button" class="btn btn-success" onclick="window.location.href='leave.php?approve=<?php echo $row['lid']; ?>'" <?php if ($stats != 0) echo 'disabled'; ?>>
                                                                    <i class="ri-check-line mr-0"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger" onclick="window.location.href='leave.php?decline=<?php echo $row['lid']; ?>'" <?php if ($stats != 0) echo 'disabled'; ?>>
                                                                    <i class="ri-close-line mr-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>
                                                            <div data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Delete the applied leave">
                                                                <button type="button" class="btn btn-danger" data-target="#modal_delete<?php echo $row['lid']; ?>" data-toggle="modal">
                                                                    <i class="ri-delete-bin-line mr-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <tr class="collapse" id="collapseDetails<?php echo $row['lid']; ?>">
                                                    <td colspan="7" style="text-align:left;">
                                                        <div class="card card-body" style="background-color: #f8f9fa; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                            <div class="col-lg-12 d-flex" style="margin-left:-15px;">
                                                                <div class="col-lg-3" style="margin-bottom: 10px;">
                                                                    <strong style="color: #000;">Employee ID:&nbsp;</strong>
                                                                        <span style="color: #333;"><?php echo $row['empid']; ?></span>
                                                                </div>
                                                                <div class="col-lg-3" style="margin-bottom: 10px;">
                                                                    <strong style="color: #000;">Leave Type:&nbsp;</strong>
                                                                    <span style="color: #333;"><?php echo $row['title']; ?></span>
                                                                </div>
                                                                <div class="col-lg-3" style="margin-bottom: 10px;">
                                                                    <strong style="color: #000;">Applied On:&nbsp;</strong>
                                                                    <span style="color: #333;"><?php echo date("d-m-Y", strtotime($row['posting_date'])); ?></span>
                                                                </div>
                                                                    <?php
                                                                    $fromdate = '';
                                                                    $enddate = '';
                                                                    if (isset($row['from_date']) && !empty($row['from_date'])) {
                                                                        $fromdate = date("d-m-Y", strtotime($row['from_date']));
                                                                    } elseif (isset($row['starttime']) && !empty($row['starttime'])) {
                                                                            $fromdate = date("d-m-Y h:i A", strtotime($row['starttime']));
                                                                    }
                                                                        if (isset($row['to_date']) && !empty($row['to_date'])) {
                                                                            $enddate = date("d-m-Y", strtotime($row['to_date']));
                                                                        } elseif (isset($row['endtime']) && !empty($row['endtime'])) {
                                                                            $enddate = date("d-m-Y h:i A", strtotime($row['endtime']));
                                                                        }
                                                                        $dateofleave = $fromdate . ' to ' . $enddate;
                                                                        ?>
                                                                <div class="col-lg-3" style="margin-bottom: 10px;">
                                                                    <strong style="color: #000;">Leave Date:&nbsp;</strong>
                                                                    <span style="color: #333;"><?php echo $dateofleave; ?></span>
                                                                </div>
                                                            </div>
                                                                        <div class="col-lg-12 mt-1">
                                                                            <strong style="color: #000;">Reason:</strong>
                                                                            <span style="color: #333;"><?php echo $row['description']; ?></span>
                                                                        </div>
                                                                        <div class="col-lg-12 mt-1 d-flex align-items-center justify-content-center" style="margin-bottom: 10px;">
                                                                            <strong style="color: #000;">Status:</strong>
                                                                            <span style="color: #333;">
                                                                                <?php
                                                                                if ($row['status'] == 1) {
                                                                                    echo '<span style="margin-left:10px; color: white; font-weight:bold; font-size:13px; background-color:green; padding:10px; border-radius:16px;">Approved</span>';
                                                                                } elseif ($row['status'] == 2) {
                                                                                    echo '<span style="margin-left:10px; color: white; font-weight:bold; font-size:13px; background-color:red; padding:10px; border-radius:16px;">Declined</span>';
                                                                                } elseif ($row['status'] == 0) {
                                                                                    echo '<span style="margin-left:10px; color: white; font-weight:bold; font-size:13px; background-color:blue; padding:10px; border-radius:16px;">Pending</span>';
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                <div class="modal fade" id="modal_delete<?php echo $row['lid']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete Leave</h4>
                                                            </div>
                                                            <div class="modal-body" style="background-color: white; color:black;">
                                                                <h5 class="wordspace">Are you sure you want to delete the leave you applied?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                                <a type="button" class="btn btn-yes" href="leave.php?id=<?php echo $row['lid']; ?>">Yes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="12" class="text-center">No records found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>                              

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php } ?>                    
                </div>                
            </div>
        </div>
    </div>

    <!-- Wrapper End-->

    <!-- Modal Start -->
    <!-- Modal for applying leave -->
<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="modal-title" id="exampleModalCenterTitle">Apply Leave</h3>
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
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="myForm" onsubmit="submitForm(event)">
    <div class="form-group mb-3">
        <label for="leaveType" class="h5">Leave Type<span class="text-danger" style="font-size:20px">*</span></label>
        <select name="leavetype" class="selectpicker form-control" data-style="py-0" required onchange="toggleLeaveFields()">
            <option value="" disable select hidden>Select Leave Type</option>
             <option value="Others" name='lopothers'>Others</option>
            <?php
$query = "SELECT * FROM holiday WHERE company_id = $companyId AND leave_type = 2";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $leavetype = $row['title'];
        $hours_per_duration = $row['hours_per_duration'];

        $leave_sql = "SELECT SUM(days_count) AS count 
                      FROM tblleaves 
                      WHERE company_id = '$companyId' 
                      AND leave_type = '$id' 
                      AND empid = '$userid' 
                      AND MONTH(from_date) = MONTH(CURRENT_DATE()) 
                      AND YEAR(from_date) = YEAR(CURRENT_DATE())";
        $leave_result = $conn->query($leave_sql);
        $leave_balance = 0;

        if ($leave_result && $leave_result->num_rows > 0) {
            $leave_row = $leave_result->fetch_assoc();
            $leave_balance = $leave_row['count'] ? $leave_row['count'] : 0;
        }

        $sql = "SELECT * FROM holiday WHERE company_id = $companyId AND id = $id";
        $result2 = $conn->query($sql);
        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $available_leave = $row2['days_count'] - $leave_balance;
            $hours = $row2['hours_per_duration'];

            if ($hours != null) {
                $leave_sql2 = "SELECT * 
                               FROM tblleaves  
                               WHERE company_id = '$companyId'  
                               AND leave_type = '$id'  
                               AND empid = '$userid' 
                               AND MONTH(starttime) = MONTH(CURRENT_DATE())  
                               AND YEAR(starttime) = YEAR(CURRENT_DATE())";
                $leave_result2 = $conn->query($leave_sql2);

                if ($leave_result2 && $leave_result2->num_rows > 0) {
                    $available_leave = 0;
                } else {
                    $available_leave = $hours;
                }
            }

            $disabled = $available_leave == 0 ? 'disabled' : '';
            echo '<option value="' . $id . '" data-hours="' . $hours_per_duration . '" ' . $disabled . '>' . $leavetype . ' (' . $available_leave . ')</option>';
        }
    }
} else {
    echo '<option value="" disabled>No type found</option>';
}
?>



        </select>
    </div>
    
    <div class="row" id="dateFields">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="fromdate" class="h5">Leave From<span class="text-danger" style="font-size:20px">*</span></label>
                <input class="form-control" type="date" data-inputmask="'alias': 'date'"  name="fromdate" id="fromdate" required value='0'>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="todate" class="h5">Leave To<span class="text-danger" style="font-size:20px">*</span></label>
                <input class="form-control" type="date" data-inputmask="'alias': 'date'"  name="todate" id="todate" required value='0'>
            </div>
        </div>
    </div>
    
    <div class="form-group"  id="timeFields" style="display:none;">
        <label for="fromtime" class="h5">Permission Start Time<span class="text-danger" style="font-size:20px">*</span></label>
        <input class="form-control" type="datetime-local" name="fromtime" id="fromtime"  required value='0'>
        <label for="totime" class="h5">Permission End Time<span class="text-danger" style="font-size:20px">*</span></label>
        <input class="form-control" type="datetime-local" name="totime" id="totime" readonly>
    </div>
    
    
    <div class="form-group">
        <label for="description" class="h5">Describe Your Reason<span class="text-danger" style="font-size:20px">*</span></label>
        <textarea class="form-control" name="description" id="editor1" rows="5"  pattern="^(?!\s*$).+"></textarea>
    </div>
    
    <div class="col-lg-12">
        <div class="d-flex flex-wrap align-items-center justify-content-center mt-4">
            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center" id="submitButton">Submit</button>
        </div>
    </div>
</form>

<script>
function toggleLeaveFields() {
    const leaveTypeSelect = document.querySelector('select[name="leavetype"]');
    const selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];
    const hoursPerDuration = selectedOption.getAttribute('data-hours');
    const startdateinputfield = document.getElementById('fromdate');
     const enddateinputfield = document.getElementById('todate');
     const fromtime = document.getElementById('fromtime');
     const totime = document.getElementById('totime');


    const dateFields = document.getElementById('dateFields');
    const timeFields = document.getElementById('timeFields');

    if (hoursPerDuration && hoursPerDuration !== 'null') {
        dateFields.style.display = 'none';
        timeFields.style.display = 'block';
        startdateinputfield.removeAttribute('required');
        enddateinputfield.removeAttribute('required');
    } else {
        dateFields.style.display = 'block';
        timeFields.style.display = 'none';
        fromtime.removeAttribute('required');
        totime.removeAttribute('required');

    }
}
</script>
<script>
        document.getElementById('fromtime').addEventListener('change', function() {
            const fromTime = document.getElementById('fromtime').value;

            if (fromTime) {
                const fromTimeDate = new Date(fromTime);
                const toTimeDate = new Date(fromTimeDate.getTime() + (60 * 60 * 1000));

                const year = toTimeDate.getFullYear();
                const month = String(toTimeDate.getMonth() + 1).padStart(2, '0');
                const day = String(toTimeDate.getDate()).padStart(2, '0');
                const hours = String(toTimeDate.getHours()).padStart(2, '0');
                const minutes = String(toTimeDate.getMinutes()).padStart(2, '0');

                const toTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                document.getElementById('totime').value = toTime;
            }
        });
    </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Modal end -->

    <!-- Footer -->
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
       <script>
function getUserLocationAndSend() {
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                const locationData = {
                    latitude: latitude,
                    longitude: longitude
                };

                fetch('locationupdate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(locationData)
                })
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw new Error('Failed to update location.');
                    }
                })
                .then(data => {
                    
                })
                .catch(error => {
                    console.error('Error updating location:', error);
                });
            },
            function(error) {
                console.log(`Error getting location: ${error.message}`);
            }
        );
    } else {
        console.log('Geolocation is not supported by this browser.');
    }
}

setInterval(getUserLocationAndSend, 5000);
</script>
</body>

</html>