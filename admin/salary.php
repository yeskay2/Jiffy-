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
    <title>Salary List | Jiffy</title>

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

        .btn-invoice:hover {
            background-color: transparent;
            padding: 7px;
            color: #009CE9;
        }

        .btn-invoice {
            background-color: #42a5f5;
            padding: 7px;
            color: #fff;
            border-radius: 8px;
        }

        .btn-invoiceMail:hover {
            background-color: transparent;
            padding: 7px;
            color: #10A711;
        }

        .btn-invoiceMail {
            background-color: #10A711;
            padding: 7px;
            color: #fff;
            border-radius: 8px;
        }
        select {
    cursor: pointer;
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

                   <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between breadcrumb-content">
                        <div class="header-title">
                            <h4 class="card-title">Salary List</h4>
                        </div>
                        <div class="pl-3 btn-new">
                        <div data-toggle="tooltip" data-placement="top" data-trigger="hover">
                            <form id="monthYearForm" class="d-flex align-items-center w-100">
                                <div id="customMonthYearPicker" class="custom-month-year-picker d-flex align-items-center w-100">
                                    <div class="d-flex align-items-center justify-content-center mr-3">
                                        <select id="monthSelect" class="form-control month-select mr-2" style="height:35px;" required data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Month">
                                            <option value="" disabled selected>Select Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mr-3">
                                        <select id="yearSelect" class="form-control year-select" style="height:35px;" required data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Year"></select>
                                    </div>
                                    <button type="submit" class="btn btn-yes mr-3">Submit</button>
                                    <button type="button" class="btn btn-primary d-flex align-items-center mr-3" onclick="sendMailToAll()" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Send Payslip">
                                        <i class="fas fa-envelope p-1"></i>
                                    </button>
                                    <button id="downloadBtn" class="btn btn-primary d-flex align-items-center" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Download Data">
                                        <i class="fas fa-download p-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>                                        
                </div>
                    <div class="card-body">   
                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped text-center">
                            <thead>
                                <tr class="ligth">
                                    <th>SI.No</th>
                                    <th>Employee Name</th>
                                    <th>Salary</th>
                                    <th>Present Days</th>
                                    <th>Absent Days</th>
                                    <th>Paid Leave</th>
                                    <th>Unpaid Leave</th>
                                    <th>Loss of Pay</th>
                                    <th>Net Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$companyId = intval($companyId); // Ensure $companyId is sanitized and cast to an integer

$sql = "SELECT 
            e.id,
            e.full_name,
            e.salary,
            COUNT(a.id) AS total_attendance_count,
            COALESCE(SUM(CASE WHEN l.leave_lop IN ('1') THEN l.days_count ELSE 0 END), 0) AS total_leave,
            (SELECT SUM(days_count) FROM tblleaves 
             WHERE empid = e.id 
             AND `status` = '1' 
             AND leave_lop = '0' 
             AND MONTH(STR_TO_DATE(from_date, '%Y-%m-%d')) = '$month'
             AND YEAR(STR_TO_DATE(from_date, '%Y-%m-%d')) = '$year') AS paid_leave,
            COALESCE(SUM(CASE WHEN l.leave_lop = 'Lop' THEN l.days_count ELSE 0 END), 0) AS lop_leave,
            (SELECT COUNT(*) FROM holiday 
             WHERE MONTH(STR_TO_DATE(`start_date`, '%Y-%m-%d')) = '$month' 
             AND Company_id = $companyId 
             AND leave_type = 1) AS holiday,
            (SELECT perday_hours FROM schedules WHERE Company_id = $companyId LIMIT 1) AS perday_hours,
            (SELECT permonth_days FROM schedules WHERE Company_id = $companyId LIMIT 1) AS permonth_days
        FROM 
            employee e
        LEFT JOIN 
            attendance a ON e.email = a.employee_id 
            AND MONTH(STR_TO_DATE(a.date, '%d-%m-%Y')) = '$month' 
            AND YEAR(STR_TO_DATE(a.date, '%d-%m-%Y')) = '$year'
        LEFT JOIN 
            tblleaves l ON e.id = l.empid 
            AND l.status = '1'
        WHERE 
            e.active = 'active' 
            AND e.Company_id = $companyId
        GROUP BY 
            e.id, e.full_name, e.salary
        ORDER BY 
            e.full_name";

                                $result = mysqli_query($conn, $sql);
                                $i = 0;

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $i++; // Increment after fetching row
                                        $monthlySalary = $row['salary'];
                                        $totalAttendance = $row['total_attendance_count'];
                                        $totalLeave = $row['total_leave'];
                                        $paidLeave = $row['paid_leave'];
                                        $holiday = $row['holiday'];

                                        $totalPaidLeaves = $paidLeave + $holiday;

                                        $workingDaysPerMonth =$row['permonth_days'];
                                        $hoursPerDay = $row['perday_hours'];
                                         if ($workingDaysPerMonth > 0 && $hoursPerDay > 0) {
                                        $absentDays = $workingDaysPerMonth - $totalAttendance;
                                        $unpaidLeave = $absentDays - $totalPaidLeaves;
                                        $dailySalary = $monthlySalary / $workingDaysPerMonth;
                                        $hourlySalary = $dailySalary / $hoursPerDay;
                                        $deductions = $unpaidLeave * $dailySalary;
                                        $netSalary = $monthlySalary - $deductions;
                                         }else {
                                            $absentDays = 0;
                                            $unpaidLeave = 0;
                                            $dailySalary = 0;
                                            $hourlySalary = 0;
                                            $deductions = 0;
                                            $netSalary = $monthlySalary;
                                        }
                                ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row['full_name'] ?></td>
                                            <td><?= number_format($monthlySalary, 2) ?></td>
                                            <td><?= $totalAttendance ?></td>
                                            <td><?= $absentDays ?></td>
                                            <td><?= $totalPaidLeaves ?></td>
                                            <td><?= $unpaidLeave ?></td>
                                            <td><?= number_format($deductions, 2) ?></td>
                                            <td><?= number_format($netSalary, 2) ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-invoice download-payslip mr-2" data-employee-id="<?= $row['id'] ?>" onclick="payslip(<?= $row['id'] ?>,<?= $monthlySalary ?>, <?= $deductions ?>, <?= $netSalary ?>, '<?= $month ?>', '<?= $year ?>','download')">
                                                        <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Download Payslip">
                                                            <i class="far fa-arrow-alt-circle-down" style="font-size: 25px;"></i>
                                                        </div>
                                                    </button>
                                                    <button type="button" class="btn btn-invoiceMail" data-toggle="modal" rel="noopener" onclick="payslip(<?= $row['id'] ?>,<?= $monthlySalary ?>, <?= $deductions ?>, <?= $netSalary ?>, '<?= $month ?>', '<?= $year ?>','mail')">
                                                        <div data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="Send Payslip">
                                                            <i class="fas fa-envelope-square" style="font-size: 25px;"></i>
                                                        </div>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>No data found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    document.getElementById('downloadBtn').addEventListener('click', function() {
                        const table = document.getElementById('datatable');
                        let csv = [];
                        for (let row of table.rows) {
                            let rowData = [];
                            for (let cell of row.cells) {
                                // Enclose cell content in double quotes to handle commas properly
                                rowData.push(`"${cell.innerText.replace(/"/g, '""')}"`);
                            }
                            csv.push(rowData.join(','));
                        }
                        let csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
                        const encodedUri = encodeURI(csvContent);
                        const link = document.createElement('a');
                        link.setAttribute('href', encodedUri);
                        link.setAttribute('download', 'employee_data.csv');
                        document.body.appendChild(link);
                        link.click();
                    });
                </script>

                      
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
                            <h4 class="modal-title wordspace" id="exampleModalCenterTitle02">New Salary Detail</h4>
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
                                    <label for="employeeName">Employee Name</label>
                                    <input type="text" class="form-control" id="employeeName" name="employeeName" placeholder="Enter employee name" pattern="[A-Za-z .]+" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="salary">Salary</label>
                                    <input type="text" class="form-control" id="salary" name="salary" placeholder="Enter salary" pattern="[0-9,]+" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="presentDays">Present Days</label>
                                    <input type="text" class="form-control" id="presentDays" name="presentDays" placeholder="Enter present days" pattern="[0-9,]+" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="absentDays">Absent Days</label>
                                    <input type="text" class="form-control" id="absentDays" name="absentDays" placeholder="Enter absent days" pattern="[0-9,]+" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="paidLeave">Paid Leave</label>
                                    <input type="text" class="form-control" id="paidLeave" name="paidLeave" placeholder="Enter paid leave" pattern="[0-9,]+" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="unpaidLeave">Unpaid Leave</label>
                                    <input type="text" class="form-control" id="unpaidLeave" name="unpaidLeave" placeholder="Enter unpaid leave" pattern="[0-9,]+" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="lossOfPay">Loss of Pay</label>
                                    <input type="text" class="form-control" id="lossOfPay" name="lossOfPay" placeholder="Enter loss of pay" pattern="[0-9,]+" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="netSalary">Net Salary</label>
                                    <input type="text" class="form-control" id="netSalary" name="netSalary" placeholder="Enter net salary" pattern="[0-9,]+" required>
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
        function payslip(id, salary, Deductions, netSalary, month, year, download) {
            $.ajax({
                type: "POST",
                url: "./../Accounts/salarysplippdf.php",
                data: {
                    employee_id: id,
                    salary: salary,
                    Deductions: Deductions,
                    netSalary: netSalary,
                    month: month,
                    year: year,
                    download: download
                },
                success: function(data) {
                    console.log("Payslip data received:", data);
                    var responseData = JSON.parse(data);
                    if (responseData.success) {
                        var fileName = responseData.fileName;
                        var downloadUrl = './../Accounts/payslip/' + fileName;
                        var a = document.createElement('a');
                        a.href = downloadUrl;
                        a.download = fileName;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    } else {
                        console.error("Error generating payslip:", responseData.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var yearSelect = document.getElementById('yearSelect');
            var currentYear = new Date().getFullYear();
            var futureYears = 10;
            for (var i = 0; i <= futureYears; i++) {
                var yearOption = document.createElement('option');
                yearOption.value = currentYear + i;
                yearOption.textContent = currentYear + i;
                yearSelect.appendChild(yearOption);
            }
            var monthYearForm = document.getElementById('monthYearForm');
            monthYearForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var selectedMonth = document.getElementById('monthSelect').value;
                var selectedYear = document.getElementById('yearSelect').value;
                var newUrl = window.location.pathname + '?month=' + selectedMonth + '&year=' + selectedYear;
                window.location.href = newUrl;
            });
        });
    </script>
    <script>
        function sendMailToAll() {   
            $.ajax({
                url: 'send_mail_to_all.php',
                method: 'POST',
                data: {
                    month: $('#monthSelect').val(),
                    year: $('#yearSelect').val(),
                    companyId: <?= $companyId ?>
                },
                success: function(response) {
                    alert('Mails sent successfully!');
                },
                error: function() {
                    alert('An error occurred while sending mails.');
                }
            });
        }
        </script>

</body>

</html>