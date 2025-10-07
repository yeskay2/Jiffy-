<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
error_reporting(E_ALL);
ini_set('display_errors', 1);
$Id = base64_decode(urldecode($_GET['id']));
$sql = "UPDATE `teamrequried` SET view = 1 WHERE Id = $Id";
$result = $conn->query($sql);

if (isset($_GET['id'])) {
    $Id = base64_decode(urldecode($_GET['id']));
    $Id = $conn->real_escape_string($Id);
    $sql = "SELECT request.*, employee.*, (SELECT full_name FROM employee WHERE id = request.forward) AS forward,
     (SELECT user_role FROM employee WHERE id = request.forward) AS user_role
            FROM teamrequried AS request
            JOIN employee AS employee ON request.TeamLead = employee.id
            WHERE request.Id = '$Id'"; 
    $result = $conn->query($sql);
    if ($result) {     
        $row = $result->fetch_assoc();       
        if ($row) {
            $employeename = $row['full_name']; 
            $employeeid =   $row['id']  ;     
            $roles = $row['user_role']; 
            $email = $row['email'];
            $resulttype = $row['type'];
            $date = $row['currentdate'];
            $tittle = $row['Subject'];
            $message = $row['Message'];
            $status = $row['Status'];
            $remark = $row['remark'];
            $forword = $row['forward'];
            $TeamLead = $row['TeamLead'];
            $user_role = $row['user_role']; 
            $RequiredRole = $row['RequiredRole'];
        } else {          
            echo "No data found for the provided ID.";
        }
    } else {       
        echo "Error executing the query: " . $conn->error;
    }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $remark = $_POST['description'];
    $assignedTo = isset($_POST['assignedTo']) ? $_POST['assignedTo'] : null;  
    $sql = "UPDATE `teamrequried` SET Status = '$status', remark = '$remark', forward = '$assignedTo' WHERE id = $Id";
    $result = $conn->query($sql);
    if ($result) {
        $_SESSION['success'] = "Status updated successfully";
        header("Location: requestdetials.php?id=$Id");
        exit();
    } 
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Requirement Details | Jiffy</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./../assets/images/jiffy-favicon.ico" />
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
                                                <button type='button' class='close'  data-dismiss='alert' aria-label='Close'>
                                                <i class='ri-close-line'></i>
                                            </button>
                                        </div>";
                        unset($_SESSION['success']);
                    }
                    ?>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex">
                                <div class="back-button">
                                    <a href="request.php">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                            <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="header-title mx-3">
                                    <h4 class="card-title">Request Details</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row" style="width: 575px;">Employee Id</th>
                                            <td colspan="5" class="text-left"><?=$employeeid?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Employee Name</th>
                                            <td colspan="5" class="text-left"><?=$employeename?></td>
                                        </tr>                                       
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Employee Email</th>
                                            <td colspan="5" class="text-left"><?=$email?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Request Type</th>
                                            <td colspan="5" class="text-left"><?php echo ($resulttype == 'request') ? 'Ticket' : $resulttype; ?></td>

                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Request On</th>
                                            <td colspan="5" class="text-left"><?=date("d-m-Y",strtotime($date))?></td>
                                        </tr>
                                         <tr>
                                            <th class="text-nowrap text-left" scope="row">Tittle</th>
                                            <td colspan="5" class="text-left" style="text-align: justify;">
                                                <?=isset($tittle)? ucfirst($tittle):''?>
                                                <?=isset($RequiredRole)?ucfirst($RequiredRole):''?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Description</th>
                                            <td colspan="5" class="text-left" style="text-align: justify;">
                                                <?=$message?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Status</th>
                                            <td colspan="5" class="text-left">
                                            <?=$status?><?php if(!empty($forword)){
                                                    echo "->$forword($user_role)";
                                            }?>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Remark</th>
                                            <td colspan="5" class="text-left">
                                            <?=$remark?>
                                            </td>
                                        </tr>                                   
                                        

                                        <tr>
                                            <td colspan="12">
                                                <div class="text-center">
                                                    <button type="button" class="custom-btn1 btn-2 mr-3 text-center" data-toggle="modal" data-target="#exampleModal">Set Action</button>
                                                </div>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header d-block text-center pb-3 border-bttom">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Set Action</h5>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button type="button" class="close" data-dismiss="modal" onClick="window.location.reload();">
                                                                            ×
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <form method="POST" name="adminaction">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="action">Choose Action</label>
                                                                                <select class="custom-select" class="form-control" name="status" required="" id="statusSelect">
                                                                                    <option value="">Choose...</option>
                                                                                    <?php if($TeamLead != $userid) { ?>
                                                                                    <option value="Approve">Approve</option>
                                                                                    <option value="Decline">Decline</option>
                                                                                    <?php } ?>
                                                                                    <option value="Forword">Forword</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                        <div class="form-group mb-3" id="forword" style="display: none;">
                                                                            <select id ="selectEmployee" name="assignedTo" class="selectpicker form-control" data-style="py-0" data-live-search=true>
                                                                                        <option disable value=''>Select Assign To</option>
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
                                                                            <div class="form-group mb-3">
                                                                                <label for="description">Action Description</label>
                                                                                <textarea id="textarea1" name="description" class="form-control" name="description" placeholder="Description" row="5" maxlength="500" required></textarea></p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3 ">
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-yes" name="update">Submit</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <script>    
                                                        document.getElementById('statusSelect').addEventListener('change', function () {
                                                            var status = this.value;   
                                                            
                                                            if (status === 'Forword') {
                                                                document.getElementById('forword').style.display = 'block';                                                      
                                                            } 
                                                        });
                                                    </script>
                                                        </div>
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
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
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

</body>

</html>
<?php } ?>