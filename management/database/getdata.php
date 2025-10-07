<?php

class DataFetcher
{
    private $db;
    private $companyId;

    public function __construct($conn,$companyId)
    {
        $this->db = $conn;
        $this->companyId = $companyId;
    }

    public function totalEmployees()
    {
        $query = "SELECT COUNT(*) as total FROM employee WHERE Company_id = '$this->companyId'";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }

        $row = mysqli_fetch_array($result);
        $totalEmployees = $row['total'];

        return $totalEmployees;
    }

    public function totalClients()
    {
        $query = "SELECT COUNT(*) as total FROM clientinformation WHERE Company_id = '$this->companyId'";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }

        $row = mysqli_fetch_array($result);
        $totalClients = $row['total'];

        return $totalClients;
    }

    public function totalProjects()
    {
        $query = "SELECT COUNT(*) as total FROM projects WHERE Company_id = '$this->companyId'";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }

        $row = mysqli_fetch_array($result);
        $totalProjects = $row['total'];

        return $totalProjects;
    }

    
    public function monthly_expension()
    {
        $query = "SELECT SUM(`prize`) AS `TotalPrize`
                  FROM `monthly_expension`
                  WHERE                     
                       Company_id = '$this->companyId'";    
        $result = mysqli_query($this->db, $query);
    
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
    
        $row = mysqli_fetch_array($result);
        $monthly_expension = $row['TotalPrize'];
    
        $query = "SELECT SUM(`received_amount`) AS `TotalReceived`
                  FROM `revenue_collected`
                  WHERE 
                     Company_id = '$this->companyId'";
    
        $result = mysqli_query($this->db, $query);
    
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
    
        $row = mysqli_fetch_array($result);
        $received_amount = $row['TotalReceived'];
    
        $percentage = 0;
        if ($monthly_expension != 0) {
            $percentage = (($received_amount - $monthly_expension) / ($monthly_expension + $received_amount)) * 100;
        }else {
            $percentage = 0;
        }    
        if ($received_amount > $monthly_expension) {
            return [
                'status' => 1,
                'percentage' => $percentage
            ];
        } else {
            return [
                'status' => 0,
                'percentage' => $percentage
            ];
        }
    }
    
    public function Revenue_Collected(){
        $query = "SELECT SUM(`received_amount`) AS `TotalReceived`
                  FROM `revenue_collected`
                  WHERE 
                      Company_id = '$this->companyId'";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }

        $row = mysqli_fetch_array($result);
        $received_amount = $row['TotalReceived'];

        return $received_amount;
    }
    public function Project_Collected(){
        $query = "SELECT SUM(`budget`) AS `TotalReceived`
                  FROM `projects`
                  WHERE 
                      Company_id = '$this->companyId' AND payment_status='Paid'";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }

        $row = mysqli_fetch_array($result);
        $received_amount = $row['TotalReceived'];

        return $received_amount;
    }

    public function Requirement(){
        $sql = "SELECT Count(*) AS `TotalReceived`
        FROM `job_applications` WHERE Company_id = '$this->companyId' AND status1 = 'Pending'";
         $result = mysqli_query($this->db, $sql);

         if (!$result) {
             die("Query failed: " . mysqli_error($this->db));
         }
 
         $row = mysqli_fetch_array($result);
         $count = $row['TotalReceived'];
 
         return $count;
    }  

    public function Total_Requirement()
    {
        $sql = "SELECT COUNT(*) AS requestcount  FROM `job_applications` WHERE Company_id = '$this->companyId' AND `status1`='pending' AND `status`='selected'";
         $result = mysqli_query($this->db, $sql);

         if (!$result) {
             die("Query failed: " . mysqli_error($this->db));
         }
 
         $row = mysqli_fetch_array($result);
         $count = $row['requestcount'];
 
         return $count;
    }
    public function Status_request()
    {
        $sql = "SELECT COUNT(*) AS requestcount  FROM `job_applications` WHERE `status1`='Approve' AND Company_id = '$this->companyId'";
         $result = mysqli_query($this->db, $sql);
         if (!$result) {
             die("Query failed: " . mysqli_error($this->db));
         }
 
         $row = mysqli_fetch_array($result);
         $count = $row['requestcount']; 
         return $count;
    }
    public function Status_Rejected ()
    {
        $sql = "SELECT COUNT(*) AS Status_Rejected  FROM `job_applications` WHERE (`status1`='Rejected' OR `status1`='Hold' ) AND Company_id = '$this->companyId'";
         $result = mysqli_query($this->db, $sql);
         if (!$result) {
             die("Query failed: " . mysqli_error($this->db));
         }
 
         $row = mysqli_fetch_array($result);
         $count = $row['Status_Rejected']; 
         return $count;
    }
    public function Amount_Spend(){
        $sql = "SELECT SUM(`cost`) AS amount_spend  FROM `job_applications` WHERE Company_id = '$this->companyId' AND `status` = 'hired'";
         $result = mysqli_query($this->db, $sql);
         if (!$result) {
             die("Query failed: " . mysqli_error($this->db));
         }
         $row = mysqli_fetch_array($result);
         $count = $row['amount_spend']; 
         return $count;
    }
    public function Requirement_details($status=null)
    {
        $sql = "SELECT * FROM `job_applications` WHERE Company_id = '$this->companyId'";
        if($status!==null){
            if($status=='Rejected'){
                $sql.= " AND (`status1`='Rejected' OR `status1`='Hold' )";
            }else{
                $sql.= " AND `status1` = '$status'";
            }
           
        }
        $result = mysqli_query($this->db, $sql);
    
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
    
        $data = [];
    
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    
        return $data;
    }

    public function Apply($status=null)
    {
        $sql = "SELECT * FROM `job_applications` WHERE `status` ='selected' AND Company_id = '$this->companyId'AND `status1`='pending' AND `status`='selected'";
        if($status!==null){
            $sql.= " WHERE `Status` = '$status'";
        }
        $result = mysqli_query($this->db, $sql);
    
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
    
        $data = [];
    
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    
        return $data;
    }

    public function Requirement_details_by_id($id){
        $sql = "SELECT * FROM `teamrequried` WHERE `id` = '$id'";
        $result = mysqli_query($this->db, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function Requirement_details_others()
    {
        $sql = "SELECT * FROM `teamrequried` WHERE Company_id = '$this->companyId'";
        $result = mysqli_query($this->db, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    public function shortlist() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }
    
        $status = sanitize_input($_POST['status']);
        $jobId = sanitize_input($_POST['id']);
    
        if (empty($status) || empty($jobId)) {
            die("Status or job ID is missing");
        }
    
        $sql = "UPDATE `job_applications` SET `status1` = ? WHERE `id` = ?";
        
        $stmt = mysqli_prepare($this->db, $sql);
        
        mysqli_stmt_bind_param($stmt, "si", $status, $jobId);
        
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        } else {
            $_SESSION['success'] = 'Status updated successfully';
            header('Location: requirement.php');
        }
    }

    public function addclient($userid) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {           
            $fullName = $_POST['fullName'];
            $phoneNumber = $_POST['phoneNumber'];
            $email = $_POST['email'];
            $GSTNumber = $_POST['GSTNumber'];
            $projectName = $_POST['projectName'];
            $budget = $_POST['budget'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $totalHours = $_POST['totalHours'];
            $resourceInvolved = $_POST['resourceInvolved'];
            $address = $_POST['address'];
            $clientid = $fullName . rand(1999, 999999);    
           
            $existingEmailQuery = "SELECT COUNT(*) FROM `clientinformation` WHERE `email` = ?";
            $stmtEmailCheck = mysqli_prepare($this->db, $existingEmailQuery);
            mysqli_stmt_bind_param($stmtEmailCheck, "s", $email);
            mysqli_stmt_execute($stmtEmailCheck);
            mysqli_stmt_bind_result($stmtEmailCheck, $emailCount);
            mysqli_stmt_fetch($stmtEmailCheck);
            mysqli_stmt_close($stmtEmailCheck);
    
            if ($emailCount > 0) {              
                $_SESSION['error'] = 'Client with this email already exists';
                header('Location: clients.php');
                exit();
            }   
         
            $sql = "INSERT INTO `clientinformation` (`fullName`, `phoneNumber`, `email`, `GSTNumber`, `projectName`, `budget`, `startDate`,
                `endDate`, `totalHours`, `resourceInvolved`, `address`, `cliendid`, `uploaderid`, `Company_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($this->db, $sql);
            
            mysqli_stmt_bind_param($stmt, "ssssssssssssss", $fullName, $phoneNumber, $email, $GSTNumber, $projectName, 
                $budget, $startDate, $endDate, $totalHours, $resourceInvolved, $address, $clientid, $userid, $this->companyId);
            
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                $_SESSION['success'] = 'Client added successfully';
                header('Location: clients.php');
                exit();
            } else {
                die("Query failed: " . mysqli_error($this->db));
            }
        }
    }
    

    public function feachclients($id=null) 
    {
        $sql = "SELECT * FROM `clientinformation` WHERE Company_id = '$this->companyId'";
        if($id!==null){
            $sql.= " AND `cliendid` = '$id'";
        }
        $result = mysqli_query($this->db, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function projects($id = null) 
{
    $sql = "SELECT p.*, 
            (SELECT full_name FROM `employee` WHERE id = p.project_manager_id) as `project_manager`
            FROM `projects` as p  
            WHERE Company_id = ?";
    
    $params = [$this->companyId];
    
    if ($id !== null) {
        $sql .= " AND `id` = ?";
        $params[] = $id;
    }    
    $stmt = mysqli_prepare($this->db, $sql);

    if ($stmt === false) {
        die("Query preparation failed: " . mysqli_error($this->db));
    }  

    if ($id !== null) {
        mysqli_stmt_bind_param($stmt, "ss", ...$params);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $params[0]);
    }

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($this->db));
    }
    
    $data = [];
    $resultSet = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($resultSet)) {
        $data[] = $row;
    }

    return $data;
}



    public function clientprojectdetials($clientid) 
    {
        $sql = "SELECT clientinformation.*,projects.*,projects.id AS projectid FROM clientinformation 
        JOIN projects ON projects.client_id = clientinformation.id
        WHERE clientinformation.id =$clientid";
        $result = mysqli_query($this->db, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($this->db));
        }
        $data = []; 
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;

    }
    
    
    


}

$dataFetcher = new DataFetcher($conn,$companyId);




?>
