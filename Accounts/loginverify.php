<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "./../include/config.php";
require_once "./../PHPMailer/PHPMailer.php";
require_once "./../PHPMailer/SMTP.php";
require_once "./../PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UserAuthenticator
{
    private $conn;
    private $mail;
    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
       

        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
        $this->mail->Username = 'jiffymine@gmail.com';
        $this->mail->Password = 'holxypcuvuwbhylj';
        $this->mail->setFrom('jiffymine@gmail.com');
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';
    }

    public function authenticateUser($email, $password)
    {
        $query = "SELECT *  FROM employee WHERE email = ? AND user_role = 'Accountant'";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row["password"];
            $full_name = $row["full_name"];
            if (md5($password) === $storedPassword) {
                $companyId = $row["Company_id"];
                $sql = "UPDATE `employee` SET status='Online' WHERE email = '$email'";
                $result = mysqli_query($this->conn,$sql);
                $this->handleSuccessfulLogin($row["id"], $full_name,$email,$companyId);
            } else {
                $this->handleLoginFailure();
            }
        } else {
            $this->handleLoginFailure2();
        }
    }
        private function handleLoginFailure()
    {
        $_SESSION['errorr'] = 'Incorrect email or password. Please try again.';
        header('Location: index.php');
        exit;
    }
    private function handleLoginFailure2()
    {
      $_SESSION['errorr'] = 'The email ID is not available.';
        header('Location: index.php');
        exit;
    }


    private function handleSuccessfulLogin($userId, $fullName,$email,$companyId)
    {
        $_SESSION["user_id"] = $userId;
        $userID = base64_encode($userId);
        $companyIds = base64_encode($companyId);
        setcookie("user_id", $userID, time() + (86400 * 30), "/");
        setcookie("Company_id", $companyIds, time() + (86400 * 30), "/");

        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $incompleteTasks = $this->checkIncompleteTasks($userId, $yesterday);
      
        $date = date("d-m-Y");
        $attendanceExists = $this->checkAttendance($email, $date);

        if (!$attendanceExists) {
            $this->recordAttendance($userId, $date,$fullName,$email,$companyId);
        }

        header("Location: dashboard.php");
        exit;
    }

    private function checkIncompleteTasks($userId, $yesterday)
    {
        $sql = "SELECT * FROM tasks WHERE assigned_to = ? AND DATE(due_date) = ?";
        $stmtTask = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmtTask, "ss", $userId, $yesterday);
        mysqli_stmt_execute($stmtTask);
        $resultTask = mysqli_stmt_get_result($stmtTask);
        if(mysqli_num_rows($resultTask) > 0){
            return 0;
        }else{
             return 1;
        }
        
    }

    private function checkAttendance($userId, $date)
    {
        $existingAttendanceQuery = "SELECT id FROM attendance WHERE employee_id = ? AND date = ?";
        $stmt = mysqli_prepare($this->conn, $existingAttendanceQuery);
        mysqli_stmt_bind_param($stmt, "ss", $userId, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        return mysqli_stmt_num_rows($stmt) > 0;
    }

    private function recordAttendance($userId, $date,$fullName,$email,$companyId)
{
    $timeIn = date("H:i:s"); 
    $status = "1";
    $formattedTime = date("H:i");       
    $sql = "SELECT time_in FROM schedules WHERE Company_id = ?";
    $stmt = mysqli_prepare($this->conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $companyId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $intime = $row['time_in'];
         if ($formattedTime < $intime) {           
            $insert_query = "INSERT INTO attendance (employee_id, date, time_in, status, send, Company_id) VALUES (?, ?, ?, ?, 0, ?)";
            $stmt = mysqli_prepare($this->conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "sssss", $email, $date, $timeIn, $status, $companyId);
            mysqli_stmt_execute($stmt);           
           
        }else {
            $status = "1";
            $insert_query = "INSERT INTO attendance (employee_id, date, time_in, status, send, Company_id) VALUES (?, ?, ?, ?, 3, ?)";
            $stmt = mysqli_prepare($this->conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "sssss", $email, $date, $timeIn, $status, $companyId);
            mysqli_stmt_execute($stmt);
             $this->sendLateEmail($userId, $date, $timeIn,$fullName,$email);
    }
    } 
}


    private function sendLateEmail($userId, $date, $timeIn,$fullName,$email) 
    {
          $this->mail->addAddress($email);
        $html = "<html>
            <body>
                <div class='container-fluid' style='max-width: 600px; margin: 0 auto;'>
                    <img src='https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png' width='800px' height='100px' alt='Jiffy Logo' class='text-left'>
                    <hr>
                    Dear, $fullName<br>
                    <p class='text-justify'>I hope this email finds you well. I would like to take a moment to address an important matter that concerns our company's productivity and teamwork. Recently, we have noticed a consistent pattern of late logins to work from certain team members, including yourself. While we understand that unforeseen circumstances can sometimes cause delays, it's essential for all of us to uphold a consistent schedule to ensure the smooth functioning of our teams and projects.<br><br> Punctuality is not only a sign of professionalism, but it also helps us create a work environment where everyone can rely on each other to be present and ready to contribute. Timely logins contribute to effective communication, collaboration, and the overall success of our projects.<br><br>We kindly request your cooperation in ensuring that you arrive on time and log in promptly moving forward. If there are any challenges you were facing that are affecting your ability to be punctual, please feel free to reach out to your immediate supervisor or our HR department. We are here to support you and address any concerns you may have. Let's work together to maintain a positive and efficient work environment for the benefit of all team members.<br> Your commitment to punctuality is greatly appreciated and does not go unnoticed.
                        Thank you for your attention to this matter.</p>
                    <hr>
                    <p class='text-center'>Powered by Jiffy</p>
                </div>
            </body>
        </html>";

        $this->mail->Subject = 'Importance of Timely Logins';
        $this->mail->Body = $html;
        $this->mail->AddAddress('recipient@example.com');

        try {
            $this->mail->Send();
        } catch (Exception $e) {            
        }
    }

    public function authenticateotp($email)
    {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql = "SELECT * FROM employee WHERE email = '$email'";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['profile_path'] = $row['profile_picture'];
            $_SESSION['email'] = $row['email'];
            $otp = rand(1000, 99999);

            $this->mail->addAddress($email);
            $this->mail->Subject = 'OTP Verification';

            $html = "<html>
                <body>
                    <div style='max-width: 600px; margin: 0 auto;'>
                        <h2>OTP Verification</h2>
                        <p>Dear User,</p>
                        <p>Your OTP for verification is: <strong>$otp</strong></p>
                        <p>Please use this OTP to complete your verification.</p>
                        <br>
                        <p>Thank you!</p>
                    </div>
                </body>
            </html>";

            $this->mail->Body = $html;

            try {
                $this->mail->send();
                $sql = "UPDATE `employee` SET `OTP`='$otp' WHERE email = '$email'";
                $result = mysqli_query($this->conn, $sql);
                if ($result) {
                    $_SESSION['errorr'] = 'OTP sent successfully!';
                    header('Location: index.php?login=otp');
                    exit;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            }
        } else {
              $_SESSION['errorr'] = 'No employee found with this email address.';
        }
    }

    public function otpverfy($email, $otp)
    {
        $email = mysqli_real_escape_string($this->conn, $email);
        $otp = mysqli_real_escape_string($this->conn, $otp);

        $sql = "SELECT * FROM employee WHERE email = '$email' AND OTP = '$otp'";
        $result = mysqli_query($this->conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: index.php?login=reset');
            exit;
        } else {
            $_SESSION['errorr'] = 'Invalid OTP. Please try again.';
            header('Location: index.php?login=otp');
            exit;
        }
    }

    public function newpassword($email, $password, $password1)
    {
       
        if ($password === $password1) {
            $hashedPassword = md5($password);
            $email = mysqli_real_escape_string($this->conn, $email);

            $sql = "UPDATE `employee` SET `password` = '$hashedPassword' WHERE `email` = '$email'";
            $result = mysqli_query($this->conn, $sql);

            if ($result) {
                $_SESSION['success_message'] = 'Password updated successfully. You can now log in with your new password.';
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['errorr'] = 'Failed to update password. Please try again.';
                header('Location: index.php?login=reset');
                exit;
            }
        } else {
            $_SESSION['errorr'] = 'Passwords do not match. Please try again.';
            header('Location: index.php?login=reset');
            exit;
        }
    }
}

$authenticator = new UserAuthenticator($conn);
?>
