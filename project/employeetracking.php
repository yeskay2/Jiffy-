<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
if (empty($userid)) {
    header("location:index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Attendance | Jiffy</title>
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
    #app {
      text-align: center;
    }
    #preview {
      width: 300px; 
      margin-bottom: 20px;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <!-- Wrapper Start -->
    <div class="wrapper">
        <?php
        include 'topbar.php';
        include 'sidebar.php';
        ?>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
    <div class="row d-flex justify-content-between align-items-center">
        <h4 class="card-title ml-4">Employee Tracking</h4>
    </div>
</div>
<div class="card-body" id="search">
    <div class="table-responsive">
        <div class="mb-3">
            <button id="export-btn" class="btn btn-primary">Export to Excel</button>
        </div>
        <table id="datatable" class="table table-striped table-hover text-center">
    <thead class="ligth">
        <tr>
            <th>S.No.</th>
            <th>Date</th>
            <th>Employee Name</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Status</th>
            <th>Total Hours</th>
        </tr>
    </thead>
    <?php
    date_default_timezone_set('Asia/Kolkata');
    $currentYear = date("Y");
    $currentMonth = date("m");
    $currentDay = date("d");
    $today = date("d-m-Y");
    $selectedMonthYear = isset($_GET['selectedMonth']) ? htmlspecialchars($_GET['selectedMonth']) : $currentMonth;
    $baseSql = "SELECT *, attendance.id AS attendanceid, attendance.date, attendance.time_in AS employee_in, 
                employee.id AS eid, attendance.send, attendance.time_out AS employee_out, schedules.time_in AS schedule_in
                FROM attendance
                LEFT JOIN schedules ON schedules.Company_id = $companyId
                LEFT JOIN employee ON employee.email = attendance.employee_id
                WHERE attendance.Company_id = $companyId";
    $baseSql .= " AND attendance.date = '$today'";
    $baseSql .= " ORDER BY attendance.id DESC";
    $result = $conn->query($baseSql);
    if ($result && $result->num_rows > 0) {
        echo '<tbody>';
        $serialNumber = 1;
        while ($row = $result->fetch_assoc()) {
            $attendanceid = $row['attendanceid'];
            $actualTimeIn = strtotime($row['employee_in']);
            $actualTimeOut = $row['employee_out'] ? strtotime($row['employee_out']) : null;
            $scheduleTimeIn = strtotime($row['schedule_in']);
            $email = $row['email'];
            $eid = $row['eid'];
            $send = $row['send'];
            $logout = $row['time_out1'];
            $totalhourd = $row['num_hr'] ?? 0;
            if ($send == '0') {
                $inTimeClass = '';
            } else {
                $inTimeClass = 'bg-late';
            }
            $sql = "SELECT id, email, status FROM employee WHERE email = '$email'";
            $employeestatus = $conn->query($sql);
            $employeestatusresult = $employeestatus->fetch_assoc();
            $status = isset($employeestatusresult['status']) ? $employeestatusresult['status'] : '';
            if ($status == 'Online') {
                $employeeId = $employeestatusresult['id'];
                $currentDate = date('Y-m-d');
                $currentTime = date('H:i');
                $sql = "SELECT tasks.*, employee.full_name
                        FROM tasks
                        JOIN employee ON tasks.assigned_to = employee.id
                        WHERE tasks.assigned_to = $employeeId
                        AND (
                            (tasks.due_date >= '$currentDate' AND tasks.Actual_start_time <= '$currentTime' AND tasks.due_date >= '$currentTime')
                            OR (tasks.due_date >= '$currentDate' AND tasks.perferstart_time <= '$currentTime' AND tasks.perferend_time >= '$currentTime')
                            OR (tasks.due_date >= '$currentDate' AND tasks.perferstart_time <= '$currentTime' AND tasks.perferend_time >= '$currentTime')
                        )
                        AND tasks.status NOT IN ('Completed', 'Pause')
                        ORDER BY tasks.Actual_start_time";
                $taskResult = $conn->query($sql);
                if ($taskResult->num_rows > 0) {
                    $status = "Busy";
                } else {
                    $status = "Available";
                }
            }
            $tdStyle = 'padding: 4px; text-align: center; border-radius: 2px;';
            switch ($status) {
                case 'Online':
                    $tdStyle .= ' background-color: #28a745; color: #fff;';
                    break;
                case 'Offline':
                    $tdStyle .= ' background-color: #dc3545; color: #fff;';
                    break;
                case 'Pending':
                    $tdStyle .= ' background-color: #ffc107; color: #000;';
                    break;
                default:
                    $tdStyle .= ' background-color: #007bff; color: #fff;';
            }
            echo '<tr>';
            echo '<td>' . $serialNumber++ . '</td>';
            echo '<td>' . date('d-m-Y', strtotime($row['date'])) . '</td>';
            echo '<td>' . $row['full_name'] . '</td>';
            echo '<td class="' . $inTimeClass . '">' . date('h:i A', $actualTimeIn) . '</td>';
            if ($actualTimeOut !== null) {
                echo '<td>' . date('h:i A', $actualTimeOut) . '</td>';
            } else {
                echo '<td>' . date('h:i A', strtotime($logout)) . '</td>';
            }
            echo '<td style="' . $tdStyle . '">' . htmlspecialchars($status) . '</td>';
            echo '<td>' . $totalhourd . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
    } else {
        echo '<tbody>';
        echo '<tr>';
        echo '<td colspan="7" class="text-center">No records found</td>';
        echo '</tr>';
        echo '</tbody>';
    }
    ?>
</table>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    document.getElementById('export-btn').addEventListener('click', function () {
        const table = document.getElementById('datatable');
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'EmployeeTracking');
        XLSX.writeFile(wb, 'EmployeeTracking.xlsx');
    });
</script>
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
        <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <!-- app JavaScript -->
        <script src="./../assets/js/app.js"></script>
        <script src="./../assets/vendor/moment.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function filterEmployees() {
            var searchValue = document.getElementById("taskSearchInput").value.toLowerCase(); // Get the search input value
            var tableRows = document.querySelectorAll("#datatable tbody tr"); // Get all the table rows inside the tbody

            tableRows.forEach(function(row) {
            var employeeName = row.querySelector("td:nth-child(3)").textContent.toLowerCase(); // Change to correct column index if needed
            if (employeeName.includes(searchValue)) {
            row.style.display = "table-row"; 
            } else {
            row.style.display = "none"; 
            }
            });
            }
document.getElementById("taskSearchInput").addEventListener("input", filterEmployees);

        </script>
        <script>
            var selectMonth = document.getElementById("selectMonth");
            selectMonth.addEventListener("change", function() {
                var selectedMonth = this.value;
                var newURL = updateQueryStringParameter(window.location.href, "selectedMonth", selectedMonth);
                history.pushState({}, "", newURL);
                window.location.reload();
            });
            var selectEmployee = document.getElementById("selectEmployee");
            selectEmployee.addEventListener("change", function() {
                var selectedEmployeeId = this.value;
                var newURL = updateQueryStringParameter(window.location.href, "selectedEmployee", selectedEmployeeId);
                history.pushState({}, "", newURL);
                window.location.reload();
              });
              function updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf("?") !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, "$1" + key + "=" + value + "$2");
                } else {
                    return uri + separator + key + "=" + value;
                }
            }
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
