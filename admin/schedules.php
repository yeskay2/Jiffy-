<?php
session_start();
include "./../include/config.php";
require_once "./database/insertdata.php";
$userid = $_SESSION["user_id"];
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (empty($userid)) {
    header("location:index.php");
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST['edit'])) {
         $scheduleManager->editSchedule();
    }else{
         $scheduleManager->addSchedule();
    }
   
} elseif (isset($_GET["id"]) && !empty($_GET["id"])) {
    $scheduleManager->deleteSchedule();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Company Details | Jiffy</title>

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
        .search-content {
            display: none;
        }

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
                           <?php
                            if (isset($companyId) && !empty($companyId)) {
                                $companyId = mysqli_real_escape_string($conn, $companyId);
                                $query = "SELECT * FROM schedules WHERE Company_id = '$companyId'";
                                $result = mysqli_query($conn, $query);
                                if ($result) {
                                    if (mysqli_num_rows($result) == 0) {
                                        ?>
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="header-title">
                                                <h4 class="card-title">Company Details</h4>
                                            </div>
                                            <div class="pl-3 btn-new" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add company details">
                                                <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-user-modal" data-toggle="modal">Add</a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo 'Error executing query: ' . mysqli_error($conn);
                                }
                                mysqli_free_result($result);
                            } else {
                                echo 'Invalid company ID.';
                            }
                            ?>


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center" role="grid" aria-describedby="user-list-page-info">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Company Name</th>
                                                <th>Logo</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $query = "SELECT * FROM schedules WHERE Company_id = '$companyId'";
                                        $result = mysqli_query($conn, $query);
                                        $i = 1;
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $time_in = date('h:i A', strtotime($row['time_in']));
                                                $time_out = date('h:i A', strtotime($row['time_out1']));
                                                $company_name = $row['Company_name'];
                                                $logo = $row['logo'];
                                                $id = $row['id'];
                                                $permonth_days = $row['permonth_days'];
                                                $perday_hours = $row['perday_hours'];
                                                $address = $row['address'];
                                                $mail = $row['emailid'];
                                                $id = $row['id'];
                                        ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $company_name; ?></td>
                                                        <td><img src="<?php echo $logo; ?>" alt="Company Logo" style="width: 50px; height: 50px; border-radius:50%"></td>
                                                        <td><?php echo $mail; ?></td>
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <div class="mr-2" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View company details">
                                                                    <button class="btn btn-yes" style="font-size:18px; border-radius: 12px;" data-target="#companyDetails" data-toggle="modal">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                </div>
                                                                <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Edit company details">
                                                                    <button class="btn btn-success" data-target="#editCompanyDetails" data-toggle="modal">
                                                                        <i class="ri-edit-line" style="font-size:18px;"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <div class="modal fade" role="dialog" aria-modal="true" id="editCompanyDetails">
    <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Edit Company Details</h4>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" name='edit'>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="company_name" class="control-label">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" value="<?php echo $company_name; ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="time_in" class="control-label">Time In</label>
                                <div class="bootstrap-timepicker">
                                    <input type="time" class="form-control timepicker" id="time_in" name="time_in" value="<?php echo $row['time_in']; ?>" required>
                                    <input type='hidden' value='<?=$id?>' name='schedule_id'>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="time_out" class="control-label">Time Out</label>
                                <div class="bootstrap-timepicker">
                                    <input type="time" class="form-control timepicker" id="time_out" name="time_out" value="<?php echo $row['time_out1']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $mail; ?>" required>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="address" class="control-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="permonth_days" class="control-label">Working Days</label>
                                <input type="number" class="form-control" id="permonth_days" name="permonth_days" value="<?php echo $permonth_days; ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="logo" class="control-label">Logo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                                    <label class="custom-file-label" for="logo">Choose file</label>
                                    
                                </div>
                                <img src='<?php echo $logo?>' width='50px'>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                   <input type="submit" class="custom-btn1 btn-2 mr-3 text-center" value="Submit" name='edit'>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                                        <?php
                                            }
                                        } else {
                                            echo '<tbody>
                                                    <tr>
                                                        <td colspan="6">No records found</td>
                                                    </tr>
                                                  </tbody>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page end  -->
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" aria-modal="true" id="new-user-modal">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Add Company Details</h4>
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
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="company_name" class="control-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="time_in" class="control-label">Time In</label>
                                    <div class="bootstrap-timepicker">
                                        <input type="time" class="form-control timepicker" id="time_in" name="time_in" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="time_out" class="control-label">Time Out</label>
                                    <div class="bootstrap-timepicker">
                                        <input type="time" class="form-control timepicker" id="time_out" name="time_out" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="company_name" class="control-label">Email Id</label>
                                    <input type="text" class="form-control" id="company_name" name="email" placeholder="Enter company email ID" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="company_name" class="control-label">Contact Number</label>
                                    <input type="text" class="form-control" id="contactno" name="contactno" pattern="\d{10}" title="Enter only numbers only" placeholder="Enter contact number" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="company_name" class="control-label">Address</label>
                                    <input type="text" class="form-control" id="company_name" name="address" placeholder="Enter company address" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="company_name" class="control-label">Working Days</label>
                                    <input type="text" class="form-control" id="permonth_days" name="permonth_days" pattern="\d{2}" title="Enter only two digit numbers" placeholder="Enter working days per month" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="logo" class="control-label">Logo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*" required>
                                        <label class="custom-file-label" for="inputGroupFile003">Upload logo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                        <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Details popup -->
    <div class="modal fade" id="companyDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Company Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Company Name : </b><?php echo $company_name; ?></p>
                    <p><b>Email : </b><?php echo $mail; ?></p>
                    <p><b>Time In : </b><?php echo $time_in; ?></p>
                    <p><b>Time Out : </b><?php echo $time_out; ?></p>
                    <p><b>Woking Days / Month : </b><?php echo $permonth_days; ?></p>
                    <p><b>Working Hours / Day : </b><?php echo $perday_hours; ?></p>
                    <p class="text-justify"><b>Address : </b><?php echo $address; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Details -->
   

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
        function viewProjectDetails(projectId) {

            $.ajax({
                type: "GET",
                url: "employeedetials.php",
                data: {
                    id: projectId
                },
                dataType: "html",
                success: function(data) {

                    $("#projectDetailsContent").html(data);

                    $("#viewProjectModal").modal("show");
                },
                error: function() {

                    alert("Failed to load project details.");
                },
            });
        }
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