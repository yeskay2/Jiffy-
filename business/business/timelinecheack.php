<?php
session_start();
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $startTime = isset($_POST['startDate']) ? date('d-m-Y h:i A', strtotime($_POST['startDate'])) : '';
    $endTime = isset($_POST['endTime']) ? date('d-m-Y h:i A', strtotime($_POST['endTime'])) : '';
    $participate_ids = is_array($_POST['employeeId']) ? $_POST['employeeId'] : array($_POST['employeeId']);

    $conflictingEmployees = array();

    foreach ($participate_ids as $participate_id) {
        $conflictQueryParticipant = "SELECT 
                                        timeline.*,
                                        GROUP_CONCAT(DISTINCT employee.full_name) AS busy_employees
                                      FROM timeline 
                                      LEFT JOIN employee ON FIND_IN_SET(employee.id, timeline.participate_id)
                                      WHERE (
                                        (STR_TO_DATE('$startTime', '%d-%m-%Y %h:%i %p') BETWEEN STR_TO_DATE(start_time, '%d-%m-%Y %h:%i %p') AND STR_TO_DATE(end_time, '%d-%m-%Y %h:%i %p'))
                                        OR
                                        (STR_TO_DATE('$endTime', '%d-%m-%Y %h:%i %p') BETWEEN STR_TO_DATE(start_time, '%d-%m-%Y %h:%i %p') AND STR_TO_DATE(end_time, '%d-%m-%Y %h:%i %p'))
                                      )
                                      AND FIND_IN_SET('$participate_id', timeline.participate_id) 
                                      GROUP BY timeline.id";

        $conflictResultParticipant = mysqli_query($conn, $conflictQueryParticipant);

        if (mysqli_num_rows($conflictResultParticipant) > 0) {
            while ($row = mysqli_fetch_assoc($conflictResultParticipant)) {
                $conflictingEmployees[] = $row['busy_employees'];
            }
        }
    }

    if (!empty($conflictingEmployees)) {
        $conflictingEmployeesList = implode(', ', $conflictingEmployees);
        echo "$conflictingEmployeesList already have scheduled meetings during this specified time, please reschedule this meeting for another time";
    } else {
        echo false;
    }
}
?>
