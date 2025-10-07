<?php
include_once("config.php");

session_start();
$searchValue = mysqli_real_escape_string($conn, $_POST['search']);

$sql = "SELECT * FROM `employee` WHERE NOT id = '{$_SESSION["user_id"]}' AND (full_name LIKE '%$searchValue%') And active ='active'";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0){
    include_once("data.php");
}else{
    echo '<div id="errors">User Not Found</div>';
}
?>