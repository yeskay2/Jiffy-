<?php
global $conn;
include "./../include/config.php";

date_default_timezone_set("Asia/Kolkata"); 

$currentTime = date("H"); 

if ($currentTime >= 5 && $currentTime < 12) {
    $greeting = "Good Morning";
    $img = "./../assets/images/Morning.png";
} elseif ($currentTime >= 12 && $currentTime < 17) {
    $greeting = "Good Afternoon";
    $img = "./../assets/images/Afternoon.png";
} else {
    $greeting = "Good Evening";
    $img = "./../assets/images/Evening.png";
}

if (isset($_GET['selectedDate'])) {
    $selectedDate = $_GET['selectedDate'];
    $formattedDate = date('m-d', strtotime($selectedDate));

    $sql = "SELECT id, full_name, dob, doj, YEAR(CURDATE()) - YEAR(doj) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(doj, '%m%d')) 
    AS working_years FROM employee WHERE DATE_FORMAT(dob, '%m-%d') = '$formattedDate' OR DATE_FORMAT(doj, '%m-%d') = '$formattedDate' AND Company_id = '$companyId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fullName = $row["full_name"];
            $dob = date('Y-m-d', strtotime($row["dob"]));
            $doj = date('Y-m-d', strtotime($row["doj"]));
            $currentDate = date('Y-m-d', strtotime($selectedDate));
            $workingYears = date_diff(date_create($doj), date_create($currentDate))->y;
            $year= $workingYears;
            $isBirthday = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($dob)));
            $isWorkAnniversary = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($doj)));

            
            $dobDateTime = new DateTime($dob);
            $currentDateTime = new DateTime();
            $age = $dobDateTime->diff($currentDateTime)->y;

            $extraWhitespace = str_repeat(' ', 4);

            echo '<div class="card card-list">';
            echo '<div class="card-body">';
            echo '<div class="d-flex align-items-center">';
            if ($isBirthday) {
                
                echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/cake.png" style="height:50px; width:60px;" alt="birthday cake image">';
                echo '<div class="pl-3 border-left">';
                echo '<h5 class="mb-1">' . $fullName . '</h5>';
            } elseif ($isWorkAnniversary && $year >0) {
                echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/work-anniversary.png" style="height:50px; width:60px;" alt="work anniversary image">';
                echo '<div class="pl-3 border-left">';
                echo '<h5 class="mb-1">' . $fullName . '</h5>';
            }elseif($isWorkAnniversary && $year ==0){
                echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/work-anniversary.png" style="height:50px; width:60px;" alt="work anniversary image">';
                echo '<div class="pl-3 border-left">';
                echo '<h5 class="mb-1">' . $fullName . '</h5>';
            }
           
            if ($isBirthday) {
                echo '<span style="color: darkblue; font-weight: bold">Happy birthday!</span><br>Wishing you a day filled with joy, success, and countless new opportunities ahead.';
                echo '<br>Age: ' . $age;
            }
            if ($isWorkAnniversary && $year >0) {
                echo '<span style="color: darkblue; font-weight: bold">Congratulations! It is your work anniversary!</span><br>You have been completed' . $extraWhitespace . $year . $extraWhitespace . 'years in our company. Marking another year of excellence, dedication, and professional growth.';
            }elseif($isWorkAnniversary && $year ==0){
                 echo '<span style="color: darkblue; font-weight: bold">Congratulations! It is your First day!</span><br>Wellcome.';
            }
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div';
        }
    } else {
        echo '<div class="card card-list">';
        echo '<div class="card-body">';
        echo '<div class="d-flex align-items-center">';
        echo '<img class="svg-icon text-secondary mr-3" src="' . $img . '" style="height:50px; width:70px;" alt="sun image">';
        echo '<div class="pl-3 border-left">';
        echo '<h6 class="text-info mb-1"> ' . $greeting . '</h6>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
