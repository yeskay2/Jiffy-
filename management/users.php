<?php
session_start();

include "./../include/config.php"; // Make sure this file includes database connection information.

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$userid = $_SESSION["user_id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $callerId = isset($_POST['callerid']) ? intval($_POST['callerid']) : 0;
    $callerId = max(0, $callerId);
    if ($callerId > 0) {
        try {
            $sql = "SELECT * FROM `employee` WHERE id = '{$userid}' AND active = 'active'";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                if ($stmt->execute()) {
                    $stmt->close();
                    echo '<script>';
                    echo 'var newWindow = window.open("./../video/index.php?roomID=9475&session_id=' . $userid . '", "_blank");';
                    echo 'window.location.href = "updatecall.php?userid=' . $callerId . '";'; 
                    echo '</script>';
                } else {
                    echo '<p class="text-center">Failed to update the call status (1).</p>';
                }
            } else {
                echo '<p class="text-center">Database error (first update).</p>';
            }
        } catch (Exception $e) {
            echo '<p class="text-center">An error occurred: ' . $e->getMessage() . '</p>';
        }
    } else {
        echo '<p class="text-center">Invalid caller ID.</p>';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chat | Jiffy</title>
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
        .search-content {
            display: none;
        }
      
.wrapper {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.card {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
}

.chat-container {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.profile-info {
    display: flex;
    align-items: center;
}

.profile-info img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.search-box {
    margin-bottom: 20px;
}

.search-box input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.search-box .search-icon {
    position: relative;
    top: -30px;
    right: 10px;
    color: #aaa;
    cursor: pointer;
}

.online-users .user-profile {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    background-color: #f9f9f9;
    text-decoration: none;
    color: #333;
}

.online-users .user-profile:hover {
    background-color: #e9ecef;
}

.profile-image {
    position: relative;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.status-indicator {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.online {
    background-color: #3cb371; /* Green */
}

.offline {
    background-color: #808080; /* Grey */
}

.profile-details {
    margin-left: 10px;
}

.profile-details .name {
    font-weight: bold;
    margin-bottom: 5px;
}

    </style>
</head>

<body>
    <div id="loading">
        <div id="loading-center"></div>
    </div>

    <?php
    include 'sidebar.php';
    include 'topbar.php';

    $headerQuery = "SELECT * FROM `employee` WHERE id = '{$userid}'";
    $runHeaderQuery = mysqli_query($conn, $headerQuery);

    if (!$runHeaderQuery) {
        echo "connection failed";
    } else {
        $info = mysqli_fetch_assoc($runHeaderQuery);
    ?>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h5>Chat</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div id="container">
                        <div id="header" style="display:flex ;align-items:center ;justify-content:end;">
                            
                            <div id="headerProfile">
                                <img src="./../uploads/employee/<?php echo $info['profile_picture']; ?>" alt="">
                            </div>
                            <div id="details">
                                <h3 id="headerName"><?php echo $info['full_name']; ?></h3>
                                <h3 id="headerStatus"><?php echo $info['status']; ?></h3>
                            </div>
                        </div>

                        <div id="searchBox">
                            <input type="text" id="search" placeholder="Find a Friend to Chat" autocomplete="OFF">
                            <i class="fas fa-search searchButton"></i>
                        </div>

                        <div id="onlineUsers">
                            <?php
                            $sql = "SELECT `employee`.*, MAX(`messages`.`date`) AS latest_message_date
                                    FROM `employee`
                                    LEFT JOIN `messages` ON `employee`.`id` = `messages`.`outgoing` OR `employee`.`id` = `messages`.`incoming`
                                    WHERE `employee`.`id` != '{$_SESSION["user_id"]}' AND `employee`.`status` = 'Online'
                                     AND `employee`.`active` = 'active' AND employee.Company_id = '$companyId'
                                    GROUP BY `employee`.`id`
                                    ORDER BY latest_message_date DESC";
                            $query = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($query)) {                               
                                $status = ($row['status'] == 'Online') ? 'online' : 'offline';
                             
                                echo '<a href="messages.php?userid=' . $row["id"] . '">
                                        <div class="profile">
                                            <div class="image">
                                                <img src="./../uploads/employee/' . $row["profile_picture"] . '" alt="">
                                            </div>
                                            <h2 class="name">' . $row["full_name"] . '</h2>                                           
                                            <div class="status ' . $status . '"></div>
                                        </div>
                                    </a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    include 'footer.php';
    ?>

    <script src="./../assets/js/backend-bundle.min.js"></script>
    <script src="./../assets/js/table-treeview.js"></script>
    <script src="./../assets/js/customizer.js"></script>
    <script async src="./../assets/js/chart-custom.js"></script>
    <script async src="./../assets/js/slider.js"></script>
    <script src="./../assets/js/app.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {   
    document.getElementById('search').addEventListener('input', function () {
        const searchInput = this.value.trim().toLowerCase();       
        const userProfiles = document.querySelectorAll('#onlineUsers .profile');   
        userProfiles.forEach(function (profile) {
            const userName = profile.querySelector('.name').textContent.toLowerCase();
            const isVisible = userName.includes(searchInput);          
            if (isVisible) {
                profile.style.display = 'block'; 
            } else {
                profile.style.display = 'none';             }
        });
    });
});

    </script>
</body>

</html>
