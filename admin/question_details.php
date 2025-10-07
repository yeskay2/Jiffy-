<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = isset($_GET['id']) ? $_GET['id'] : null;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $description = $_POST["dec"];
    
    $status = 1;
    
    

    $sql = "UPDATE posters SET status = ?, answer = ? WHERE PosterId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $description, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Answer added successfully';
            header('location: q&a.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Q & A Details | Jiffy</title>

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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Q & A Details</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <?php
                                    $sql = "SELECT posters.PosterId,posters.PosterId,posters.QuestionType,posters.QuestionDescription,posters.status,posters.answer,
                                    posters.CreatedAt,questiontypes.TypeName,posters.Name FROM posters 
                                    JOIN questiontypes ON posters.QuestionType = questiontypes.QuestionTypeId 
                                    WHERE posters.PosterId = $id;
                                    
                                    
                                    ";

                                    $result = mysqli_query($conn, $sql);
                                    $i = 1;

                                    echo '<tbody>';
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result))
                                      
                                         { ?>

                                    <?php  $session['id'] = $row['PosterId'];?>
                                    <?php  $session['ques'] = $row['TypeName'];?>
                                    <?php  $session['ans'] = $row['answer'];?>
                                    <tbody>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row" style="width: 575px;">Poster
                                                Id</th>
                                            <td colspan="5" class="text-left"><?= $row['PosterId'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Poster Name</th>
                                            <td colspan="5" class="text-left"><?= $row['Name'] ?></td>
                                        </tr>                                       
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Posted On</th>
                                            <td colspan="5" class="text-left">
                                                <?= date("d-m-Y", strtotime($row['CreatedAt'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Question Type</th>
                                            <td colspan="5" class="text-left"><?= $row['TypeName'] ?></td>
                                        </tr>

                                        <tr>
                                            <th class="text-nowrap text-left" scope="row">Question</th>
                                            <td colspan="5" class="text-left" style="text-align: justify;">
                                                <?= $row['QuestionDescription'] ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="12">
                                                <div class="text-center">
                                                    <button type="button" class="custom-btn1 btn-2 mr-3 text-center"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal">Post&nbsp;&nbsp;Answer</button>
                                                </div>
                                                <?php
                                            }
                                        }
                                                ?>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div
                                                                class="modal-header d-block text-center pb-3 border-bttom">
                                                                <div class="row">
                                                                    <div class="col-lg-10">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Describe Answer</h5>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            onClick="window.location.reload();">
                                                                            ×
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <form method="POST" name="adminaction">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="action">Choose Question
                                                                                    Type</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="<?= $session['ques']  ?>"
                                                                                    </div>
                                                                            </div>

                                                                            <div class="col-lg-12">
                                                                                <div class="form-group mb-3">
                                                                                    <input type="hidden" name="id"
                                                                                        value="<?=$session['id']?>">
                                                                                    <label for="description">Answer
                                                                                        Description</label>
                                                                                    <textarea class="form-control"
                                                                                        name="dec" id="editor1"
                                                                                        placeholder="Description"
                                                                                        required><?= htmlspecialchars($session['ans']) ?></textarea>

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12">
                                                                                <div class="form-group mb-3 ">
                                                                                    <div class="modal-footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-yes"
                                                                                            name="update">Submit</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <script>
    CKEDITOR.replace('editor1');
    </script>

</body>

</html>