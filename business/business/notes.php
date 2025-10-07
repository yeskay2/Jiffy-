                    <?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
$sql = "UPDATE `timeline` SET `status`= 1 WHERE id = {$_GET['meetingid']} AND emp_id = $userid AND `status`= 0";
$result = $conn->query($sql);
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
                            <div class="card-header d-flex ">
                            <div class="back-button mr-3" style="cursor: pointer;" onclick="history.back()">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512" fill="#bc2d75" style="margin-right: 10px;">
                                        <path fill="#3d3399" d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z" />
                                    </svg>
                                </div>
                                <div class="header-title">
                                    <h4 class="card-title">Minutes of Meeting</h4>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5 id="report-title" class="selectedMonthLabel">Notes</h5>
                                </div>
                                <form action="generate_pdf.php?<?=$_GET['meetingid']?>" method="post">
    <div id="noteFields">
        <!-- Initial note field -->
        <div class="note-container row col-lg-12">
            <div class="col-lg-1">
                <div class="form-group">
                    <label for="number">S.No</label>
                    <input type="text" class="form-control text-center number" readonly value="1">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="note">Note</label>
                    <input type="text" class="form-control note" name="note[]">
                    <input type="hidden" class="form-control note" value="<?= isset($_GET['subject']) ? $_GET['subject'] : ''; ?>" name="subject">
                    <input type="hidden" class="form-control note" value="<?= isset($_GET['date']) ? $_GET['date'] : ''; ?>" name="date">
                    <input type="hidden" class="form-control note" value="<?= isset($_GET['meetingid']) ? $_GET['meetingid'] : ''; ?>" name="meetingid">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="incharge">Incharge</label>
                            <input type="text" class="form-control" name="incharge[]">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="dueDate">Due Date</label>
                            <input type="date" class="form-control" name="dueDate[]">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="d-flex justify-content-end mt-3">
            <button type="button" id="addNote" class="btn btn-primary"
                data-toggle="tooltip" data-placement="top" title="Add note">
                <i class="fas fa-plus-circle"></i> Add Note
            </button>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" id="submitButton" class="btn btn-primary">Generate Document</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        var counter = 1;

        $("#addNote").click(function () {
            counter++;
            var newNoteField = '<div class="note-container row col-lg-12">' +
                '<div class="col-lg-1">' +
                '<div class="form-group">' +
                '<input type="text" class="form-control text-center number" readonly value="' + counter + '">' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-4">' +
                '<div class="form-group">' +
                '<label for="note">Note</label>' +
                '<input type="text" class="form-control note" name="note[]">' +
                '<input type="hidden" class="form-control note" value="<?= isset($_GET['subject']) ? $_GET['subject'] : ''; ?>" name="subject">' +
                '<input type="hidden" class="form-control note" value="<?= isset($_GET['date']) ? $_GET['date'] : ''; ?>" name="date">' +
                '<input type="hidden" class="form-control note" value="<?= isset($_GET['meetingid']) ? $_GET['meetingid'] : ''; ?>" name="meetingid">' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-7">' +
                '<div class="row">' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="incharge">Incharge</label>' +
                '<input type="text" class="form-control" name="incharge[]">' + // Incharge input with name as an array
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="dueDate">Due Date</label>' +
                '<input type="date" class="form-control" name="dueDate[]">' + // Due Date input with name as an array
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
            $("#noteFields").append(newNoteField);
        });
    });
</script>




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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



</body>

</html>