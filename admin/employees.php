<?php
session_start();
include "./../include/config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userid = $_SESSION["user_id"];

require_once "./../PHPMailer/PHPMailer.php";
require_once "./../PHPMailer/SMTP.php";
require_once "./../PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST["fullName"];
    $phoneNumber = $_POST["phoneNumber"];
    $dob = $_POST["dob"];
    $doj = $_POST["doj"];
    $password = md5($_POST["password"]);
    $email = $_POST["email"];
    $userType = $_POST["userType"];
    $userRole = $_POST["userRole"];
    $address = $_POST["address"];
    $userdpt = $_POST['userdpt'];
        
    $employeeidsql = "SELECT MAX(empid) as max_empid FROM employee WHERE Company_id = $companyId";
    $result = mysqli_query($conn, $employeeidsql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $max_empid = $row['max_empid'];

    if ($max_empid) {
        $empidWithoutPrefix = (int) substr($max_empid, 4);
        $next_empid = $empidWithoutPrefix + 1;
    } else {
        $next_empid = 1;
    }

    $employeeid = 'EMP-' . str_pad($next_empid, 4, '0', STR_PAD_LEFT);
  
    $checkQuery = "SELECT * FROM employee WHERE email = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "s", $email);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = 'Email already registered';
        header('location: employees.php');
        exit();
    }

    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] === UPLOAD_ERR_OK) {
        $profilePictureName = $_FILES["profilePicture"]["name"];
        $profilePictureTmpName = $_FILES["profilePicture"]["tmp_name"];
        $uploadDir = "./../uploads/employee/";
        $uploadedProfilePicture = $uploadDir . basename($profilePictureName);
        move_uploaded_file($profilePictureTmpName, $uploadedProfilePicture);

        $query = "INSERT INTO employee (full_name,empid,phone_number, email, dob, password, doj, user_type, user_role, profile_picture, address, Company_id,department) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssssis", $fullName,$employeeid, $phoneNumber, $email, $dob, $password, $doj, $userType, $userRole, $profilePictureName, $address, $companyId,$userdpt);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            try {
                $sql = "SELECT * FROM schedules WHERE Company_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $companyId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $companyname = $row['Company_name'];

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'jiffymine@gmail.com';
                $mail->Password   = 'holxypcuvuwbhylj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('jiffymine@gmail.com', $companyname);
                $mail->addAddress($email, $fullName);
                $mail->isHTML(true);
                $mail->Subject = 'Welcome to ' . $companyname;
                $mail->Body    = 'Dear ' . $fullName . ',<br><br>
                                  Thank you for registering with ' . $companyname . '.<br>
                                  Your login details are:<br>
                                  Email: ' . $email . '<br>
                                  Password: ' . $_POST["password"] . '<br><br>
                                  Please keep this information safe.<br><br>
                                  Regards,<br>
                                  ' . $companyname . ' Team';

                $mail->send();
                $_SESSION['success'] = 'Employee details added successfully';
                header('location: employees.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                header('location: employees.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Something went wrong while adding';
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = 'File not uploaded';
    }

    mysqli_close($conn);
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Employees | Jiffy</title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.1/tagify.css">
    <style>
        .custom-btn1 i {
            font-size: 1.5rem; /* Adjust the icon size */
            color: #007bff;   /* Change the icon color */
        }
    </style>
    <style>
        @media(max-width:650px) {
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

        .status {
            background: #3d3399;
            color: white;
            padding: 5px 10px 5px 10px;
            border-radius: 16px;
            text-align: center;
        }

        #viewButton:hover {
            border: 2px solid #fff;
            border-radius: 12px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        #editButton:hover {
            border: 2px solid #fff;
            border-radius: 12px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .tagify{
            overflow : hidden;
            height: 75px ;
            resize: vertical;
            overflow-y: scroll;
        }
        .form-check{
            padding: 10px 20px 10px 40px;
        }
        .form-check:hover{
            cursor: pointer;
            background-color: #bde0fe;
            border-radius: 16px;
        }
        .form-check-label:hover, .form-check-input:hover{
            cursor: pointer;
        }
        .checkbox-container{
            padding: 10px;
            background-color: #f8f7f7;
            border: 1px solid #ced4da;
        }


        .status {
    cursor: pointer; /* Makes cursor change to hand symbol */
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
        include 'sidebar.php';
        include 'topbar.php';
        ?>

        <!--start dashboard--->
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
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                <h4 class="card-title">Employees</h4>
                                    <div class="d-flex align-items-center">
                                        <div class="list-grid-toggle d-flex align-items-center mr-3" style=" cursor:pointer;">
                                            <div data-toggle-extra="tab" data-target-extra="#grid" class="active">
                                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Grid view">
                                                    <div class="grid-icon mr-3" style="display: flex; align-items: center; justify-content: center;">
                                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="3" y="3" width="7" height="7"></rect>
                                                            <rect x="14" y="3" width="7" height="7"></rect>
                                                            <rect x="14" y="14" width="7" height="7"></rect>
                                                            <rect x="3" y="14" width="7" height="7"></rect>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <div data-toggle-extra="tab" data-target-extra="#list">
                                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="List view">
                                                    <div class="grid-icon" style="display: flex; align-items: center; justify-content: center;">
                                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <line x1="21" y1="10" x2="3" y2="10"></line>
                                                            <line x1="21" y1="6" x2="3" y2="6"></line>
                                                            <line x1="21" y1="14" x2="3" y2="14"></line>
                                                            <line x1="21" y1="18" x2="3" y2="18"></line>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pl-3 btn-new">
                                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new employee">
                                                    <a href="#" class="custom-btn1 btn-2 mr-2 text-center" data-target="#new-user-modal" data-toggle="modal">Add Employee</a>
                                                </div>
                                            </div>
                                            <div class="pl-2 btn-new">
                                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Invite new employee">
                                                    <a href="#" class="custom-btn1 btn-2 text-center" style="width:95px;" data-target="#new-user-modal2" data-toggle="modal">
                                                        Invite<!--<i class="fas fa-user-plus" style="line-height:40px; font-size:18px;"></i>-->
                                                    </a>
                                                </div>
                                                   
                                            </div>
                                            <div class="pl-2 btn-new">
                                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Download Employee Details">
                                                   <button id="exportBtn" class="custom-btn1 btn-2 text-center">Export to CSV</button>
                                                </div>
                                                   
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <div id="noResultsMessage" style="display: none;">
                                No results found
                            </div>
                        </div>

<div id="grid" class="item-content active" data-toggle-extra="tab-content">

    <div class="row" id="card1">
        <?php
        $query = "SELECT * FROM employee WHERE Company_id='$companyId' ORDER BY full_name ";
        $stmt = mysqli_query($conn, $query);

        if ($stmt && mysqli_num_rows($stmt) > 0) {
            $employees = [];
            while ($row = mysqli_fetch_array($stmt)) {
                $employees[] = $row;
        ?>
                <div class="col-lg-4 col-md-6 employee">
                    <div class="card-transparent card-block card-stretch card-height">
                        <div class="card-body text-center p-0">
                            <div class="item">
                                <div class="odr-img">
                                    <img src="./../uploads/employee/<?php echo $row["profile_picture"]; ?>" class="img-fluid rounded-circle avatar-90 m-auto" alt="image">
                                </div>
                                <div class="odr-content rounded" id="content">
                                    <h4 class="mb-2"><?php echo $row["full_name"]; ?></h4>
                                    <p class="mb-3"><?php echo $row["user_role"]; ?> - <?php echo isset($row["status"])?$row["status"]:'Offline'; ?></p>
                                    <ul class="list-unstyled mb-3">
                                        <a href="mailto:<?php echo $row["email"]; ?>" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Send mail">
                                            <li class="bg-secondary-light rounded-circle iq-card-icon-small mr-4"><i class="ri-mail-open-line m-0"></i></li>
                                        </a>
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo $row["phone_number"]; ?>" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Send message">
                                            <li class="bg-primary-light rounded-circle iq-card-icon-small mr-4"><i class="ri-chat-3-line m-0"></i></li>
                                        </a>
                                        <a href="tel:<?php echo $row["phone_number"]; ?>" data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Connect call">
                                            <li class="bg-success-light rounded-circle iq-card-icon-small"><i class="ri-phone-line m-0"></i></li>
                                        </a>
                                    </ul>
                                    <div class="pt-3 border-top">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="View employee details">
                                                <a class="mr-3" href="#" data-target="#modal_delete<?php echo  $row['id']; ?>" data-toggle="modal" id="viewButton">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Edit employee details">
                                                <a href="#" data-target="#modal_edit<?php echo  $row['id']; ?>" data-toggle="modal" id="editButton<?php echo  $row['id']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 576 512" style="fill:#c72f2e;">
                                                        <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal_delete<?php echo  $row['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header d-block text-center pb-3 border-bttom">
                                                    <div class="row">
                                                        <div class="col-lg-10">
                                                            <h4 class="modal-title"><?php echo $row['full_name']; ?>/<?php echo $row["empid"]; ?></h4>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                ×
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body" style="background-color: white; color:black;">
                                                    <img src="./../uploads/employee/<?php echo $row["profile_picture"]; ?>" class="img-fluid rounded-circle avatar-90 m-auto" alt="image">
                                                    <h4 class="mb-2 text-center"><?php echo $row["full_name"]; ?>/<?php echo $row["empid"]; ?></h4>
                                                    <p><b>Date of Birth:</b> <?php echo date("d-m-Y", htmlspecialchars(strtotime($row['dob']))); ?></p>
                                                    <p><b>Phone Number:</b> <?php echo $row["phone_number"]; ?></p>
                                                    <p><b>Email:</b> <?php echo $row["email"]; ?></p>
                                                    <p><b>User Type:</b> <?php echo $row["user_type"]; ?></p>
                                                    <p><b>User Role:</b> <?php echo $row["user_role"]; ?></p>
                                                    <p><b>Address:</b> <?php echo $row["address"]; ?></p>
                                                    <p><b>Joined Date:</b> <?php echo  date("d-m-Y", htmlspecialchars(strtotime($row['doj']))); ?></p>
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
                        }
                        // Pass the employee data to JavaScript
                        echo "<script>var employees = " . json_encode($employees) . ";</script>";
                    } ?>
                </div>
            </div>




                        <div id="list" class="item-content bg-white p-5 mb-5" style="border-radius:16px;" data-toggle-extra="tab-content">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped dataTable mt-4 text-center" style="width:100% !important;" role="grid" aria-describedby="user-list-page-info">
                                    <thead style="font-weight:bold;">
                                        <tr>
                                            <td>Emp ID</td>
                                            <td>Employee Name</td>
                                            <td>Email ID</td>
                                            <td>Contact Info</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM employee WHERE Company_id = '$companyId'";
                                        $stmt = mysqli_query($conn, $query);

                                        if ($stmt && mysqli_num_rows($stmt) > 0) {
                                            while ($row = mysqli_fetch_array($stmt)) {
                                        ?>
                                        <tr>
                                        <td><?=$row['empid']?></td>
                                            <td>
                                                <div class="media align-items-center">
                                                    <img src="./../uploads/employee/<?php echo $row["profile_picture"]; ?>" class="img-fluid rounded-circle avatar-45" alt="image">
                                                    <h6 class="ml-4"><?php echo $row["full_name"]; ?></h6>
                                                </div>
                                            </td>
                                            <td style="text-align:left;"><?php echo $row["email"]; ?></td>
                                            <td>
                                                <div class="media align-items-center justify-content-center">

                                                    <style>
    .iq-card-icon-small:hover {
        transform: scale(1.1); /* Zooms in slightly */
    }
</style>

    <!-- Email Icon -->
    <a href="#" id="sendMailLink" data-email="<?php echo $row["email"]; ?>" title="Send mail">
        <div class="bg-secondary-light rounded-circle iq-card-icon-small mr-3"
             style="transition: transform 0.3s; cursor: pointer;">
            <i class="ri-mail-open-line m-0"></i>
        </div>
    </a>

    <!-- WhatsApp Icon -->
    <a href="https://api.whatsapp.com/send?phone=<?php echo $row["phone_number"]; ?>" title="Send message">
        <div class="bg-primary-light rounded-circle iq-card-icon-small mr-3"
             style="transition: transform 0.3s; cursor: pointer;">
            <i class="ri-chat-3-line m-0"></i>
        </div>
    </a>

    <!-- Phone Icon -->
    <a href="tel:<?php echo $row["phone_number"]; ?>" title="Connect call">
        <div class="bg-success-light rounded-circle iq-card-icon-small"
             style="transition: transform 0.3s; cursor: pointer;">
            <i class="ri-phone-line m-0"></i>
        </div>
    </a>
</div>
                                            </td>
                                            <td>
                                                <div data-toggle="tooltip" data-placement="left" data-trigger="hover" title="">
                                                    <form id="myForm_<?php echo $row['id']; ?>" method="POST" action="updatestatus.php">
                                                        <input type="hidden" name="employee_id" value="<?php echo $row['id']; ?>">
                                                        <select id="status" name="status" class="status">
                                                            <option value="active" <?php if ($row['active'] == 'active') echo 'selected'; ?>>Active</option>
                                                            <option value="deactive" <?php if ($row['active'] == 'deactive') echo 'selected'; ?>>Deactive</option>
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal<?php echo  $row['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header d-block text-center pb-3 border-bottom">
                                                        <div class="row">
                                                            <div class="col-lg-10">
                                                                <h4 class="modal-title"><?php echo $row['full_name']; ?></h4>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                    ×
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body" style="background-color: white; color:black;">
                                                        <img src="./../uploads/employee/<?php echo $row["profile_picture"]; ?>" class="img-fluid rounded-circle avatar-90 m-auto" alt="image">
                                                        <h4 class="mb-2 text-center"><?php echo $row["full_name"]; ?></h4>
                                                        <p class="text-center">Date of Birth: <?php echo date("d-m-Y", htmlspecialchars(strtotime($row['dob']))); ?>'</p>
                                                        <p class="text-center">Phone Number: <?php echo $row["phone_number"]; ?></p>
                                                        <p class="text-center">Email: <?php echo $row["email"]; ?></p>
                                                        <p class="text-center">User Type: <?php echo $row["user_type"]; ?></p>
                                                        <p class="text-center">User Role: <?php echo $row["user_role"]; ?></p>
                                                        <p class="text-center">Address: <?php echo $row["address"]; ?></p>
                                                        <p class="text-center">Joined Date: <?php echo  date("d-m-Y", htmlspecialchars(strtotime($row['doj']))); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Page end  -->
                    </div>
                </div>
            </div>



            <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-user-modal">
                <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Employee</h4>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" class="close" data-dismiss="modal">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                        <label for="fullName">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="fullName" placeholder="Enter name" required pattern="^[^\s]+$" title="Name should not contain spaces">

<script>
    document.getElementById("name").addEventListener("keydown", function(e) {
        if (e.key === " ") {
            e.preventDefault();
        }
    });
</script>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" placeholder="Date of birth" onfocus="(this.type='date')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="phoneNumber">Phone Number</label>
                                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" onkeypress="return onlyNumberKey(event)" maxLength="10" minLength="10" placeholder="Enter phone number" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address." required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Password must contain at least one letter, one number, one special character, and be at least 8 characters long." placeholder="Enter password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userType">Type</label>
                                            <select name="userType" class="selectpicker form-control" data-style="py-0" required>
                                                <option value="" disabled selected hidden>Select Type</option>
                                                <option value="Trainee">Trainee</option>
                                                <option value="Employee">Employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Role</label>
                                            <select name="userRole" class="selectpicker form-control" data-style="py-0" required data-live-search="true">
                                                <option disabled selected hidden>Select Role</option>
                                                <?php
                                                $sql = "SELECT * FROM roles WHERE Company_id = '$companyId'";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $roleName = $row["name"];
                                                        echo "<option value='$roleName'>$roleName</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No roles found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Date of Joining</label>
                                            <input type="date" class="form-control" name="doj" placeholder="Date of Joining" onfocus="(this.type='date')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Department</label>
                                            <select name="userdpt" class="selectpicker form-control" data-style="py-0" required data-live-search="true">
                                                <option disabled selected hidden>Select Department</option>
                                                <?php
                                                $sql = "SELECT * FROM department WHERE Company_id = '$companyId'";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $roleName = $row["name"];
                                                        $id = $row['id'];
                                                        echo "<option value='$id'>$roleName</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No roles found</option>";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3 custom-file-small">
                                            <label for="profilePicture">Upload Profile Picture</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" accept=".jpg, .jpeg" id="profilePicture" name="profilePicture" required>
                                                <label class="custom-file-label" for="profilePicture">Choose file (JPEG or JPG only)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Address" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $query = "SELECT * FROM employee WHERE Company_id = '$companyId'";
            $stmt = mysqli_query($conn, $query);

            if ($stmt && mysqli_num_rows($stmt) > 0) {
                while ($row = mysqli_fetch_array($stmt)) {
            ?>

            <!-- Edit form -->
            <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="modal_edit<?php echo  $row['id']; ?>">
                <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-block text-center pb-3 border-bttom">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Edit <?=$row['full_name']?> Details</h4>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" class="close" data-dismiss="modal">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form action="updateuserprofile.php" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="fullName">Full Name</label>
                                            <input type="text" class="form-control" id="fullName" pattern="^[A-Za-z\s.]*$" title="Enter letters only" name="fullName" placeholder="Enter employee name" required value='<?php echo $row["full_name"]; ?>'>
                                            <input type='hidden' name='userid' value='<?=$row['id']?>'>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob" placeholder="Date of birth" onfocus="(this.type='date')" required value='<?php echo $row["dob"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="phoneNumber">Phone Number</label>
                                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" onkeypress="return onlyNumberKey(event)" maxLength="10" minLength="10" placeholder="Enter phone number" required value='<?php echo $row["phone_number"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address." required value='<?php echo $row["email"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"  title="Password must contain at least one letter, one number, one special character, and be at least 8 characters long." placeholder="Enter password" value='<?=$row['password']?>' readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userType">Type</label>
                                            <select name="userType" class="selectpicker form-control" data-style="py-0" required>
                                                <option value="" disabled selected hidden>Select Type</option>
                                                <option <?php echo ($row["user_type"] == 'Trainee') ? 'selected' : '' ?> value="Trainee">Trainee</option>
                                                <option <?php echo ($row["user_type"] == 'Employee') ? 'selected' : '' ?> value="Employee">Employee</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Role</label>
                                            <select name="userRole" class="selectpicker form-control" data-style="py-0" required data-live-search="true">
                                                <option disabled selected hidden>Select Role</option>
                                                <?php
                                                $roles = $row["user_role"];
                                                $sql = "SELECT * FROM roles WHERE Company_id = '$companyId'";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row1 = $result->fetch_assoc()) {
                                                        $roleName = $row1["name"];
                                                         $selected = ($roles == $roleName) ? 'selected' : '';
                                                        echo "<option value='$roleName' $selected>$roleName</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No roles found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Date of Joining</label>
                                            <input type="date" class="form-control" name="doj" placeholder="Date of birth" onfocus="(this.type='date')" required value='<?php echo $row["doj"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Department</label>
                                            <select name="userdpt" class="selectpicker form-control" data-style="py-0" required data-live-search="true">
                                                <option disabled selected hidden value="">Select Department</option>
                                                <?php
                                                $Department = $row['department'];
                                                $sql = "SELECT * FROM department WHERE Company_id = '$companyId'";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row2 = $result->fetch_assoc()) {
                                                        $roleName = $row2["name"];
                                                        $id = $row2['id'];
                                                         $selected = ($Department == $id) ? 'selected' : '';
                                                        echo "<option value='$id' $selected >$roleName</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No roles found</option>";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="salary">Salary</label>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Enter Salary" pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid salary amount." required value='<?php echo $row["salary"]; ?>'>
                                            <!-- pattern="^\d+(\.\d{1,2})?$" allows for numbers with optional decimal up to two places -->
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="account">Account Number</label>
                                            <input type="text" class="form-control" id="account" name="account" placeholder="Enter account number" pattern="[0-9A-Za-z\-]+" title="Please enter a valid account number (alphanumeric characters and hyphens)." required value='<?php echo $row["accountnumber"]; ?>'>
                                            <!-- pattern="[0-9A-Za-z\-]+" allows alphanumeric characters and hyphens -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3 custom-file-small">
                                            <label for="profilePicture">Upload Profile Picture</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" accept=".jpg, .jpeg" id="profilePicture" name="profilePicture">
                                                <label class="custom-file-label" for="profilePicture">Choose file (JPEG or JPG only)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="userRole">Address</label>
                                            <textarea class="form-control" name="address" placeholder="Address" required><?=$row['address']?></textarea>
                                        </div>
                                    </div>

                                    <!-- New checkboxes start here -->
                                  <?php
                                $userRoles = isset($row['Allpannel']) ? explode(",", $row['Allpannel']) : [];


                                $rolesToDisplay = ['Management', 'Accounts', 'Sales', 'Admin', 'Project Manager', 'Employee', 'Client', 'All'];
                                ?>

                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label for="userRole">Select Panel Access Control</label>
                                        <div class="checkbox-container">
                                            <div class="row d-flex col-lg-12">
                                                <?php foreach ($rolesToDisplay as $role): ?>
                                                    <div class="col-lg-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="<?php echo strtolower(str_replace(' ', '-', $role)); ?>" name="role[]" value="<?php echo $role; ?>" <?php echo in_array($role, $userRoles) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="<?php echo strtolower(str_replace(' ', '-', $role)); ?>"><?php echo $role; ?></label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <!-- New checkboxes end here -->

                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
<!-- Modal -->
    <div class="modal fade" id="new-user-modal2" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">Invite New Employees</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="invite-form" method="POST" action="invite.php">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="emails">Email Addresses</label>
                                    <textarea class="form-control" id="emails" name="emails" placeholder="Enter multiple email addresses separated by commas" required></textarea>
                                    <small id="emailsHelp" class="form-text text-muted">Separate multiple emails with commas (e.g., email1@example.com, email2@example.com)</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="invite-message">Invitation Message</label>
                                    <textarea class="form-control" id="invite-message" name="invite_message" rows="4" placeholder="Enter your invitation message" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Send Invitations</button>
                            </div>
                        </div>
                    </form>
                </div>               
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.1/tagify.min.js"></script>
    <script>        
        var input = document.querySelector('#emails');
        new Tagify(input, {
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/, 
            delimiters: ",",
            maxTags: 10, 
            blacklist: ["spam@domain.com"], 
        });

        function submitInvite() {
            const emails = input.value;
            const message = document.getElementById('invite-message').value;
            $('#new-user-modal2').modal('hide');
        } 
 </script>

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
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 2000);
        });
    </script>
    <script>
        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
    <script>
        function filterEmployees() {
            var searchValue = document.getElementById("taskSearchInput").value.toLowerCase();
            var employeeCards = document.querySelectorAll(".employee");
            var noResultsMessage = document.getElementById("noResultsMessage");
            var foundResultsForH4 = false;
            var foundResultsForP = false;
            employeeCards.forEach(function(card) {
                var employeeNameH4 = card.querySelector("h4").textContent.toLowerCase();
                if (employeeNameH4.includes(searchValue)) {
                    card.style.display = "block";
                    foundResultsForH4 = true;
                } else {
                    card.style.display = "none";
                }
                var employeeNameP = card.querySelector("p.mb-3").textContent.toLowerCase();
                if (employeeNameP.includes(searchValue)) {
                    card.style.display = "block";
                    foundResultsForP = true;
                }
            });

            if (foundResultsForH4 || foundResultsForP) {
                noResultsMessage.style.display = "none";
            } else {
                noResultsMessage.style.display = "block";
            }
        }
        document.getElementById("taskSearchInput").addEventListener("input", filterEmployees);
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("#sendMailLink").on("click", function(e) {
        e.preventDefault();

        var email = $(this).data("email");
        var confirmMessage = "Are you sure you want to send an email to " + email + "?";

        if (confirm(confirmMessage)) {
            window.location.href = "mailto:" + email;
        }
        });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".status").on("change", function() {
                var formId = $(this).closest("form").attr("id");
                $("#" + formId).submit();
            });
        });
    </script>
    <script>
        document.getElementById("taskSearchInput").addEventListener("input", function() {
            var searchValue = this.value.toLowerCase();
            var rows = document.querySelectorAll("#user-list-table tbody tr");

            rows.forEach(function(row) {
                var fullName = row.querySelector("h5").textContent.toLowerCase();
                if (fullName.includes(searchValue)) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        });
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
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function submitInvite() {
            const emails = document.getElementById('emails').value;
            const message = document.getElementById('invite-message').value;
            console.log('Emails:', emails);
            console.log('Message:', message);         
            $('#new-user-modal').modal('hide');
        }
    </script>
    

<!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
    <script>
document.getElementById('exportBtn').addEventListener('click', function() {
    if (employees.length > 0) {
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Full Name,Email,User Role\n";
        
        employees.forEach(function(employee) {
            let row = `${employee.full_name},${employee.email},${employee.user_role}\n`;
            csvContent += row;
        });
        
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "employees.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        alert("No employee data available to export.");
    }
});
</script>

</body>

</html>