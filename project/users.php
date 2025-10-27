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
    <title>Chat | PMS</title>

    <!-- Favicon -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./../assets/css/viewicon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./../assets/css/users.css">
    <style>
        .iq-search-bar {
            display: none;
        }
        
          .image{
            text-align:center;
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
    <?php
    include 'sidebar.php';
    include 'topbar.php';
    ?>

    <div class="content-page">
        <?php
        include "./../include/call.php";

        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                <h4 class="card-title">Chat</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="container">
                    <!-- header -->
                    <div id="header">
                        <?php
                        $headerQuery = "SELECT * FROM `employee` WHERE id = '{$userid}' AND active = 'active'";
                        $runHeaderQuery = mysqli_query($conn, $headerQuery);

                        if (!$runHeaderQuery) {
                            echo "connection failed";
                        } else {
                            $info = mysqli_fetch_assoc($runHeaderQuery);
                        ?>
                            <!-- profile image -->
                            <div id="headerProfile">
                                <img src="./../uploads/employee/<?php echo $info['profile_picture']; ?>" alt="">
                            </div>
                            <div id="details">
                                <!-- full name -->
                                <h3 id="headerName"><?php echo $info['full_name']; ?></h3>
                                <!-- status => Onine or Offline -->
                                <h3 id="headerStatus"><?php echo $info['status']; ?></h3>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- search box -->
                    <div id="searchBox" style="text-align: center;">
            <input type="text" id="search" placeholder="Find a Friend to Chat" autocomplete="OFF">
            <i class="fas fa-search searchButton"></i>
        </div>
<div id="onlineUsers" style="position: relative;">
        
            <div id="noSearchMessage" style="display:none; position:absolute; top:30%; left:50%; transform:translate(-50%, -50%); text-align:center; font-size: 2rem; color:red;">
                No search found
            </div>
                       <?php
                        $sql = "SELECT `employee`.*, MAX(`messages`.`date`) AS latest_message_date
                        FROM `employee`
                        LEFT JOIN `messages` ON (`employee`.`id` = `messages`.`outgoing` AND `messages`.`incoming` = '{$_SESSION["user_id"]}')
                                            OR (`employee`.`id` = `messages`.`incoming` AND `messages`.`outgoing` = '{$_SESSION["user_id"]}')
                        WHERE `employee`.`id` != '{$_SESSION["user_id"]}'
                        AND `employee`.`active` = 'active'
                        AND `employee`.`Company_id` = '$companyId'
                        GROUP BY `employee`.`id`
                        ORDER BY latest_message_date DESC;
                        ";
                        $query = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($query)) {
                            $status = ($row['status'] == 'Online') ? 'online' : 'offline';

                           $sql_team = "SELECT * FROM `messages` 
                                WHERE (incoming = {$row["id"]} AND outgoing = {$_SESSION["user_id"]}) 
                                    OR (incoming = {$_SESSION["user_id"]} AND outgoing = {$row["id"]}) 
                                ORDER BY messages_id DESC";
                            $result_team = mysqli_query($conn, $sql_team);
                            $team_row = mysqli_fetch_assoc($result_team);
                            $lastmessage =  isset($team_row['messages']) ? $team_row['messages']:'' ;

                            ?>
                            <a href="messages.php?userid=<?php echo $row["id"]; ?>">
                                <div class="profile">
                                    <div class="image">
                                        <img src="./../uploads/employee/<?php echo $row["profile_picture"]; ?>" alt="">
                                    </div>
                                    <h2 class="name"><?php echo $row["full_name"]; ?></h2>
                                    <span class="name mt-4 mx-1 text-dark" style="font-size:12px"><?= isset($lastmessage)? $lastmessage :''?></span>
                                    <div class="status <?php echo $status; ?>"></div>
                                </div>
                            </a>
                            <?php
                        }
                        ?>

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

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script file -->
    <script src="script/script.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search').addEventListener('input', function() {
                const searchInput = this.value.trim().toLowerCase();
                const userProfiles = document.querySelectorAll('#onlineUsers .profile');
                userProfiles.forEach(function(profile) {
                    const userName = profile.querySelector('.name').textContent.toLowerCase();
                    const isVisible = userName.includes(searchInput);
                    if (isVisible) {
                        profile.style.display = 'block';
                    } else {
                        profile.style.display = 'none';
                    }
                });
            });
        });
    </script> -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const onlineUsers = document.getElementById('onlineUsers');
        const profiles = onlineUsers.querySelectorAll('.profile');

        // Listen for input in the search box
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();

            // Loop through each profile in onlineUsers
            profiles.forEach(function(profile) {
                const name = profile.querySelector('.name').textContent.toLowerCase();

                // Check if the profile's name matches the query
                if (name.includes(query)) {
                    profile.style.display = 'flex'; 
                } else {
                    profile.style.display = 'none';  
                }
            });
        });
    });
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search').addEventListener('input', function() {
                const searchInput = this.value.trim().toLowerCase();
                const userProfiles = document.querySelectorAll('#onlineUsers .profile');
                userProfiles.forEach(function(profile) {
                    const userName = profile.querySelector('.name').textContent.toLowerCase();
                    const isVisible = userName.includes(searchInput);
                    if (isVisible) {
                        profile.style.display = 'block';
                    } else {
                        profile.style.display = 'none';
                    }
                });
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const userProfiles = document.querySelectorAll('#onlineUsers .profile');
        const noSearchMessage = document.getElementById('noSearchMessage');

        searchInput.addEventListener('input', function () {
            const searchQuery = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            userProfiles.forEach(function (profile) {
                const userName = profile.querySelector('.name').textContent.toLowerCase();
                if (userName.includes(searchQuery)) {
                    profile.style.display = 'block';
                    visibleCount++;
                } else {
                    profile.style.display = 'none';
                }
            });

            // Show or hide the "No search found" message
            if (visibleCount === 0) {
                noSearchMessage.style.display = 'block';
            } else {
                noSearchMessage.style.display = 'none';
            }
        });
    });
</script>


</body>

</html>