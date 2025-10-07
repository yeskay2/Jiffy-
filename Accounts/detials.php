<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$userid = $_SESSION["user_id"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['monthly_expension'])) {
        $title = $_POST['tittle'];
        $amount = $_POST['amount'];
        $month = $_POST['month'];
        $title = htmlspecialchars($title);
        $amount = floatval($amount); 
        $formattedMonth = date("F Y", strtotime($month));
        $companyId = $companyId;
        $stmt = $conn->prepare("INSERT INTO monthly_expension (tittle, prize, `month-year`, company_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsi", $title, $amount, $formattedMonth, $companyId);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Monthly expense added successfully';
            header('Location: detials.php?details=' . urlencode($_GET['details']));
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $title = $_POST['tittle'];
        $amount = $_POST['amount'];
        $month = $_POST['month'];
        $title = htmlspecialchars($title);
        $amount = floatval($amount); 
        $formattedMonth = date("F Y", strtotime($month));
        $companyId = $companyId;
        $stmt = $conn->prepare("INSERT INTO revenue_collected (tittle,received_amount, `month`,company_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsi", $title, $amount, $formattedMonth, $companyId);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Monthly revenue added successfully';
            header('Location: detials.php?details=' . urlencode($_GET['details']));
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
       
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo$_GET['details']?> | Jiffy</title>

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
    </style>
</head>

<body>
  

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
                                    <h4 class="card-title"><?php echo$_GET['details']?> Details</h4>
                                </div>                                
                                <div class="pl-3 btn-new">
                                    <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add payment details">
                                        <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-user-modal-<?php echo$_GET['details']?>" data-toggle="modal">Add</a>
                                    </div>
                                </div>                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <?php if(isset($_GET['details']) && $_GET['details'] === 'Income') { ?>                                    
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>title</th>
                                                <th>received_amount</th>
                                                <th>Month</th>                                                
                                            </tr>
                                        </thead>   
                                        <?php 
                                            $sql = "SELECT * FROM revenue_collected WHERE Company_id = $companyId ORDER BY id desc ";
                                            $result = mysqli_query($conn, $sql);
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $row['tittle'];?></td>
                                                    <td><?php echo $row['received_amount'];?></td>
                                                    <td><?php echo $row['month'];?></td>                                                    
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>                 
                                    </table>
                                <?php } ?>
                                <?php if(isset($_GET['details']) && $_GET['details'] === 'Expense') { ?>                                    
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>title</th>
                                                <th>received_amount</th>
                                                <th>Month</th>                                                
                                            </tr>
                                        </thead>   
                                        <?php 
                                            $sql = "SELECT * FROM monthly_expension WHERE Company_id = $companyId ORDER BY id desc ";
                                            $result = mysqli_query($conn, $sql);
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $row['tittle'];?></td>
                                                    <td><?php echo $row['prize'];?></td>
                                                    <td><?php echo $row['month-year'];?></td>                                                    
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>                 
                                    </table>
                                <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page end  -->
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-user-modal-Expense">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Add Details</h4>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="close" data-dismiss="modal">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" name='monthly_expension'>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="customerName">title</label>
                                        <input type="text" class="form-control" id="customerName" name="tittle" placeholder="Enter title name" pattern="[A-Za-z .]+" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="projectName">Amount</label>
                                        <input type="text" class="form-control" id="projectName" name="amount" placeholder="Enter Amount name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="projectName">Month-Year</label>
                                        <input type="date" class="form-control" id="projectName" name="month" placeholder="Enter Amount name" required>
                                    </div>
                                </div>
                                 <div class="col-lg-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                        <input type="submit" class="custom-btn1 btn-2 mr-3 text-center" value="Submit" name='monthly_expension'>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-user-modal-Income">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">Add Details</h4>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="close" data-dismiss="modal">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" name='income'>
                        <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="customerName">title</label>
                                        <input type="text" class="form-control" id="customerName" name="tittle" placeholder="Enter title name" pattern="[A-Za-z .]+" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="projectName">Amount</label>
                                        <input type="text" class="form-control" id="projectName" name="amount" placeholder="Enter Amount name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="projectName">Month-Year</label>
                                        <input type="date" class="form-control" id="projectName" name="month" placeholder="Enter Amount name" required>
                                    </div>
                                </div>
                                 <div class="col-lg-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-center mt-2">
                                        <input type="submit" class="custom-btn1 btn-2 mr-3 text-center" value="Submit" name='income'>
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