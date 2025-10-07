<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['userid'];


    $sql = "UPDATE employee SET `call` = 0 WHERE id = $url";

    if ($conn->query($sql) === TRUE) {
        echo 'Call status updated to 0 for user ID ' . $url;
    } else {
        echo 'Failed to update call status.';
    }
}
?>
