<?php

include "config.php";


$callerId = isset($_POST['callerid']) ? intval($_POST['callerid']) : 0;
$callerId = max(0, $callerId);

if ($callerId > 0) {
 
    $sql = "UPDATE employee SET `call` = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $callerId);
        if ($stmt->execute()) {
            $stmt->close();
        } else {
            echo '<p class="text-center">Failed to update the call status (0).</p>';
        }
    } else {
        echo '<p class="text-center">Database error (update).</p>';
    }
} else {
    echo '<p class="text-center">Invalid caller ID.</p>';
}
?>
