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
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM invoices WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = 'Invoice deleted successfully';
        header('Location: invoice.php');
        exit;
    } else {
        $_SESSION['error'] = 'Failed to delete invoice';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice | Jiffy</title>

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
                                    <h4 class="card-title">Invoice List</label></h4>
                                </div>
                                <div class="pl-3 btn-new">
                                    <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Add payment details">
                                        <a href="#" class="custom-btn1 btn-2 mr-3 text-center" data-target="#new-user-modal" data-toggle="modal">Add</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Invoice Number</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Date</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Preview</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT invoices.id, invoices.invoice_number, clientinformation.fullName AS customer_name, 
               invoices.created_at, invoices.due_date, invoices.status, 
               SUM(invoice_services.unit_cost) AS total_unit_cost
        FROM invoices
        JOIN invoice_services ON invoices.id = invoice_services.invoice_id
        JOIN clientinformation ON invoices.customer_name = clientinformation.id
        WHERE invoices.Company_id = $companyId
        GROUP BY invoices.id";

                                            $result = $conn->query($sql);

                                            if ($result && $result->num_rows > 0) {
                                                $id = 0;
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo ++$id ?></td>
                                                        <td><?php echo $row['invoice_number']; ?></td>
                                                        <td><?php echo $row['customer_name']; ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                                        <td><?php echo date('d-m-Y', strtotime($row['due_date'])); ?></td>

                                                        <td>
                                                            <select class="status" name="invoice" onchange="updatestatus(this.value,<?= $row['id'] ?>)">
                                                                <option <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?> value="Pending">Pending</option>
                                                                <option <?php echo ($row['status'] == 'Paid') ? 'selected' : ''; ?> value="Paid">Paid</option>
                                                                <option <?php echo ($row['status'] == 'Overdue') ? 'selected' : ''; ?> value="Overdue">Overdue</option>
                                                            </select>

                                                        </td>

                                                        <td>
                                                            <a href="./invoicepdf.php?invoice=<?= $row['id'] ?>" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Preview Invoice">
                                                                <i class="fas fa-eye" style="font-size: 25px;"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete<?= $row['id'] ?>">
                                                                <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Delete Invoice">
                                                                    <i class="ri-delete-bin-line mr-0"></i>
                                                                </div>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="modal_delete<?= $row['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Delete Invoice</h4>
                                                                </div>
                                                                <div class="modal-body" style="background-color: white; color:black;">
                                                                    <h5 class="wordspace">Are you sure you want to delete this invoice?</h5>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-no" data-dismiss="modal">No</button>
                                                                    <a type="button" class="btn btn-yes" href="./invoice.php?id=<?= $row['id'] ?>">Yes</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='9'>No invoices found.</td></tr>";
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

        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-user-modal">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Client Payment Details</h4>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="close" data-dismiss="modal">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="./invoicesumit.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="invoiceType">Invoice Type<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select class="form-control" id="invoiceType" name="invoiceType" required>
                                            <option value="">Select type</option>
                                            <option value="Project">Project</option>
                                            <option value="Items">Items</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="projectName">Project Name<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="projectName" class="selectpicker form-control" data-style="py-0" id="projectSelect" onchange="project(this.value)" data-live-search="true">
                                            <?php
                                            $query = "SELECT * FROM projects  WHERE  Company_id=$companyId  ORDER BY project_name";
                                            $result = mysqli_query($conn, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $projectId = $row['id'];
                                                    $projectName = $row['project_name'];

                                                    echo '<option value="' . $projectId . '">' . $projectName . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No projects found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="customerName">Client Name<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="customerName" class="selectpicker form-control" data-style="py-0" id="projectSelect" onchange="project(this.value)" data-live-search="true">
                                            <?php
                                            $query = "SELECT * FROM clientinformation  WHERE  Company_id=$companyId  ORDER BY fullName";
                                            $result = mysqli_query($conn, $query);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $projectId = $row['id'];
                                                    $projectName = $row['fullName'];

                                                    echo '<option value="' . $projectId . '">' . $projectName . '</option>';
                                                }
                                            } else {
                                                echo '<option value="" disabled>No Client found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="address">Address<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="email">Email<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="date">Date<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="date" class="form-control" id="date" name="date" placeholder="Enter date" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="dueDate">Due Date<span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="date" class="form-control" id="dueDate" name="dueDate" placeholder="Enter due date" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="dueDate">Tax Percentage % <span class="text-danger" style="font-size:20px">*</span></label>
                                        <input type="number" class="form-control" id="dueDate" name="tax" placeholder="Enter Tax Percentage" required>
                                    </div>
                                </div>

                                <div class="col-lg-12" id="services">
                                </div>

                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary" id="addServiceBtn"><i class="fas fa-plus"></i> Add Service</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            const addServiceBtn = document.getElementById('addServiceBtn');
            const servicesContainer = document.getElementById('services');
            let serviceIndex = 1;

            addServiceBtn.addEventListener('click', function() {
                const serviceDiv = document.createElement('div');
                serviceDiv.classList.add('row', 'service-row');

                serviceDiv.innerHTML = `
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="service${serviceIndex}">Service Name<span class="text-danger" style="font-size:20px">*</span></label>
                        <input type="text" class="form-control" id="service${serviceIndex}" name="service[]" placeholder="Enter service" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="description${serviceIndex}">Description<span class="text-danger" style="font-size:20px">*</span></label>
                        <input type="text" class="form-control" id="description${serviceIndex}" name="description[]" placeholder="Enter description" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="unitCost${serviceIndex}">Unit Cost<span class="text-danger" style="font-size:20px">*</span></label>
                        <input type="text" class="form-control" id="unitCost${serviceIndex}" name="unitCost[]" placeholder="Enter unit cost" pattern="[0-9.]+" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="quantity${serviceIndex}">Quantity<span class="text-danger" style="font-size:20px">*</span></label>
                        <input type="number" class="form-control" id="quantity${serviceIndex}" name="quantity[]" placeholder="Enter quantity" required>
                    </div>
                </div>
            `;
                servicesContainer.appendChild(serviceDiv);
                serviceIndex++;
            });
        });
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updatestatus(status, projectId) {
            var xhr = new XMLHttpRequest();

            var url = 'update_status2.php';

            var params = 'status=' + status + '&projectId=' + projectId;

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(params);
        }
    </script>
</body>

</html>