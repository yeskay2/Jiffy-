<?php

session_start();

$current_time = date("H:i:s");
$logout_time = "17:34:00";

if ($current_time >= $logout_time) {
    unset($_SESSION["user_id"]);
    session_write_close(); 
    mysqli_close($conn);

    
    echo json_encode(["logout" => true]);
} else {
    
    echo json_encode(["logout" => false]);
}
?>
