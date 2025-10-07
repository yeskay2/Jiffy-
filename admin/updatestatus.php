<?php
session_start(); // Start or resume the session

include "./../include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employee_id'];
    $newStatus = $_POST['status'];
    $sql = "UPDATE employee SET active = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $employeeId);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Status updated successfully"; 
        header('location: employees.php'); 
    } else {
        echo "Error: " . $stmt->error; 
    }

    
    $stmt->close();
    $conn->close();
}
?>
