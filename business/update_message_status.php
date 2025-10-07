<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];

if (isset($_POST['user_id']) && isset($_POST['myid'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $myid = mysqli_real_escape_string($conn, $_POST['myid']);

    $updateQuery = "UPDATE `messages` SET message_status = 1 WHERE incoming = $myid AND outgoing =$user_id  ";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo 'Message status updated successfully.';
    } else {
        echo 'Error updating message status.';
    }
} else {
    echo 'Invalid request.';
}
?>

