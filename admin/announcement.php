<?php
session_start();
include "./../include/config.php";
require './../PHPMailer/PHPMailer.php';
require './../PHPMailer/SMTP.php';
require './../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$userid = $_SESSION["user_id"];
if (empty($userid)) {
    header("Location: index.php");
    exit;
}

if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $query = "DELETE FROM announcements WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['success'] = 'Announcement deleted successfully';
        header('Location: announcement.php');
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong while deleting the announcement';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title =$_POST['tittle'];
    $content =  $_POST['dec'];
    $companyId = $companyId;

    if (empty($content)) {
        $_SESSION['error'] = 'Description cannot be empty';
        header('Location: announcement.php');
        exit();
    }

    $insertQuery = 'INSERT INTO announcements (announcement_title, announcement_content, Company_id) VALUES (?, ?, ?)';
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sss", $title, $content, $companyId);
    $result = mysqli_stmt_execute($stmt);
    $sql = "SELECT * FROM `schedules` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $companyId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $companyname = isset($row['Company_name']) ? $row['Company_name'] : '';
    $companylogo = isset($row['logo']) ? $row['logo'] : '';


    if ($result) {
        $mailer = new PHPMailer(true);

        try {
            $mailer->isSMTP();
            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = 'jiffymine@gmail.com';
            $mailer->Password = 'holxypcuvuwbhylj';
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;

            

           $message = '
  <!DOCTYPE html>
    <html>
    <head>
        <title>Important Announcement</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f7f7f7;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #00698f;
                color: #fff;
                padding: 20px;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .announcement {
                padding: 20px;
            }
            .announcement h2 {
                color: #00698f;
                font-weight: bold;
                margin-top: 0;
            }
            .announcement p {
                margin-bottom: 10px;
            }
            .announcement a {
                text-decoration: none;
                color: #00698f;
            }
            .announcement a:hover {
                text-decoration: underline;
            }
            .footer {
                text-align: center;
                padding: 20px;
                font-size: 12px;
                color: #666;
                border-top: 1px solid #ccc;
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }
            .footer img {
                height: 40px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>Important Announcement</h2>
            </div>
            <div class="announcement">
                <h2>' . $title . '</h2>
                <p>' . strip_tags($content) . '</p>
            </div>
            <div class="footer">
                <p>&copy; ' . date("Y") .' '. $companyname .' All rights reserved.</p>
                <img src="' . $companylogo . '" alt="Company Logo">
            </div>
        </div>
    </body>
    </html>';


            $employeeSql = "SELECT * FROM employee WHERE active='active' AND Company_id='4'";
            $employeeResult = mysqli_query($conn, $employeeSql);

            if (mysqli_num_rows($employeeResult) > 0) {
                while ($employeeRow = mysqli_fetch_assoc($employeeResult)) {
                    $email = 'jayam4413@gmail.com';
                    $name = $employeeRow['full_name'];
                   
                    $company = base64_decode($_COOKIE['companyname']);

                    $mailer->setFrom('jiffymine@gmail.com', $company);
                    $mailer->addAddress($email, $name);
                    $mailer->Subject = 'Important Announcement - ' . $title;
                    $mailer->isHTML(true);
                    $mailer->Body = $message;

                    $mailer->send();
                    $mailer->clearAddresses();  
                }

                $_SESSION['success'] = 'Announcement added successfully and email sent.';
                header('Location: announcement.php');
                exit();
            } else {
                $_SESSION['error'] = 'No active employees found.';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = 'Failed to add announcement.';
    }

    header('Location: announcement.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Announcements | Jiffy</title>

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
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h4 class="card-title">Announcements</h4>
                                </div>
                                <div class="pl-3 btn-new" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new announcement">
                                    <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-user-modal" data-toggle="modal">Add</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Announced Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM announcements WHERE Company_id = '$companyId'";
                                            $result = mysqli_query($conn, $query);
                                            $i = 0;
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id = $row['id'];
                                                    $title = $row['announcement_title'];
                                                    $dec = $row['announcement_content'];
                                                    $date = date('d-m-Y', strtotime($row['announcement_date']));
                                            ?>
                                                    <tr>
                                                        <td><?php echo ++$i ?></td>
                                                        <td><?php echo $title ?></td>
                                                        <td>
                                                            <?php
                                                            $content_limit = 100; // Adjust the character limit as needed
                                                            if (strlen($dec) > $content_limit) {
                                                                $short_desc = substr($dec, 0, $content_limit);
                                                                echo $short_desc . '...';
                                                            } else {
                                                                echo $dec;
                                                            }
                                                            ?>
                                                            <?php if (strlen($dec) > $content_limit) : ?>
                                                                <a href="#" data-toggle="modal" data-target="#readMoreModal<?php echo $id; ?>">Read More</a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo $date ?></td>
                                                        <td>
                                                            <div data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Delete announcement">
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
                                                                    <h4 class="modal-title">Delete Announcement</h4>
                                                                </div>
                                                                <div class="modal-body" style="background-color: white; color:black;">
                                                                    <h5 class="wordspace">Are you sure you want to delete this announcement?</h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                                    <a type="button" class="btn btn-yes" href="announcement.php?id=<?php echo $id; ?>">Yes</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Read More Modal -->
                                                    <div class="modal fade" id="readMoreModal<?php echo $id; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header d-block text-center pb-3 border-bttom">
                                                                    <div class="row">
                                                                        <div class="col-lg-11">
                                                                            <h5 class="modal-title"><?php echo $title; ?></h5><br>
                                                                            <hr>
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <button type="button" class="close" data-dismiss="modal">
                                                                                ×
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body" style="text-align: justify;padding: 25px;margin-top: -20px;">
                                                                        <?php echo $dec; ?>
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
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-block text-center pb-3 border-bttom">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Announcement</h4>
                        </div>
                        <div class="col-lg-4">
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
                                    <label for="title">Announcement Title<span style="color:red; margin-left:5px;">*</span></label>
                                    <input type="text" class="form-control" id="location" name="tittle" placeholder="Enter Announcement Title" required pattern="\S.*">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="userRole">Announcement Description</label>
                                    <textarea class="form-control" name="dec" id="editor1" rows="2" placeholder="Enter Announcement Content" required pattern="\S.*"></textarea>
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