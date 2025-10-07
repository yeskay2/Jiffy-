<?php
session_start();
$userid = $_SESSION["user_id"];
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postData = file_get_contents("php://input");

    if ($postData) {
        $locationData = json_decode($postData, true);

        if ($locationData && isset($locationData['latitude']) && isset($locationData['longitude'])) {
            $latitude = $locationData['latitude'];
            $longitude = $locationData['longitude'];

            
            $existingRecord = mysqli_query($conn, "SELECT * FROM `user_locations` WHERE `userid` = '$userid'");
            
            if (mysqli_num_rows($existingRecord) > 0) {               
                $sql = "UPDATE `user_locations` SET `latitude` = '$latitude', `longitude` = '$longitude', `timestamp` = NOW() WHERE `userid` = '$userid'";
            } else {                
                $sql = "INSERT INTO `user_locations`(`userid`, `latitude`, `longitude`, `timestamp`, `Company_id`) 
                        VALUES ('$userid','$latitude','$longitude',NOW(),'$companyId')";
            }

            if (mysqli_query($conn, $sql)) {
                http_response_code(200);
                echo "Location updated successfully";
            } else {
                http_response_code(500);
                echo "Error updating location";
            }
        } else {
            http_response_code(400);
            echo "Invalid data received";
        }
    } else {
        http_response_code(400);
        echo "Error decoding JSON data";
    }
} else {
    http_response_code(405);
    echo "Method not allowed";
}
?>
