<?php 
session_start();
include "config.php";
$userid = $_SESSION["user_id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['userid'];
    $ans = $_POST['ans'];
    $date = date("d-m-Y");
    $date = mysqli_real_escape_string($conn, $date);

    if ($ans == "Answer") {
        $userid = mysqli_real_escape_string($conn, $userid);

        $sql = "UPDATE employee SET `call`= 0 WHERE id = $userid";
        if ($conn->query($sql) === TRUE) {
            $answerURL = "./../video/index.php?roomID=9475&session_id=$userid";

            echo "<script>window.open('$answerURL', '_blank');</script>";


            echo "<script>window.location.href = './../Employee/dashboard.php';</script>";


            echo "<script>window.location.reload();</script>";
        } else {
            echo '<p>Failed to update the database.</p>';
        }
    } elseif ($ans == "Decline") {
        $userid = mysqli_real_escape_string($conn, $userid);

        $sql = "UPDATE employee SET `call`= 0 WHERE id = $userid";
        if ($conn->query($sql) === TRUE) {

            echo "<script>window.location.href = './../Employee/dashboard.php';</script>";
            exit;
        } else {
            echo '<p>Failed to update the database.</p>';
        }
    }
}
?>