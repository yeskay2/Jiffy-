<?php
session_start();
include "./../include/config.php";
include "./../project/taskdata/feach.php";
include "./../project/taskdata/insertdata.php";
$userid = $_SESSION["user_id"];

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; 
}

$profiledata = $projectManager->profiledata($userid);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["updateprofile"])) {
        $taskManager->updateprofile($userid);
    }
    elseif(isset($_POST['updatepassword'])){
        $taskManager->updatepassword($userid);
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

    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
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
        @media (max-width:760px) {
            .mr-3,
            .mx-3 {
             margin-right: 0px !important;
            }
        }
          .search-content{
            display:none;
        }
        .fa-edit:before {
    content: "\f044";
    color: white !important;
    cursor:pointer;
}
    </style>
</head>

<body>
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

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
                                            <?php if (!empty($profiledata)): ?>
                                            <?php foreach ($profiledata as $profile) : ?>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row align-items-center">
                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $profile['id']; ?>">
                                                        <div class="col-md-12" style="align-items-center">
                                                               <div class="profile-img-edit ">
                                                                <div class="crm-profile-img-edit">
                                                                    <img class="crm-profile-pic rounded-circle avatar-100" id="profile-preview" src="./../uploads/employee/<?php echo $profile['profile_picture']; ?>" alt="profile-pic">
                                                                    <div class="crm-p-image bg-primary">
                                                                        <label for="profile-image-upload" class="fas fa-edit"></label>
                                                                        <input id="profile-image-upload" class="file-upload"  name ="image" type="file" accept="image/*" onchange="previewImage(this)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                                            
                                                    <div class="form-group col-sm-6 mt-3">
                                                        <div class="form-group mb-3">
                                                            <label for="fname">Full Name:</label>
                                                            <input type="text" class="form-control" id="fname" name="name" value="<?php echo $profile['full_name']; ?>" onkeypress="return onlyLetterKey(event)">
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-6 mt-3">
                                                        <div class="form-group mb-3">
                                                            <label for="email" >Email:</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $profile['email']; ?>" placeholder="Enter  Email" required>
                                                        </div>
                                                    </div>


                                                    <div class="form-group col-sm-4">
                                                        <div class="form-group mb-3">
                                                            <label for="phoneNumber">Phone Number:</label>
                                                            <input type="text" class="form-control" id="phoneNumber" value="<?php echo $profile['phone_number']; ?>" name="phone_number" onkeypress="return onlyNumberKey(event)" maxLength="10" minLength="10" placeholder="Enter phone number">
                                                        </div>
                                                    </div>                                                  


                                                    <div class="form-group col-sm-4">
                                                        <div class="form-group mb-3">
                                                            <label for="dob">Date Of Birth:</label>
                                                            <input type="text" class="form-control" name="dob" placeholder="Date of birth" onfocus="(this.type='date')" value="<?php echo $profile['dob']; ?>" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label for="salary">Salary:</label>
                                                        <input type="text" class="form-control" name="salary" placeholder="Salary" pattern="[0-9]+(\.[0-9]{2})?" title="Please enter a valid salary (e.g., 1000.00)" value="<?php echo $profile['salary']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                        <div class="form-group mb-3">
                                                            <label for="phoneNumber">Department :</label>
                                                            <input type="text" class="form-control" id="phoneNumber" value="<?php echo $profile['name']; ?>" name="dpt" onkeypress="return onlyNumberKey(event)" maxLength="10" minLength="10" placeholder="Enter phone number" readonly>
                                                        </div>
                                                    </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label for="role">Role:</label>
                                                        <input type="text" class="form-control" name="role" placeholder="Role" pattern="^[A-Za-z\s]+$"  title="Please enter a valid role (letters only)" value="<?php echo $profile['user_role']; ?>" required readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label for="role">Account Number:</label>
                                                        <input type="text" class="form-control" name="accountnumber" placeholder="Enter your account number" pattern="^[0-9]+$" title="Please enter a valid account number (numbers only)" value="<?php echo htmlspecialchars($profile['accountnumber']); ?>" required>
                                                    </div>
                                                </div>
                                                    <div class="form-group col-sm-12">
                                                        <label>Address:</label>
                                                        <textarea class="form-control" name="address" rows="5" style="line-height: 22px;">
                                                                <?php echo $profile['address']; ?>
                                                                </textarea>
                                                    </div>
                                                </div>

                                                <button type="submit" name="updateprofile" class="custom-btn1 btn-2 mr-3">Submit</button>
                                                <button type="reset" class="custom-btn1 btn-2 mr-3">Cancel</button>
                                            </form>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
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
                                                    <label for="vpass">Confirm Password:</label>
                                                    <input type="password" class="form-control" id="vpass" name="verify_password">
                                                </div>
                                                <button type="submit" name="updatepassword" class="custom-btn1 btn-2 mr-3">Submit</button>
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


   <?php
        include 'footer.php';
    ?>
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
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
        });

        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
                
        function onlyLetterKey(event) {
    const keyCode = event.keyCode || event.which;

    // Allow letters (uppercase and lowercase), space, and some common special characters
    if ((keyCode >= 65 && keyCode <= 90) || // A-Z
        (keyCode >= 97 && keyCode <= 122) || // a-z
        keyCode === 32 || // space
        keyCode === 8 || // backspace
        keyCode === 9 || // tab
        keyCode === 46 || // delete
        (keyCode >= 37 && keyCode <= 40)) { // arrow keys
        return true;
    } else {
        return false;
    }
}    
</script>
 <script>
        function previewImage(input) {
        var preview = document.getElementById('profile-preview');
         var file = input.files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
        preview.src = reader.result;
        };
        if (file) {
        reader.readAsDataURL(file);
         } else {
        preview.src = "./../uploads/employee/<?php echo $profile['user_role']; ?>"; 
         }
         }
 </script>
</body>

</html>