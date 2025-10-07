<?php
session_start();
include "./../include/config.php";
require './../PHPMailer/PHPMailer.php';
require './../PHPMailer/SMTP.php';
require './../PHPMailer/Exception.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = $_POST['text'];  

  
$sql = "INSERT INTO `community` (`user_id`, `date`, `text`,`Company_id`) VALUES (?, NOW(),?,?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iss", $userid, $text,$companyId);
$result = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($result) {
    $_SESSION['success'] = 'Message submitted successfully';
    header("Location: ticket.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
} 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Community | Jiffy</title>

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
    <link rel="stylesheet" href="./../assets/css/community.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        #community-img {
            max-width: 50px;
            border-radius: 50%;
            height: 50px;
        }
        .comment-author-ava img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
        .liked-profiles {
            margin-top: 10px;
        }
    
        .liked-profile-img {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            margin-right: 5px;
        }
    
        .comment-meta,
        .comment-date {
            margin-top: 10px;
            font-size: 12px;
            color: #888;
        }
        .scroll-button {
            display: none;
            position: fixed;
            bottom: 20px;
            z-index: 999;
        }

       .scroll-button {
            display: none;
            position: fixed;
            bottom: 20px;
            z-index: 999;
            background-color: #bc2d75;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 6px;
        }

        #scrollToTopBtn {
            right: 20px;
        }

        #scrollToBottomBtn {
            right: 60px;
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
        <?php include 'topbar.php'; ?>
        <?php include 'sidebar.php'; ?>

        <div class="content-page">
            <button id="scrollToTopBtn" class="scroll-button" onclick="scrollToTop()">
                <i class="material-icons">keyboard_arrow_up</i>
            </button>
        
            <!-- Scroll to Bottom Button -->
            <button id="scrollToBottomBtn" class="scroll-button" onclick="scrollToBottom()">
                <i class="material-icons">keyboard_arrow_down</i>
            </button>
            <?php include "./../include/call.php"; ?>

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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                               <div
                                class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                <h4 class="card-title">Community</h4>
                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                    <div data-toggle="tooltip" data-placement="top" data-trigger="hover"
                                        title="Add new Post">
                                        <a href="#" class="btn btn-community px-3 font-weight-boldr"
                                            data-target="#new-project-modal" data-toggle="modal">Post Your Comment</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                                <div id="commentsContainer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <div class="modal fade" role="dialog" aria-modal="true" id="new-project-modal">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content modal-xl">
                        <div class="modal-header d-block text-center pb-3 border-bottom">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h4 class="modal-title wordspace" id="exampleModalCenterTitle01">Create Team
                                    </h4>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="close" data-dismiss="modal">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body ">
                           <form method="post" action="#">
                                    <div class="form-group">
                                        <label for="subject" class="h5">Enter Comment</label>
                                        <textarea class="form-control form-control-rounded" name="text" id="review_text"
                                            rows="4" required></textarea>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center mt-4">
                                        <button class="btn btn-community px-3 font-weight-bold" type="submit">Submit
                                            Message</button>
                                    </div>
                                </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script/ticket.js"></script>
    <!-- Your existing script -->
    <script>
        var user_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
    </script>
    <script>
        $(document).ready(function () {
            setInterval(function () {
                var userid = <?php echo json_encode($userid); ?>;
                $.ajax({
                    type: 'POST',
                    url: './../project/comments.php',
                    data: {
                        user_id: userid,
                    },
                    success: function (response) {
                        console.log('Message status updated successfully.');
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.error('Error updating message status: ' + errorThrown);
                    }
                });
            }, 100);
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('review_text');

        function validateForm() {
            var editorData = CKEDITOR.instances.review_text.getData().trim();
            if (!editorData) {
                alert("Message is required");
                return false;
            }
            return true;
        }
    </script>
  <script>
        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0; 
        }
        function scrollToBottom() {
            window.scrollBy(0, 10000000);
        }

        function handleScroll() {
            var scrollToTopBtn = document.getElementById('scrollToTopBtn');
            var scrollToBottomBtn = document.getElementById('scrollToBottomBtn');

            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                scrollToTopBtn.style.display = 'block';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 20) {
                scrollToBottomBtn.style.display = 'none';
            } else {
                scrollToBottomBtn.style.display = 'block';
            }
        }        
        window.onscroll = handleScroll;
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