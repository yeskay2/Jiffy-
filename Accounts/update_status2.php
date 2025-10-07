<?php
include "./../include/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status']) && isset($_POST['projectId'])) {
    $status = $_POST['status'];
    $projectId = $_POST['projectId'];   
    $sql = "UPDATE invoices SET `status` = '$status' WHERE id = $projectId";
    if (mysqli_query($conn, $sql)) {
        echo 'Project status updated successfully.';
    } else {

        echo 'Error updating project status: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request.';
}
?>
