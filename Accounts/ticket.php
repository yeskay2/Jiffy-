<?php
session_start();
include "./../include/config.php";
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userid = $_SESSION["user_id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"];
    $hashtags = $_POST["hashtags"];    

    $foundHashtags = explode(',', $hashtags);
    $hashtagsString = implode(',', array_map(function($tag) {
        return '#' . trim($tag, '# '); 
    }, $foundHashtags));    

    $userid = $_SESSION["user_id"];    

    $sqlInsertPost = "INSERT INTO posts (user_id, message, hashtags) VALUES ($userid, '$message', '$hashtagsString')";
    
    if (mysqli_query($conn, $sqlInsertPost)) {
        header("Location: ticket.html");
        exit();
    } else {
        echo "Error: " . $sqlInsertPost . "<br>" . mysqli_error($conn);
    }
}
?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Leave | Jiffy</title>

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
    <script src="https://cdn.tiny.cloud/1/qz81h4aj3gd2pslrqpav1d9ogdryhq0z2ck94yxh9pnjkah1/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        #searchbar1 {
            display: none;
        }
    </style>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
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
                    <div class="col-sm-16">
                        <div class="card">
                            <div class="container-fluid gedf-wrapper">
                                <div class="row">
                                    <div class="col-md-12 gedf-main">
                                        <div class="card gedf-card">
                                            <div class="card-header">
                                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="posts-tab" data-toggle="tab"
                                                            href="#posts" role="tab" aria-controls="posts"
                                                            aria-selected="true">Make
                                                            a publication</a>
                                                    </li>                                                    
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                            <!-- index.html -->
                                                <form method="post" action="#" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="message">What are you thinking?</label>
                                                        <textarea class="form-control" id="mytextarea" name="message" rows="1" placeholder="Type your post here..."></textarea>
                                                    </div>                    
                                                    <div class="form-group">
                                                        <label for="hashtags">Add Hashtags (comma-separated):</label>
                                                        <input type="text" class="form-control" id="hashtags" name="hashtags" placeholder="e.g., #technology, #coding">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Share</button>
                                                </form>

                                        </div>
                                        </div>                                       
                                        <div class="card gedf-card">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="mr-2">
                                                            <img class="rounded-circle" width="45"
                                                                src="https://picsum.photos/50/50" alt="">
                                                        </div>
                                                        <div class="ml-2">
                                                            <div class="h5 m-0">@LeeCross</div>
                                                            <div class="h7 text-muted">Miracles Lee Cross</div>
                                                        </div>
                                                    </div>
                                                    <div>                                                        
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body">
                                                <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i> 10 min
                                                    ago</div>
                                                <a class="card-link" href="#">
                                                    <h5 class="card-title"> Lorem ipsum dolor sit amet consectetur
                                                        adipisicing elit. Velit consectetur
                                                        deserunt illo esse distinctio.</h5>
                                                </a>

                                                <p class="card-text">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam
                                                    omnis nihil, aliquam est, voluptates officiis iure soluta
                                                    alias vel odit, placeat reiciendis ut libero! Quas aliquid natus
                                                    cumque quae repellendus. Lorem
                                                    ipsum dolor sit amet consectetur adipisicing elit. Ipsa, excepturi.
                                                    Doloremque, reprehenderit!
                                                    Quos in maiores, soluta doloremque molestiae reiciendis libero
                                                    expedita assumenda fuga quae.
                                                    Consectetur id molestias itaque facere? Hic!
                                                </p>
                                                <div>
                                                    <span class="badge badge-primary">JavaScript</span>
                                                    <span class="badge badge-primary">Android</span>
                                                    <span class="badge badge-primary">PHP</span>
                                                    <span class="badge badge-primary">Node.js</span>
                                                    <span class="badge badge-primary">Ruby</span>
                                                    <span class="badge badge-primary">Paython</span>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                                                <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                                                <a href="#" class="card-link"><i class="fa fa-mail-forward"></i>
                                                    Share</a>
                                            </div>
                                        </div>                                        
                                    </div>
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
</body>

</html>