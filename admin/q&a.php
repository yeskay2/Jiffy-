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
    <title>Q & A | Jiffy</title>

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
</head>


<body>
    <!-- loader Start -->
   
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
                                    <h4 class="card-title">Q & A</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable" class="table data-table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <td>SI.No</td>
                                                <td width="120">Question Type</td>
                                                <td>Posted Date</td>
                                                <td>Current Status</td>
                                                <td>View</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $sql = "SELECT posters.PosterId,posters.QuestionType,posters.QuestionDescription,posters.status,posters.CreatedAt,questiontypes.TypeName  FROM posters 
                                        JOIN questiontypes ON posters.QuestionType = questiontypes.QuestionTypeId;";                                

                                        $result = mysqli_query($conn, $sql);
                                        $i = 1;

                                        echo '<tbody>';
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>';
                                                echo '<td>' . $i++ . '</td>';
                                                echo '<td>' . $row['TypeName'] . '</td>';
                                                echo '<td>' . date("d-m-Y", strtotime($row['CreatedAt'])) . '</td>';
                                                echo '<td>';
                                                $stats = $row['status'];
                                                if ($stats == 1) {
                                                    echo '<span class="approve">Approved</span>';
                                                } elseif ($stats == 2) {
                                                    echo '<span class="reject">Declined</span>';
                                                } elseif ($stats == 0) {
                                                    echo '<span class="pending">Pending</span>';
                                                }
                                                echo '</td>';
                                                echo '<td>
                                                            <a href="question_details.php?id= '.$row['PosterId'].'" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="View question details">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" style="fill:#3d3399;">
                                                                    <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                                                                </svg>
                                                            </a>
                                                        </td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr>';
                                            echo '<td colspan="6" class="text-center">No records found</td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody>';
                                        ?>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page end  -->
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
        <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
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




</body>

</html>