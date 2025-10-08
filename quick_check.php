<?php
// Quick DB connection check
$conn = @mysqli_connect("localhost", "root", "", "pms");
if ($conn) {
    echo "CONNECTED";
    mysqli_close($conn);
} else {
    $conn = @mysqli_connect("localhost", "root", "root", "pms");
    if ($conn) {
        echo "CONNECTED";
        mysqli_close($conn);
    } else {
        echo "DISCONNECTED";
    }
}
?>