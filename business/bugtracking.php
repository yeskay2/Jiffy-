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
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Request | Jiffy</title>

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
        #searchbar1 {
            display: none;
        }
       .btn-group {
        display: flex;
        flex-direction: row;
    }

    .btn {
        flex: 1; 
    }

    .pass-btn.hidden {
        display: none;
    }

    .fail-btn.hidden {
        display: none; 
    }
    </style>
</head>


<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center"></div>
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
                     <div class="col-md-6 col-lg-4" onclick="window.location.href='recruitment.php?model=totalrequirement'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Total Testing</h5>
                                    <div id="circle-progress-01" class="circle-progress circle-progress-success d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="40" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-11%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z" />
                                    </svg>
                                    <span class="counter" id="teamrequried">
                                   <?php
                                        $stmt = $conn->prepare("SELECT SUM(number) AS count FROM teamrequried WHERE completed = 0 AND Company_id = ?");
                                        $stmt->bind_param("i", $companyId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();                                      
                                        if ($row && $row['count'] !== null) {
                                            echo $row['count'];
                                        } else {
                                            echo 0;
                                        }
                                        ?>                                  
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" onclick="window.location.href='recruitment.php?model=totalrequirement'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Total Retesting</h5>
                                    <div id="circle-progress-02" class="circle-progress circle-progress-success d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="60" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-11%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z" />
                                    </svg>
                                    <span class="counter" id="teamrequried">
                                   <?php
                                        $stmt = $conn->prepare("SELECT SUM(number) AS count FROM teamrequried WHERE completed = 0 AND Company_id = ?");
                                        $stmt->bind_param("i", $companyId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();                                      
                                        if ($row && $row['count'] !== null) {
                                            echo $row['count'];
                                        } else {
                                            echo 0;
                                        }
                                        ?>                                  
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" onclick="window.location.href='recruitment.php?model=totalrequirement'" style="cursor: pointer;">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body p-4">
                                <div class="top-block d-flex justify-content-between">
                                    <h5>Total Project</h5>
                                    <div id="circle-progress-03" class="circle-progress circle-progress-success d-flex flex-column align-items-center justify-content-center" data-min-value="0" data-max-value="100" data-value="60" data-type="percent">
                                    </div>
                                </div>
                                <h4 style="margin-top:-11%;"><svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 640 512" style="margin-right: 10px;">
                                        <path fill="#50c6b4" d="M96 0C60.7 0 32 28.7 32 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H96zM208 288h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H144c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM512 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V80zM496 192c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm16 144c0-8.8-7.2-16-16-16s-16 7.2-16 16v64c0 8.8 7.2 16 16 16s16-7.2 16-16V336z" />
                                    </svg>
                                    <span class="counter" id="teamrequried">
                                   <?php
                                        $stmt = $conn->prepare("SELECT SUM(number) AS count FROM teamrequried WHERE completed = 0 AND Company_id = ?");
                                        $stmt->bind_param("i", $companyId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();                                      
                                        if ($row && $row['count'] !== null) {
                                            echo $row['count'];
                                        } else {
                                            echo 0;
                                        }
                                        ?>                                  
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Bug Tracking</h4>
                                </div>
                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="New request">
                                    <a href="#" class="custom-btn1 btn-2  text-center" data-target="#new-task-modal" data-toggle="modal">Request</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr>
                                            <td>SI. No</td>
                                            <td>Project Name</td>
                                            <td>Bug Title</td>  
                                            <td>Testing Status</td>                                                  
                                            <td>Retesting Status</td>                                          
                                            <td>Assigned To</td>
                                             <td>Action</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                         <tr>
                                            <td>1</td>
                                            <td>Project X</td>
                                            <td>UI not responsive on mobile</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Pass or Fail">
                                                    <button type="button" class="btn btn-success pass-btn" onclick="toggleButtons('pass')" id='pass'>Pass</button>
                                                    <button type="button" class="btn btn-danger fail-btn" onclick="toggleButtons('fail')" id='fail'>Fail</button>
                                                </div>
                                            </td>
                                            <td>                                             
                                                <div class="btn-group" role="group" aria-label="Pass or Fail">
                                                    <button type="button" class="btn btn-success">Pass</button>
                                                    <button type="button" class="btn btn-danger">Fail</button>
                                                </div>                                               
                                            </td>
                                            <td>Jayamani</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="mr-2" data-toggle="tooltip" data-placement="top" title="Delete request">
                                                        <a href="#" data-toggle="modal" data-target="#deleteModal<?= $request['Id'] ?>" class="btn btn-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                    <div class="mr-2">
                                                        <a href="./requestdetials.php?id=<?= $request['Id'] ?>" class="btn btn-info" style="border-radius: 12px;" data-toggle="tooltip" data-placement="top" title="View request details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a href="./request.php?closed=<?= $request['Id'] ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ticket Closed">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                                                                                   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page end  -->
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="modal-title" id="exampleModalCenterTitle">New bug</h3>
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
                                <form action="" method="post" enctype="multipart/form-data" id="myForm" onsubmit="submitForm(event)">                                    
                                    <div id="hiringFields">
                                        <div class="form-group">
                                            <label class="h5">Bug Tittle<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="bugtittle" pattern="[A-Za-z\s]+" title="Only letters are allowed" placeholder="Enter required role">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Description<span class="text-danger" style="font-size:20px">*</span></label>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Time to Hire<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="date" name="time_to_hire">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Required Resources<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="number_of_resources" pattern="[0-9]+" title="Only numbers are allowed" placeholder="Enter required resources">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Description<span class="text-danger" style="font-size:20px">*</span></label>
                                            <textarea class="form-control" type="text" name="Description"  placeholder="Enter description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Select Department<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select name="department" class="form-control">
                                                <option value="IT">IT</option>
                                                <option value="Non IT">Non IT</option>
                                                <option value="HR">HR</option>
                                                <option value="Marketing">Marketing</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Select Assign To<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select id="selectEmployee" name="hirerequedto" class="selectpicker form-control" data-style="py-0" data-live-search=true>
                                                <option disable value=''>Select</option>
                                                <?php
                                                $query = "SELECT * FROM employee WHERE active= 'active' AND  Company_id ='$companyId' AND user_role = 'admin' ORDER BY  full_name";
                                                $result = mysqli_query($conn, $query);

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $employeeId = $row['id'];
                                                        $employeeName = $row['full_name'];
                                                        $roles = $row['user_role'];
                                                        echo '<option value="' . $employeeId . '">' . $employeeName . '(' . $roles . ')</option>';
                                                    }
                                                } else {
                                                    echo '<option value="" disabled>No employees found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <div id="otherFields" style="display: none;">                                    
                                        <div class="form-group">
                                            <label class="h5">Subject<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="request_subject1" placeholder="Enter subject">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Message<span class="text-danger" style="font-size:20px">*</span></label>
                                            <textarea class="form-control" name="request_message1" rows="5" placeholder="Enter message"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Select Assign To<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select id="selectEmployee" name="sendto1" class="selectpicker form-control" data-style="py-0" data-live-search=true>
                                                <option disable value=''>Select</option>
                                                <?php
                                                $query = "SELECT * FROM employee WHERE active= 'active' AND  Company_id ='$companyId' ORDER BY  full_name";
                                                $result = mysqli_query($conn, $query);

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $employeeId = $row['id'];
                                                        $employeeName = $row['full_name'];
                                                        $roles = $row['user_role'];
                                                        echo '<option value="' . $employeeId . '">' . $employeeName . '(' . $roles . ')</option>';
                                                    }
                                                } else {
                                                    echo '<option value="" disabled>No employees found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>                                
                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center" id="submitButton">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
        <script src="script/script.js"></script>
        <script>
        function toggleButtons(button) {
            const passButton = document.querySelector('.pass-btn');
            const failButton = document.querySelector('.fail-btn');
            
            if (button === 'pass') {
                failButton.classList.add('hidden');
                passButton.classList.remove('hidden');
                passButton.style.borderTopRightRadius = '10px';
                passButton.style.borderBottomRightRadius = '10px';
            } else if (button === 'fail') {
                passButton.classList.add('hidden');
                failButton.classList.remove('hidden');
                failButton.style.borderTopLeftRadius = '10px';
                failButton.style.borderBottomLeftRadius = '10px';
            }
        }
    </script>
</body>

</html>