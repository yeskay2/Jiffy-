<?php
include "./../include/config.php";
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['emails'], $_POST['invite_message'])) {
        $emails = $_POST['emails'];
        $invite_message = $_POST['invite_message'];
        
        $emailsArray = json_decode($emails, true);
        
        if ($emailsArray === null) {
            $_SESSION['error'] = 'Error decoding JSON';
            header('Location: employees.php');
            exit();
        }
        
        // Assuming $companyId is defined somewhere else in your code
        if (!isset($companyId)) {
            $_SESSION['error'] = 'Company ID is not set.';
            header('Location: employees.php');
            exit();
        }

        foreach ($emailsArray as $emailData) {
            $email = $emailData['value'];
            
            $sql = "SELECT * FROM schedules WHERE Company_id = $companyId";
            $result = $conn->query($sql);
            
            if ($result === false) {
                $_SESSION['error'] = 'Database query failed: ' . $conn->error;
                header('Location: employees.php');
                exit();
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $companyName = $row['Company_name'];
                $companyLogo = str_replace('./../', '', $row['logo']);
                $companyLogoUrl = 'https://jiffy.mineit.tech/' . $companyLogo;
                $companyIdEncoded = base64_encode($row['Company_id']);
                $inviteLink = 'https://jiffy.mineit.tech/employeeregister.php?companyid=' . urlencode($companyIdEncoded);
                $companyEmail = $row['emailid'];
            } else {
                $_SESSION['error'] = 'Company information not found in database.';
                header('Location: employees.php');
                exit();
            }
            
            // Send Email using PHPMailer
            $mailer = new PHPMailer(true);
            
            try {
                // Server settings
                $mailer->isSMTP();
                $mailer->Host = 'smtp.gmail.com';
                $mailer->SMTPAuth = true;
                $mailer->Username = 'jiffymine@gmail.com'; // Update with your Gmail username
                $mailer->Password = 'holxypcuvuwbhylj'; // Update with your Gmail password
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mailer->Port = 587;
                
                // Sender info
                $mailer->setFrom($companyEmail, $companyName);
                $mailer->addAddress($email);
                
                // Email content
                $mailer->isHTML(true);
                $mailer->Subject = 'Welcome to ' . $companyName . '!';
                
                // Email body
                $mailer->Body = '
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                background-color: #f4f4f4;
                                padding: 20px;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                padding: 30px;
                                border-radius: 8px;
                                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                            }
                            .header {
                                background-color: #007bff;
                                color: #ffffff;
                                padding: 10px;
                                text-align: center;
                                border-radius: 8px 8px 0 0;
                            }
                            .content {
                                padding: 20px;
                            }
                            .footer {
                                text-align: center;
                                margin-top: 20px;
                                color: #888888;
                            }
                            .company-logo {
                                max-width: 150px;
                                margin: 0 auto;
                                display: block;
                                padding-top: 10px;
                            }
                            .button {
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                padding: 10px 20px;
                                display: inline-block;
                                border-radius: 5px;
                                margin-top: 20px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <img src="' . $companyLogoUrl . '" alt="' . $companyName . ' Logo" class="company-logo">
                                <h2>Welcome to ' . $companyName . '!</h2>
                            </div>
                            <div class="content">
                                <p>Dear New Employee,</p>
                                <p>' . nl2br(htmlspecialchars($invite_message)) . '</p>
                                <p>We are thrilled to have you join our team at ' . $companyName . '.</p>
                                <p>Click the button below to get started:</p>
                                <a href="' . $inviteLink . '" class="button">Accept Invitation</a>
                            </div>
                            <div class="footer">
                                <p>Best regards,<br>Your ' . $companyName . ' Team</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ';
                
                // Send email
                $sent = $mailer->send();
                
                if ($sent) {
                    $_SESSION['success'] = 'Invite sent successfully';
                } else {
                    $_SESSION['error'] = 'Failed to send email to ' . $email . '. Mailer Error: ' . $mailer->ErrorInfo;
                }
                
            } catch (Exception $e) {
                $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mailer->ErrorInfo;
            }
        }
        
    } else {
        $_SESSION['error'] = 'Please provide both emails and invitation message.';
    }
    
    header('Location: employees.php');
    exit();
}
?>
