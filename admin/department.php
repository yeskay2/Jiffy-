<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; 
}
if (isset($_GET["departmentId"]) && !empty($_GET["departmentId"])) {

    $departmentId = $_GET["departmentId"];

    $query = "DELETE FROM department WHERE id = $departmentId";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['success'] = 'Department deleted successfully';
        header('location: department.php');
        exit();
    } else {

        $_SESSION['error'] = 'Something went wrong while adding';
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = "";
    $sucess = "";
    $departname = $_POST['department'];
    $logo = $_FILES['projectImages']['name'];
    $logo_tmp = $_FILES['projectImages']['tmp_name'];


    $logo = preg_replace('/[()\d]+/', '_', $logo);
    $logo = preg_replace('/\..+$/', '', $logo);
    $logo_path = "./../uploads/department/" . $logo . ".webp";


    move_uploaded_file($logo_tmp, $logo_path);


    $insertQuery = "INSERT INTO department (name, logo,Company_id) VALUES ('$departname', '$logo_path','$companyId')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        $_SESSION['success'] = 'Department added successfully';
        header('location: department.php');
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
    <title>Department | Jiffy</title>

    <!-- Favicon -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <style>
           
         .search-content{
            display:none;
        }
   
        @media(max-width:650px){
          .bg-success {
        left:12%;
        }}
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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Departments</h4>
                                </div>
                                <div class="pl-3 btn-new">
                                    <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new department">
                                        <button type="button" class="custom-btn1 btn-2 mr-3 text-center" data-toggle="modal" data-target="#exampleModalCenteredScrollable">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Department Name</th>
                                                <th>Department Logo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $sql = "SELECT * FROM department WHERE Company_id ='$companyId'";
                                        $result = mysqli_query($conn, $sql);
                                        $i = 1;
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            echo '<tbody>';

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $departmentId = $row['id'];
                                                $name = $row['name'];
                                                $logo = $row['logo'];

                                                echo '<tr>';
                                                echo '<td>' .  $i++ . '</td>';
                                                echo '<td>' . $row['name'] . '</td>';
                                                echo '<td> <img class="rounded img-fluid avatar-40" src="./' . $logo . '" alt="' . $name . '"> </td>';
                                                echo '<td>
                                                        <div href="#" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Delete department"> 
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" rel="noopener" href="#myModal' . $departmentId . '" >                                                            
                                                                <i class="ri-delete-bin-line mr-0"></i>                                                            
                                                            </button>
                                                        </div>
                                                        </td>';
                                                echo '</tr>';
                                                echo    '<!-- Modal HTML -->
                                                <div id="myModal' . $departmentId . '" class="modal fade">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header flex-column">
                                                                <h4 class="modal-title w-100">' . $name . ' Department</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                            <h5 class="wordspace">Do you really want to delete this department ?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                                <a href="department.php?departmentId=' . $departmentId . '"><button type="button" class="btn btn-yes">Yes</button></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                            }

                                            echo '</tbody>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="exampleModalCenteredScrollable" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Department</h4>
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
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="department">Department *</label>
                                <input type="text" class="form-control" placeholder="Enter Department Name" name="department" required pattern="^[A-Za-z]+(\s[A-Za-z]+)*$">
                            </div>
                        </div>
                        <!-- Add Images Upload Field -->
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="projectImages">Attach Images *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept=".png,.jpg" name="projectImages" required>
                                    <label class="custom-file-label" for="projectImages">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Wrapper End-->
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