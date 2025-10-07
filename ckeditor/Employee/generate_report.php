<?php
session_start();
include "./../include/config.php";
require('pdf/fpdf.php');

$userid = $_SESSION["user_id"];

$current_month = date("m");
$current_year = date("Y");
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["selectMonth"])) {
    $selectedMonth = (int) $_GET["selectMonth"];

    if ($selectedMonth >= 1 && $selectedMonth <= 12) {
        $current_year = date("Y");

        $sql = "SELECT tasks.task_name, tasks.description, tasks.due_date, tasks.end_time,tasks.start_time,tasks.status,tasks.category,
        employee.full_name AS uploader_name, assigned.full_name AS assigned_name 
        FROM tasks 
        JOIN employee ON tasks.uploaderid = employee.id 
        JOIN employee AS assigned ON tasks.assigned_to = assigned.id
        WHERE tasks.assigned_to = $userid AND MONTH(tasks.created_at) = $selectedMonth AND tasks.status='Completed' ";


        $result = $conn->query($sql);
    }
}
if ($result->num_rows > 0) {

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Rect(5, 5, 200, 287);
    $pdf->Ln(5);

    $pdf->SetFont('Times', 'B', 16);
    $pdf->Cell(190, 10, "Monthly Report - " . date("F Y"), 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetLineWidth(0.5);

    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(8);

    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $pdf->SetLineWidth(0.5);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Rect(5, 5, 200, 287);

        $taskName = $row["task_name"];
        $uploader = $row["uploader_name"];
        $assignedTo = $row["assigned_name"];
        $description = strip_tags($row["description"]);
        $start = $row["start_time"];
        $end_date = $row["end_time"];
        $employee_name = $row["assigned_name"];
        $tasktype = $row["category"];

        $start_date1 = date("d F Y", strtotime(substr($start, 0, 10)));
        $end_date1 = date("d F Y", strtotime(substr($end_date, 0, 10)));

        $startTimestamp = strtotime($start);
        $endTimestamp = strtotime($end_date);
        $timeInSeconds = $endTimestamp - $startTimestamp;

        $hours = floor($timeInSeconds / 3600);
        $minutes = floor(($timeInSeconds % 3600) / 60);
        $days = floor($timeInSeconds / 86400);

        $formattedTime = null;

        if ($days > 0) {
            $formattedTime = "$days days";
        } elseif ($hours > 0) {
            $formattedTime = "$hours hours";
        } elseif ($minutes > 0) {
            $formattedTime = "$minutes minutes";
        }

        $i++;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(190, 10, "Task $i: $taskName", 0, 1, 'L');

        $pdf->Ln(7);

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "Assigned by", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->Cell(0, 10, $uploader, 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "Assigned to", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->Cell(0, 10, $assignedTo, 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "Task type", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->Cell(0, 10, $tasktype, 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "StartDate", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->Cell(0, 10, $start_date1, 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "EndDate", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->Cell(0, 10, $end_date1, 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "Completed Hours", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->Cell(0, 10, $formattedTime, 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, "Description", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(1);
        $pdf->Cell(3, 10, ":", 0, 0, 'L');
        $pdf->Cell(3);
        $pdf->MultiCell(0, 10, $description, 0, 'L');


        $pdf->Ln(5);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.2);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);
    }

    $filename = "monthly_report_" . date("Y-m") . ".pdf";
    $pdf->Output('F', './../Employee/report/' . $filename);

    echo '<a href="./../Employee/report/' . $filename . '" download class="btn"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" style="fill:#fff;"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg></a>';
} else {
    echo "no file";
}
