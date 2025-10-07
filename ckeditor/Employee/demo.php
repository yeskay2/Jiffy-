<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include "./../include/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $_POST['user_email'];
    $user_full_name = $_POST['user_full_name'];
    $taskName = $_POST['taskName'];
    $dec = $_POST['dec'];
    $uploader = $_POST['uploader'];
    $due_date = $_POST['due_date'];

    $mailer = new PHPMailer(true);

    try {
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'anusiyam52@gmail.com';
        $mailer->Password = 'ysimyraodahjdmus';
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;

        $mailer->setFrom('jayam4413@gmail.com', '$user_full_name');
        $mailer->addAddress($user_email, $user_full_name);
        $user_subject = 'Task assigned for you: ' . $taskName;
        $mailer->Subject = $user_subject;

        $user_message = "<html>
<head>
    <title>Service Request Confirmation</title>
</head>
<body>
    <div class='container'>
        <h2>Dear $user_full_name,</h2>
        <h3>New task assigned for you</h3>
        <p>Task Name: $taskName</p>
        <p>Description: $dec</p>
        <p>Due Date: $due_date</p>
        <p>Assigned by: $uploader</p>
        <p><a href='https://jiffy.mineit.tech/Employee/'>Click here to view the task</a></p>
    </div>
</body>
</html>";
        $mailer->Body = $user_message;
        $mailer->isHTML(true);

        $mailer->send();

        echo json_encode(array('success' => true, 'message' => 'Email sent successfully.'));
    } catch (Exception $e) {
        echo json_encode(array('success' => false, 'message' => 'Email could not been sent. Mailer Error: ' . $mailer->ErrorInfo));
    }
} else {
    
    
?>

    <!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="loading" id="loading"></div>
    <script>
        var fetchedTaskIds = [];

        function showLoading() {
            $("#loading").css("display", "block");
        }

        function hideLoading() {
            $("#loading").css("display", "none");
        }

        function fetchData() {
            showLoading();
            $.ajax({
                url: 'email.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    hideLoading();
                    if (response.success) {
                        var taskId = response.notifications[0].taskId;

                        if (fetchedTaskIds.indexOf(taskId) === -1) {
                            fetchedTaskIds.push(taskId);

                            var user_email = response.notifications[0].assignedEmail;
                            var user_full_name = response.notifications[0].assignedFullName;
                            var taskName = response.notifications[0].taskName;
                            var dec = response.notifications[0].description;
                            var uploader = response.notifications[0].uploaderFullName;
                            var due_date = response.notifications[0].due_Date;

                            showLoading(); 
                            $.ajax({
                                url: window.location.href,
                                type: 'POST',
                                data: {
                                    user_email: user_email,
                                    user_full_name: user_full_name,
                                    taskName: taskName,
                                    dec: dec,
                                    uploader: uploader,
                                    due_date: due_date
                                },
                                success: function(sendResponse) {
                                    hideLoading();
                                    console.log(sendResponse);
                                    if (sendResponse.success) {
                                        alert('Email sent successfully.');
                                        window.location.href = 'task.php';
                                    } else {
                                        
                                        window.location.href = 'task.php';
                                    }
                                },
                                error: function(sendError) {
                                    hideLoading();
                                    console.error(sendError);
                                    alert('An error occurred while sending the email.');
                                }
                            });
                        }
                    }
                },
                error: function(error) {
                    hideLoading();
                    console.error(error);
                },
                complete: function() {
                    setTimeout(fetchData, 5000);
                }
            });
        }

        // Initial fetch
        fetchData();
    </script>
</body>

</html>

   <?php }
    ?>