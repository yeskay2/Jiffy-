<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['id'])) {
    $sql = "SELECT id FROM eventstable WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE `eventstable` SET 
                `start` = ?,
                `end` = ?,
                `title` = ?,
                `description` = ?,
                `allDay` = ?,
                `free` = ?,
                `color` = ?
                WHERE `id` = ? AND `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiisi", $data['start'], $data['end'], $data['title'], $data['description'], $data['allDay'], $data['free'], $data['color'], $data['id'], $userid);
    } else {
        $sql = "INSERT INTO `eventstable`(`start`, `end`, `title`, `description`, `allDay`, `free`, `color`, `user_id`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiis", $data['start'], $data['end'], $data['title'], $data['description'], $data['allDay'], $data['free'], $data['color'], $userid);
    }
} else {
    $sql = "INSERT INTO `eventstable`(`start`, `end`, `title`, `description`, `allDay`, `free`, `color`, `user_id`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiis", $data['start'], $data['end'], $data['title'], $data['description'], $data['allDay'], $data['free'], $data['color'], $userid);
}

if ($stmt->execute()) {
    echo "Event data saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
