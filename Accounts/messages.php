<?php
session_start();

include "./../include/config.php"; // Include your database configuration here

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
            $sql = "UPDATE employee SET `call` = 1, callerid = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ii", $userid, $callerId); 
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

    <!-- Favicon -->
    <link rel="shortcut icon" href="./../assets/images/jiffy-favicon.ico" />
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
    <link rel="stylesheet" href="./../assets/css/message.css">
    <style>
    @media(max-width:650px){
        #header #userDetail #name {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 5px 0;
    color: #bc2d75;
    width: 80%;
}
#header p {
    font-weight: 300;
    font-size: 11px;
    width: 50px;
    padding: 2px 8px;
}
#mainSection{
    word-wrap: break-word;
}
}
  .search-content{
            display:none;
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
                                <h5>Chat</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="container">
                    <!-- header -->
                    <div id="header" style="display: flex; align-items: center; justify-content: space-between;">
                        <a href="users.php" style="text-decoration: none;">
                            <!-- Arrow icon -->
                            <i class="fas fa-arrow-left" style="font-size: 24px; color: #333;"></i>
                        </a>

                        <?php
                        $myid = $_SESSION['user_id'];
                        $userid = mysqli_real_escape_string($conn, $_GET['userid']);

                        $headerQuery = "SELECT * FROM `employee` WHERE id = '{$userid}'";
                        $runHeaderQuery = mysqli_query($conn, $headerQuery);

                        if (!$runHeaderQuery) {
                            echo "Connection failed";
                        } else {
                            $info = mysqli_fetch_assoc($runHeaderQuery);
                        ?>
                            <div style="display: flex; align-items: center;">
                                <!-- Profile image -->
                                <div id="profileImage" style="margin-right: 10px;">
                                    <img src="./../uploads/employee/<?php echo $info['profile_picture']; ?>" alt="" style="width: 56px; height: 56px; border-radius: 50%;">
                                </div>

                                <!-- User detail (name & status) -->
                                <div id="userDetail">
                                    <h3 id="name" style="margin: 0;"><?php echo $info['full_name']; ?></h3>
                                    <p id="status" style="margin: 0;"><?php echo $info['status']; ?></p>
                                </div>
                            </div>

                            <!-- Video call form -->
                            <form action="" method="POST" style="margin: 0;">
                                <input type="text" class="form-control" value="<?php echo $userid ?>" name="callerid" hidden>
                                <button class="custom-button" type="submit" id="sendMessage" >
                                <img src="./../assets/images/videocall.webp" class="videocall" alt="Videocall" />
                                </button>
                            </form>
                        <?php } ?>
                    </div>




                    <div id="mainSection">

                    </div>

                    <!-- input messages -->
                    <form action="" id="typingArea">
                        <div id="messagingTypingSection">
                            <input type="text" name="outgoing" placeholder="Type your message here..." id="outgoing" class="setid" autocomplete="off" value="<?php echo $myid; ?>" hidden>
                            <input type="text" name="incoming" placeholder="Type your message here..." id="incoming" class="setid" autocomplete="off" value="<?php echo $userid ?>" hidden>


                            <div data-toggle="tooltip" data-placement="top" title="Attach File">
                                <label for="attachFile" class="custom-icon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" fill="#3d3399">
                                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1 219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7 .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zm48 96a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm16 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v48H368c-8.8 0-16 7.2-16 16s7.2 16 16 16h48v48c0 8.8 7.2 16 16 16s16-7.2 16-16V384h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H448V304z" />
                                    </svg>

                                </label>
                            </div>
                            <input type="file" name="file" id="attachFile" style="display: none;" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.ppt,.pptx" onchange="checkFileSize(this)">
                   
                            
                            <input type="text" name="typingField" placeholder="Type your message here..." id="typingField" autocomplete="off" pattern="^(?!\s*$).+" required>
                            <button class="custom-button" type="submit" id="sendMessage">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
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
    <script src="./../assets/js/message.js"></script>
    <script src="./../assets/js/showChat.js"></script>

<script>
function updateTypingField(event) {
    const selectedFile = event.target.files[0];
    const typingField = document.getElementById('typingField');

    if (selectedFile) {
        typingField.value = selectedFile.name;
    } else {
        typingField.value = typingField.name;
    }
}

document.getElementById('attachFile').addEventListener('change', updateTypingField);
document.getElementById('attachFile').addEventListener('click', clearFields);


window.addEventListener('beforeunload', confirmLeavePage);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var userid = <?php echo json_encode($userid); ?>;
            var myid = <?php echo json_encode($myid); ?>;
            
            $.ajax({
                type: 'POST',
                url: './../project/update_message_status.php', 
                data: {
                    user_id: userid,
                    myid: myid
                },
                success: function(response) {
                    
                    console.log('Message status updated successfully.');
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error updating message status: ' + errorThrown);
                }
            });
        });
    </script>
 <script>
                            function checkFileSize(input) {
                                if (input.files.length > 0) {
                                    const file = input.files[0];
                                    if (file.size > 2 * 1024 * 1024) { 
                                        alert("File size exceeds the 2 MB limit.");
                                        input.value = ""; 
                                    }
                                }
                            }
                            </script>



</body>

</html>