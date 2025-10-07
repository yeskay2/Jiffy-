<?php
include "./../include/config.php";

if (isset($_GET['selectedDate'])) {
    $selectedDate = $_GET['selectedDate'];
    $formattedDate = date('m-d', strtotime($selectedDate));

    $sql = "SELECT * FROM employee WHERE DATE_FORMAT(dob, '%m-%d') = '$formattedDate' OR DATE_FORMAT(doj, '%m-%d') = '$formattedDate'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fullName = $row["full_name"];
            $dob = date('Y-m-d', strtotime($row["dob"]));
            $doj = date('Y-m-d', strtotime($row["doj"]));

            $isBirthday = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($dob)));
            $isWorkAnniversary = (date('m-d', strtotime($selectedDate)) === date('m-d', strtotime($doj)));

            echo '<div class="card card-list">';
            echo '<div class="card-body">';
            echo '<div class="d-flex align-items-center">';
            echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/cake.png" style="height:30px; width:50px;" alt="cake image">';
            echo '<div class="pl-3 border-left">';
            echo '<h5 class="mb-1">' . $fullName . '</h5>';
            if ($isBirthday) {
                echo '<span style="color:darkblue; font-weight:bold">Happy birthday!</span><br>Wishing you a day filled with joy, success, and countless new opportunities ahead.';
            }
            if ($isWorkAnniversary) {
                echo "Congratulations! It's your work anniversary!<br>";
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="card card-list">';
        echo '<div class="card-body">';
        echo '<div class="d-flex align-items-center">';
        echo '<img class="svg-icon text-secondary mr-3" src="./../assets/images/sun.png" style="height:50px; width:70px;" alt="sun image">';
        echo '<div class="pl-3 border-left">';
        echo '<h5 class="text-info mb-1">GOOD MORNING !!</h5>';
        
        // Different content for each day
        $currentDay = date("l");  
        switch ($currentDay) {
            case "Sunday":
                echo '<p class="mb-0">It’s a beautiful Sunday morning and a great opportunity to thank the Lord for reminding us how blessed we are.</p>';
                break;
            case "Monday":
                echo '<p class="mb-0">New week, new goals. Let’s go and achieve them!</p>';
                break;
            case "Tuesday":
                echo '<p class="mb-0">Don’t wait for the perfect moment, take the moment and make it perfect.</p>';
                break;
            case "Wednesday":
                echo '<p class="mb-0">It’s Wednesday. Even the camels are celebrating!</p>';
                break;
            case "Thursday":
                echo '<p class="mb-0">Keep your face to the sunshine and you cannot see a shadow.</p>';
                break;
            case "Friday":
                echo '<p class="mb-0">It’s Friday! Time to reflect on the week and look forward to the weekend.</p>';
                break;
            case "Saturday":
                echo '<p class="mb-0">Weekends are the best. Enjoy and recharge!</p>';
                break;
            default:
                echo '<p class="mb-0">Do not watch the clock; Do what it does. Keep going...</p>';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

?>

