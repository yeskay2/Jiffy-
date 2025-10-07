<?php
session_start();

include "./../include/config.php"; 

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
} else {
    echo "Session ID is missing.";
    exit;
}

sleep(30);

try {
    $sql = "UPDATE employee SET `call` = 0";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        
        $stmt->execute();
        $stmt->close();

        header("Location: users.php");
        exit;
    } else {
        echo '<p class="text-center">Database error (update).</p>';
    }
} catch (Exception $e) {
    echo '<p class="text-center">An error occurred: ' . $e->getMessage() . '</p>';
}
?>

