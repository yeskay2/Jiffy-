<?php
session_start();
include "./../include/config.php";

class CallHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function fetchDataAndShowAlert($userid) {
        $sql = "SELECT * FROM employee WHERE id = ? AND `call` = 1 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $callerid = $row['callerid'];
            $sql = "SELECT * FROM employee WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $callerid); 
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $callername = $row['full_name'];
                $response = array(
                    'callerName' => $callername,
                    'callDuration' => '5 minutes',
                    'callStatus' => 'Incoming'
                );
                sleep(2);
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                $response = array(
                    'error' => 'User not found'
                );
                echo json_encode($response);
            }
        }
    }
    public function cancelCall($userid) {
        $sql = "UPDATE employee SET `call` = 0 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        if ($stmt->execute()) {
            $this->redirectToVideoPage($userid);
        } else {
            echo '<p>Failed to update call status.</p>';
        }
    }
    private function redirectToVideoPage($userid) {
        header("Location: ./../video/index.php?roomID=9475&session_id=$userid");
        exit;
    }
}
$userid = isset($_GET['userid']) ? $_GET['userid'] : '';
$callHandler = new CallHandler($conn);
if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $callHandler->cancelCall($userid);
} else {
    $callHandler->fetchDataAndShowAlert($userid);
}
$conn->close();
?>
