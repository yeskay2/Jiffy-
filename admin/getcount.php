<?php
include "./../include/config.php";

class TaskManager {
    private $conn;
    private $companyId;

    public function __construct($conn, $companyId) {
        $this->conn = $conn;
        $this->companyId = $companyId;
    }

    public function getCount() {
        $sql = "SELECT SUM(number) as count FROM teamrequried WHERE completed = 0 AND Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function getCountApplicationNew() {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = '0' AND Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    public function getCountApplicationNew2() {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE  Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    

    public function getCountshortlist() {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'shortlist' AND Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function selected() {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'selected' AND Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    public function hire() {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'hired' AND Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function rejected() {
        $sql = "SELECT COUNT(*) as count FROM job_applications WHERE status = 'rejected' AND Company_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function department() {
        $sql = "SELECT 
                    SUM(CASE WHEN teamtype = 'Marketing' THEN number ELSE 0 END) AS Marketing_count,
                    SUM(CASE WHEN teamtype = 'IT' THEN number ELSE 0 END) AS IT_count,
                    SUM(CASE WHEN teamtype = 'Non IT' THEN number ELSE 0 END) AS Non_IT_count,
                    SUM(CASE WHEN teamtype = 'HR' THEN number ELSE 0 END) AS HR_count,
                    SUM(CASE WHEN teamtype = 'Management' THEN number ELSE 0 END) AS Management_count,
                    SUM(CASE WHEN teamtype = 'Accounts' THEN number ELSE 0 END) AS Accounts_count
                FROM 
                    teamrequried 
                WHERE 
                    Completed = 0 AND Company_id = ? AND type = 'hiring'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $counts = $result->fetch_assoc();
            return $counts;
        } else {
            return null;
        }
    }

    public function portal() {
        $sql = "SELECT
                    SUM(CASE WHEN source = 'jobPortal' THEN 1 ELSE 0 END) AS jobPortal_count,
                    SUM(CASE WHEN source = 'socialMedia' THEN 1 ELSE 0 END) AS socialMedia_count,
                    SUM(CASE WHEN source = 'referral' THEN 1 ELSE 0 END) AS referral_count,
                    SUM(CASE WHEN source = 'ourportal' THEN 1 ELSE 0 END) AS our_portal
                FROM
                    job_applications
                WHERE
                    Company_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->companyId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $counts = $result->fetch_assoc();
            return $counts;
        } else {
            return null;
        }
    }
}

$taskManager = new TaskManager($conn, $companyId);

$totalTasks = $taskManager->getCount();
$totalApplications = $taskManager->getCountApplicationNew();
$getCountShortlist = $taskManager->getCountshortlist();
$selected = $taskManager->selected();
$rejected = $taskManager->rejected();
$department = $taskManager->department();
$portal = $taskManager->portal();
$getCountApplicationNew2 = $taskManager->getCountApplicationNew2();
$hired = $taskManager->hire();
echo json_encode([
    'totalTasks' => $totalTasks,
    'totalApplications' => $totalApplications,
    'shortlist' => $getCountShortlist,
    'selected' => $selected,
    'hire' => $hired,
    'rejected' => $rejected,
    'department' => $department,
    'portal' => $portal,
    'getCountApplicationNew2' => $getCountApplicationNew2
]);
?>
