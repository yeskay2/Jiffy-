<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Timesheet | Jiffy</title>

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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h5>Timesheet</h5>
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="dropdown dropdown-project mr-3">
                                            <div class="dropdown-toggle" id="dropdownMenuButton03" data-toggle="dropdown">

                                                <form method="POST" id="reportForm">
                                                    <div class="btn bg-body">
                                                        <label for="selectMonth">Select Month:</label>
                                                        <select name="selectMonth" id="selectMonth">
                                                            <?php
                                                            $currentMonth = date("m");
                                                            for ($month = 1; $month <= 12; $month++) {
                                                                $selected = ($month == $currentMonth) ? 'selected="selected"' : '';
                                                                echo '<option value="' . $month . '" ' . $selected . '>' . date("F", mktime(0, 0, 0, $month, 1)) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <button type="submit" id="reportContainer" class="styled-button">
                                                        Generate Report
                                                    </button>

                                                </form>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title text-center">
                                        <h5 id="report-title" class="selectedMonthLabel">Month Report</h5>
                                        
                                    
                                        
                                    </div>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped text-center">
                                            <thead>
                                                <tr class="ligth">
                                                    <th>S.no</th>
                                                    <th>Projects</th>
                                                    <th>Task</th>
                                                    <th>Start time</th>
                                                    <th>End time</th>
                                                    <th>Hours</th>
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
        <footer class="iq-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="backend/privacy-policy.html">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="backend/terms-of-service.html">Terms of Use</a></li>
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



        <script>
$(document).ready(function() {
    function fetchTasksByMonth(selectedMonth) {
        $.ajax({
            url: 'get_completed_tasks.php',
            method: 'POST',
            data: {
                selectMonth: selectedMonth
            },
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#datatable tbody');
                tableBody.empty();

                for (var i = 0; i < data.length; i++) {
                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        
                        '<td>' + data[i].project_name + '</td>' +
                        '<td>' + data[i].task_name + '</td>' +
                        '<td>' + data[i].start_date + '</td>' +
                        '<td>' + data[i].end_date + '</td>' +
                        '<td>' + data[i].time_spent + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                }
            },
            error: function() {
                console.log('Error fetching data.');
            }
        });
    }  
    
    var initialSelectedMonth = $('#selectMonth').val();
    fetchTasksByMonth(initialSelectedMonth);
    $('.selectedMonthLabel').text($('#selectMonth option:selected').text() + " Month Report"); 
    
    $('#selectMonth').change(function() {
        var selectedMonth = $(this).val();
        fetchTasksByMonth(selectedMonth);
        $('.selectedMonthLabel').text($('#selectMonth option:selected').text() + " Month Report"); 
    });

    $('#printButton').on('click', function() {
        window.print();
    });
});



            document.addEventListener("DOMContentLoaded", function() {
                const reportForm = document.getElementById("reportForm");
                const reportContainer = document.getElementById("reportContainer");

                reportForm.addEventListener("submit", function(event) {
                    event.preventDefault();
                    const selectedMonth = document.getElementById("selectMonth").value;
                    const xhr = new XMLHttpRequest();
                    xhr.open("GET", "generate_report.php?selectMonth=" + selectedMonth, true);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            reportContainer.innerHTML = xhr.responseText;
                            if (xhr.responseText === "no file") {
                                alert("No report available.");
                                location.reload();
                            } else {
                                reportContent.innerHTML = xhr.responseText;
                            }
                        }
                    };

                    xhr.send();
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

</body>

</html>