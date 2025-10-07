<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require_once "./taskdata/insertdata.php";
require_once "./taskdata/feach.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userid = $_SESSION["user_id"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskManager->applyrequest($userid);
}

if (isset($_GET["requestid"])) {
    $id = $_GET["requestid"];
    $sql  = "DELETE FROM `teamrequried` WHERE Id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['error'] = "Request deleted successfully";
        header('Location:request.php');
        exit();
    }
}elseif(isset($_GET["closed"])){
    //Update status
    $id = $_GET["closed"];
    $sql  = "UPDATE `teamrequried` SET `status`='Ticket Closed' WHERE Id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['success'] = "Ticket closed successfully";
        header('Location:request.php');
        exit();

}
}
$statusid = $_SESSION["id"];
$requestdata = $projectManager->feachrequest($userid,'$statusid');
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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Request List</h4>
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
                                                <td>SI.No</td>
                                                <td>Sender Name</td>
                                                <td>Send To</td>  
                                                <td>Request Type</td>                                                  
                                                <td>Current Status</td> 
                                                <td>Ticket Id</td>                                                   
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php $sid = 0 ?>
                                        <?php foreach ($requestdata as $request) : ?>
                                            <tr>
                                                <td><?= ++$sid ?></td>
                                                <td><?= $request['full_name'] ?></td>
                                                <td><?= $request['sendtoname'] ?></td>      
                                                <td><?= isset($request['type']) && $request['type'] == 'request' ? 'Ticket' : ucfirst($request['type']) ?></td>                                          
                                                <td><?= isset($request['Status']) ? $request['Status'] : 'Pending' ?></td>        
                                                <td><?= isset($request['Ticket']) ? $request['Ticket'] : '' ?></td>                                                                                               
                                                <?php if ($request['TeamLead'] == $userid) : ?>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <?php if (isset($request['Status']) && $request['Status'] != 'Ticket Closed') : ?>
                                                                <div class="mr-2" data-toggle="tooltip" data-target="tooltip" data-placement="top" data-trigger="hover" title="Delete request">
                                                                    <a href="#" data-target="#deleteModal<?= $request['Id'] ?>" data-toggle="modal" class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Delete">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <a href="./requestdetials.php?id=<?= urlencode(base64_encode($request['Id'])) ?>" class="btn btn-yes" style="border-radius: 12px;" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View request details">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="ml-2">
                                                                    <a href="./request.php?closed=<?= $request['Id'] ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Ticket Closed">
                                                                        <i class="fas fa-check-circle"></i>
                                                                    </a>
                                                                </div>
                                                            <?php else : ?>
                                                                <div>
                                                                    <a href="./requestdetials.php?id=<?= urlencode(base64_encode($request['Id'])) ?>" class="btn btn-yes" style="border-radius: 12px;" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View request details">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                <?php else : ?>
                                                    <td>
                                                        <a href="./requestdetials.php?id=<?= urlencode(base64_encode($request['Id'])) ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                <?php endif; ?>                                                    
                                            </tr>
                                        


                                                <!-- Modal HTML -->
                                                <div id="deleteModal<?= $request['Id'] ?>" class="modal fade">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header flex-column">
                                                                <h4 class="modal-title w-100"><?= $request['full_name'] ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="wordspace">Do you really want to delete this Request?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                                <a href="request.php?requestid=<?= $request['Id'] ?>"><button type="button" class="btn btn-yes">Yes</button></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
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
                                <h3 class="modal-title" id="exampleModalCenterTitle">New Request</h3>
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
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText2" class="h5">Request Type<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="type" class="selectpicker form-control" data-style="py-0" required onchange="showFields(this.value)">
                                            <option value="" disable select hidden>Select Type</option>                                         
                                                <option value="hiring">Manpower</option>
                                                <option value="Infrastructure">Infrastructure</option>
                                                <option value="AC Issue">AC Issue</option>
                                                <option value="Network Issue">Network Issue</option>
                                                <option value="Software Issue">Software Issue</option>
                                                <option value="Hardware Issue">Hardware Issue</option>
                                                <option value="Electrical Issue">Electrical Issue</option>
                                                <option value="Plumbing Issue">Plumbing Issue</option>                                                                                           
                                                <option value="other">Other</option> 
                                             </select>
                                    </div>
                                    <div id="hiringFields" style="display: none;">
                                        <div class="form-group">
                                            <label class="h5">Required Role<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="required_roles" pattern="[A-Za-z\s]+" title="Only letters are allowed" placeholder="Enter required role">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Experience Required<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="required_experiences" pattern="[0-9]+" title="Only numbers are allowed" placeholder="Enter required experience">
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
                                            <textarea class="form-control" type="text" name="Description"  placeholder="Enter description" id='editor1'></textarea>
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
                                            <textarea class="form-control" name="request_message1" rows="5" placeholder="Enter message" id='editor2'></textarea>
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
                                    <div id="otherFields1" style="display: none;">
                                    <div class="form-group">
                                            <label class="h5">Specify Type<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="other_subject" placeholder="Specify the type">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Subject<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="request_subject" placeholder="Enter subject">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Message<span class="text-danger" style="font-size:20px">*</span></label>
                                            <textarea class="form-control" name="request_message" rows="5" placeholder="Enter message" id='editor3'></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Select Assign To<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select id="selectEmployee" name="sendto" class="selectpicker form-control" data-style="py-0" data-live-search=true>
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
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 2000);
            });
        </script>

        <script>
            CKEDITOR.replace('editor1');

            function validateForm() {
                var editorData = CKEDITOR.instances.editor1.getData().trim();
                if (!editorData) {
                    alert("Description is required.");
                    return false;
                }
                return true;
            }
        </script>
        <script>
            const fromDateInput = document.getElementById('fromdate');
            const toDateInput = document.getElementById('todate');

            function setMinDateForEndDate() {
                toDateInput.setAttribute('min', fromDateInput.value);
            }

            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = (today.getMonth() + 1).toString().padStart(2, '0');
                const day = today.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            fromDateInput.addEventListener('change', setMinDateForEndDate);
            document.getElementById('fromdate').setAttribute('min', getCurrentDate());
        </script>
        <script>
          function showFields(value) {         
            document.getElementById("hiringFields").style.display = "none";
            document.getElementById("otherFields").style.display = "none";      
          
            if (value === "hiring") {
                document.getElementById("hiringFields").style.display = "block";
            }else if(value === "other"){
                   document.getElementById("otherFields1").style.display = "block";
            } else {
                document.getElementById("otherFields").style.display = "block";
            }
        }
        </script>
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
         <script>
            CKEDITOR.replace('editor2');

            function validateForm() {
                var editorData = CKEDITOR.instances.editor1.getData().trim();
                if (!editorData) {
                    alert("Description is required.");
                    return false;
                }
                return true;
            }
        </script>
        <script>
            CKEDITOR.replace('editor3');

            function validateForm() {
                var editorData = CKEDITOR.instances.editor1.getData().trim();
                if (!editorData) {
                    alert("Description is required.");
                    return false;
                }
                return true;
            }
        </script>




</body>

</html>