<?php
require './../PHPMailer/PHPMailer.php';
require './../PHPMailer/SMTP.php';
require './../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class TaskManager
{
    private $conn;
    private $companyId;

    public function __construct($conn,$companyId)
    {
        $this->conn = $conn;
        $this->companyId = $companyId;
    }

    public function deleteTask($trainid)
    {
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $trainid);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($result) {
                $_SESSION['success'] = 'Task deleted successfully';
                header("Location: task.php");
                exit();
            } else {
                $_SESSION['error'] = 'Something went wrong while deleting';
            }
        }
    }

    public function addTask($userid)
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $uploaderid = $userid;
            $project = $_POST["projectid"];
            $taskName = $_POST["taskName"];
            $assignedTo = $_POST["assignedTo"];
            $dueDate = $_POST["dueDate"];
            $original_date = $dueDate;
            $timestamp = strtotime($original_date);
            $formatted_date = date('d-m-Y', $timestamp);
            $category = $_POST["category"];
            $description = $_POST["description"];
            $checklist = $_POST["checklist"];
            $start_date = $_POST["startdate"];
            $todo = "Todo";
            $random = mt_rand(10, 10000);
            $ticket = "T-" . $random;
            $fileCount = count($_FILES['projectDocument']['name']);
            $targetDir = "./../uploads/task/";
            $modules = $_POST['modules'];
            $perferstrt = date('H:i', strtotime($_POST['startperTime']));
            $perferend = date('H:i', strtotime($_POST['endperTime']));
            $uploadedFiles = [];
                for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES['projectDocument']['name'][$i];
                $fileSize = $_FILES['projectDocument']['size'][$i];
                 if ($fileSize > (5 * 1024 * 1024)) {
                 $_SESSION['error'] = 'File size limit exceeded. Maximum file size allowed is 5 MB.';
                  header("Location: task.php");
                    exit;
                 }
                $fileTmpName = $_FILES['projectDocument']['tmp_name'][$i];
                $uniqueFileName = uniqid() . '_' . $fileName;
                $targetFilePath = $targetDir . $uniqueFileName;
                if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                    $uploadedFiles[] = $uniqueFileName;
                }
            }
            $documentAttachment = implode(', ', $uploadedFiles);
            $sql = "INSERT INTO tasks (projectid, uploaderid, task_name, assigned_to, 
            due_date, category, description, checklist, document_attachment, status, ticket,
            Actual_start_time,modules_name,perferstart_time,perferend_time,Company_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)";
            $stmt = mysqli_prepare($this->conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $project, $uploaderid, $taskName, $assignedTo, 
                $dueDate, $category, $description, $checklist, $documentAttachment, $todo, $ticket,
                $start_date,$modules,$perferstrt,$perferend,$this->companyId);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    $query = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_assigned.email AS assigned_email,e_uploader.full_name AS uploader_full_name,
                    objectives.project_name FROM  tasks t LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id LEFT JOIN  
                    employee e_uploader ON t.uploaderid = e_uploader.id LEFT JOIN objectives ON t.projectid = objectives.id WHERE t.status = 'Todo' AND t.ticket = '$ticket'
                    ORDER BY t.created_at DESC";
                    $result = mysqli_query($this->conn, $query);
                    $mailer = new PHPMailer(true);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $taskId = $row['id'];
                            $assignedFullName = $row['assigned_full_name'];
                            $assignedEmail = $row['assigned_email'];
                            $uploaderFullName = $row['uploader_full_name'];
                            $project_name = $row['project_name'];
                            if ($category === "Bug") {
                                $buttonClass = "custom-button bug";
                            } elseif ($category === "Improvement") {
                                $buttonClass = "custom-button success";
                            } else {
                                $buttonClass = "custom-button task";
                            }
                            try {
                                $mailer->isSMTP();
                                $mailer->Host = 'smtp.gmail.com';
                                $mailer->SMTPAuth = true;
                                $mailer->Username = 'jiffymine@gmail.com';
                                $mailer->Password = 'holxypcuvuwbhylj';
                                $mailer->SMTPSecure = 'tls';
                                $mailer->Port = 587;

                                $mailer->setFrom('jayam4413@gmail.com', $uploaderFullName);
                                $mailer->addAddress($assignedEmail, $assignedFullName);
                                $user_subject = 'Task assigned for you: ' . $taskName;
                                $mailer->Subject = $user_subject;


                                $user_message = "<html>

        <head>

            <title>Service Request Confirmation</title>

            <style>

            .btn-primary{

                text-decoration: none;

                width: 200px !important;

                height: 200px !important;

                padding: 10px 10px !important;

                background-color: #5047a3!important;

                color: #fff !important;

                border-radius: 10px !important;

            }

            .btn-primary:hover{

                background-color: #3d3399 !important;

            }

            .custom-button {

                display: inline-block;

                font-family: 'Roboto', sans-serif;

                font-size: 12px;

                color: black;

                text-align: center;

                vertical-align: middle;

                user-select: none;

                background-color: transparent;

                border: 1px solid transparent;

                padding: 5px;

                line-height: 1;

                border-radius: 8px;

                cursor: default;

              }

       

              .bug,.bug:hover {

                color: #fff;

                background-color: red;

                border-color: red;

                box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.2);

        }

                .success,.success:hover {

                color: #fff;

                background-color: green !important;

                border-color: green !important;

                box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.2);

                }

                .task,.task:hover {

                color: #fff;

                background-color: blue !important;

                border-color: blue !important;

                box-shadow: 4px 4px 6px rgba(0, 0, 0, 0.2);

                }
                
                .text-right {
                    margin-left:65%;
                }
                .para{
                    text-align:center; 
                    color:#3d3399;
                    font-size:15px;
                    font-weight:500;
                }

            </style>

        </head>

        <body>

            <div class='container' style='color:black;'>

                <h3>Dear $assignedFullName ,</h3>

                <h4>New task assigned for you </h4>
                
                <a href='jiffy.mineit.tech'><img src='https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png' width='150px' height='30px' alt='Jiffy Logo'/ class='text-right'></a>

                <div class='container-fluid' style=' max-width: 600px; margin: 0 auto;'>

                <p style='font-size: 20px; color: #3d3399; font-weight:bold;'>$taskName</p>

                <p>Project Name:$project_name</p>

                <hr>

                <p><span style='font-weight:bold'>Assigned by &nbsp;: </span>$uploaderFullName</p>

                <p><span style='font-weight:bold'>Task Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span><button type='button' class='$buttonClass'>$category</button></p>

                <p><span style='font-weight:bold'>Due Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>
                
                
                 $formatted_date
                
                </p>

                <br>

                <br>

                <a type='button' class='btn btn-primary' href='https://jiffy.mineit.tech/project'>View Details</a>

                <br>

                <br>

                <hr>

                <br>

                </div>

                <p class='para'>Powered By <a href='jiffy.mineit.tech'><span style='color:#3d3399; text-decoration:none;'>JIFFY</span></a></p>
            </div>
        </body>
        </html>";

                                $mailer->Body = $user_message;
                                $mailer->isHTML(true);
                                $mailer->send();

                                $_SESSION['success'] = 'Task has been added successfully';
                                header("Location: task.php");
                                exit();
                            } catch (Exception $e) {
                                $_SESSION['error'] = 'Task has been added successfully Email Not Send Network';
                                header("Location: task.php");
                            }
                            exit;
                        }
                    }
                }
            }
        }
    }

public function applyLeave($userid,$modules = null)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_id = $userid;
        $leavetype = $_POST["leavetype"];
        $description = $_POST["description"];

        if (!empty($_POST['fromtime'])) {
            $starttime = $_POST['fromtime'];
            $endtime = $_POST['totime'];
            $lop = 0;
            
            $sql = "INSERT INTO tblleaves (empid, leave_type, description, Company_id, starttime, endtime,leave_lop) VALUES (?, ?, ?, ?, ?, ?,?)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssssss", $user_id, $leavetype, $description, $this->companyId, $starttime, $endtime,$lop);
                if ($stmt->execute()) {
                    $stmt->close();
                    $_SESSION['success'] = 'Leave has been applied successfully';
                    if(!empty($modules)){
                          header("Location: addhoildays.php");
                           exit();
                            }else{
                                header("Location: leave.php");
                            exit();
                            }
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Error: Statement execution failed.'));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error: Statement preparation failed.'));
            }
        } else {

            $fromdate = $_POST["fromdate"];
            $todate = $_POST["todate"];
            $fromDateTime = new DateTime($fromdate);
            $toDateTime = new DateTime($todate);
            $interval = $fromDateTime->diff($toDateTime);
            $daysCount = $interval->days + 1;
           if( $leavetype =='Others'){
            $isLOP = 1;
                    $sql = "INSERT INTO tblleaves (empid, leave_type, to_date, from_date, description, Company_id, days_count, leave_lop) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("sssssisi", $user_id, $leavetype, $todate, $fromdate, $description, $this->companyId, $daysCount, $isLOP);
                        if ($stmt->execute()) {
                            $stmt->close();
                            $_SESSION['success'] = 'Leave has been applied successfully';
                            if(!empty($modules)){
                          header("Location: addhoildays.php");
                           exit();
                            }else{
                                header("Location: leave.php");
                            exit();
                            }
                            
                        } else {
                            echo json_encode(array('success' => false, 'message' => 'Error: Statement execution failed.'));
                        }
                    } else {
                        echo json_encode(array('success' => false, 'message' => 'Error: Statement preparation failed.'));
                    }
           } 

            
            if (empty($description)) {
                echo '<script>alert("Description cannot be empty");</script>';
                echo '<script>window.location.href = "leave.php";</script>';
                exit();
            }
            


            $sql = "SELECT days_count FROM holiday WHERE company_id = ? AND id = ?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ii", $this->companyId, $leavetype);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $available_leave = $row['days_count'];

                    $leave_sql = "SELECT SUM(days_count) AS count FROM tblleaves WHERE company_id = ? AND leave_type = ? AND empid = ? AND MONTH(from_date) = MONTH(?) AND YEAR(from_date) = YEAR(?)";
                    $leave_stmt = $this->conn->prepare($leave_sql);
                    $leave_stmt->bind_param("sssss", $this->companyId, $leavetype, $userid, $fromdate, $fromdate);
                    $leave_stmt->execute();
                    $leave_result = $leave_stmt->get_result();

                    if ($leave_result && $leave_result->num_rows > 0) {
                        $leave_row = $leave_result->fetch_assoc();
                        $already_taken_leave_count = $leave_row['count'] ?? 0;
                        $pendingleave = $available_leave - $already_taken_leave_count;
                        
                        if ($daysCount > $pendingleave) {
                            $_SESSION['success'] = "You don't have enough leave days. You have $pendingleave days left.";
                            if(!empty($modules)){
                          header("Location: addhoildays.php");
                           exit();
                            }else{
                                header("Location: leave.php");
                            exit();
                            }
                        }
                    } else {
                        $pendingleave = $available_leave;
                    }

                    $isLOP = $this->isLOP($user_id, $leavetype, $fromDateTime, $toDateTime, $daysCount);

                    $sql = "INSERT INTO tblleaves (empid, leave_type, to_date, from_date, description, Company_id, days_count, leave_lop) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("sssssisi", $user_id, $leavetype, $todate, $fromdate, $description, $this->companyId, $daysCount, $isLOP);
                        if ($stmt->execute()) {
                            $stmt->close();
                            $_SESSION['success'] = 'Leave has been applied successfully';
                            if(!empty($modules)){
                          header("Location: addhoildays.php");
                           exit();
                            }else{
                                header("Location: leave.php");
                            exit();
                            }
                        } else {
                            echo json_encode(array('success' => false, 'message' => 'Error: Statement execution failed.'));
                        }
                    } else {
                        echo json_encode(array('success' => false, 'message' => 'Error: Statement preparation failed.'));
                    }
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Error: Could not retrieve available leave.'));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Error: Statement preparation failed.'));
            }
        }
    }
}




private function isLOP($user_id, $leavetype, $fromDateTime, $toDateTime, $daysCount)
{
    $currentMonth = $fromDateTime->format('m');
    $currentYear = $fromDateTime->format('Y');

    $query = "SELECT SUM(days_count) AS total_days FROM tblleaves WHERE empid = ? AND leave_type = ? AND MONTH(from_date) = ? AND YEAR(from_date) = ? AND leave_lop = 0";
    $stmt = mysqli_prepare($this->conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "siii", $user_id, $leavetype, $currentMonth, $currentYear);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $totalDays);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $newTotalDays = $totalDays + $daysCount;

        $sql = "SELECT days_count FROM holiday WHERE company_id = ? AND id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $this->companyId, $leavetype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $count = $row['days_count'];
                if ($newTotalDays > $count) {
                    return 1; 
                } else {
                    return 0; 
                }
            }
        }
    }
    return 1; 
}



    
public function updateTask($userid)
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $taskId = $_POST["id"];
        $taskName = $_POST["taskName"];
        $assignedTo = $_POST["assignedTo"];
        $dueDate = $_POST["dueDate"];
        $category = $_POST["category"];
        $description = $_POST["description"];
        $checklist = $_POST["checklist"];
        $projectid = $_POST["projectid"];
        $fileCount = count($_FILES['projectDocument']['name']);
        $targetDir = "./../uploads/task/";
        $uploadedFiles = [];
        $path = $_POST['path'];
        $modules = $_POST['modules'];
        $perstartdate = date("H:i", strtotime($_POST['startperTime']));
        $perendtime = date("H:i", strtotime($_POST['endperTime']));
        $actual_start_date = $_POST["startdate"];
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES['projectDocument']['name'][$i];
            $fileSize = $_FILES['projectDocument']['size'][$i];
            $fileTmpName = $_FILES['projectDocument']['tmp_name'][$i];
            $uniqueFileName = uniqid() . '_' . $fileName;
            $targetFilePath = $targetDir . $uniqueFileName;

            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                $uploadedFiles[] = $uniqueFileName;
            }
        }      
        $sql = "SELECT document_attachment FROM tasks WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $currentAttachment);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if(empty($currentAttachment)) {
            $documentAttachment = implode(', ', $uploadedFiles);
        }else{
            $documentAttachment = $currentAttachment .",". implode(', ', $uploadedFiles);
        } 
        $sql = "UPDATE tasks 
                SET projectid=?, task_name = ?, assigned_to = ?, due_date = ?, category = ?, 
                description = ?, checklist = ?, document_attachment = ?,modules_name = ?,perferstart_time=?,
                perferend_time=?,Actual_start_time = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssssssss",$projectid, $taskName, $assignedTo, $dueDate, $category,
             $description, $checklist, $documentAttachment,$modules,$perstartdate,$perendtime,$actual_start_date,$taskId);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                $_SESSION['success'] = 'Task has been updated successfully';
                if($assignedTo == $userid){
                     header("Location: task.php");
                    exit();
                }else{
                    header("Location: edittask.php?id=$taskId&cod=$path");
                    exit();
                }
                
            } else {
                echo "Error updating task: " . mysqli_error($this->conn);
            }
        } else {
            echo "Error preparing update statement: " . mysqli_error($this->conn);
        }
    }
}
public function requrement()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $name = $_POST["name"];
        $email  =$_POST["email"];

        $sql = "INSERT INTO requirement (name, email) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        if ($stmt) 
        {
            mysqli_stmt_bind_param($stmt, "ss", $name, $email);
            if (mysqli_stmt_execute($stmt)) 
            {
                mysqli_stmt_close($stmt);
                $_SESSION['success'] = 'Requirement has been added successfully';
                header("Location: requirement.php");
                exit();
            }
        }

        }
}
    public function project($uploaderid)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $id = $_SESSION["user_id"];
        $projectName = $_POST["projectName"];
        $dueDate = $_POST["end_date"];
        $priority = $_POST["priority"];
        $shortDescription = $_POST["shortDescription"];
        $assigndep = isset($_POST['selecteddpt']) ? $_POST['selecteddpt'] : array();
        $assignMembers = isset($_POST['selectedMembers']) ? $_POST['selectedMembers'] : 0;
        if($assignMembers==0){
            $employeeId = null;
        } else
        {
            $employeeId = implode(", ", $assignMembers);
        }
        
        $dpt = implode(", ", $assigndep);
        $progress = 0;
        $location = $_POST["location"];
        $budget = $_POST["budget"];
        $startdate = $_POST["start_date"];
        $moduleNames = isset($_POST['moduleNames']) ? $_POST['moduleNames'] : array();
        $placeholders = implode(", ", $moduleNames);
        $tasks = isset($_POST['tasks']) ? $_POST['tasks'] : array();
        $tasks = implode(", ", $tasks);
        $selectedleader =isset($_POST['selectedleader']) ? $_POST['selectedleader'] : array();
        $selectedleader1 = implode(",", $selectedleader);
        $projectmanger = $_POST['selectedproject'];
        $no_resources = $_POST['resources'];
        $resources_requries = $_POST['add-resources'];
        $hours = $_POST['totalhours'];
        $per_day_working_hours = $_POST['perday'];

        $client = $_POST['clentid'];

        if ($_FILES["projectDocument"]["name"]) {
            $targetDir = "./../uploads/projects/";
            $originalFileName = pathinfo($_FILES["projectDocument"]["name"], PATHINFO_FILENAME);
            $fileExtension = pathinfo($_FILES["projectDocument"]["name"], PATHINFO_EXTENSION);
            $fileName = $originalFileName . "-" . rand(1000, 9999) . "." . $fileExtension;
            if (move_uploaded_file($_FILES["projectDocument"]["tmp_name"], $targetDir . $fileName)) {

                $query = "INSERT INTO objectives (project_name, due_date, priority, description, progress, start_date, members, location, 
                budget, document_attachment,department,modules,no_resource,no_resources_requried,lead_id,project_manager_id,
                totalhours,perday,tasks,Company_id,uploaderid,client_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_prepare($this->conn, $query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssss", $projectName, $dueDate, $priority, $shortDescription, $progress, $startdate,
                        $employeeId, $location, $budget, $fileName, $dpt, $placeholders, $no_resources, 
                        $resources_requries,$selectedleader1,$projectmanger,$hours,$per_day_working_hours,$tasks,$this->companyId,$uploaderid,$client);

                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['success'] = 'Project added successfully';
                    } else {
                        $_SESSION['error'] = 'Failed, Try again';
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $_SESSION['error'] = 'Statement preparation failed.';
                }

                header('location: project.php');
                exit();
            } else {
                $_SESSION['error'] = 'File upload failed.';
            }
        } else {
            $_SESSION['error'] = 'Project document not provided.';
        }

        header('location: project.php');
        exit();
    }


    public function deleteProject($projectId) {   
          
        $query = "DELETE FROM objectives WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $projectId);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = 'Project Delete successfully';
                mysqli_stmt_close($stmt);
                header('location: project.php');
                exit(); 
            } else {
                $_SESSION['error'] = 'Project  Delete Failed.';
                header('location: project.php');
                exit(); 
            }
        } else {
            return 'Statement preparation failed.';
        }
    }
    public function updateProject() {
        $projectId = $_POST["projectId"];
        $projectName = $_POST["projectName"];
        $assignDepartments = isset($_POST['selecteddpt']) ? $_POST['selecteddpt'] : [];
        $assignMembers = isset($_POST['selectedMembers']) ? $_POST['selectedMembers'] : [];
        $selectedDepartments = implode(", ", $assignDepartments);
        $selectedMembers = implode(", ", $assignMembers);
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $budget = $_POST["budget"];
        $priority = $_POST["priority"];
        $location = $_POST["location"];
        $shortDescription = $_POST["shortDescription"];
        $projectDocument = $_FILES["projectDocument"];
        $moduleNames = isset($_POST['moduleNames']) ? $_POST['moduleNames'] : [];
        $placeholders = implode(", ", $moduleNames);
        $leader = isset($_POST['selectedleader']) ? $_POST['selectedleader'] : [];
        $leader = implode(", ", $leader);
        $projectmanager = $_POST['selectedproject'];
        $hours = $_POST['totalhours'];
        $per_day_working_hours = $_POST['perday'];
        $no_resources = $_POST['resources'];
        $resources_requries = $_POST['add-resources'];
        $dpt = is_array($assignDepartments) ? implode(",", $assignDepartments) : $selectedDepartments;
        $employeeId = is_array($assignMembers) ? implode(",", $assignMembers) : $selectedMembers;
        $start_date = !empty($start_date) ? $start_date : NULL;
        $client = $_POST['clentid'];
        $tasks = isset($_POST['tasks']) ? $_POST['tasks'] : array();
        $tasks = implode(", ", $tasks);
    
        if (!empty($projectDocument['name'])) {
            $targetDir = "./../uploads/projects/";
            $originalFileName = pathinfo($_FILES["projectDocument"]["name"], PATHINFO_FILENAME);
            $fileExtension = pathinfo($_FILES["projectDocument"]["name"], PATHINFO_EXTENSION);
            $fileName = $originalFileName . "-" . rand(1000, 9999) . "." . $fileExtension;
    
            if (move_uploaded_file($projectDocument['tmp_name'], $targetDir . $fileName)) {
                $query = "UPDATE objectives SET project_name=?, start_date=?, due_date=?, budget=?, priority=?, location=?, description=?, document_attachment=?, department=?, members=?, no_resource=?, no_resources_requried=?, lead_id=?, project_manager_id=?, totalhours=?, perday=?,client_id=?,tasks=? WHERE id=?";
                $stmt = mysqli_prepare($this->conn, $query);
    
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ssssssssssissssssss", $projectName, $start_date, $end_date, $budget, $priority, $location, $shortDescription, $fileName, $dpt, $employeeId, $no_resources, $resources_requries, $leader, $projectmanager, $hours, $per_day_working_hours,$client,$tasks,$projectId);
    
                    if (mysqli_stmt_execute($stmt)) {
                        return 'Project updated successfully';
                    } else {
                        return 'Failed to update project. Try again.';
                    }
                } else {
                    return 'Statement preparation failed.';
                }
            } else {
                return 'File upload failed.';
            }
        } else {
            $query = "UPDATE objectives SET project_name=?, start_date=?, due_date=?, budget=?, priority=?, location=?, description=?, department=?, members=?, modules=?, no_resource=?, no_resources_requried=?, lead_id=?, project_manager_id=?, totalhours=?, perday=?,client_id=?,tasks=? WHERE id=?";
            $stmt = mysqli_prepare($this->conn, $query);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssssssssssssssss", $projectName, $start_date, $end_date, $budget, $priority, $location, $shortDescription, $dpt, $employeeId, $placeholders, $no_resources, $resources_requries, $leader, $projectmanager, $hours, $per_day_working_hours,$client,$tasks,$projectId);
    
                if (mysqli_stmt_execute($stmt)) {
                    return 'Project updated successfully';
                } else {
                    return 'Failed to update project. Try again.';
                }
            } else {
                return 'Statement preparation failed.';
            }
        }
    }
    


public function addTimeline($userid) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $projectid = mysqli_real_escape_string($this->conn, $_POST['projectid']);
    $startTime = isset($_POST['startTime']) ? date('h:i A', strtotime($_POST['startTime'])) : '';
    $start_t2 = isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '';
    $start_t1 = isset($_POST['startdate']) ? date('d-m-Y', strtotime($_POST['startdate'])) : '';
    $endTime = isset($_POST['endTime']) ? date('h:i A', strtotime($_POST['endTime'])) : '';
    $activity = mysqli_real_escape_string($this->conn, $_POST['activity']);
    $start_t =  isset($_POST['startTime']) ? date('d-m-Y h:i A', strtotime($_POST['startTime'])) : '';
    $meetingType = isset($_POST['meetingType']) ? $_POST['meetingType'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $dec = isset($_POST['meetingSubject']) ? mysqli_real_escape_string($this->conn, $_POST['meetingSubject']) : mysqli_real_escape_string($this->conn, $_POST['enterTask']);
    $startTime = $start_t1 .' '.$startTime;
     $endTime = $start_t1 . ' '. $endTime;
    $participate_id = 0;
    if(isset($_POST['selectedMembers'])){
        $participate_id = is_array($_POST['selectedMembers']) ? implode(",", $_POST['selectedMembers']) : $_POST['selectedMembers'];
        $participate_id = mysqli_real_escape_string($this->conn, $participate_id);
    }

    if ($activity == "meeting") {
        $meetingLink = mysqli_real_escape_string($this->conn, $_POST['meetingLink']);
        $sql1 = "INSERT INTO timeline (start_time, end_time, project_id, activity,meeting_type, meeting_link,meeting_location, emp_id, participate_id, task_description,start_t,Company_id) 
        VALUES ('$startTime', '$endTime', '$projectid', '$activity','$meetingType', '$meetingLink', '$location', 
        '$userid','$participate_id', '$dec','$start_t2','$this->companyId')";
    } 
    $result = mysqli_query($this->conn, $sql1);
    if($result){
        $lastInsertedId = mysqli_insert_id($this->conn);
    $sql = "SELECT * FROM objectives WHERE id = $projectid";
    $result = mysqli_query($this->conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $project_name= $row['project_name'];
    
    $sql_profile = "SELECT full_name FROM employee WHERE id IN ($participate_id)";
    $result_profile = mysqli_query($this->conn, $sql_profile);
    $full_names = [];
    if(mysqli_num_rows($result_profile) > 0){
        while ($row_profile = mysqli_fetch_assoc($result_profile)) {
            $full_names[] = $row_profile['full_name'];
        }
    }
    $participant_names = implode(', ', $full_names);
    $sql1 = "SELECT full_name FROM employee WHERE id = $userid";
    $result1 = mysqli_query($this->conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    //company detials
    $sql2 = "SELECT * FROM schedules WHERE Company_id = '$this->companyId'";
    $result2 = mysqli_query($this->conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $company_name = $row2['Company_name'];

    $full_name = $row1['full_name'];
    if (mysqli_query($this->conn, $sql)) {
        foreach(explode(',', $participate_id) as $participant_id) {
            $sql_email = "SELECT * from employee WHERE id = '$participant_id'";
            $result = mysqli_query($this->conn, $sql_email);
            if(mysqli_num_rows($result) > 0){
                $mailer = new PHPMailer(true);
                while ($row = mysqli_fetch_assoc($result)) {
                    $to = $row['email'];
                    $full_name = $row['full_name'];
                    try {
                        $mailer->isSMTP();
                        $mailer->Host = 'smtp.gmail.com';
                        $mailer->SMTPAuth = true;
                        $mailer->Username = 'jiffymine@gmail.com';
                        $mailer->Password = 'holxypcuvuwbhylj';
                        $mailer->SMTPSecure = 'tls';
                        $mailer->Port = 587;
                        $mailer->setFrom('jiffymine@gmail.com', 'Meeting Scedule By'.$full_name);
                        $mailer->addAddress($to);
                        $mailer->Subject = 'Meeting Invitation: ' . $dec;
                        $message = '<!doctype html>
                                <html lang="en-US">
                                <head>
                                    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                                    <title>Meeting Mail</title>
                                    <meta name="description" content="Meeting Mail">
                                </head>
                                <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
                                    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
                                        <tr>
                                            <td>
                                                <table style="background-color: #f2f3f8; max-width:1000px; margin:0 auto;" width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="height:80px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center;">
                                                            <a href="https://jiffy.mineit.tech" title="logo" target="_blank">
                                                                <img width="200" src="https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png" style="width: 50%; max-width: 200px;" title="logo" alt="logo">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="height:20px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px; background:#fff; border-radius:3px; -webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06); -moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06); box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                                                <tr>
                                                                    <td style="height:40px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:0 35px;">
                                                                        <div style="text-align: center;">
                                                                            <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;">Hello ' . $full_name . ',</h1>
                                                                            <p style="font-size:15px; color:#455056; margin:8px 0 0; line-height:24px;"></p>
                                                                            <p>You are invited to a meeting organized by ' . $full_name . '.</p>
                                                                            <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;">'.'Regarding - ' . $dec . '</span>
                                                                        </div>
                                                                        <p style="color:#455056; font-size:16px; line-height:40px; margin:0; font-weight: 500;">
                                                                            <strong style="display: inline; font-size: 17px; font-weight:bolder;">Project Name</strong>&emsp;--&emsp;' . $project_name . '<br>
                                                                            <strong style="display: inline;font-size: 17px; margin-right:10px; font-weight:bolder;">Date</strong>&emsp;--&emsp;' . date('d-m-Y', strtotime($startTime)) . '<br>
                                                                            <strong style="display: inline;font-size: 17px; font-weight:bolder;">Start Time</strong>&emsp;--&emsp;' . date('h:i A', strtotime($start_t)) . '<br>
                                                                            <strong style="display: inline;font-size: 17px; font-weight:bolder;">End Time</strong>&emsp;--&emsp;' . date('h:i A', strtotime($endTime)) . '<br>
                                                                            <strong style="display: inline;font-size: 17px; font-weight:bolder;">Meeting</strong>&emsp;--&emsp;' . $meetingType . '<br>                                                                          
                                                                            <strong style="display: inline;font-size: 17px; margin-right:10px; font-weight:bolder;">Attendees</strong>&emsp;--&emsp;' . $participant_names . '

                                                                            </div>                                        
                                                                        </p>
                                                                        <div style="margin-top:20px; display: flex; justify-content: center; align-items: center;text-align:center;">
                                                                            <a href="http://jiffy.mineit.tech/jiffy/project/meetingid.php?meetingid=' . $lastInsertedId . '&&userid=' . $participant_id . '" style="background-color:#3d3399; color:#fff; padding:15px;">Response Now</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height:40px;">&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="height:20px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center;">
                                                            <a href="https://mineit.tech/" target="_blank" style="font-size:14px; color:#c72f2e; line-height:18px; margin:0 0 0; text-decoration:none;">&copy; <strong>' . $company_name . '</strong></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="height:80px;">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </body>
                                </html>';

                        $mailer->Body = $message;
                        $mailer->isHTML(true);
                        
                        if($mailer->send()) {
                           
                        } else {
                            
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = 'Failed to send email notification: ' . $e->getMessage();
                        header('location: timeline.php');
                        exit();
                    }
                }
            }
        }
        $_SESSION['success'] = 'Timeline added successfully';
        header('location: timeline.php');
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        header('location: timeline.php');
        exit();
    }
    }
}



 public function updateprofile($userid){
     $id = $userid;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];
    $accountnumber = $_POST['accountnumber'];
    
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDirectory = './../uploads/employee/';
            $uploadedFileName = basename($file['name']);
            $targetFilePath = $uploadDirectory . $uploadedFileName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $query = "UPDATE employee SET full_name = '$name', email = '$email',
                phone_number = '$phone_number', dob = '$dob', address = '$address',
                profile_picture = '$uploadedFileName',user_role='$role',salary='$salary',
                accountnumber='$accountnumber' WHERE id = $id";

                if (mysqli_query($this->conn, $query)) {
                    $_SESSION['success'] = 'Details updated successfully';
                    header('location: profile.php');
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to update details, try again';
                    header('location: profile.php');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Failed to move uploaded file';
                header('location: profile.php');
                exit;
            }
        } else {
            $query = "UPDATE employee SET full_name = '$name', email = '$email', 
            phone_number = '$phone_number', dob = '$dob', address = 
            '$address',user_role='$role',salary='$salary',accountnumber='$accountnumber' WHERE id = $id";

        if (mysqli_query($this->conn, $query)) {
            $_SESSION['success'] = 'Details updated successfully';
            header('location: profile.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update details, try again';
            header('location: profile.php');
            exit;
            }
        }
    } 
    
}

public function updatepassword($userid){
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $verifyPassword = $_POST['verify_password'];

    $query = "SELECT password FROM employee WHERE id = $userid";
    $result = mysqli_query($this->conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];
        $currentPasswordHash = md5($currentPassword);
        if ($currentPasswordHash === $storedPassword) {
            $newPasswordHash = md5($newPassword);
            $updateQuery = "UPDATE employee SET password = '$newPasswordHash' WHERE id = $userid";
            if (mysqli_query($this->conn, $updateQuery)) {
                $_SESSION['success'] = 'Password changed successfully!';
                header('location: profile.php');
                exit;
            } else {
                $_SESSION['error'] = 'Failed, try again.';
                header('location: profile.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Incorrect current password!';
            header('location: profile.php');
            exit;
        }
    } else {
        echo "User not found";
    }
    
}

public function deleteLeave($id,$modules=null){
    $sql = "DELETE FROM tblleaves WHERE id = $id";
    $result = mysqli_query($this->conn, $sql);
    if($result){
         $_SESSION['success'] = 'Leave deleted successfully';
        if(!empty($modules)){
            header("Location: addhoildays.php");
            exit();
            }else{
                header("Location: leave.php");
            exit();
            }
    }
}
public function deleteLeavebycondition($id){
    $sql = "DELETE FROM holiday WHERE id = $id";
    $result = mysqli_query($this->conn, $sql);
    if($result){
         $_SESSION['success'] = 'Leave deleted successfully';       
        header("Location: addhoildays.php?date=Holidays");
    exit();
            
    }
}


public function editTimeline($userid)
{
    $projectId = $_POST['projectid'];
    $timelineId  = $_POST['timelineid'];
    $startTime = isset($_POST['startTime']) ? date('h:i A', strtotime($_POST['startTime'])) : '';
    $start_t = isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '';
    $start_t1 = isset($_POST['startdate']) ? date('d-m-Y', strtotime($_POST['startdate'])) : '';
    $endTime = isset($_POST['endTime']) ? date('h:i A', strtotime($_POST['endTime'])) : '';
    $meetingType = $_POST['meetingType'];
    $location = isset($_POST['location']) ? $_POST['location'] : "";
    $meetingLink = isset($_POST['meetingLink']) ? $_POST['meetingLink'] : "";
    $selectedMembers = isset($_POST['selectedMembers']) ? $_POST['selectedMembers'] : [];
    $meetingSubject = isset($_POST['meetingSubject']) ? $_POST['meetingSubject'] : "";
    $enterTask = isset($_POST['enterTask']) ? $_POST['enterTask'] : "";
    $startTime = $start_t1 .' '.$startTime;
    $endTime = $start_t1 . ' '. $endTime;
    $activity  = "meeting";
    $participate_id = 0;   

    if (isset($_POST['selectedMembers'])) {
        $participate_id = is_array($_POST['selectedMembers']) ? implode(",", $_POST['selectedMembers']) : $_POST['selectedMembers'];
        $participate_id = mysqli_real_escape_string($this->conn, $participate_id);
    }
    
    $sql = "UPDATE timeline 
            SET start_time = '$startTime', 
                end_time = '$endTime', 
                project_id = '$projectId', 
                activity = '$activity', 
                meeting_type = '$meetingType', 
                meeting_link = '$meetingLink', 
                meeting_location = '$location', 
                participate_id = '$participate_id', 
                task_description = '$meetingSubject',
                start_t = '$start_t'
                WHERE id = $timelineId"; 
    $result = mysqli_query($this->conn, $sql);

    if ($result) {
        $_SESSION['success'] = 'Timeline updated successfully';
        header('location: timeline.php');
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        header('location: timeline.php');
        exit();
    }
}






public function applyrequest($userid) {
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
        $ticket = 'Ticket_' . rand(9999,1000);
        switch ($type) {
            case 'hiring':
                if (isset($_POST['required_roles'], $_POST['required_experiences'], $_POST['time_to_hire'], $_POST['number_of_resources'], $_POST['department'], $_POST['hirerequedto'])) {
                    $required_roles = $_POST['required_roles'];
                    $required_experiences = $_POST['required_experiences'];
                    $time_to_hire = $_POST['time_to_hire'];
                    $number_of_resources = $_POST['number_of_resources'];
                    $department = $_POST['department'];
                    $sendto = $_POST['hirerequedto'];
                    $dec = $_POST['Description'];

                    $emailQuery = "SELECT full_name FROM employee WHERE id = '$userid'";
                    $emailResult = mysqli_query($this->conn, $emailQuery);
                    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                        $row = mysqli_fetch_assoc($emailResult);                       
                        $sendername = $row['full_name'];
                    } else {
                        die('Employee not found or email not available.');                   
                    }

                    $sql = "SELECT * FROM `schedules` WHERE Company_id = '$this->companyId'";
                        $result = mysqli_query($this->conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $Company_name = $row['Company_name'];
                        } else {
                            die('Schedule not found.');
                        }

                    $emailQuery = "SELECT email FROM employee WHERE id = '$sendto'";
                    $emailResult = mysqli_query($this->conn, $emailQuery);
                    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                        $row = mysqli_fetch_assoc($emailResult);
                        $emailto = $row['email'];

                        $sql = "INSERT INTO teamrequried (type, RequiredRole, RequiredExperience, TimeToHire, number, teamtype, TeamLead, Company_id, `to`,Message,Ticket) 
                                VALUES ('$type', '$required_roles', '$required_experiences', '$time_to_hire', '$number_of_resources', '$department', 
                                '$userid', '$this->companyId', '$sendto','$dec','$ticket')";

                        $insertResult = mysqli_query($this->conn, $sql);
                        if ($insertResult) {
                            if ($this->sendMailForHiring($emailto, $required_roles, $required_experiences, $time_to_hire, $number_of_resources, $department,$sendername,$Company_name,$dec)) {
                                $_SESSION['success'] = "Request sent successfully";
                                header("Location: request.php");
                                exit();
                            } else {
                                die('Failed to send email for hiring request.');
                            }
                        } else {
                            die('Query execution failed: ' . mysqli_error($this->conn));
                        }
                    } else {
                        die('Employee not found or email not available.');
                    }
                }else{
                    $_SESSION['error'] = "All Field are Required";
                     header("Location: request.php");
                }
                break;
                default:      
                    if( $type=='other'){
                     $to = $_POST['sendto'];
                    $subject = $_POST['other_subject'];
                    $message = $_POST['request_message'];
                    }else{
                    $to = $_POST['sendto1'];
                    $subject = $_POST['request_subject1'];
                    $message = $_POST['request_message1'];
                    }               


                    $emailQuery = "SELECT email, full_name FROM employee WHERE id = '$to'";
                    $emailResult = mysqli_query($this->conn, $emailQuery);
                    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                        $row = mysqli_fetch_assoc($emailResult);
                        $emailto = $row['email'];
                        $sendertoname = $row['full_name'];
                    } else {
                        die('Employee not found or email not available.');                   
                    } 

                    $emailQuery = "SELECT full_name FROM employee WHERE id = '$userid'";
                    $emailResult = mysqli_query($this->conn, $emailQuery);
                    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                        $row = mysqli_fetch_assoc($emailResult);                       
                        $sendername = $row['full_name'];
                    } else {
                        die('Employee not found or email not available.');                   
                    }

                    $sql = "SELECT * FROM `schedules` WHERE Company_id = '$this->companyId'";
                    $result = mysqli_query($this->conn, $sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $Company_name = $row['Company_name'];
                    } else {
                        die('Schedule not found.');
                    }

                    $insertQuery = "INSERT INTO teamrequried (`type`, `Subject`, `Message`, `TeamLead`, `Company_id`, `to`,Ticket) 
                                    VALUES ('$type', '$subject', '$message', '$userid', '$this->companyId', '$to','$ticket')";
                    
                    $insertResult = mysqli_query($this->conn, $insertQuery);
                    if ($insertResult) {
                        if ($this->sendMailForRequest($emailto, $subject, $message, $sendername, $sendertoname,$Company_name,$type)) {
                            $_SESSION['success'] = "Request sent successfully";
                            header("Location: request.php");
                            exit();
                        } else {
                            die('Failed to send email for ' . $type . ' request.');
                        }
                    } else {
                        die('Query execution failed: ' . mysqli_error($this->conn));
                    }                
                        break;
                }
                    }
                }

private function sendMailForHiring($sendto, $required_roles, $required_experiences, $time_to_hire, $number_of_resources, $department,$sendername,$Company_name,$dec) {    
    $mail = new PHPMailer(true); 
    try {      
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'jiffymine@gmail.com'; 
        $mail->Password = 'holxypcuvuwbhylj'; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587;
        $mail->setFrom('jiffymine@gmail.com', 'HR Team');
        $mail->addAddress($sendto); 

        $mail->isHTML(true); 
        $mail->Subject = 'New Hiring Request';
        $mail->Body = "<!DOCTYPE html>
        <html lang='en'>
        <head>
        <meta charset='UTF-8' name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>New Hiring Request</title>
        <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
            }
        </style>
        </head>
        <body>
        <div class='content'>
        <a href='jiffy.mineit.tech'><img src='https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png' alt='Jiffy Logo' class='logo'></a>
        <p>Dear Hiring Team,</p>
        <p>A new hiring request has been submitted with the following details:</p>
        <ul style='line-height:30px;'>
        <li><strong>Required Role:</strong> $required_roles</li>
        <li><strong>Required Experience:</strong> $required_experiences</li>
        <li><strong>Time to Hire:</strong> $time_to_hire</li>
        <li><strong>Number of Resources:</strong> $number_of_resources</li>
        <li><strong>Department:</strong> $department</li>
        </ul><br>
        <p style='font-weight:bold;'>Description</p>
        <p style='text-align:justify;'>$dec</p>
    <br>
        <p>Best Regards,<br><br>$sendername<br>$Company_name</p>
        </div>
        <div class='footer'>
            <p>Powered by <a href='https://jiffy.mineit.tech/' target=_blank;>JIFFY</a></p>
        </div>
        </body>
        </html>";
        $mail->send(); 
        return true; 
    } catch (Exception $e) {       
        error_log('SMTP Error: ' . $mail->ErrorInfo);
        return false; 
    }
}



private function sendMailForRequest($to, $subject, $message, $sendername, $sendertoname, $Company_name,$type) {
    $mail = new PHPMailer(true); 
    try {      
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'jiffymine@gmail.com'; 
        $mail->Password = 'holxypcuvuwbhylj'; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587;
        $mail->setFrom('jiffymine@gmail.com', $sendername);
        $mail->addAddress($to); 

        $mail->isHTML(true); 
        $mail->Subject = 'New Request Received';

        $emailContent = "
        
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>$subject</title>
            <style>
                body, html {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    font-size: 16px;
                    line-height: 1.6;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f9f9f9;
                    border: 1px solid #ddd;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                    background-color: #007bff;
                    color: #fff;
                    padding: 10px 0;
                }
                .content {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                }
                .logo{
                    width:50px !important;
                    height:30px !important;
                    float:right !important;
                    }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    color: #888;
                }
            </style>
        </head>
        <body>
                <div class='content'>
                <a href='jiffy.mineit.tech'><img src='https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png' alt='Jiffy Logo' class='logo'></a>
                    <p>Dear $sendertoname,</p>
                    <p><b>Subject</b> : $subject</p>
                    <p style='text-align: justify;'>$message</p>
                    <hr>
                    <p>Best Regards,<br><br>$sendername<br>$Company_name</p></p>
                </div>
                <div class='footer'>
                    <p>Powered by <a href='https://jiffy.mineit.tech/' target=_blank;>JIFFY</a></p>
                </div>
        </body>
        </html>";

        $mail->Body = $emailContent;
        $mail->send(); 
        return true; 
    } catch (Exception $e) {       
        error_log('SMTP Error: ' . $mail->ErrorInfo);
        return false; 
    }
}
}

$userid = $_SESSION["user_id"];
$taskManager = new TaskManager($conn,$companyId);
if (isset($_GET["trainid"]) && !empty($_GET["trainid"])) {
    $trainid = $_GET["trainid"];
    $taskManager->deleteTask($trainid);
}





?>