<?php
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["userid"])) {
        $userid = $_POST["userid"];

        $sql = "SELECT email FROM `employee` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $email = $row["email"];
            
            $date = date("d-m-Y");
            
            $sql = "SELECT id FROM attendance WHERE employee_email = ? AND date = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $email, $date);
            mysqli_stmt_execute($stmt);
            $result_attendance = mysqli_stmt_get_result($stmt);

            if ($result_attendance && mysqli_num_rows($result_attendance) > 0) {
                $response = array(
                    "status" => "success",
                    "message" => "Attendance record found for userid: " . $userid,
                    "current_date" => $date
                );
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "No attendance record found for userid: " . $userid
                );
            }
        } else {
            $response = array(
                "status" => "error",
                "message" => "User not found for userid: " . $userid
            );
        }
    } else {
        $response = array(
            "status" => "error",
            "message" => "Userid not provided in POST data"
        );
    }
} else {
    $response = array(
        "status" => "error",
        "message" => "Invalid request method"
    );
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
