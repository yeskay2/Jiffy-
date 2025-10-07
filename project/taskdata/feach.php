<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class ProjectManager {
    private $conn;
    private $companyId;

    public function __construct($conn,$companyId)
    {
        $this->conn = $conn;
        $this->companyId = $companyId;
    }

        public function getProjects($userid=null,$type_id=null,$status=null) {
        $query = "";
        if($type_id ==null){
            $query = "SELECT * FROM projects WHERE  Company_id = $this->companyId AND uploaderid = $userid
             ORDER BY project_name";
        }   
        elseif ($type_id != 1) {
            $query = "SELECT * FROM projects WHERE REPLACE(CONCAT(',', members, ','), ' ', '') 
            LIKE '%,$userid,%' AND  Company_id = $this->companyId ORDER BY project_name";
        } elseif ($status != null) {
            $query = "SELECT * FROM projects WHERE progress = 100  AND  Company_id = $this->companyId
             ORDER BY project_name";
        }
        else {
            $query = "SELECT * FROM projects  WHERE  Company_id = $this->companyId ORDER BY project_name";
        }
        $result = mysqli_query($this->conn, $query);
        $progressClasses = array("circle-progress-primary", "circle-progress-secondary", "circle-progress-success", "circle-progress-info");
        $classIndex = 0;
        $projects = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $project = $this->processProjectData($row, $progressClasses, $classIndex);
                $projects[] = $project;
                $classIndex = ($classIndex + 1) % count($progressClasses);
            }
        }
        return $projects;
    }


    private function processProjectData($row, $progressClasses, $classIndex) {
        $projectname = $row['project_name'];
        $id = $row['id'];
        $progress = $row['progress'];
        $priority = $row['priority'];
        $departments = $row['department'];
        $member = $row['members'];
        $departmentNames = array();
        $departmentLogos = array();
        $memberNames = array();
        $memberimage = array();
        $progressClass = $progressClasses[$classIndex];

        if ($priority === "High") {
            $buttonClasses ="badge bg-high" ;
        } else {
            $buttonClasses = "badge bg-low";
        }

        if ($member !== null) {
            $memberIDs = explode(',', $member);
        } else {
            $memberIDs = array();
        }

        if ($departments !== 0) {
            $departmentIDs = explode(',', $departments);
        
            foreach ($departmentIDs as $departmentID) {
                $sql4 = "SELECT name, logo FROM department WHERE id = ?";
                $stmt4 = mysqli_prepare($this->conn, $sql4);
                mysqli_stmt_bind_param($stmt4, "i", $departmentID);
                mysqli_stmt_execute($stmt4);
                $result4 = mysqli_stmt_get_result($stmt4);
        
                if ($result4 && mysqli_num_rows($result4) > 0) {
                    $departmentRow = mysqli_fetch_assoc($result4);
                    $departmentNames[] = $departmentRow['name'];
                    $departmentLogos[] = $departmentRow['logo'];
                }
            }
        } else {            
            $departmentNames[] = null;
            $departmentLogos[] = null;
        }
        

        if ($member !== null) {
            foreach ($memberIDs as $memberID) {
                $sql5 = "SELECT full_name,profile_picture FROM employee WHERE id = ?";
                $stmt5 = mysqli_prepare($this->conn, $sql5);
                mysqli_stmt_bind_param($stmt5, "i", $memberID);
                mysqli_stmt_execute($stmt5);
                $result5 = mysqli_stmt_get_result($stmt5);

                if ($result5 && mysqli_num_rows($result5) > 0) {
                    $memberRow = mysqli_fetch_assoc($result5);
                    $memberNames[] = $memberRow['full_name'];
                    $memberimage[] = $memberRow['profile_picture'];
                }
            }
        }

       $projects = array(
        'projectname' => $projectname,
        'id' => $id,
        'progress' => $progress,
        'priority' => $priority,
        'departments' => $departmentNames,
        'departmentLogos' => array(
            'full_name' => $memberNames,
            'images' => $memberimage
        ),
        'progressClass' => $progressClass,
        'buttonClasses' => $buttonClasses, 
    );


        return $projects;
    }
    
    public function editproject(){   
        $projectId = $_GET['id'];  
        $sql = "SELECT * FROM projects WHERE id = $projectId";
        $result = mysqli_query($this->conn, $sql);    
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $projectname = htmlspecialchars($row['project_name']);
            $description = strip_tags($row['description']);
            $progress = htmlspecialchars($row['progress']);
            $priority = htmlspecialchars($row['priority']);       
            $documentAttachment = htmlspecialchars($row['document_attachment']);
            $dueDate = htmlspecialchars($row['due_date']);
            $startDate = date('Y-m-d', strtotime($row['start_date']));
            $member = $row['members'];
            $memberNames = array();
            $lead = $row['lead_id'];
            $lead_id = array();
            $department2 = $row['department'];
            $departmentIds = explode(',', $row['department']);
            $budget = $row['budget'];
            $location = $row['location'];
            $no_resource = $row['no_resource'];
            $ladname = $row['lead_id'];
            $totalhours = $row['totalhours'];
            $perdayhours = $row['perday'];
            $project_manager_id = $row['project_manager_id'];
            $client = $row['client_id'];
            if ($row['modules'] !== null) {
                $models = explode(',', $row['modules']);
            } else {
                $models = array();
            }

            if($row['tasks'] !== 'null') {

                $tasks = explode(',', $row['tasks']);
            }else{
                $tasks = array();
            }

            if ($member !== null) {
                $memberIDs = explode(',', $member);
            } else {
                $memberIDs = array();
            }

            if ($lead !== null) {
                $leadid = explode(',', $lead);
            } else {
                $leadid = array();
            }
            foreach ($leadid as $memberID) {
                $sql5 = "SELECT full_name,id FROM employee WHERE id = $memberID";
                $result5 = mysqli_query($this->conn, $sql5);

                if ($result5 && mysqli_num_rows($result5) > 0) {
                    $memberRow = mysqli_fetch_assoc($result5);
                    $lead_id[] = $memberRow['id'];
                }
            }
    
            $departmentNames = array();    
            if(!empty($departmentIds)) { 
            foreach ($departmentIds as $departmentId) {
                $sqlDept = "SELECT id FROM department WHERE id = $departmentId";
                $resultDept = mysqli_query($this->conn, $sqlDept);    
                if ($resultDept && mysqli_num_rows($resultDept) > 0) {
                    $deptRow = mysqli_fetch_assoc($resultDept);
                    $departmentNames[] = htmlspecialchars($deptRow['id']);
                }
            }    
        }
            if ($member !== null) {
                $memberIDs = explode(',', $member);
    
                foreach ($memberIDs as $memberID) {
                    $sql5 = "SELECT full_name,id FROM employee WHERE id = $memberID";
                    $result5 = mysqli_query($this->conn, $sql5);
    
                    if ($result5 && mysqli_num_rows($result5) > 0) {
                        $memberRow = mysqli_fetch_assoc($result5);
                        $memberNames[] = $memberRow['id'];
                    }
                }
            }    
            $projectDetails = array(
                'projectname' => $projectname,
                'description' => $description,
                'progress' => $progress,
                'priority' => $priority,
                'documentAttachment' => $documentAttachment,
                'dueDate' => $dueDate,
                'startDate' => $startDate,
                'departmentNames' => $departmentNames,
                'memberNames' => $memberNames,
                'budget'  =>$budget,
                'location' => $location,
                'projectId' =>$projectId,
                'no_resource' => $no_resource,
                'modules' => $models,
                'leadname' => $ladname,
                'project_manager_id' => $project_manager_id,
                'hours' => $totalhours,
                'perday_hours' => $perdayhours,
                'lead_id'=>$lead_id,
                'tasks' => $tasks,
                'client_id' =>  $client
            );   
           
            return array($projectDetails);
        }   
       
        return null;
    }
    
public function overview()
{
    $sql = "SELECT 
    employee.user_role,
    employee.profile_picture,
    COUNT(*) as total_tasks,
    SUM(CASE WHEN tasks.status = 'Todo' THEN 1 ELSE 0 END) as to_do_tasks,
    SUM(CASE WHEN tasks.status = 'InProgress' THEN 1 ELSE 0 END) as in_progress_tasks,
    SUM(CASE WHEN tasks.status = 'Completed' THEN 1 ELSE 0 END) as completed_tasks
FROM 
    tasks
LEFT JOIN 
    employee ON tasks.assigned_to = employee.id
WHERE 
    (employee.user_role LIKE 'Designer%' OR 
    employee.user_role LIKE 'Testing Engineer%' OR 
    employee.user_role LIKE 'Developer%') AND employee.Company_id = $this->companyId
GROUP BY 
    employee.user_role, employee.profile_picture;";

    $result = mysqli_query($this->conn, $sql);

    $totals = array(
        'Developer' => ['completed' => 0, 'total' => 0],
        'Designer' => ['completed' => 0, 'total' => 0],
        'Testing Engineer' => ['completed' => 0, 'total' => 0],
    );

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userrole = $row['user_role'];
            $totals[$userrole]['completed'] += $row['completed_tasks'];
            $totals[$userrole]['total'] += $row['total_tasks'];
        }
    } 
   
    foreach ($totals as $userrole => $values) {
        $completed = $values['completed'];
        $total = $values['total'];
        if ($total > 0) {
            $totals[$userrole] = ($completed / $total) * 100;
        } else {
            $totals[$userrole] = 0;
        }
    }
    return $totals;
}
public function timeline($userid) {
    $query = "SELECT
    timeline.*,
    IF(timeline.project_id = 0, 'Common Meeting', projects.project_name) AS project_name,
    GROUP_CONCAT(DISTINCT employee.id) AS employee_ids,
    GROUP_CONCAT(DISTINCT employee.profile_picture) AS profile_pictures,
    (SELECT profile_picture FROM employee WHERE id = timeline.emp_id) AS assigned_by,
    (SELECT full_name FROM employee WHERE id = timeline.emp_id) AS assigned_name
FROM
    timeline
LEFT JOIN projects ON timeline.project_id = projects.id 
LEFT JOIN employee ON FIND_IN_SET(employee.id, timeline.participate_id)
WHERE
    (timeline.emp_id = ? OR FIND_IN_SET(?, timeline.participate_id)) 
GROUP BY
    timeline.id, project_name
ORDER BY
    timeline.start_time ASC";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userid, $userid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}
public function profiledata($userid) {
$query = "SELECT employee.*, 
                    CASE 
                        WHEN employee.department = 0 THEN 'Default Department' 
                        ELSE department.name 
                    END AS name
            FROM employee 
            LEFT JOIN department ON department.id = employee.department  
            WHERE employee.id = '$userid'";
            
$roleResult = mysqli_query($this->conn, $query);
return $roleResult;
}
   

public function feachrequest($userid, $status = null) {
    $query = "SELECT teamrequried.*, employee.*, 
              (SELECT full_name FROM `employee` WHERE id = teamrequried.to) AS sendtoname
              FROM teamrequried 
              JOIN employee ON teamrequried.TeamLead = employee.id
              WHERE teamrequried.Company_id = '$this->companyId'";
    
    // Check if status is not equal to 1
    if ($status !== '1') {
        $query .= " AND (teamrequried.to = '$userid' OR teamrequried.forward = '$userid')";
        
        if ($status != null) {
            if ($status == 'today') {
                $date = date("Y-m-d");
                $query .= " AND teamrequried.currentdate = '$date'";
            } elseif ($status == 'Unactioned') {
                $query .= " AND teamrequried.status = 'Pending'";
            } elseif ($status == 'Actioned') {
                $query .= " AND teamrequried.status != 'Pending'";
            } elseif ($status == 'myself') {
                $query .= " AND teamrequried.type != 'hiring'";
            } else {
                $query .= " OR teamrequried.TeamLead = '$userid'";
            }
        } else {
            $query .= " OR teamrequried.TeamLead = '$userid'";
        }
    }
    
    $roleResult = mysqli_query($this->conn, $query);
    $data = [];
    
    if ($roleResult && mysqli_num_rows($roleResult) > 0) {
        while ($row = mysqli_fetch_assoc($roleResult)) {
            $data[] = $row;
        }
    }
    
    return $data;
}

    
    
    
    
    
}
$projectManager = new ProjectManager($conn,$companyId);



?>
