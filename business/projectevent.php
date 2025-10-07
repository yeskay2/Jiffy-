<?php
session_start();
include "./../include/config.php";

$userid = $_SESSION["user_id"];
date_default_timezone_set("Asia/Kolkata");
$currentTime = date("H");

if ($currentTime >= 5 && $currentTime < 12) {
    $greeting = "Good Morning";
    $img = "./../assets/images/Morning.png";
} elseif ($currentTime >= 12 && $currentTime < 17) {
    $greeting = "Good Afternoon";
    $img = "./../assets/images/Afternoon.png";
} else {
    $greeting = "Good Evening";
    $img = "./../assets/images/Evening.png";
}

$meeting = "./../assets/images/meeting.png";

if (isset($_GET['selectedDate'])) {
    $selectedDate = $_GET['selectedDate'];
    $formattedDate = date('m-d', strtotime($selectedDate));
    $selectedtable = date('Y-m-d', strtotime($selectedDate));
    // SQL injection prevention with prepared statements
    $sql = "SELECT id, full_name, dob, doj, YEAR(CURDATE()) - YEAR(doj) - (DATE_FORMAT(CURDATE(), '%m%d') 
    < DATE_FORMAT(doj, '%m%d')) AS working_years FROM employee WHERE (DATE_FORMAT(dob, '%m-%d') = ? 
    OR DATE_FORMAT(doj, '%m-%d') = ?) AND Company_id = $companyId";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $formattedDate, $formattedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fullName = $row["full_name"];
            $dob = date('Y-m-d', strtotime($row["dob"]));
            $doj = date('Y-m-d', strtotime($row["doj"]));
            $currentDate = date('Y-m-d', strtotime($selectedDate));
            $workingYears = date_diff(date_create($doj), date_create($currentDate))->y;
            $year = $workingYears;
            $isBirthday = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($dob)));
            $isWorkAnniversary = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($doj)));
            $dobDateTime = new DateTime($dob);
            $currentDateTime = new DateTime();
            $age = $dobDateTime->diff($currentDateTime)->y;
            $extraWhitespace = str_repeat(' ', 4);

            echo '<div class="card card-list">';
            echo '<div class="card-body">';
            echo '<div class="d-flex align-items-center">';

            if ($isBirthday) {
                echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/cake.png" style="height:50px; width:60px;" alt="birthday cake image">';
                echo '<div class="pl-3 border-left">';
                echo '<h5 class="mb-1">' . $fullName . '</h5>';
            } elseif ($isWorkAnniversary && $year > 0) {
                echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/work-anniversary.png" style="height:50px; width:60px;" alt="work anniversary image">';
                echo '<div class="pl-3 border-left">';
                echo '<h5 class="mb-1">' . $fullName . '</h5>';
            } elseif ($isWorkAnniversary && $year == 0) {
                echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/work-anniversary.png" style="height:50px; width:60px;" alt="work anniversary image">';
                echo '<div class="pl-3 border-left">';
                echo '<h5 class="mb-1">' . $fullName . '</h5>';
            }

            if ($isBirthday) {
                echo '<span style="color: darkblue; font-weight: bold">Happy birthday!</span><br>Wishing you a day filled with joy, success, and countless new opportunities ahead.';
                
            }

            if ($isWorkAnniversary && $year > 0) {
                echo '<span style="color: darkblue; font-weight: bold">Congratulations! It is your work anniversary!</span><br>You have completed' . $extraWhitespace . $year . $extraWhitespace . 'years in our company. Marking another year of excellence, dedication, and professional growth.';
            } elseif ($isWorkAnniversary && $year == 0) {
                echo '<span style="color: darkblue; font-weight: bold">Congratulations! It is your First day!</span><br>Welcome.';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="card card-list">';
        echo '<div class="card-body">';
        echo '<div class="d-flex align-items-center">';
        echo '<img class="svg-icon text-secondary mr-3" src="' . $img . '" style="height:50px; width:70px;" alt="sun image">';
        echo '<div class="pl-3 border-left">';
        echo '<h6 class="text-info mb-1"> ' . $greeting . '</h6>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    $today = $selectedtable;
    $tenDaysLater = date('Y-m-d', strtotime($today . ' + 30 days'));
    $sql = "SELECT * FROM objectives WHERE (due_date BETWEEN ? AND ?)
     AND Company_id = $companyId
      ORDER BY due_date LIMIT 2";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $today, $tenDaysLater);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $fullName = $row["project_name"];
            $projectDueDate = date('Y-m-d', strtotime($row["due_date"]));
            $firstLetter = substr($fullName, 0, 1) . '...';
            echo '<div class="card card-list" onclick="window.location.href = \'viewproject.php?projectid=' . $id . '\';" style="cursor: pointer;">';
            echo '<div class="card-body">';
            echo '<div class="d-flex align-items-center">';
            echo '<div style="background-color: #f5f5f5; width: 60px; height: 60px; border-radius: 50%; text-align: center; font-size: 24px; font-weight: bold; line-height: 60px;">' . strtoupper($firstLetter) . '</div>';
            echo '<div class="pl-3 border-left">';
            echo '<h5 class="mb-1">' . $fullName . '</h5>';
            echo '<span style="color:darkblue; font-weight:bold">Project Due Soon!</span><br>';
            echo 'The project is due on ' . date('F j, Y', strtotime($projectDueDate)) . '.';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    $today = date('Y-m-d');
    $query = "SELECT 
    timeline.id,
    timeline.start_time,
    timeline.end_time,
    timeline.project_id,
    timeline.activity,
    timeline.meeting_link,
    timeline.task_description,
    timeline.emp_id,
    timeline.start_t,
    timeline.participate_id,
    timeline.Company_id,
    IF(timeline.project_id = 0, 'Common Meeting', objectives.project_name) AS project_name,
    (SELECT full_name FROM employee WHERE id = timeline.emp_id) AS assignedby,
    GROUP_CONCAT(DISTINCT employee.full_name ORDER BY employee.full_name ASC) AS employee_names
    FROM timeline
    JOIN employee ON FIND_IN_SET(employee.id, timeline.participate_id) > 0
    LEFT JOIN objectives ON objectives.id = timeline.project_id
    WHERE timeline.start_t = ? AND timeline.activity = 'meeting' AND  FIND_IN_SET(?, timeline.participate_id) > 0 AND (timeline.status = 0)
    AND timeline.Company_id = $companyId
    GROUP BY timeline.id, timeline.start_time, timeline.end_time, timeline.project_id,
             timeline.activity, timeline.meeting_link, timeline.task_description,
             timeline.emp_id, timeline.start_t, timeline.participate_id, objectives.id, objectives.project_name";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $today, $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card card-list">';
            echo '<div class="card-body">';
            echo '<div class="d-flex align-items-center">';
            echo '<img class="svg-icon text-secondary mr-3" src="' . $meeting . '" style="height:50px; width:70px;" alt="sun image">';
            echo '<div class="pl-3 border-left">';
            echo '<h5 class="mb-1">' . $row['project_name'] . '</h5>';
            echo '<span style="color:darkblue; font-weight:bold">Meeting at!' . $row['start_time'] . '</span><br>';
            echo 'Assigned by '.$row['assignedby'].'';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }

    $stmt->close();
}

$conn->close();
?>
