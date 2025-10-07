    <?php

include "./../include/config.php";
if (isset($_GET['session_id'])) {
    $userid = $_GET['session_id'];
}

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $query = "SELECT * FROM employee WHERE id = '$userid'";
    $roleResult = mysqli_query($conn, $query);
    if ($roleResult && mysqli_num_rows($roleResult) > 0) {
        $roleRow = mysqli_fetch_assoc($roleResult);
        $id = htmlspecialchars($roleRow['id']);
        $name = htmlspecialchars($roleRow['full_name']);
        $email = htmlspecialchars($roleRow['email']);
        $dob = htmlspecialchars($roleRow['dob']);
        $phone_number = htmlspecialchars($roleRow['phone_number']);
        $address = htmlspecialchars($roleRow['address']);
        $userRole = htmlspecialchars($roleRow['user_role']);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $query = "UPDATE employee SET full_name = '$name', email = '$email', phone_number = '$phone_number', dob = '$dob', address = '$address' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Profile Updated successfully !!');
            window.location.href = 'dashboard.php';
        </script>";
        } else {
            $_SESSION['error'] = 'Failed,Try again';
            header('location: profile.php');
        }
    }
    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Profile | Jiffy</title>

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
        

        <!-- Wrapper Start -->
        <div class="wrapper">
            <?php
            include "sidebar.php";
            include "topbar.php";
            ?>

            <div class="content-page">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="iq-edit-list usr-edit">
                                        <ul class="iq-edit-profile d-flex nav nav-pills">
                                            <li class="col-md-6 p-0">
                                                <a class="nav-link active" data-toggle="pill" href="#personal-information">
                                                    Personal Information
                                                </a>
                                            </li>
                                            <li class="col-md-6 p-0">
                                                <a class="nav-link" data-toggle="pill" href="#chang-pwd">
                                                    Change Password
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="iq-edit-list-data">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <div class="iq-header-title">
                                                    <h4 class="card-title">Personal Information</h4>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <form action="profile.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                                                    <div class="row align-items-center">
                                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id; ?>">

                                                        <div class="form-group col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="fname">Full Name:</label>
                                                                <input type="text" class="form-control" id="fname" name="name" value="<?php echo $name; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="email">Email</label>
                                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter  Email" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="phoneNumber">Phone Number</label>
                                                                <input type="text" class="form-control" id="phoneNumber" value="<?php echo $phone_number; ?>" name="phone_number" onkeypress="return onlyNumberKey(event)" maxLength="10" minLength="10" placeholder="Enter phone number">
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-sm-6">
                                                            <div class="form-group mb-3">
                                                                <label for="dob">Date Of Birth:</label>
                                                                <input type="text" class="form-control" name="dob" placeholder="Date of birth" onfocus="(this.type='date')" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-sm-12">
                                                            <label>Address:</label>
                                                            <textarea class="form-control" name="address" rows="5" style="line-height: 22px;">
                                                                    <?php echo $address; ?>
                                                                    </textarea>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="custom-btn1 btn-2 mr-3 text-center">Submit</button>
                                                    <button type="reset" class="custom-btn1 btn-2 mr-3 text-center">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <div class="iq-header-title">
                                                    <h4 class="card-title">Change Password</h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form action="change_password.php" method="post">
                                                    <div class="form-group">
                                                        <label for="cpass">Current Password:</label>
                                                        <input type="password" class="form-control" id="cpass" name="current_password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="npass">New Password:</label>
                                                        <input type="password" class="form-control" id="npass" name="new_password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vpass">Verify Password:</label>
                                                        <input type="password" class="form-control" id="vpass" name="verify_password">
                                                    </div>
                                                    <button type="submit" class="custom-btn1 btn-2 mr-3">Submit</button>
                                                    <button type="reset" class="custom-btn1 btn-2 mr-3">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wrapper End-->
        <footer class="iq-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="   backend/privacy-policy.html">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="   backend/terms-of-service.html">Terms of Use</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 text-right">
                        <span class="mr-1">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>©
                        </span> <a href="#" class="">MINE</a>.
                    </div>
                </div>
            </div>
        </footer>
        <!-- Backend Bundle JavaScript -->
        <script src="   ./../assets/js/backend-bundle.min.js"></script>

        <!-- Table Treeview JavaScript -->
        <script src="   ./../assets/js/table-treeview.js"></script>

        <!-- Chart Custom JavaScript -->
        <script src="   ./../assets/js/customizer.js"></script>

        <!-- Chart Custom JavaScript -->
        <script async src="   ./../assets/js/chart-custom.js"></script>
        <!-- Chart Custom JavaScript -->
        <script async src="   ./../assets/js/slider.js"></script>

        <!-- app JavaScript -->
        <script src="   ./../assets/js/app.js"></script>

        <script src="   ./../assets/vendor/moment.min.js"></script>

        <!-- Script file -->
        <script src="script/script.js"></script>

    </body>

    </html>