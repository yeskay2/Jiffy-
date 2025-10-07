<?php
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["userid"])) {
        $userid = $_POST["userid"];
        
        $sql = "SELECT email FROM `employee` WHERE id = '$userid'";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $email = $row["email"];
            
            $date = date("d-m-Y");
            
            $sql = "SELECT id FROM attendance WHERE employee_id = '$email' AND date = '$date'";
            $result_attendance = mysqli_query($conn, $sql);
            
            if ($result_attendance && mysqli_num_rows($result_attendance) > 0) {
                $response = array(
                    "status" => "success",
                    "message" => "Attendance record found for userid: " . $userid,
                    "current_datetime" => $date
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
