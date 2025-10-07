<?php
session_start();
include "./../include/config.php";
include './../././timezone.php';
require_once "./database/getdata.php";
$userid = $_SESSION["user_id"];

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applydata = $dataFetcher->addclient($userid);
}
$feachclients = $dataFetcher->feachclients();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Clients | Jiffy</title>

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

        .status {
            background: #3d3399;
            color: white;
            padding: 5px 10px 5px 10px;
            border-radius: 16px;
            text-align: center;
        }

        #viewButton:hover {
            border: 2px solid #fff;
            border-radius: 12px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
        include 'sidebar.php';
        include 'topbar.php';
        ?>

        <!--start dashboard--->
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
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h4 class="header-title">Clients</h4>
                                    <div class="d-flex align-items-center">
                                        <div class="list-grid-toggle d-flex align-items-center mr-3" style=" cursor:pointer;">
                                            <div class="pl-3 btn-new">
                                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add new client">
                                                    <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-user-modal" data-toggle="modal">Add Client</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="grid" class="item-content active" data-toggle-extra="tab-content">
                            <div class="row" id="card1">
                                <?php foreach ($feachclients as $client) { ?>
                                    <div class="col-lg-4 col-md-6 employee">
                                        <div class="card-transparent card-block card-stretch card-height">
                                            <div class="card-body text-center p-0">
                                                <div class="item">
                                                    <div class="odr-img">
                                                        <img src="./../uploads/employee/client.png" class="img-fluid rounded-circle avatar-90 m-auto" alt="image">
                                                    </div>
                                                    <div class="odr-content rounded" id="content">
                                                        <h4 class="mb-2"><?php echo $client['fullName']; ?></h4>
                                                        <p class="mb-3"><?php echo $client['projectName']; ?></p>
                                                        <ul class="list-unstyled mb-3">
                                                            <a href="mailto:<?php echo $client['email']; ?>" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Send mail">
                                                                <li class="bg-secondary-light rounded-circle iq-card-icon-small mr-4"><i class="ri-mail-open-line m-0"></i></li>
                                                            </a>
                                                            <a href="https://api.whatsapp.com/send?phone=<?php echo $client['phoneNumber']; ?>" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Send message">
                                                                <li class="bg-primary-light rounded-circle iq-card-icon-small mr-4"><i class="ri-chat-3-line m-0"></i></li>
                                                            </a>
                                                            <a href="tel:<?php echo $client['phoneNumber']; ?>" data-toggle="tooltip" data-placement="right" data-trigger="hover" title="Connect call">
                                                                <li class="bg-success-light rounded-circle iq-card-icon-small"><i class="ri-phone-line m-0"></i></li>
                                                            </a>
                                                        </ul>
                                                        <div class="pt-3 border-top">
                                                            <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="View client details">
                                                                <a href="clientDetails.php?id=<?php echo $client['id']; ?>" id="viewButton">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9-3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>


                        <!-- Page end  -->
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-user-modal">
                <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-block text-center pb-3 border-bttom">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Client</h4>
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
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="clientName">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="clientName" name="fullName" pattern="[a-zA-Z.\s]+" title="Enter only letters" placeholder="Enter client name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="phoneNumber">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" onkeypress="return onlyNumberKey(event)" pattern="[0-9]{10}" maxlength="10" minlength="10" placeholder="Enter phone number" required title="Please enter a 10 digit phone number">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Enter a valid email address" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="GSTNumber">Company GST Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="GSTNumber" name="GSTNumber" placeholder="Enter GST number" pattern="[0-9]+" title="Enter only numbers" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="projectName">Project Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="projectName" name="projectName" placeholder="Enter project name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="budget">Project Budget <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="budget" name="budget" placeholder="Enter project budget" pattern="[0-9]+" title="Enter only numbers" required>
                                        </div>
                                    </div>                                

                                    

                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="address">Company Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="address" name="address" placeholder="Enter company address" required></textarea>
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
        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
    <script>
        function filterEmployees() {
            var searchValue = document.getElementById("taskSearchInput").value.toLowerCase();
            var employeeCards = document.querySelectorAll(".employee");
            var noResultsMessage = document.getElementById("noResultsMessage");
            var foundResultsForH4 = false;
            var foundResultsForP = false;
            employeeCards.forEach(function(card) {
                var employeeNameH4 = card.querySelector("h4").textContent.toLowerCase();
                if (employeeNameH4.includes(searchValue)) {
                    card.style.display = "block";
                    foundResultsForH4 = true;
                } else {
                    card.style.display = "none";
                }
                var employeeNameP = card.querySelector("p.mb-3").textContent.toLowerCase();
                if (employeeNameP.includes(searchValue)) {
                    card.style.display = "block";
                    foundResultsForP = true;
                }
            });

            if (foundResultsForH4 || foundResultsForP) {
                noResultsMessage.style.display = "none";
            } else {
                noResultsMessage.style.display = "block";
            }
        }
        document.getElementById("taskSearchInput").addEventListener("input", filterEmployees);
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("#sendMailLink").on("click", function(e) {
            e.preventDefault();

            var email = $(this).data("email");
            var confirmMessage = "Are you sure you want to send an email to " + email + "?";

            if (confirm(confirmMessage)) {
                window.location.href = "mailto:" + email;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add a change event listener to the status select element
            $(".status").on("change", function() {
                // Get the form associated with the select element
                var formId = $(this).closest("form").attr("id");
                $("#" + formId).submit();
            });
        });
    </script>
    <script>
        document.getElementById("taskSearchInput").addEventListener("input", function() {
            var searchValue = this.value.toLowerCase();
            var rows = document.querySelectorAll("#user-list-table tbody tr");

            rows.forEach(function(row) {
                var fullName = row.querySelector("h5").textContent.toLowerCase();
                if (fullName.includes(searchValue)) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>