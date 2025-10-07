
<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];



// Get the selected employee ID from the query parameter
$selectedEmployeeId = isset($_GET['employee']) ? $_GET['employee'] : null;

// Initialize latitude and longitude to default values
$latitude = 0;
$longitude = 0;

// Fetch employee location data from the database
$query = "SELECT * FROM user_locations WHERE userid = $selectedEmployeeId"; 
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
}

// Create an associative array with the fetched data
$employeeData = [
    'latitude' => $latitude,
    'longitude' => $longitude
];

// Check if the selected employee ID exists in the data
if ($latitude != 0 && $longitude != 0) {
    // Return the data for the selected employee as JSON
    header('Content-Type: application/json');
    echo json_encode($employeeData);
} else {
    // If the employee ID is not found, return an error message
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Employee not found']);
}

// Close the database connection
$conn->close();
?>
