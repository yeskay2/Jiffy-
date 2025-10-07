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
    .btn-excel {
        margin-right:1px !Important;
    }
    
    #app {
      text-align: center;
    }
    #preview {
      margin-bottom: 20px;
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
                               <div class="row d-flex col-12 justify-content-between align-items-center">
                               <div class="col-3">
                                        <h4 class="card-title">Attendance</h4>
                                    </div>
                                    <div class="col-9 d-flex">
                                        <div class="col-1 mr-2" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Scan QR">
                                            <button class="btn btn-scan" style="background-color: #3d3399; color: #fff;" id="scanButton" data-toggle="modal" data-target="#qrModal">
                                                <i class="fas fa-qrcode" style="font-size:35px;"></i>
                                            </button>
                                        </div>

                                        <div class="col-2 align-items-center justify-content-center" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select month">
    <select name="selectMonth" id="selectMonth" class="form-control" style="cursor: pointer;">
        <?php
        $currentMonth = date("m");
        $selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : $currentMonth;

        for ($month = 1; $month <= 12; $month++) {
            $monthName = date("F", mktime(0, 0, 0, $month, 1));
            $selected = ($month == $selectedMonth) ? 'selected="selected"' : '';
            echo '<option value="' . $month . '" ' . $selected . '>' . $monthName . '</option>';
        }
        ?>
    </select>
</div>


                                  <div class="col-5 align-items-center justify-content-center" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select employee">
    <select name="selectEmployee" id="selectEmployee" class="form-control" style="cursor: pointer;">
        <option value="all" <?= isset($_GET['selectedEmployee']) && $_GET['selectedEmployee'] == 'all' ? 'selected' : '' ?>>All</option>
        <?php
        $query = "SELECT * FROM employee WHERE active='active' AND Company_id='$companyId' ORDER BY full_name";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $employeeId = $row['id'];
                $employeeName = $row['full_name'];
                $roles = $row['user_role'];

                $selectedEmployeeId = isset($_GET['selectedEmployee']) ? $_GET['selectedEmployee'] : '';

                $selected = ($employeeId == $selectedEmployeeId) ? 'selected' : '';

                echo '<option value="' . $employeeId . '"' . $selected . '>' . $employeeName . ' (' . $roles . ')</option>';
            }
        } else {
            echo '<option value="" disabled>No employees found</option>';
        }
        ?>
    </select>
</div>



                                        <div class="col-2 align-items-center justify-content-center" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select status">
    <select name="selectStatus" id="selectStatus" class="form-control" style="cursor: pointer;">
        <option value="all" <?= isset($_GET['selectedStatus']) && $_GET['selectedStatus'] == 'all' ? 'selected' : '' ?>>All</option>
        <option value="on_time" <?= isset($_GET['selectedStatus']) && $_GET['selectedStatus'] == 'on_time' ? 'selected' : '' ?>>On Time</option>
        <option value="late" <?= isset($_GET['selectedStatus']) && $_GET['selectedStatus'] == 'late' ? 'selected' : '' ?>>Late</option>
    </select>

    <script>
        document.getElementById('selectStatus').addEventListener('change', function() {
            var selectedValue = this.value;
            var url = new URL(window.location.href);
            url.searchParams.set('selectedStatus', selectedValue);
            window.location.href = url.href;
        });
    </script>
</div>
                                        <div class="col-2">
                                            <button class="btn btn-excel" id="exportButton" data-toggle="tooltip" data-placement="top" title="Download Excel Sheet">
                                                Export Excel <i class="fas fa-arrow-alt-circle-up"></i>
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" id="search">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table  table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>Date</th>
                                                    <th>Employee Name</th>
                                                    <th>Time In</th>
                                                    <th>Time Out</th>
                                                    <th>Status</th>
                                                    <th>Total Hours</th>
                                                </tr>
                                            </thead>
                                           <?php
                                                $currentYear = date("Y");
                                                $currentMonth = date("m");
                                                $currentDay = date("d");
                                                $today = date("d-m-Y");

                                                $selectedMonthYear = isset($_GET['selectedMonth']) ? htmlspecialchars($_GET['selectedMonth']) : $currentMonth;

                                                // Initialize the base SQL query
                                                $baseSql = "SELECT *, attendance.id AS attendanceid, attendance.date, attendance.time_in AS employee_in, 
                                                            employee.id AS eid, attendance.send, attendance.time_out AS employee_out, schedules.time_in AS schedule_in
                                                            FROM attendance
                                                            LEFT JOIN schedules ON schedules.Company_id = $companyId
                                                            LEFT JOIN employee ON employee.email = attendance.employee_id
                                                            WHERE attendance.Company_id = $companyId";

                                                // Add conditions based on the provided parameters
                                                if (isset($_GET["period"])) {
                                                    if ($_GET["period"] == 'today') {
                                                        $baseSql .= " AND attendance.date = '$today' AND attendance.send ='0'";
                                                    } elseif ($_GET["period"] == 'late') {
                                                        $baseSql .= " AND attendance.date = '$today' AND attendance.send ='3'";
                                                    }
                                                } elseif (isset($_GET["selectedStatus"])) {
                                                    if ($_GET["selectedStatus"] == 'late') {
                                                        $baseSql .= " AND attendance.send = '3'";
                                                    } elseif ($_GET["selectedStatus"] == 'on_time') {
                                                        $baseSql .= " AND attendance.send = '0'";
                                                    }
                                                }

                                                if (isset($_GET['selectedMonth'])) {
                                                    $selectedMonth = intval($_GET['selectedMonth']);
                                                    $baseSql .= " AND MONTH(year_time) = $selectedMonth AND YEAR(year_time) = $currentYear";
                                                }

                                                // Handle selected employee filter
                                                if (isset($_GET['selectedEmployee'])) {
                                                    $userid = intval($_GET['selectedEmployee']);
                                                    
                                                    $stmt = $conn->prepare("SELECT email FROM employee WHERE employee.id = ?");
                                                    $stmt->bind_param("i", $userid);
                                                    $stmt->execute();
                                                    $employeeResult = $stmt->get_result();
                                                    
                                                    if ($employeeResult->num_rows > 0) {
                                                        $employeeData = $employeeResult->fetch_assoc();
                                                        $email = $employeeData['email'];
                                                        $baseSql .= " AND attendance.employee_id = ?";
                                                    } else {
                                                        echo "Employee not found.";
                                                        exit;
                                                    }
                                                }

                                                // Add the ORDER BY clause
                                                $baseSql .= " ORDER BY attendance.id DESC";

                                                // Prepare and execute the SQL query
                                                if (isset($_GET['selectedEmployee'])) {
                                                    $stmt->close();
                                                    $stmt = $conn->prepare($baseSql);
                                                    $stmt->bind_param("s", $email);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                } else {
                                                    $result = $conn->query($baseSql);
                                                }

                                                // Process the results
                                                if ($result && $result->num_rows > 0) {
                                                    echo '<tbody>';
                                                    while ($row = $result->fetch_assoc()) {
                                                        $attendanceid = $row['attendanceid'];
                                                        $actualTimeIn = strtotime($row['employee_in']);
                                                        $actualTimeOut = $row['employee_out'] ? strtotime($row['employee_out']) : null;
                                                        $scheduleTimeIn = strtotime($row['schedule_in']);
                                                        $email = $row['email'];
                                                        $eid = $row['eid'];
                                                        $send = $row['send'];
                                                        $logout = $row['time_out1'];
                                                        $totalhourd = $row['num_hr']??0;
                                                        
                                                        $status = $send == '0' ? '<span class="mb-2 bg-ontime text-white">On time</span>' : '<span class="mb-2 bg-late text-white">Late</span>';
                                                        
                                                        if ($send == '0') {
                                                            $status1 = '<span style="font-size: 30px;">✅</span>';
                                                        } elseif ($send == 3) {
                                                            $status1 = '<button class="btn-download"><i class="fa fa-check"></i></button>';
                                                        } else {
                                                            $status1 = '<button id="sendButton" class="btn-download" onclick="send_msg(' . $eid . ', ' . $attendanceid . '); changeIcon();" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Send memo mail" data-eid="' . $eid . '" data-attendanceid="' . $attendanceid . '"><i id="mailIcon" class="fa fa-envelope"></i></button>';
                                                        }
                                                        
                                                        echo '<tr>';
                                                        echo '<td>' . date('d-m-Y', strtotime($row['date'])) . '</td>';
                                                        echo '<td>' . $row['full_name'] . '</td>';
                                                        echo '<td>' . date('h:i A', $actualTimeIn) . '</td>';
                                                        
                                                        if ($actualTimeOut !== null) {
                                                            echo '<td>' . date('h:i A', $actualTimeOut) . '</td>';
                                                        } else {
                                                            echo '<td>' . date('h:i A', strtotime($logout)) . '</td>';
                                                        }
                                                        echo '<td>' . $status . '</td>';
                                                        echo '<td>' . $totalhourd  . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    echo '</tbody>';
                                                } else {
                                                    echo '<tbody>';
                                                    echo '<tr>';
                                                    echo '<td colspan="6" class="text-center">No records found</td>';
                                                    echo '</tr>';
                                                    echo '</tbody>';
                                                }
                                                ?>


                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan QR to Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div id="app">
            <video id="preview"></video>
            <p>{{ scannedResult }}</p>
            <p v-if="response">{{ response }}</p>         
            <button class="btn btn-primary" @click="exportDate()">Export Date</button>
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
                var searchValue = document.getElementById("taskSearchInput").value.toLowerCase();
                var tableRows = document.querySelectorAll("#datatable tbody tr");

                tableRows.forEach(function(row) {
                    var employeeName = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
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

            // Helper function to update URL query parameters
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
        <script>
            function getQueryParam(name) {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }
            document.getElementById("exportButton").addEventListener("click", function() {
                var selectedMonthYearFromURL = getQueryParam("selectedMonth");
                var selectedMonthYear = selectedMonthYearFromURL ? parseInt(selectedMonthYearFromURL) : null;
                var table = document.getElementById("datatable");
                var tableData = [];
                var headers = [];
                for (var i = 0; i < table.rows[0].cells.length; i++) {
                    headers.push(table.rows[0].cells[i].textContent);
                }
                tableData.push(headers);
                for (var j = 1; j < table.rows.length; j++) {
                    var rowData = [];
                    var dateCell = table.rows[j].cells[0];
                    var dateParts = dateCell.textContent.split("-");
                    var rowMonth = parseInt(dateParts[1]);
                    if (selectedMonthYear === null || rowMonth === selectedMonthYear) {
                        for (var k = 0; k < table.rows[j].cells.length; k++) {
                            rowData.push(table.rows[j].cells[k].textContent);
                        }
                        tableData.push(rowData);
                    }
                }
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.aoa_to_sheet(tableData);
                XLSX.utils.book_append_sheet(wb, ws, "Attendance");

                XLSX.writeFile(wb, "attendance.xlsx");
            });
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
                                    console.error('Error while updating location:', error);
                                });
                        },
                        function(error) {
                            console.log(`Error while getting location: ${error.message}`);
                        }
                    );
                } else {
                    console.log('Geolocation is not supported by this browser.');
                }
            }

            setInterval(getUserLocationAndSend, 5000);
        </script>
 <script>
    var app = new Vue({
      el: '#app',
      data: {
        scanner: null,
        scannedResult: '',
        response: ''
      },
      mounted() {
        this.scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        this.scanner.addListener('scan', (content) => {
          this.scannedResult = content;       
          this.sendData(content);
        });
        Instascan.Camera.getCameras().then(cameras => {
          if (cameras.length > 0) {
            this.scanner.start(cameras[0]);
          } else {
            console.error('No cameras found.');
          }
        }).catch(err => {
          console.error(err);
        });
      },
      methods: {
        sendData(data) {
          // Create an AJAX request
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'actionscan.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                console.log('Data sent successfully');
                this.response = xhr.responseText;
              } else {
                console.error('Error:', xhr.status, xhr.statusText); // Update error message
                this.response = 'Error while sending data: ' + xhr.statusText; // Display error to user
              }
            }
          };
          xhr.send('data=' + encodeURIComponent(data));
        },
        exportDate() {
          var currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
          this.date(currentDate);
        },
        date(value) {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'export.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                console.log('Data exported successfully');
                if (xhr.responseText) {
                  exportToExcel(JSON.parse(xhr.responseText));
                }
              } else {
                console.error('Error:', xhr.status, xhr.statusText); // Update error message
                this.response = 'Error while exporting data: ' + xhr.statusText; // Display error to user
              }
            }
          };
          xhr.send('date=' + encodeURIComponent(value));
        }
      }
    });

    function exportToExcel(data) {
      var wb = XLSX.utils.book_new();
      var ws = XLSX.utils.json_to_sheet(data);
      XLSX.utils.book_append_sheet(wb, ws, "Login Data");
      var wbout = XLSX.write(wb, { type: 'binary', bookType: 'xlsx' });
      var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
      saveAs(blob, 'login_data.xlsx');
    }
    
    function s2ab(s) {
      var buf = new ArrayBuffer(s.length);
      var view = new Uint8Array(buf);
      for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
      return buf;
    }
  </script>


</body>

</html>