<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Timesheet | Jiffy</title>

    <!-- Favicon -->
    <link rel="icon" type="images/x-icon" href="./../assets/images/Jiffy-favicon.ico" />
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
        @media(max-width:720px) {
            .bg-body {
                margin-left: 60px
            }
        }

        @media(max-width:650px) {
            #reportContainer {
                height: 60px;
                font-size: 13px;
                width: 80px;
            }

            .font {
                font-size: 26px;
            }
        }
        /* Apply hand cursor to date inputs */
#startDate,
#endDate {
    cursor: pointer;
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
            <?php
            include "./../include/call.php";
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                <h4 class="card-title">Timesheet</h4>
                                </div>                               

                                <form method="POST" id="reportForm">
                                    <div class="dropdown show">
                                        <a class="custom-btn1 btn-2  text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Download
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <!-- Update href to # and add onclick attributes -->
                                            <a id="downloadPDF" class="dropdown-item" href="#">PDF</a>
                                            <a id="downloadExcel" class="dropdown-item" href="#">Excel</a>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5 id="report-title" class="selectedMonthLabel">Month Report</h5>
                                </div>

                                <!-- <div class="d-flex flex-wrap align-items-center justify-content-around">
                                    <div class="dropdown dropdown-project mr-3">
                                        <div id="dropdownMenuButton03" data-toggle="dropdown">
                                            <form method="POST" id="reportForm" class="form-inline">
                                                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select date from">
                                                    <label for="startDate" class="mr-2">Start Date</label>
                                                    <input type="date" class="form-control" name="startDate" id="startDate">
                                                </div>
                                                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select date to">
                                                    <label for="endDate" class="mr-2">End Date</label>
                                                    <input type="date" class="form-control" name="endDate" id="endDate">
                                                </div> -->
                                                <div class="d-flex flex-wrap align-items-center justify-content-around">
    <div class="dropdown dropdown-project mr-3">
        <div id="dropdownMenuButton03" data-toggle="dropdown">
            <form method="POST" id="reportForm" class="form-inline">
                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select date from">
                    <label for="startDate" class="mr-2">Start Date</label>
                    <input type="date" class="form-control" name="startDate" id="startDate">
                </div>
                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select date to">
                    <label for="endDate" class="mr-2">End Date</label>
                    <input type="date" class="form-control" name="endDate" id="endDate">
                </div>
                                                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select employee">
                                                    <label for="selectmembers" class="mr-2">Employee</label>
                                                    <select name=" selectmembers" id="selectmembers" class="selectpicker form-control" data-style="py-0" data-live-search="true">
                                                    <option value='' disbale selected hidden></option>
                                                        <?php
                                                            if ($_SESSION["id"] == 1) {
                                                                $query = "SELECT * FROM employee WHERE active='active' AND Company_id='$companyId' ORDER BY full_name";
                                                            } elseif ($_SESSION["id"] == 2) {
                                                                $sql = "SELECT * FROM team WHERE leader='$userid' AND Company_id='$companyId'";
                                                                $resultTeam = $conn->query($sql);
                                                                
                                                                if ($resultTeam && $resultTeam->num_rows > 0) {
                                                                    $selectedid2 = [];
                                                                    while ($rowEmployee = $resultTeam->fetch_assoc()) {
                                                                        $selectedid2[] = $rowEmployee["employee"];
                                                                    }
                                                                    $selectedid2 = implode(',', $selectedid2);
                                                                    $query = "SELECT full_name,user_role, id FROM employee WHERE active='active' AND id IN ($selectedid2) AND Company_id='$companyId' ORDER BY full_name";
                                                                } else {
                                                                    $query = ""; 
                                                                }
                                                            } else {
                                                                $query = "SELECT * FROM employee WHERE active='active' AND Company_id='$companyId' AND id='$userid' ORDER BY full_name";
                                                            }

                                                            if (!empty($query)) {
                                                                $result = mysqli_query($conn, $query);
                                                                if ($result && mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $employeeId = $row['id'];
                                                                        $employeeName = $row['full_name'];
                                                                        $roles = $row['user_role'];
                                                                       
                                                                        echo '<option value="' . $employeeId . '">' . $employeeName . ' (' . $roles . ')</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option value="" disabled>No employees found</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="" disabled>No employees found</option>';
                                                            }
                                                            ?>
                                                    </select>
                                                </div>
                                                <?php if($_SESSION["id"] == 1) { ?>
                                                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Team">
                                                    <label for="selectteam" class="mr-2">Team</label>
                                                    <select name="selectteam" id="selectteam" class="selectpicker form-control" data-style="py-0" data-live-search="true">
                                                    <option value='' disbale selected hidden></option>
                                                           <?php
                                                            $query = "SELECT * FROM team WHERE Company_id='$companyId' ORDER BY teamname";
                                                            $result = mysqli_query($conn, $query);

                                                            if ($result && mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $employeeId = $row['team_id'];
                                                                    $employeeName = $row['teamname'];
                                                                    echo '<option value="' . htmlspecialchars($employeeId) . '">' . htmlspecialchars($employeeName) . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="" disabled>No employees found</option>';
                                                            }
                                                            ?>
                                                     </select>
                                                </div>
                                                <?php } ?>
                                                 <?php if($_SESSION["id"] == 2) { ?>
                                                <div class="form-group mr-3" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Select Team">
                                                    <label for="selectteam" class="mr-2">Team</label>
                                                    <select name="selectteam" id="selectteam" class="selectpicker form-control" data-style="py-0" data-live-search="true">
                                                    <option value='' disbale selected hidden></option>
                                                           <?php
                                                            $query = "SELECT * FROM team WHERE Company_id='$companyId' and leader= '$userid' ORDER BY teamname";
                                                            $result = mysqli_query($conn, $query);

                                                            if ($result && mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    $employeeId = $row['team_id'];
                                                                    $employeeName = $row['teamname'];
                                                                    echo '<option value="' . htmlspecialchars($employeeId) . '">' . htmlspecialchars($employeeName) . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="" disabled>No employees found</option>';
                                                            }
                                                            ?>
                                                     </select>
                                                </div>
                                                <?php } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-striped text-center">
                                        <thead>
                                            <tr class="ligth">
                                                <th>SI.No</th>
                                                <th>Project Name</th>
                                                <th>Task</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Task Duration</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
        $(document).ready(function() {
            function fetchTasks(startDate, endDate, employeeId,selectteam) {
                $.ajax({
                    url: './../project/get_completed_tasks.php',
                    method: 'POST',
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                        selectmembers: employeeId,
                        selectteam : selectteam
                    },
                    dataType: 'json',
                    success: function(data) {
                        var tableBody = $('#datatable tbody');
                        tableBody.empty();
                        console.log(data);
                        for (var i = 0; i < data.length; i++) {
                            var row = '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + data[i].project_name + '</td>' +
                                '<td>' + data[i].task_name + '</td>' +
                                '<td>' + data[i].start_date + '</td>' +
                                '<td>' + data[i].end_date + '</td>' +
                                '<td>' + data[i].due + '</td>' +                               
                                '</tr>';
                            tableBody.append(row);
                        }
                    },
                    error: function() {
                        console.log('Error fetching data.');
                    }
                });
            }
            var initialStartDate = $('#startDate').val();
            var initialEndDate = $('#endDate').val();
            var initialEmployeeId = $('#selectmembers').val();
            var selectteam = $('#selectteam').val();
            fetchTasks(initialStartDate, initialEndDate, initialEmployeeId);
            $('#startDate, #endDate, #selectmembers,#selectteam').change(function() {
                var selectedStartDate = $('#startDate').val();
                var selectedEndDate = $('#endDate').val();
                var selectedEmployeeId = $('#selectmembers').val();
                var selectteam = $('#selectteam').val();
                fetchTasks(selectedStartDate, selectedEndDate, selectedEmployeeId,selectteam);
            });
            $('#printButton').on('click', function() {
                window.print();
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $("#downloadLink").on("click", function(e) {
                e.preventDefault();
                $("#reportContainer").toggleClass("btn-dn");
            });
        });
    </script>
    <script>
        var input = document.getElementById("taskSearchInput");
        var table = document.getElementById("datatable");
        var tbody = table.getElementsByTagName("tbody")[0];
        var rows = tbody.getElementsByTagName("tr");
        input.addEventListener("keyup", function() {
            var filter = input.value.toUpperCase();
            for (var i = 0; i < rows.length; i++) {
                var projectCell = rows[i].getElementsByTagName("td")[1];
                var taskCell = rows[i].getElementsByTagName("td")[2];
                var startDateCell = rows[i].getElementsByTagName("td")[3];
                var endDateCell = rows[i].getElementsByTagName("td")[4];

                if (projectCell || taskCell || startDateCell || endDateCell) {
                    var projectText = projectCell.textContent || projectCell.innerText;
                    var taskText = taskCell.textContent || taskCell.innerText;
                    var startDateText = startDateCell.textContent || startDateCell.innerText;
                    var endDateText = endDateCell.textContent || endDateCell.innerText;
                    if (
                        projectText.toUpperCase().indexOf(filter) > -1 ||
                        taskText.toUpperCase().indexOf(filter) > -1 ||
                        startDateText.toUpperCase().indexOf(filter) > -1 ||
                        endDateText.toUpperCase().indexOf(filter) > -1
                    ) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        });
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reportForm = document.getElementById("reportForm");        
        function generateReport(type) {
            const selectedStartDate = document.getElementById("startDate").value;
            const selectedEndDate = document.getElementById("endDate").value;
            const selectedMembers = document.getElementById("selectmembers").value;
            var selectteam = document.getElementById("selectteam").value;
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "./../project/generate_report.php?startDate=" + selectedStartDate + "&endDate=" +
                selectedEndDate + "&selectmembers=" + selectedMembers + "&type=" + type + "&teamid=" + selectteam, true);
            xhr.responseType = 'text';
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const responseUrl = xhr.responseText.trim();
                    console.log('Generated URL:', responseUrl);
                    if (responseUrl === "no file") {
                        alert("No report available.");
                    } else {
                        const downloadLink = document.createElement('a');
                        downloadLink.href = responseUrl;
                        downloadLink.download = type === 'pdf' ? "Monthly_Report.pdf" : "Monthly_Report.xlsx";
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    }
                }
            };
            xhr.send();
        }       
        document.getElementById("downloadPDF").addEventListener("click", function(event) {
            event.preventDefault();
            generateReport('pdf');
        });

        document.getElementById("downloadExcel").addEventListener("click", function(event) {
            event.preventDefault();
            generateReport('excel');
        });
    });
</script>
<script>
    $(document).ready(function() {      
        $('#startDate').on('change', function() {
            var startDate = $(this).val();
            $('#endDate').attr('min', startDate); 
        });
    });
</script>
</body>

</html>