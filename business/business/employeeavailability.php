<?php
session_start();
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $employeeId = isset($_POST['employeeId']) ? intval($_POST['employeeId']) : 0;
    $startDate = isset($_POST['startDate']) ? date('Y-m-d', strtotime($_POST['startDate'])) : '';
    $endDate = isset($_POST['endDate']) ? date('Y-m-d', strtotime($_POST['endDate'])) : '';
    $startTime = isset($_POST['starttime']) ? date('H:i:s', strtotime($_POST['starttime'])) : '';
    $endTime = isset($_POST['endtime']) ? date('H:i:s', strtotime($_POST['endtime'])) : '';

    if ($employeeId && $startDate && $endDate && $startTime && $endTime) {

        $sql = "SELECT tasks.*, employee.full_name
                FROM tasks
                JOIN employee ON tasks.assigned_to = employee.id
                WHERE tasks.assigned_to = ?
                AND tasks.due_date >= ?
                AND tasks.Actual_start_time <= ?
                AND tasks.status NOT IN ('Completed', 'Pause')
                AND (
                    (tasks.perferstart_time <= ? AND tasks.perferend_time >= ?)
                    OR (tasks.perferstart_time <= ? AND tasks.perferend_time >= ?)
                    OR (tasks.perferstart_time <= ? AND tasks.due_date >= ?)
                )
                ORDER BY tasks.Actual_start_time";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssss", $employeeId, $startDate, $endDate, $endTime, $startTime, $startTime, $endTime, $startTime, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $response = [];

        if ($result->num_rows > 0) {
            $response['message'] = "Employee is busy during the specified time period";
        } else {
           
        }

        $stmt->close();

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => "Invalid input. Please provide all required data"]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => "Invalid request method"]);
}
?>
