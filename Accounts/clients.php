<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Clients | Jiffy</title>

    <!-- Favicon -->
    <link href="./../assets/images/dummy.png" rel="icon">
    <link href="./../assets/images/dummy.png" rel="apple-touch-icon">
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

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Clients Payment Details</h4>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Customer Name</th>
                                                <th>Project Name</th>
                                                <th>Project Budget</th>
                                                <th>Payment Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT p.*,p.id AS project_id, clientinformation.* FROM `projects` AS p 
                                                                JOIN clientinformation ON clientinformation.id = p.client_id
                                                                WHERE p.`Company_id` = '$companyId'";
                                            if (isset($_GET['project'])) {
                                                $sql = "SELECT p.*,p.id AS project_id, clientinformation.* FROM `projects` AS p 
                                                                    JOIN clientinformation ON clientinformation.id = p.client_id
                                                                    WHERE p.`Company_id` = '$companyId' AND p.payment_status = 'Paid'";
                                            }
                                            $result = mysqli_query($conn, $sql);
                                            $i = 0;
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                    <tr>
                                                        <td><?= ++$i ?></td>
                                                        <td><?= $row['fullName'] ?></td>
                                                        <td><?= $row['project_name'] ?></td>
                                                        <td><?= number_format($row['budget'], 2) ?></td>
                                                        <td><?= date('d-m-Y', strtotime($row['due_date'])) ?></td>
                                                        <td>
                                                            <span class="badge badge-success" style="background-color: green !important;"><?= $row['payment_status'] ?></span>
                                                        </td>
                                                        <td>
                                                            <select class="status" name="statusAmount">
                                                                <option value="Pending" <?= ($row['payment_status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                                                <option value="Paid" <?= ($row['payment_status'] == 'Paid') ? 'selected' : '' ?>>Paid</option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="paymentModalLabel">Select Payment Method</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form>
                                                                        <div class="form-group">
                                                                            <label for="paymentMethod">Payment Method</label>
                                                                            <select class="form-control" id="paymentMethod" name="paymentMethod">
                                                                                <option value="Credit Card">Credit Card</option>
                                                                                <option value="Debit Card">Debit Card</option>
                                                                                <option value="PayPal">PayPal</option>
                                                                                <!-- Add more payment methods here -->
                                                                            </select>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" onchange="updatePaymentStatus(this.value, <?= $row['project_id'] ?>)">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } else {
                                                echo "<p>No clients found</p>";
                                            }
                                            ?>
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
    </div>
    </div>

    <!-- Modal Popup -->




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
        function showModal(selectElement) {
            if (selectElement.value === "Paid") {
                $('#paymentModal').modal('show');
            }
        }
    </script>

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
    <script>
        function updatePaymentStatus(status, projectId) {
            var xhr = new XMLHttpRequest();

            var url = 'update_status.php';

            var params = 'status=' + status + '&projectId=' + projectId;

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Handle the AJAX response
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };

            // Send the AJAX request with the parameters
            xhr.send(params);
        }
    </script>

</body>

</html>