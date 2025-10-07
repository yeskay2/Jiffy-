<?php
include "./../include/config.php";

if(isset($_GET['incomechart']) && $_GET['incomechart'] == "monthly") {
    $sql = "SELECT SUM(`received_amount`) AS `income`, 
            SUBSTRING_INDEX(`month`, ' ', 1) AS `month_name`, 
            SUBSTRING_INDEX(`month`, ' ', -1) AS `year`
            FROM `revenue_collected`
            GROUP BY `year`, `month_name`
            ORDER BY `year`, `month_name`";   
    $result = mysqli_query($conn, $sql); 
    $incomeData = [];
    $monthMapping = [
        'January' => 'Jan',
        'February' => 'Feb',
        'March' => 'Mar',
        'April' => 'Apr',
        'May' => 'May',
        'June' => 'Jun',
        'July' => 'Jul',
        'August' => 'Aug',
        'September' => 'Sep',
        'October' => 'Oct',
        'November' => 'Nov',
        'December' => 'Dec'
    ];  
    while ($row = mysqli_fetch_assoc($result)) {
        $month = $monthMapping[$row['month_name']];
        $year = $row['year'];
        $monthYear = $month . " " . $year;
        $incomeData[$monthYear] = $row['income'];
    }
    header('Content-Type: application/json');
    echo json_encode($incomeData);

} else {
    echo json_encode(array("error" => "Invalid request"));
}
?>
    