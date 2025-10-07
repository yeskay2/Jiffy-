<?php
session_start();
include "./../include/config.php";

$userid = $_SESSION["user_id"];

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; 
}

// Delete Holiday
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM holiday WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $_SESSION['success'] = 'Holiday deleted successfully';
        header('location: addhoildays.php.php');
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong while deleting';
    }
}

// Add Holiday
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = "";
    $success = "";    
    $title = $_POST['leaveType'];
    $date = $_POST['startDate'];    
    $insertQuery = "INSERT INTO holiday (title, date) VALUES ('$title', '$date')";    
    $result = mysqli_query($conn, $insertQuery);
    if ($result) {
        $_SESSION['success'] = 'Holiday added successfully';
        header('location: addhoildays.php.php');
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong while adding';
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>holiday | Jiffy</title>

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
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h5>Holiday</h5>
                                </div>
                                <div class="pl-3 btn-new" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new event">
                                    <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-user-modal" data-toggle="modal">Add</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Leave Title</th>
                                                <th>Leave Detials</th>                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM tblleavetype";
                                            $result = mysqli_query($conn, $query);
                                            $i = 1;
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $title = $row['LeaveType'];
                                                    $date = $row['Description'];                                               

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $title; ?></td>
                                                        <td><?php echo $date; ?></td>                                                        
                                                        <td>
                                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Delete event">
                                                                <button type="button" class="btn btn-danger" data-target="#modal_delete<?php echo $id; ?>" data-toggle="modal">
                                                                    <i class="ri-delete-bin-line mr-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal for Delete Confirmation -->
                                                    <div class="modal fade" id="modal_delete<?php echo $id; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">holiday</h4>
                                                                </div>
                                                                <div class="modal-body" style="background-color: white; color:black;">
                                                                    <h5 class="wordspace">Are you sure you want to delete this holiday?</h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                                    <a type="button" class="btn btn-yes" href="events.php?id=<?php echo $id; ?>">Yes</a>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wrapper End-->

    <!-- Modal Start -->
     <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-user-modal">
        <div class="modal-dialog  modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Add holiday</h4>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="fullName">Leave Type</label>
                            <input type="text" class="form-control" id="leaveType" name="leaveType" placeholder="Enter Leave Type (e.g., Annual, Sick)">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="email">Date</label>
                            <input type="date" class="form-control" name="startDate" placeholder="Enter Start Date" required>
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