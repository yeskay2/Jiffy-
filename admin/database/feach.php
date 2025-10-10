<?php
error_reporting(E_ALL);

require './../PHPMailer/PHPMailer.php';
require './../PHPMailer/SMTP.php';
require './../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class ProjectManager {
    private $conn;
    private $companyId;
        public function __construct($conn, $companyId)
        {
            $this->conn = $conn;
            $this->companyId = $companyId; 
        }
    public function feachdatarequriedlist()
    {
        $sql = "SELECT teamrequried.*,employee.full_name FROM teamrequried 
        JOIN employee ON employee.id = teamrequried.TeamLead
        where completed = '0' AND teamrequried.Company_id = '$this->companyId' AND teamrequried.type='hiring'";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function feachdatarequriedlist1($id)
    {
        $sql = "SELECT * FROM job_applications WHERE jobid = $id AND status = '0' AND Company_id = '$this->companyId' ";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function allfeachdatarequriedlist()
    {
        $sql = "SELECT job_applications.*,teamrequried.* FROM job_applications 
        JOIN teamrequried ON job_applications.jobid = teamrequried.Id
        where job_applications.status = '0' AND job_applications.Company_id = '$this->companyId'";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function shortlistfeachdatarequriedlist($status=null)
    {
         $today = date('Y-m-d');
        if($status=null){       
        $sql = "SELECT job_applications.*,teamrequried.* FROM job_applications 
        JOIN teamrequried ON job_applications.jobid = teamrequried.Id
        where job_applications.status = 'shortlist' AND job_applications.Company_id = '$this->companyId'";
        }else{
        $sql = "SELECT job_applications.*,teamrequried.* FROM job_applications 
        JOIN teamrequried ON job_applications.jobid = teamrequried.Id
        where job_applications.status = 'shortlist' AND DATE(job_applications.interviewdate) ='$today'  AND job_applications.Company_id = '$this->companyId'";
        }

        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function selected()
    {
        $sql = "SELECT job_applications.*,teamrequried.* FROM job_applications 
        JOIN teamrequried ON job_applications.jobid = teamrequried.Id
        where job_applications.status = 'selected' AND job_applications.Company_id = '$this->companyId'";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function rejecteddata()
    {
        $sql = "SELECT job_applications.*,teamrequried.* FROM job_applications 
        JOIN teamrequried ON job_applications.jobid = teamrequried.Id
        where job_applications.status = 'rejected' AND job_applications.Company_id = '$this->companyId'";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function hired()
    {
        $sql = "SELECT * FROM job_applications WHERE status= 'hired' AND Company_id = '$this->companyId'";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function shortlist($userid,$status=null)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $status = $_POST['status'];
    
            $select_query = "SELECT job_applications.*,teamrequried.* FROM job_applications 
            JOIN teamrequried ON teamrequried.Id = job_applications.jobid
            WHERE job_applications.id = $id";
            $sql_result = mysqli_query($this->conn, $select_query);
            $row = mysqli_fetch_assoc($sql_result);
    
            $name = $row['full_name'];
            $email = $row['email'];
            $jobroll = $row['RequiredRole'];
            $jobid = $row['jobid'];

            $company_select = "SELECT * FROM schedules WHERE company_id =$this->companyId";
            $company_result = mysqli_query($this->conn, $company_select);
            $company_row = mysqli_fetch_assoc($company_result);

            $company_name = $company_row['Company_name'];
            $company_logo_with_dotdotslash = $company_row['logo']; 
            $company_logo = str_replace('./../', '', $company_logo_with_dotdotslash);
            $base_url = 'https://jiffy.mineit.tech/jiffy/';      
            $company_logo = $base_url . $company_logo;
    
            if ($status == "shortlist") {
                $MeetingLink = $_POST['meeting_link'];
                $InterviewerName = $name;                
                $formattedDateTime = date('d-m-Y h:i A', strtotime($MeetingDateTime));
                $Roles = $_POST['roles'];
                $company_name = $_POST['companyname'];
                $acceptLink = "https://jiffy.mineit.tech/accept.php?jobid=$jobid&companyid=$this->companyId&userid=$id";

            $jiffy_message = "<html>
                    <head>
                        <title>Invitation to interview at $company_name</title>
                    </head>
                    <body style=\"font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;\">
                        <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"background-color: #ffffff; max-width: 1000px; margin: 0 auto; border-collapse: collapse;\">
                            <tr>
                                <td style=\"padding: 20px 0; text-align: center; background-color: #c72f2e;\">
                                    <h1 style=\"color: #fff;\">Your Resume Has Been Shortlisted</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style=\"padding: 20px;\">
                                    <h2>Dear $name,</h2>
                                    <p style=\"text-align:justify;\">I am pleased to inform you that your resume has been shortlisted for the 
                                    $jobroll position at $company_name. Your skills and qualifications impressed us, and we believe you could be an excellent addition to our team.</p>
                                    <p style=\"font-weight:bold;\">Interview Details</p>
                                    <p>Please click the button below to accept the interview invitation:</p>
                                    <p style=\"text-align: center;\">
                                        <a href='$acceptLink' style=\"display: inline-block; background-color: #c72f2e; color: #fff; padding: 12px 24px; font-size: 16px; font-weight: bold; text-decoration: none; border-radius: 5px; margin-top: 20px;\">Accept Interview</a>
                                    </p>
                                    <p>Thank you for your attention!</p>
                                    <p>If you have any questions or need further information, please do not hesitate to reach us.</p>
                                    <p>Thanks,<br>$company_name</p>
                                </td>
                            </tr>
                            <tr>
                                <td style=\"padding: 20px; text-align: center; background-color: #c72f2e;\">
                                    <p style=\"color: #fff; margin: 0;\">&copy; " . date("Y") . " $company_name</p>
                                </td>
                            </tr>
                        </table>
                    </body>
                </html>";


    
                $this->sendmail($id, $formattedDateTime, $name, $email, $jiffy_message);               
                 
               
                $update_query = "UPDATE job_applications SET status = ?, interviewdate = ?,interviewlink=? WHERE id = ?";
                $stmt = mysqli_prepare($this->conn, $update_query);
                mysqli_stmt_bind_param($stmt, "ssss", $status, $MeetingDateTime,$MeetingLink, $id);
    
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = 'Status updated successfully';
                    header("Location: recruitment.php");
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to update status.';
                }
            } elseif ($status == "hired") {
                 $select_query = "SELECT job_applications.*,teamrequried.* FROM job_applications 
                 JOIN teamrequried ON teamrequried.Id = job_applications.jobid
                 WHERE job_applications.id = $id";
                $sql_result = mysqli_query($this->conn, $select_query);
                $row = mysqli_fetch_assoc($sql_result);
                $jobtitle = $row['RequiredRole'];
                $due = $_POST['due'];
                $jobtitle = ucfirst($jobtitle);
                $due = date('d-m-Y', strtotime($due));
                $offer_letter_name = $_FILES['offer_letter']['name'];
                $target_directory = 'offerletter/';
                $target_file = $target_directory . basename($offer_letter_name);
    
                if (move_uploaded_file($_FILES['offer_letter']['tmp_name'], $target_file)) {
                  
                    $jobid_query = "SELECT jobid FROM job_applications WHERE id = $id";
                    $job_result = mysqli_query($this->conn, $jobid_query);
                    $job_row = mysqli_fetch_assoc($job_result);
                    $jobid = $job_row['jobid'];
    
                    $update_team_required = "UPDATE teamrequried SET number = number - 1, completed = CASE WHEN number = 0 THEN 1 ELSE completed END WHERE id = $jobid";
                    mysqli_query($this->conn, $update_team_required);    
                  
                    $offer_message = "<html>
                        <head>
                            <title>Offer Letter Initiated</title>
                        </head>
                        <body style=\"font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;\">
                            <table role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"background-color: #ffffff; max-width: 1000px; margin: 0 auto; border-collapse: collapse;\">
                                <tr>
                                    <td style=\"padding: 20px 0; text-align: center; background-color: #c72f2e;\">
                                        <h1 style=\"color: #fff;\">Job Offer - $jobtitle at $company_name</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 20px;\">
                                        <h2>Dear $name,</h2>
                                        <p>Congratulations! We are pleased to offer you the position of $jobtitle at $company_name, starting on $due. 
                                        Please review the attached offer letter for full 
                                        details and reply to this email by $due to confirm your acceptance.</p>
                                        <p>If you have any questions, feel free to reach us.</p>
                                        <p>We look forward to welcoming you to our team!</p>
                                        <p>Best Regards,<br>$company_name</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 20px; text-align: center; background-color: #c72f2e;\">
                                        <p style=\"color: #fff; margin: 0;\">&copy; " . date("Y") . " $company_name</p>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>";
    
                    $this->sendmail($id, $due, $name, $email, $offer_message, $target_file);    
                  
                    $update_query = "UPDATE job_applications SET status = ?,offer_letter = ? WHERE id = ?";
                    $stmt = mysqli_prepare($this->conn, $update_query);
                    mysqli_stmt_bind_param($stmt, "sss", $status, $offer_letter_name, $id);
    
                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['success'] = 'Status updated successfully';
                        header("Location: recruitment.php");
                        exit;
                    } else {
                        $_SESSION['error'] = 'Failed to update status.';
                    }
                } else {
                    $_SESSION['error'] = 'Failed to move uploaded offer letter file.';
                }
            } elseif ($status == 'selected') {
                $cost = !empty($_POST['cost']) ? $_POST['cost'] : "";
                $update_query = "UPDATE job_applications SET status = ?, cost = ? WHERE id = ?";
                $stmt = mysqli_prepare($this->conn, $update_query);
                mysqli_stmt_bind_param($stmt, "sss", $status, $cost, $id);
    
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = 'Status updated successfully';
                    header("Location: recruitment.php");
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to update status.';
                }
            } elseif ($status == 'hold' || $status == 'rejected') {
                $update_query = "UPDATE job_applications SET status = ? WHERE id = ?";
                $stmt = mysqli_prepare($this->conn, $update_query);
                mysqli_stmt_bind_param($stmt, "ss", $status, $id);
    
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = 'Status updated successfully';
                    header("Location: recruitment.php");
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to update status.';
                }
            }
        }
    }
    
    public function sendmail($id, $date, $name, $email, $message, $attachment = null)    {

    
        $mailer = new PHPMailer(true);
    
        try {
        
            $mailer->isSMTP();
            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = 'jiffymine@gmail.com';
            $mailer->Password = 'holxypcuvuwbhylj';
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;
    
            $mailer->setFrom('jiffymine@gmail.com'); 
            $mailer->addAddress($email, $name); 
            $mailer->Subject ='Interview Updates'; 
            $mailer->isHTML(true); 
            $mailer->Body = $message;   

            if ($attachment !== null) {
                $mailer->addAttachment($attachment); 
            }   

            $sent = $mailer->send();
    
            if ($sent) {
                $_SESSION['success'] = 'Email sent successfully';
            } else {
                $_SESSION['error'] = 'Failed to send email.';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
    }
    

    
    



    public static function getCount($conn,$companyId)    {
        $sql = "SELECT SUM(number) as count FROM teamrequried WHERE completed = 0 AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }

    public static function getCountcompleted($conn,$companyId)
    {
        $sql = "SELECT COUNT(*) as count FROM teamrequried WHERE completed = 1 AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }

    public static function getCountapplicationnew($conn,$companyId)
    {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = '0' AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }
    

    public static function getCountapplicationupdate($conn,$companyId)
    {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status!= '0' AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }
     public static function getCountshortlist($conn,$companyId) {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'shortlist' AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }
    public static function hire($conn,$companyId) {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'selected' AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }
     public static function rejected($conn,$companyId) {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'rejected' AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count;
    }
    public static function totalhirecount($conn,$companyId) {
        $sql = "SELECT SUM(`number`) AS total_number_count FROM `teamrequried` WHERE Status = 'Approved' AND Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['total_number_count'];
        return $count;
    }
    public static function totalregistercount($conn,$companyId) {
        $sql = "SELECT count(*) AS total_number_count FROM `job_applications` WHERE Company_id = '$companyId'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['total_number_count'];
        return $count;
    }
    
}

$projectManager = new ProjectManager($conn,$companyId);

$count = ProjectManager::getCount($conn,$companyId);

$countCompleted = ProjectManager::getCountcompleted($conn,$companyId);

$getCountapplicationnew = ProjectManager::getCountapplicationnew($conn,$companyId);

$getCountapplicationupdate = ProjectManager::getCountapplicationupdate($conn,$companyId);

$getCountshortlist = ProjectManager::getCountshortlist($conn,$companyId);

$hire = ProjectManager::hire($conn,$companyId);

 $rejected = ProjectManager::rejected($conn,$companyId);

$totalhirecount = ProjectManager::totalhirecount($conn,$companyId);

$totalregistercount = ProjectManager::totalregistercount($conn,$companyId);



$totalTasks = $count + $countCompleted;

$totalapplication = $getCountapplicationnew + $getCountapplicationupdate;

if ($totalapplication > 0) {
    
      $percentageapplication = (3 / 3) * 100;
} else {
    $percentageapplication = 0;
}

if ($totalTasks > 0) {
    
    $percentageCompleted = ($countCompleted / $totalTasks) * 100;
    $getCountshortlist = ($getCountshortlist / $totalTasks) * 100;
if ($totalhirecount != 0) {
    $hire = ($hire / $totalhirecount) * 100;
    $rejected = ($rejected / $totalregistercount) * 100;
} else {
    $hire = 0;
    $rejected = 0;
}

    
    
} else {
    
    $percentageCompleted = 0;
}
?>
