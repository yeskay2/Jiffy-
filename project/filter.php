<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = ($_SESSION["user_id"] ?? 0);
if ($user == 0) {
    exit("User not logged in");
}

$employeeArrayQuery = "SELECT employee FROM team WHERE leader = $user AND Company_id=$companyId";
$result = $conn->query($employeeArrayQuery);
$employeeArray = [];
while ($row = mysqli_fetch_assoc($result)) {
    $employeeArray[] = $row['employee'];
}
$employeeList = implode(',', $employeeArray);

$selectedid = isset($_GET["employeeid"]) ? (int)$_GET["employeeid"] : 0;
$uploaderid = $user;
if(isset($_GET["condition"]) && $_GET["condition"] == "1" && isset($_GET["assignedby"])){
    
    if($_GET["assignedby"] == "Myself"){
        $whereCondition =  "AND t.assigned_to = t.uploaderid";
    }else{
        $whereCondition =  "AND t.assigned_to != t.uploaderid";
    }   
    $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }

}elseif (isset($_GET["condition"]) && $_GET["condition"] == "1") {
    $whereCondition = ($selectedid == 0) ? "" : "AND t.assigned_to = $selectedid";
    $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
} elseif(isset($_GET["condition"]) && $_GET["condition"] == "2") {
        $sql = "SELECT * FROM team WHERE leader ='$user' AND Company_id=$companyId";
        $resultTeam = $conn->query($sql);
        if ($resultTeam->num_rows > 0) {
            $selectedid2 = [];
            while ($rowEmployee = $resultTeam->fetch_assoc()) {
                $selectedid2[] = $rowEmployee["employee"];
            }
        $selectedid2 = implode(',', $selectedid2);
        if($selectedid == 0){
            $whereCondition =  "AND t.assigned_to IN ($selectedid2)";
        }else{
            $whereCondition =  "AND t.assigned_to = $selectedid";
        }

        $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND id IN ($selectedid2) AND Company_id=$companyId ORDER BY full_name";
        $resultEmployee = $conn->query($sqlEmployee);
        $employeeData = [];
        if ($resultEmployee) {
            while ($row = mysqli_fetch_assoc($resultEmployee)) {
                $employeeData[] = [
                    "id" => $row["id"],
                    "full_name" => $row["full_name"]
                ];
            }
        }
    }
}elseif(isset($_GET["teamid"])){
    $teamid = $_GET["teamid"];
    $sql = "SELECT * FROM team WHERE team_id ='$teamid' AND Company_id=$companyId";
        $resultTeam = $conn->query($sql);
        if ($resultTeam->num_rows > 0) {
            $selectedid2 = [];
            while ($rowEmployee = $resultTeam->fetch_assoc()) {
                $selectedid2[] = $rowEmployee["employee"];
            }
        $selectedid2 = implode(',', $selectedid2);
        if($selectedid == 0){
            $whereCondition =  "AND t.assigned_to IN ($selectedid2)";
        }else{
            $whereCondition =  "AND t.assigned_to = $selectedid";
        }

        $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND id IN ($selectedid2) AND Company_id=$companyId ORDER BY full_name";
        $resultEmployee = $conn->query($sqlEmployee);
        $employeeData = [];
        if ($resultEmployee) {
            while ($row = mysqli_fetch_assoc($resultEmployee)) {
                $employeeData[] = [
                    "id" => $row["id"],
                    "full_name" => $row["full_name"]
                ];
            }
        }
    }

}elseif((isset($_GET["assignedby"]))){
    $whereCondition = ($selectedid == 0) ? "" : "AND t.assigned_to = $selectedid";
    $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
    if($_GET["assignedby"]=='Myself'){
        $whereCondition =  " AND (t.assigned_to = '$user' AND t.uploaderid = '$user')" ;
    }elseif($_GET["assignedby"]=='Others'){
        $whereCondition =  " AND (t.assigned_to = '$user' AND t.uploaderid != '$user')" ;
    }else{
        $whereCondition =  " AND (t.assigned_to = '$user' OR t.uploaderid = '$user')" ;
    }

} elseif((isset($_GET["eid"]) && $_GET["eid"] == "$user")) {
    $whereCondition =  "AND (t.assigned_to = '$user')" ;
} else {
    $whereCondition = ($selectedid == 0) ? "AND (t.assigned_to = '$user' OR t.uploaderid = '$user')" : 
        "AND (t.assigned_to = '$selectedid' AND t.uploaderid = '$user') ";
    $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId ORDER BY full_name";
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
}

$sqlProjects = "SELECT DISTINCT id, project_name FROM projects WHERE Company_id=$companyId ORDER BY project_name";
$resultProjects = $conn->query($sqlProjects);
$projectNames = [];
if ($resultProjects) {
    while ($rowProject = mysqli_fetch_assoc($resultProjects)) {
        $projectNames[] = [
            'project_id' => $rowProject['id'],
            'project_name' => $rowProject['project_name']
        ];
    }
}

if (isset($_GET['taskstatus']) && $_GET['taskstatus'] == 'Inprogress') {
    $statuses = ["InProgress"];
     if(isset($_GET['eid'])){
        $usertaskid = $_GET['eid'];
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId AND id=$usertaskid ORDER BY full_name";
    }else{
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    }
   
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
} elseif(isset($_GET['taskstatus']) && $_GET['taskstatus'] == 'Completed') {
    $statuses = ["Completed"];
     if(isset($_GET['eid'])){
        $usertaskid = $_GET['eid'];
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId AND id=$usertaskid ORDER BY full_name";
    }else{
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    }
   
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
} elseif(isset($_GET['taskstatus']) && $_GET['taskstatus'] == 'Todo'){
    $statuses = ["Todo"];
    if(isset($_GET['eid'])){
        $usertaskid = $_GET['eid'];
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId AND id=$usertaskid ORDER BY full_name";
    }else{
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    }
   
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
} elseif(isset($_GET['taskstatus']) && $_GET['taskstatus'] == 'Pause'){
    $statuses = ["Pause"];
     if(isset($_GET['eid'])){
        $usertaskid = $_GET['eid'];
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId AND id=$usertaskid ORDER BY full_name";
    }else{
         $sqlEmployee = "SELECT full_name, id FROM employee WHERE active = 'active' AND Company_id=$companyId  ORDER BY full_name";
    }
   
    $resultEmployee = $conn->query($sqlEmployee);
    $employeeData = [];
    if ($resultEmployee) {
        while ($row = mysqli_fetch_assoc($resultEmployee)) {
            $employeeData[] = [
                "id" => $row["id"],
                "full_name" => $row["full_name"]
            ];
        }
    }
} else {
    $statuses = ["Todo", "InProgress", "Completed", "Pause"];
}
$periodCondition = "";
$limit = " LIMIT 10";
if (isset($_GET['period'])) {
    $period = $_GET['period'];
    if ($period == 'Today') {
       $periodCondition = " AND DATE(t.due_date) = '" . date('Y-m-d') . "'";
    } elseif ($period == 'All') {
        $limit = "";
    } else {
        $limit = " LIMIT " . (int) $period;
    }
} else {
    $limit = " LIMIT 10";
}

$statusData = [];

foreach ($statuses as $status) {
    $statusCondition = "AND t.status = '$status'";
    $query = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_uploader.full_name AS uploader_full_name, 
                      e_assigned.profile_picture AS assigned_profile_picture, e_uploader.profile_picture AS uploader_profile_picture, 
                      p.project_name 
              FROM tasks t 
              LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
              LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
              LEFT JOIN projects p ON t.projectid = p.id
              WHERE 1 $whereCondition $statusCondition $periodCondition  AND t.Company_id=$companyId ";
    
    if (!empty($_GET["project_id"])) {
        $projectId = mysqli_real_escape_string($conn, $_GET["project_id"]);
        $query .= " AND t.projectid = '$projectId'";
    }
    if (!empty($_GET["modules"])) {
        $projectmodulesname = mysqli_real_escape_string($conn, $_GET["modules"]);
        $query .= " AND t.modules_name = '$projectmodulesname'";
    }
    $query .= " ORDER BY t.id DESC $limit";        
     
    $result = $conn->query($query);
    if ($result) {
        $statusData[$status] = [
            'data' => $result,
            'row_count' => $result->num_rows
        ];
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
