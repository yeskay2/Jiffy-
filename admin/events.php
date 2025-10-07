<?php
session_start();
include "./../include/config.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];
    $query = "DELETE FROM events WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['success'] = 'Event deleted successfully';
        header('Location: events.php');
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong while deleting event';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $startdate = mysqli_real_escape_string($conn, $_POST["startdate"]);
        $mode = mysqli_real_escape_string($conn, $_POST["mode"]);
        $starttime = mysqli_real_escape_string($conn, $_POST["starttime"]);
        $endtime = mysqli_real_escape_string($conn, $_POST["endtime"]);
        $dec = mysqli_real_escape_string($conn, $_POST["dec"]);
        $location = "";

        if ($mode == "Online") {
            $location = mysqli_real_escape_string($conn, $_POST["onlineLink"]);
            $type = 'Online';
        } elseif ($mode == "Offline") {
            $location = mysqli_real_escape_string($conn, $_POST["offlineLocation"]);
            $type = 'Offline';
        } else {
            $location = "Unknown";
        }

        $updateQuery = "UPDATE events SET title='$title', date='$startdate', event_mode='$mode', location='$location', start_time='$starttime', end_time='$endtime', detials='$dec' WHERE id='$id'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            $_SESSION['success'] = 'Event updated successfully';
            header('Location: events.php');
            exit();
        } else {
            $_SESSION['error'] = 'Something went wrong while updating event';
        }
    } else {
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $startdate = mysqli_real_escape_string($conn, $_POST["startdate"]);
        $mode = mysqli_real_escape_string($conn, $_POST["mode"]);
        $starttime = mysqli_real_escape_string($conn, $_POST["starttime"]);
        $endtime = mysqli_real_escape_string($conn, $_POST["endtime"]);
        $dec = mysqli_real_escape_string($conn, $_POST["dec"]);
        $location = "";

        if ($mode == "Online") {
            $location = mysqli_real_escape_string($conn, $_POST["onlineLink"]);
            $type = 'Online';
        } elseif ($mode == "offline") {
            $location = mysqli_real_escape_string($conn, $_POST["offlineLocation"]);
            $type = 'Offline';
        } else {
            $location = "Unknown";
        }

        $insertQuery = "INSERT INTO events (title, date, start_time, end_time, location, detials, Company_id, event_mode) 
                        VALUES ('$title', '$startdate', '$starttime', '$endtime', '$location', '$dec', '$companyId', '$type')";

        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['success'] = 'Event added successfully';
            header('Location: events.php');
            exit();
        } else {
            $_SESSION['error'] = 'Something went wrong while adding event';
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Events | Jiffy</title>

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

        form .form-group label:after {
    content: " *";
    color: red;
}
form input, form select, form textarea, form button {
    cursor: pointer;
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

<?php
$query = "SELECT * FROM events WHERE Company_id = '$companyId'";
$result = mysqli_query($conn, $query);
$i = 1;
$row_count = mysqli_num_rows($result);
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Events</h4>
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
                            <th>Event Title</th>
                            <th>Event Date</th>
                            <th>Event Time</th>
                            <th>Event Mode</th>
                            <th>Event Description</th>
                            <th>Event Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $row_count > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $title = $row['title'];
                                $date = $row['date'];
                                $start_time = $row['start_time'];
                                $location = $row['location'];
                                $details = $row['detials'];
                                $id = $row['id'];
                                $type = $row['event_mode'];
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $start_time; ?></td>
                                    <td><?php echo $type; ?></td>
                                    <td>
                                        <?php
                                        $details_limit = 100;
                                        if (strlen($details) > $details_limit) {
                                            $short_details = substr($details, 0, $details_limit);
                                            echo $short_details . '...';
                                        ?>
                                            <a href="#" data-toggle="modal" data-target="#readMoreModal<?php echo $id; ?>">Read More</a>
                                        <?php
                                        } else {
                                            echo $details;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $location; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="mr-2" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Edit event">
                                                <button class="btn btn-success" data-target="#editEvent_<?php echo $id; ?>" data-toggle="modal">
                                                    <i class="ri-edit-line" style="font-size:18px;"></i>
                                                </button>
                                            </div>
                                            <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Delete event">
                                                <button type="button" class="btn btn-danger" data-target="#modal_delete<?php echo $id; ?>" data-toggle="modal">
                                                    <i class="ri-delete-bin-line mr-0"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal for Delete Confirmation -->
                                <div class="modal fade" id="modal_delete<?php echo $id; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Event</h4>
                                            </div>
                                            <div class="modal-body" style="background-color: white; color:black;">
                                                <h5 class="wordspace">Are you sure you want to delete this Event?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                <a type="button" class="btn btn-yes" href="events.php?id=<?php echo $id; ?>">Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Read More Modal -->
                                <div class="modal fade" id="readMoreModal<?php echo $id; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Read More</h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo $details; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>No events found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if ($row_count > 0) { ?>
                <!-- Pagination here -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Your pagination logic here -->
                    </ul>
                </nav>
            <?php } ?>
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
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Event</h4>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                   <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group mb-3">
                <label for="fullName">Event Title</label>
                <input type="text" class="form-control" id="title" minlength="3" name="title" placeholder="Enter event title" required pattern="\S.*"> 
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group mb-3">
                <label for="email">Event Date</label>
                <input type="date" class="form-control" name="startdate" placeholder="Enter Event Date" required>
            </div>
        </div>      

        <div class="col-lg-6">
            <div class="form-group mb-3">
                <label for="mode">Event Mode</label>
                <select class="form-control" name="mode" id="modeSelect" required>
                    <option value="">Select Mode</option>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
            </div>
        </div>

        <div class="col-lg-6" id="onlineFields" style="display: none;">
            <div class="form-group mb-3">
                <label for="onlineLink">Online Link</label>
                <input type="url" class="form-control" id="onlineLink" name="onlineLink" placeholder="Enter online link">
            </div>
        </div>

        <div class="col-lg-6" id="offlineFields" style="display: none;">
            <div class="form-group mb-3">
                <label for="offlineLocation">Offline Location</label>
                <input type="text" class="form-control" id="offlineLocation" name="offlineLocation" placeholder="Enter offline location">
            </div>
        </div>
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="starttime" required>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="endtime" required>
        </div>
    </div>
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label for="userRole">Event Description</label>
                <textarea class="form-control" name="dec" id="editor1" placeholder="Enter event details" required pattern="\S.*"></textarea>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
            </div>
        </div>
    </div>
    <div id="error-messages" style="color: red;"></div>
</form>

<script>
    document.getElementById('modeSelect').addEventListener('change', function() {
        var mode = this.value;
        if (mode === 'Online') {
            document.getElementById('onlineFields').style.display = 'block';
            document.getElementById('offlineFields').style.display = 'none';
        } else if (mode === 'Offline') {
            document.getElementById('onlineFields').style.display = 'none';
            document.getElementById('offlineFields').style.display = 'block';
        } else {
            document.getElementById('onlineFields').style.display = 'none';
            document.getElementById('offlineFields').style.display = 'none';
        }
    });
</script>



                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <!-- Edit Event -->
   <?php
$query = "SELECT * FROM events WHERE Company_id = '$companyId'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($event = mysqli_fetch_assoc($result)) {
?>
<div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="editEvent_<?php echo $event['id']; ?>">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-block text-center pb-3 border-bttom">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Edit Event</h4>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">   
                <form action="#" method="post" enctype="multipart/form-data" name='edit'>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="fullName">Event Title</label>
                                <input type="text" class="form-control" id="title" minlength="3" name="title" placeholder="Enter event title" value="<?php echo $event['title']; ?>" required>
                                <input type='hidden' name='id' value='<?php echo $event['id']; ?>'>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="email">Event Date</label>
                                <input type="date" class="form-control" name="startdate" placeholder="Enter Event Date" value="<?php echo $event['date']; ?>" required>
                            </div>
                        </div>                       
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="mode">Event Mode</label>
                                <select class="form-control" name="mode" required id="modeSelect1">
                                    <option value="">Select Mode</option>
                                    <option value="Online" <?php if ($event['event_mode'] == 'Online') echo 'selected'; ?>>Online</option>
                                    <option value="Offline" <?php if ($event['event_mode'] == 'Offline') echo 'selected'; ?>>Offline</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6" id="onlineFields1" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="onlineLink">Online Link</label>
                                <input type="url" class="form-control" id="onlineLink" name="onlineLink" placeholder="Enter online link" value="<?php echo isset($event['event_mode']) && $event['event_mode'] == 'Online' ? $event['location'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-lg-6" id="offlineFields1" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="offlineLocation">Offline Location</label>
                                <input type="text" class="form-control" id="onlineLink" name="offlineLocation" placeholder="Enter online link" value="<?php echo isset($event['event_mode']) && $event['event_mode'] == 'Offline' ? $event['location'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="start_time">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="starttime" value="<?php echo $event['start_time']; ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="end_time">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="endtime" value="<?php echo $event['end_time']; ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="userRole">Event Description</label>
                                <textarea class="form-control" name="dec" id="editor2" placeholder="Enter event details" required><?php echo $event['detials']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                <input type="submit" class="custom-btn1 btn-2 mr-3 text-center" value="Submit" name='edit'>
                            </div>
                        </div>
                    </div>
                    <div id="error-messages" style="color: red;"></div>
                </form>
                <script>
                var mode = '<?php echo $event['event_mode']; ?>';
                if (mode === 'Online') {
                        document.getElementById('onlineFields1').style.display = 'block';
                        document.getElementById('offlineFields1').style.display = 'none';
                    } else if (mode === 'Offline') {
                        document.getElementById('onlineFields1').style.display = 'none';
                        document.getElementById('offlineFields1').style.display = 'block';
                    }
                document.getElementById('modeSelect1').addEventListener('change', function() {
                    var mode = this.value;
                    if (mode === 'Online') {
                        document.getElementById('onlineFields1').style.display = 'block';
                        document.getElementById('offlineFields1').style.display = 'none';
                    } else if (mode === 'Offline') {
                        document.getElementById('onlineFields1').style.display = 'none';
                        document.getElementById('offlineFields1').style.display = 'block';
                    } else {
                        document.getElementById('onlineFields1').style.display = 'none';
                        document.getElementById('offlineFields1').style.display = 'none';
                    }
                });
            </script>

            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>


    </div>
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
        CKEDITOR.replace('editor2');
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