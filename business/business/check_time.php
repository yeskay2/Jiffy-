<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 

$indianTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
$currentHour = $indianTime->format('H');
$currentMinute = $indianTime->format('i');

if ($currentHour >= 18 && $currentMinute >= 25) {
    echo 'redirect';
} else {
    echo 'no_redirect';
}
?>
