<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include "./../include/config.php";

class TaskStatistics {
    private $conn;

    private $companyId;

    public function __construct($conn,$companyId) {

        $this->conn = $conn;
        
        $this->companyId = $companyId;
    }

    public function getTotalTasks($status, $userid) {
        $query = "SELECT COUNT(*) as total_tasks FROM tasks WHERE status = ? AND assigned_to = ? AND  Company_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, 'sss', $status, $userid,$this->companyId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['total_tasks'];
        } else {
            return 0;
        }
    }

    public function getTotalProjects($userid) {
        $query = "SELECT COUNT(*) as total_projects FROM projects WHERE FIND_IN_SET(?, REPLACE(members, ' ', '')) AND  Company_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, 'si', $userid,$this->companyId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['total_projects'];
        } else {
            return 0;
        }
    }

    public function getTotalTasksToday($userid) {
        $today = date('Y-m-d');
        $query = "SELECT COUNT(*) as total_tasks FROM tasks WHERE (status = 'Todo' OR status = 
        'InProgress' OR status = 'Pause') AND assigned_to = ? AND DATE(due_date) = ? AND Company_id = ?";
        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, 'sss', $userid, $today,$this->companyId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['total_tasks'];
        } else {
            return 0;
        }
    }

    public function getStatistics($userid) {
        $totalProjects = $this->getTotalProjects($userid);
        $newTasks = $this->getTotalTasks('Todo', $userid);
        $inProgressTasks = $this->getTotalTasks('InProgress', $userid);
        $completedTasks = $this->getTotalProjects($userid);
        $totalToday = $this->getTotalTasksToday($userid);

        return array(
            'newTasks' => $newTasks,
            'newTask' => $newTasks,
            'inProgressTasks' => $inProgressTasks,
            'completedTasks' => $completedTasks,
            'totaltoday' => $totalToday
        );
    }
            public function Priority($userid) {
                date_default_timezone_set('Asia/Kolkata');
                $today = new DateTime('now');
                $today_string = $today->format('Y-m-d');
                $query = "SELECT tasks.*, employee.full_name 
                            FROM tasks 
                            INNER JOIN employee ON tasks.assigned_to = employee.id 
                            WHERE tasks.assigned_to = ? 
                            AND (tasks.status = 'Todo' OR tasks.status = 'InProgress') 
                            AND DATE_FORMAT(tasks.due_date, '%Y-%m-%d') = ?";

                $stmt = mysqli_prepare($this->conn, $query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ss', $userid, $today_string);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $projectname = $row['task_name'];
                            $assignbyname = $row['full_name'];
                            $due_time = strtotime($row['due_date']);
                            $today_time = strtotime('now');

                            $remaining_time_seconds = $due_time - $today_time;

                            $remaining_hours = floor($remaining_time_seconds / 3600);
                            $remaining_minutes = floor(($remaining_time_seconds % 3600) / 60);
                            $remaining_seconds = $remaining_time_seconds % 60;
                        }
                    }
                }
            }

}

$userid = $_GET['userid'];

$taskStats = new TaskStatistics($conn,$companyId);
$response = $taskStats->getStatistics($userid);

echo json_encode($response);

?>
