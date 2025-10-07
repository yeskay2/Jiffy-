<?php
session_start();
include "./../include/config.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    die;
}

$userid = $_SESSION["user_id"];

$lat = $_POST['lat'];
$lng = $_POST['lng'];

// Check if a record with the given userid already exists
$checkSql = "SELECT * FROM user_locations WHERE userid = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If a record exists, update the location data
    $updateSql = "UPDATE user_locations SET latitude = ?, longitude = ?, `timestamp` = NOW() WHERE userid = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ddi", $lat, $lng, $userid);
    
    if ($stmt->execute()) {
        echo "Location updated successfully";
    } else {
        echo "Error updating location: " . $stmt->error;
    }
} else {
    // If no record exists, insert a new record
    $insertSql = "INSERT INTO user_locations (userid, latitude, longitude) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("idd", $userid, $lat, $lng);
    
    if ($stmt->execute()) {
        echo "Location inserted successfully";
    } else {
        echo "Error inserting location: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
