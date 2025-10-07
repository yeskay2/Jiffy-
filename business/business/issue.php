<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $subject = $_POST['request_subject'];
    $message = $_POST['request_message'];
    $assignTo = $_POST['Ticketto'];
    
    if ($type == "manual_entry") {
        $issue = $_POST['manual_entry_issue'];
    } else {
        $issue = $type;
    }   
    $ticketId = uniqid('TICKET_');
    $stmt = $conn->prepare("INSERT INTO issue (type, subject, message, assign_to, issue,Ticketid) VALUES (?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssss", $type, $subject, $message, $assignTo, $issue,$ticketId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    $_SESSION['success'] = "Issue Add successfully";
    header('Location:issue.php');
    exit();
}
?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Request | Jiffy</title>

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
        #searchbar1 {
            display: none;
        }
    </style>
</head>


<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center"></div>
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
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div class='modal fade' id='alertMessage' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content justify-content-center align-items-center d-flex'>
                        <div class='modal-body m-3'>
                            <i class='fa fa-exclamation-triangle' style='font-size: 25px; color:red;'></i>
                            <span class='ml-2' style='color: black !important; font-size: 18px; font-weight:bold'>" . $_SESSION['error'] . "</span>
                        </div>
                    </div>
                </div>
            </div>";
                        unset($_SESSION['error']);
                        echo "<script>
                $(document).ready(function(){
                    $('#alertMessage').modal('show');
                    setTimeout(function(){
                        $('#alertMessage').modal('hide');
                    }, 2000);
                });
            </script>";
                    }

                    if (isset($_SESSION['success'])) {
                        echo "<div class='modal fade' id='alertMessage' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content justify-content-center align-items-center d-flex'>
                        <div class='modal-body m-3'>
                            <i class='fa fa-check-circle' style='font-size: 25px; color:green;'></i>
                            <span class='ml-2' style='color: black !important; font-size: 18px; font-weight:bold;'>" . $_SESSION['success'] . "</span>
                        </div>
                    </div>
                </div>
            </div>";
                        unset($_SESSION['success']);
                        echo "<script>
                $(document).ready(function(){
                    $('#alertMessage').modal('show');
                    setTimeout(function(){
                        $('#alertMessage').modal('hide');
                    }, 2000);
                });
            </script>";
                    }
                    ?>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Issue List</h4>
                                </div>
                                <div data-toggle="tooltip" data-placement="top" data-trigger="hover" title="New request">
                                    <a href="#" class="custom-btn1 btn-2  text-center" data-target="#new-task-modal" data-toggle="modal">Request</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                  <table id="datatable" class="table data-table table-striped text-center">
    <thead>
        <tr>
            <td>ID</td>
            <td>Type</td>
            <td>Subject</td>
            <td>Message</td>
            <td>Assign To</td>
            <td>Issue</td>
            <td>Ticket ID</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM issue";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["subject"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td>" . $row["assign_to"] . "</td>";
                echo "<td>" . $row["issue"] . "</td>";
                echo "<td>" . $row["Ticketid"] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $row["id"] . "'><i class='fa fa-edit'></i></a>&nbsp;";
                echo "<a href='view.php?id=" . $row["id"] . "'><i class='fa fa-eye'></i></a>&nbsp;";
                echo "<a href='close.php?id=" . $row["id"] . "'><i class='fa fa-times'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
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
        <div class="modal fade bd-example-modal-lg" role="dialog" aria-modal="true" id="new-task-modal">
            <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-block text-center pb-3 border-bttom">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="modal-title" id="exampleModalCenterTitle">New Issue</h3>
                            </div>
                            <div class="col-lg-6">
                                <button type="button" class="close" data-dismiss="modal">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="" method="post" enctype="multipart/form-data" id="myForm" onsubmit="submitForm(event)">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputText2" class="h5">Request Type<span class="text-danger" style="font-size:20px">*</span></label>
                                        <select name="type" class="selectpicker form-control" data-style="py-0" required onchange="showFields(this.value)">
                                            <option value="" disabled selected hidden>Select Type</option>
                                            <option value="system_issue">System Issue</option>
                                            <option value="ac_issue">AC Issue</option>
                                            <option value="network_issue">Network Issue</option>
                                            <option value="software_issue">Software Issue</option>
                                            <option value="hardware_issue">Hardware Issue</option>
                                            <option value="electrical_issue">Electrical Issue</option>
                                            <option value="plumbing_issue">Plumbing Issue</option>
                                            <option value="other_issue">Other Issue</option>
                                            <option value="manual_entry">Manual Entry</option>
                                        </select>

                                        <div id="manualEntryField" style="display: none;">
                                            <label for="manualEntry">Enter Your Issue:</label>
                                            <input type="text" id="manualEntry" name="manual_entry_issue" class="form-control">
                                        </div>

                                        <script>
                                            function showFields(value) {
                                                if (value === "manual_entry") {
                                                    document.getElementById("manualEntryField").style.display = "block";
                                                } else {
                                                    document.getElementById("manualEntryField").style.display = "none";
                                                }
                                            }
                                        </script>
                                    </div>                                 
                                   
                                    <div id="requestFields">
                                        <div class="form-group">
                                            <label class="h5">Subject<span class="text-danger" style="font-size:20px">*</span></label>
                                            <input class="form-control" type="text" name="request_subject" placeholder="Enter subject">
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Message<span class="text-danger" style="font-size:20px">*</span></label>
                                            <textarea class="form-control" name="request_message" rows="5" placeholder="Enter message"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="h5">Select Assign To<span class="text-danger" style="font-size:20px">*</span></label>
                                            <select id="selectEmployee" name="Ticketto" class="selectpicker form-control" data-style="py-0" data-live-search=true>
                                                <option disable value=''>Select</option>
                                                <?php
                                                $query = "SELECT * FROM employee WHERE active= 'active' AND Company_id = '$companyId' ORDER BY  full_name";
                                                $result = mysqli_query($conn, $query);

                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $employeeId = $row['id'];
                                                        $employeeName = $row['full_name'];
                                                        $roles = $row['user_role'];
                                                        echo '<option value="' . $employeeId . '">' . $employeeName . '(' . $roles . ')</option>';
                                                    }
                                                } else {
                                                    echo '<option value="" disabled>No employees found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>                                  

                                    <div class="col-lg-12">
                                        <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                            <button type="submit" class="custom-btn1 btn-2 mr-3 text-center" id="submitButton">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
        <script src="script/script.js"></script>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 2000);
            });
        </script>

        <script>
            CKEDITOR.replace('editor1');

            function validateForm() {
                var editorData = CKEDITOR.instances.editor1.getData().trim();
                if (!editorData) {
                    alert("Description is required.");
                    return false;
                }
                return true;
            }
        </script>
        <script>
            const fromDateInput = document.getElementById('fromdate');
            const toDateInput = document.getElementById('todate');

            function setMinDateForEndDate() {
                toDateInput.setAttribute('min', fromDateInput.value);
            }

            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                const month = (today.getMonth() + 1).toString().padStart(2, '0');
                const day = today.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            fromDateInput.addEventListener('change', setMinDateForEndDate);
            document.getElementById('fromdate').setAttribute('min', getCurrentDate());
        </script>
        <script>
            function submitForm(event) {
                var element = document.getElementById("submitButton");
                element.classList.add("no-drop");
                element.disabled = true;
            }
        </script>

</body>

</html>