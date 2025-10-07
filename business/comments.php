<?php
session_start();
include "./../include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['user_id'])) {
$userid = $_POST['user_id'];

$stmt = $conn->prepare("UPDATE community SET ring = CONCAT(ring, ',$userid') WHERE FIND_IN_SET(?, ring) = 0");
$stmt->bind_param("i", $userid);

if ($stmt->execute()) {
    echo "Update successful";
} else {
    echo "Error updating: " . $stmt->error;
}

}
$stmt->close();
?>
