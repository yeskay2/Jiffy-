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


    $sql = "INSERT INTO `community` (`user_id`, `date`, `text`,`Company_id`) VALUES (?, NOW(), ?,$companyId)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $userid, $text);
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
    <l!-- Favicon -->
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
    <style>
     
.online{
    position: relative;
}
.online::after{
    content: '';
    width: 7px;
    height: 7px;
    border: 2px solid #fff;
    border-radius: 50%;
    right: 0px;
    top: 0;
    background: #41db51;
    position: absolute;
}
.container{
    padding: 13px 5%;
    display: flex;
    justify-content: space-between;
    flex-direction: column
}
.left-sidebar{
    /* background: #cbdffa; */
    flex-basis: 25%;
    position: sticky;
    top: 70px;
    align-self: flex-start;
    padding: 10px;
}
.right-sidebar{
    background: var(--bg-color);
    flex-basis: 25%;
    position: sticky;
    top: 70px;
    align-self: flex-start;
    color: #626262;
    padding: 20px;
    border-radius: 4px;
}
.main-content{
    /* background: #cbdffa; */
    flex-basis: 47%;
}
/* ------------------ main content ------------- */
/* -------story-------- */
.story-gallery{
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.story{
    flex-basis: 18%;
    padding-top: 31.86%;
    position: relative;
    background-size: cover;
    background-position: center;
    border-radius: 10px;
}
.story1{
    background-image: linear-gradient(transparent,rgba(0,0,0,0.5)), url(images/status-1.png);
}
.story2{
    background-image: linear-gradient(transparent,rgba(0,0,0,0.5)), url(images/status-2.png);
}
.story3{
    background-image: linear-gradient(transparent,rgba(0,0,0,0.5)), url(images/status-3.png);
}
.story4{
    background-image: linear-gradient(transparent,rgba(0,0,0,0.5)), url(images/status-4.png);
}
.story5{
    background-image: linear-gradient(transparent,rgba(0,0,0,0.5)), url(images/status-5.png);
}
.story img{
    width: 45px;
    border-radius: 50%;
    border: 5px solid #1876f2;
    position: absolute;
    top: 10px;
    left: 10px;
}
.story p{
    position: absolute;
    bottom: 10px;
    width: 100%;
    text-align: center;
    color: #fff;
    font-size: 14px;
}
.story.story1 img{
    top: unset;
    left: 50%;
    bottom: 40px;
    transform: translateX(-50%);
    border: 0;
    width: 35px;
}
/* ------------write post --------- */
.write-post-container{
    width: 100%;
    background: var(--bg-color);
    border-radius: 6px;
    padding: 20px;
    color: #626262;
}
.user-profile{
    display: flex;
    align-items: center;
}
.user-profile img{
    width: 45px;
    border-radius: 50%;
    margin-right: 10px;
}
.user-profile p{
    margin-bottom: -5px;
    font-weight: 500;
    color: #626262;
}
.user-profile small{
    font-size: 12px;
}
.post-input-container{
    padding-left: 55px;
    padding-top: 20px;
}

.post-input-container textarea{
    width: 100%;
    border: 0;
    outline: 0;
    border-bottom: 1px solid #ccc;
    resize: none;
    background: transparent;
}
.add-post-links{
    display: flex;
    margin-top: 10px;
}
.add-post-links a{
    text-decoration: none;
    display: flex;
    align-items: center;
    color: #626262;
    margin-right: 30px;
    font-size: 13px;
}
.add-post-links a img{
    width: 20px;
    margin-right: 10px;
}
/* -------post list------- */


.post-container{
    width: 100%;
    background: var(--bg-color);
    border-radius: 6px;
    padding: 20px;
    color: #626262;
    margin: 20px 0;
}

.user-profile span{
    font-size: 13px;
    color: #9a9a9a;
}

.post-row{
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.post-row a{
    color: #9a9a9a;
}

.post-text{
    color: #9a9a9a;
    margin: 15px 0;
    font-size: 15px;
}
.post-text span{
    color: #626262;
    font-weight: 500;
}
.post-text a{
    color: #1876f2;
    text-decoration: none;
}
.post-img{
    width: 100%;
    border-radius: 4px;
    margin-bottom: 5px;
}
.activity-icons div img{
    width: 18px;
    margin-right: 10px;
}
.activity-icons div{
    display: inline-flex;
    align-items: center;
    margin-right: 30px;
}
.post-profile-icon{
    display: flex;
    align-items: center;
}
.post-profile-icon img{
    width: 20px;
    border-radius: 50%;
    margin-right: 5px;
}

/* --------settings-menu----------- */
.settings-menu{
    width: 90%;
    max-width: 350px;
    max-height: 0px;
    background: var(--bg-color);
    box-shadow: 0 0 10px rgba(0,0,0,0.4);
    position: absolute;
    top: 108%;
    right: 5%;
    border-radius: 4px;
    overflow: hidden;
    transition: max-height 0.3s;
}
.user-profile a{
    font-size: 12px;
    color: #1876f2;
    text-decoration: none;
}
.settings-menu hr{
    border: 0;
    height: 1px;
    background: #9a9a9a;
    margin: 15px 0;
}
.settings-links{
    display: flex;
    align-items: center;
    margin: 15px 0;
}
.settings-links .settings-icon{
    width: 38px;
    border-radius: 50%;
    margin-right: 10px;
}
.settings-links a{
    display: flex;
    flex: 1;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    color: #626262;
}
.settings-menu-height{
    max-height: 450px;
}
.settings-menu-inner{
    padding: 20px;
}

.load-more-btn{
    display: block;
    margin: auto;
    cursor: pointer;
    padding: 5px 10px;
    border: 1px solid #9a9a9a;
    color: #626262;
    background: transparent;
    border-radius: 4px;
}
.footer{
    text-align: center;
    color: #9a9a9a;
    padding: 10px 0 20px;
    font-size: 13px;
}

/*---------- dark mode button--------- */
#dark-btn{
    position:absolute;
    top: 20px;
    right: 20px;
    background: #ccc;
    width: 45px;
    border-radius: 15px;
    padding: 2px 3px;
    display: flex;
    cursor: pointer;
    transition: padding-left 0.5s, background 0.5s;
}
#dark-btn span{
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    display: inline-block;

}
#dark-btn.dark-btn-on{
    padding-left: 23px;
    background: #0a0a0a;
    
}


/* -------- profile page --------- */
.profile-container{
    padding: 20px 15%;
    color: #626262;
}
.cover-img{
    width: 100%;
    border-radius: 6px;
    margin-bottom: 14px;
}
.profile-details{
    background: var(--bg-color);
    padding: 20px;
    border-radius: 4px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}
.pd-row{
    display: flex;
    align-items: flex-start;
}
.pd-image{
    width: 100px;
    margin-right: 20px;
    border-radius: 6px;
}
.pd-row div h3{
    font-size: 25px;
    font-weight: 600;
}
.pd-row div p{
    font-size: 13px;
}
.pd-row div img{
    width: 25px;
    border-radius: 50%;
    margin-top: 12px;
}
.pd-right button{
    background: #1876f2;
    border: 0;
    outline: 0;
    padding: 6px 10px;
    display: inline-flex;
    align-items: center;
    color: #fff;
    border-radius: 3px;
    margin-left: 10px;
    cursor: pointer;
}
.pd-right button img{
    height: 15px;
    margin-right: 10px;
}
.pd-right button:first-child{
    background: #e4e6eb;
    color: #000;
}
.pd-right{
    text-align: right;
}
.pd-right a{
    background: #e4e6eb;
    border-radius: 3px;
    padding: 12px;
    display: inline-flex;
    margin-top: 30px;
}
.pd-right a img{
    width: 20px;
}
.profile-info{
    display: flex;
    align-self: flex-start;
    justify-content: space-between;
    margin-top: 20px;
}
.info-col{
    flex-basis: 33%;
}
.post-col{
    flex-basis: 65%;
}
.profile-intro{
    background: var(--bg-color);
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.profile-intro h3{
    font-weight: 600;
}
.intro-text{
    text-align: center;
    margin: 10px 0;
    font-size: 15px;
}
.intro-text img{
    width: 15px;
    margin-bottom: -3px;
}
.profile-intro hr{
    border: 0;
    height: 1px;
    background: #ccc;
    margin: 24px 0;
}
.profile-intro ul li{
    list-style: none;
    font-size: 15px;
    margin: 15px 0;
    display: flex;
    align-items: center;
}
.profile-intro ul li img{
    width: 26px;
    margin-right: 10px;
}
.title-box{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.title-box a{
    text-decoration: none;
    color: #1876f2;
    font-size: 14px;
}
.photo-box{
    display: grid;
    grid-template-columns: repeat(3, auto);
    grid-gap: 10px;
    margin-top: 15px;
}
.photo-box div img{
    width: 100%;
    cursor: pointer;
}
.profile-intro p{
    font-size: 14px;
}
.friends-box{
    display: grid;
    grid-template-columns: repeat(3, auto);
    grid-gap: 10px;
    margin-top: 15px;
}
.friends-box div img{
    width: 100%;
    cursor: pointer;
    padding-bottom: 20px;
}
.friends-box div{
    position: relative;
}

.friends-box p{
    position: absolute;
    bottom: 0;
    left: 0;
}

/* ---------------- home page media query ---------- */

@media (max-width:900px){
    nav{
        flex-wrap: wrap;
    }
    .add-post-links{
        flex-wrap: wrap;
    }

    .left-sidebar{
        display: none;      
    }
    .right-sidebar{
        display: none;
    }
    .main-content{
        flex-basis: 100%;
    }
    .logo{
        width: 110px;
        margin-right: 20px;
    }
    .search-box{
        display: none;
    }
    .nav-left ul li img{
        width: 20px;
        margin: 0 8px;
    }
    .nav-user-icon img{
        width: 30px;
    }
    .nav-user-icon{
        margin-left: 0;
    }
    .story img{
        width: 30px;
        border-width: 3px;
    }
    .story p{
        font-size: 10px;
    }
    .story.story1 img{
        width: 25px;
        bottom: 30px;
    }
    .post-input-container{
        padding-left: 0;
    }
    .add-post-links a{
        margin-right: 12px;
        font-size: 9px;
    }
    .add-post-links a img {
        width: 16px;
        margin-right: 5px;
    }
}


/* ---------------- profile page media query ---------- */

@media (max-width:900px){
    .profile-details{
        flex-wrap: wrap;
    }
    .profile-info{
        flex-wrap: wrap;
    }

    .profile-container{
        padding: 20px 5%;
    }
    .pd-row div h3{
        font-size: 16px;
    }
    .pd-right{
        margin-top: 15px;
        text-align: left;
    }
    .pd-right button{
        margin-left: 0;
        margin-right: 10px;
    }
    .info-col{
        flex-basis: 100%;
    }
    .post-col{
        flex-basis: 100%;
    }
}




    </style>
     

</head>

<body>
    <!-- Loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- Loader END -->

    <!-- Wrapper Start -->
    <div class="wrapper">
        <?php include 'topbar.php'; ?>
        <?php include 'sidebar.php'; ?>

        <div class="content-page">
        <h2 class="text-center mt-3" style="word-spacing:10px; letter-spacing:2px;">COMMUNITY DEVELOPMENT IN PROGRESS!</h2>
        <h6 class="mt-5 text-center"><span style="font-weight:bold;">Our community page is currently undergoing development to enhance your browsing experience.</span></br>Please bear with us as we work to bring you exciting new features and content.</h6>
            <div class="container-fluid" style="display:flex; align-items:center; justify-content:center;">
                
                <img src="./../assets/images/underDevelopment.gif" alt="Under Development"/>      
            <!----------------- middle content--------- -->
               <!-- <div class="main-content">
                    <div class="story-gallery">
                        <div class="story story1">
                            <img src="images/upload.png">
                            <p>Post Story</p>
                        </div>
                        <div class="story story2">
                            <img src="images/member-1.png">
                            <p>Alison</p>
                        </div>
                        <div class="story story3">
                            <img src="images/member-2.png">
                            <p>Jackson</p>
                        </div>
                        <div class="story story4">
                            <img src="images/member-3.png">
                            <p>Samona</p>
                        </div>
                        <div class="story story5">
                            <img src="images/member-4.png">
                            <p>John Doe</p>
                        </div>
                    </div>

                    <div class="write-post-container">
                        <div class="user-profile">
                            <img src="images/profile-pic.png">
                            <div>
                                <p>John Nicholson</p>
                                <small>Public <i class="fas fa-caret-down"></i></small>
                            </div>
                        </div>

                        <div class="post-input-container">
                            <textarea rows="3" placeholder="What's on your mind, Jack?"></textarea>
                            <div class="add-post-links">
                                <a href="#"><img src="images/live-video.png"> Live Video</a>
                                <a href="#"><img src="images/photo.png"> Photo/Video</a>
                                <a href="#"><img src="images/feeling.png"> Feeling/Activity</a>
                            </div>
                        </div>

                    </div>
                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <img src="images/profile-pic.png">
                                <div>
                                    <p>John Nicholson</p>
                                    <span>June 24 2021, 13:40 pm</span>
                                </div>
                            </div>
                            <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                        </div>
                        <p class="post-text">Subscribe <span>@Easy Tutorials</span> YouTube channel to watch more videos on website developement and UI designs. <a href="">#EasyTutorials</a> <a href="">#YouTubeChannel</a></p>
                        <img src="images/feed-image-1.png" class="post-img">
                        <div class="post-row">
                            <div class="activity-icons">
                                <div><img src="images/like-blue.png"> 120</div>
                                <div><img src="images/comments.png"> 45</div>
                                <div><img src="images/share.png"> 20</div>
                            </div>
                            <div class="post-profile-icon">
                                <img src="images/profile-pic.png"> <i class="fas fa-caret-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <img src="images/profile-pic.png">
                                <div>
                                    <p>John Nicholson</p>
                                    <span>June 24 2021, 13:40 pm</span>
                                </div>
                            </div>
                            <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                        </div>
                        <p class="post-text">Like and share this video with friends, tag <span>@Easy Tutorials</span> facebook page on your post. Ask you doubts in the comments <a href="">#EasyTutorials</a> <a href="">#Subscribe</a></p>
                        <img src="images/feed-image-2.png" class="post-img">
                        <div class="post-row">
                            <div class="activity-icons">
                                <div><img src="images/like.png"> 120</div>
                                <div><img src="images/comments.png"> 45</div>
                                <div><img src="images/share.png"> 20</div>
                            </div>
                            <div class="post-profile-icon">
                                <img src="images/profile-pic.png"> <i class="fas fa-caret-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <img src="images/profile-pic.png">
                                <div>
                                    <p>John Nicholson</p>
                                    <span>June 24 2021, 13:40 pm</span>
                                </div>
                            </div>
                            <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                        </div>
                        <p class="post-text">Like and share this video with friends, tag <span>@Easy Tutorials</span> facebook page on your post. Ask you doubts in the comments <a href="">#EasyTutorials</a> <a href="">#Subscribe</a></p>
                        <img src="images/feed-image-3.png" class="post-img">
                        <div class="post-row">
                            <div class="activity-icons">
                                <div><img src="images/like.png"> 120</div>
                                <div><img src="images/comments.png"> 45</div>
                                <div><img src="images/share.png"> 20</div>
                            </div>
                            <div class="post-profile-icon">
                                <img src="images/profile-pic.png"> <i class="fas fa-caret-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <img src="images/profile-pic.png">
                                <div>
                                    <p>John Nicholson</p>
                                    <span>June 24 2021, 13:40 pm</span>
                                </div>
                            </div>
                            <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                        </div>
                        <p class="post-text">Like and share this video with friends, tag <span>@Easy Tutorials</span> facebook page on your post. Ask you doubts in the comments <a href="">#EasyTutorials</a> <a href="">#Subscribe</a></p>
                        <img src="images/feed-image-4.png" class="post-img">
                        <div class="post-row">
                            <div class="activity-icons">
                                <div><img src="images/like.png"> 120</div>
                                <div><img src="images/comments.png"> 45</div>
                                <div><img src="images/share.png"> 20</div>
                            </div>
                            <div class="post-profile-icon">
                                <img src="images/profile-pic.png"> <i class="fas fa-caret-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="post-container">
                        <div class="post-row">
                            <div class="user-profile">
                                <img src="images/profile-pic.png">
                                <div>
                                    <p>John Nicholson</p>
                                    <span>June 24 2021, 13:40 pm</span>
                                </div>
                            </div>
                            <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                        </div>
                        <p class="post-text">Like and share this video with friends, tag <span>@Easy Tutorials</span> facebook page on your post. Ask you doubts in the comments <a href="">#EasyTutorials</a> <a href="">#Subscribe</a></p>
                        <img src="images/feed-image-5.png" class="post-img">
                        <div class="post-row">
                            <div class="activity-icons">
                                <div><img src="images/like.png"> 120</div>
                                <div><img src="images/comments.png"> 45</div>
                                <div><img src="images/share.png"> 20</div>
                            </div>
                            <div class="post-profile-icon">
                                <img src="images/profile-pic.png"> <i class="fas fa-caret-down"></i>
                            </div>
                        </div>
                    </div>                    
                    <button type="button" class="load-more-btn">Load More</button>
                    </div>
                </div> -->
    </div>
    </div>
    <!-- Wrapper End -->

    <?php include 'footer.php'; ?>

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
        var user_id = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
    </script>
     <script>
        $(document).ready(function () {
            var $storySection = $('.story-section');
            var $storyWidth = $('.story').outerWidth(true);
            var scrollAmount = $storyWidth * 2;

            $('.slider-left').click(function () {
                $storySection.animate({ scrollLeft: '-=' + scrollAmount }, 500);
            });

            $('.slider-right').click(function () {
                $storySection.animate({ scrollLeft: '+=' + scrollAmount }, 500);
            });
        });
    </script>
</body>
</html>





