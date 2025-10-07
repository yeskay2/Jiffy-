<?php

session_start();
include "./../include/config.php";
require('./../pdf/fpdf.php');
require './vendor/autoload.php'; // Path to PHPExcel autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["startDate"]) && isset($_GET["endDate"]) && isset($_GET["selectmembers"]) && isset($_GET["type"])) {
    $startDate = trim($_GET['startDate']) . ' 00:00:00';
    $endDate = trim($_GET['endDate']) . ' 23:59:59';
    $reportType = trim($_GET['type']);
    $teamid = !empty($_GET["teamid"]) ? $_GET["teamid"] :null;
    $employeeId = !empty($_GET["selectedEmployee"]) ? $_GET["selectedEmployee"] : null;
    if ($teamid !== null) {
            $sql = 'SELECT employee FROM team WHERE team_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $teamid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $employeeIds = [];
                while ($row = $result->fetch_assoc()) {
                    $employeeIds = array_merge($employeeIds, explode(',', $row['employee']));
                }               
                $employeeId = implode(',', array_map('intval', $employeeIds));
            }
    }

    $sql = "SELECT tasks.*, employee.full_name AS uploader_name, assigned.full_name AS assigned_name 
            FROM tasks 
            JOIN employee ON tasks.uploaderid = employee.id 
            JOIN employee AS assigned ON tasks.assigned_to = assigned.id
            WHERE tasks.assigned_to IN ($employeeId) AND tasks.end_time BETWEEN ? AND ? AND tasks.status = 'Completed'";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    if ($result->num_rows > 0) {
        $query = "SELECT * FROM schedules";
        $result_schedules = $conn->query($query);
        $data = $result_schedules->fetch_assoc();
        $image = $data['logo'];
        $companyname = $data['Company_name'];

        if ($reportType === 'pdf') {
            class PDF extends FPDF {
                function Footer() {
                    $this->SetY(-10);
                    $this->SetFont('Times', 'I', 11);
                    $currentDateTime = date('Y-m-d H:i:s');
                    $pageNum = 'Page ' . $this->PageNo();
                    $url = 'https://jiffy.mineit.tech/project/generate_pdf.php';

                    $pageWidth = $this->GetPageWidth();
                    $center = $pageWidth / 15;
                    $pageNumWidth = $this->GetStringWidth($pageNum) / 2;

                    $this->Cell(0, 10, $currentDateTime, 0, 0, 'L');

                    $this->SetX($center - $pageNumWidth);
                    $this->Cell(0, 10, $pageNum, 0, 0, 'C');

                    $this->SetX(-$this->GetStringWidth($url) - 10);
                    $this->Cell(0, 10, $url, 0, 0, 'R');
                }
            }

            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->Rect(5, 5, 200, 287);
            $pdf->Ln(5);

            $pdf->Image($image, 10, 8, 33);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(100);
            $pdf->Cell(0, 10, $companyname, 0, 1, 'C');
            $pdf->Cell(100);
            $pdf->Ln(10);

            $pdf->SetFont('Times', 'B', 16);
            $pdf->Cell(190, 10, "Report for " . date('d-m-Y', strtotime($startDate)) . ' to ' . date('d-m-Y', strtotime($endDate)), 0, 1, 'C');
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
                $employee_name = $row["assigned_name"];
                $tasktype = $row["category"];
                $assigndate = $row["created_at"];
                $start = date("d-m-Y", strtotime($row["Actual_start_time"]));
                $end_date = date("d-m-Y", strtotime($row["due_date"]));
                $assigndate1 = substr($assigndate, 10, 6);
                $assigndate = substr($assigndate, 0, 10);
                $formattedDate = date("d-m-Y", strtotime($assigndate));
                $duedate = date("d-m-Y/h:i A", strtotime($row["due_date"]));
                $start_date2 = $row["start_time"];
                $end_date2 = $row["end_time"];

                $user_start_at = date("d-m-Y", strtotime($row["start_time"]));
                $user_end_at = date("d-m-Y", strtotime($row["end_time"]));

                $startTimestamp = strtotime($start_date2);
                $endTimestamp = strtotime($end_date2);
                $timeInSeconds = $endTimestamp - $startTimestamp;

                $hours = floor($timeInSeconds / 3600);
                $minutes = floor(($timeInSeconds % 3600) / 60);
                $days = floor($timeInSeconds / 86400);

                $formattedTime = 0;

                $start_date2 = strtotime($row["Actual_start_time"]);
                $due_date2 = strtotime($row["due_date"]);

                $per_start_time = $row["perferstart_time"];
                $per_end_time = $row["perferend_time"];

                $per_start_timestamp = strtotime($per_start_time);
                $per_end_timestamp = strtotime($per_end_time);

                $hours_between = floor(($per_end_timestamp - $per_start_timestamp) / (60 * 60));
                $minutes_between = round((($per_end_timestamp - $per_start_timestamp) % (60 * 60)) / 60);

                $days_between = round(($due_date2 - $start_date2) / (60 * 60 * 24)) + 1;

                $per_day = number_format(($hours_between + $minutes_between / 60) * $days_between, 2) . ' hours';

                $per_day_task = number_format($hours_between + $minutes_between / 60, 2);

                $timestamp1 = strtotime($row['start_time']);
                $timestamp2 = strtotime($row['end_time']);
                $diffSeconds = abs($timestamp1 - $timestamp2);
                $days_between = floor($diffSeconds / (60 * 60 * 24)) + 1;

                $formattedTime = $days_between;

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
                $pdf->Cell(50, 10, "Assigned Date", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $formattedDate, 0, 1, 'L');

                $pdf->SetFont('Times', 'B', 12);
                $pdf->Cell(50, 10, "Actual Start Date", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $start, 0, 1, 'L');

                $pdf->SetFont('Times', 'B', 12);
                $pdf->Cell(50, 10, "Actual End Date", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $end_date, 0, 1, 'L');

                $pdf->SetFont('Times', 'B', 12);
                $pdf->Cell(50, 10, "Employee Start At", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $user_start_at, 0, 1, 'L');

                $pdf->SetFont('Times', 'B', 12);
                $pdf->Cell(50, 10, "Employee End At", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $user_end_at, 0, 1, 'L');

                $pdf->SetFont('Times', 'B', 12);
                $pdf->Cell(50, 10, "Total hour for this task", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $per_day, 0, 1, 'L');

                $pdf->SetFont('Times', 'B', 12);
                $pdf->Cell(50, 10, "Total hour per day", 0, 0, 'L');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(1);
                $pdf->Cell(3, 10, ":", 0, 0, 'L');
                $pdf->Cell(3);
                $pdf->Cell(0, 10, $per_day_task, 0, 1, 'L');

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

            $filename = "Monthly_Report_" . $assignedTo . ".pdf";
            $pdf->Output('F', './../report/' . $filename);

            $path = "./../report/$filename";

            echo $path;
        } elseif ($reportType === 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Task Name');
            $sheet->setCellValue('B1', 'Assigned By');
            $sheet->setCellValue('C1', 'Assigned To');
            $sheet->setCellValue('D1', 'Task Type');
            $sheet->setCellValue('E1', 'Assigned Date');
            $sheet->setCellValue('F1', 'Actual Start Date');
            $sheet->setCellValue('G1', 'Actual End Date');
            $sheet->setCellValue('H1', 'Employee Start At');
            $sheet->setCellValue('I1', 'Employee End At');
            $sheet->setCellValue('J1', 'Total Hour for This Task');
            $sheet->setCellValue('K1', 'Total Hour Per Day');
            $sheet->setCellValue('L1', 'Completed Hours');
            $sheet->setCellValue('M1', 'Description');

            $i = 2;
            while ($row = $result->fetch_assoc()) {
                $taskName = $row["task_name"];
                $uploader = $row["uploader_name"];
                $assignedTo = $row["assigned_name"];
                $description = strip_tags($row["description"]);
                $tasktype = $row["category"];
                $assigndate = $row["created_at"];
                $start = date("d-m-Y", strtotime($row["Actual_start_time"]));
                $end_date = date("d-m-Y", strtotime($row["due_date"]));
                $formattedDate = date("d-m-Y", strtotime($assigndate));
                $user_start_at = date("d-m-Y", strtotime($row["start_time"]));
                $user_end_at = date("d-m-Y", strtotime($row["end_time"]));

                $startTimestamp = strtotime($row["start_time"]);
                $endTimestamp = strtotime($row["end_time"]);
                $timeInSeconds = $endTimestamp - $startTimestamp;

                $hours = floor($timeInSeconds / 3600);
                $minutes = floor(($timeInSeconds % 3600) / 60);
                $days = floor($timeInSeconds / 86400);

                $start_date2 = strtotime($row["Actual_start_time"]);
                $due_date2 = strtotime($row["due_date"]);

                $per_start_time = $row["perferstart_time"];
                $per_end_time = $row["perferend_time"];

                $per_start_timestamp = strtotime($per_start_time);
                $per_end_timestamp = strtotime($per_end_time);

                $hours_between = floor(($per_end_timestamp - $per_start_timestamp) / (60 * 60));
                $minutes_between = round((($per_end_timestamp - $per_start_timestamp) % (60 * 60)) / 60);

                $days_between = round(($due_date2 - $start_date2) / (60 * 60 * 24)) + 1;

                $per_day = number_format(($hours_between + $minutes_between / 60) * $days_between, 2) . ' hours';
                $per_day_task = number_format($hours_between + $minutes_between / 60, 2);

                $timestamp1 = strtotime($row['start_time']);
                $timestamp2 = strtotime($row['end_time']);
                $diffSeconds = abs($timestamp1 - $timestamp2);
                $days_between = floor($diffSeconds / (60 * 60 * 24)) + 1;

                $formattedTime = $days_between;

                $sheet->setCellValue("A$i", $taskName);
                $sheet->setCellValue("B$i", $uploader);
                $sheet->setCellValue("C$i", $assignedTo);
                $sheet->setCellValue("D$i", $tasktype);
                $sheet->setCellValue("E$i", $formattedDate);
                $sheet->setCellValue("F$i", $start);
                $sheet->setCellValue("G$i", $end_date);
                $sheet->setCellValue("H$i", $user_start_at);
                $sheet->setCellValue("I$i", $user_end_at);
                $sheet->setCellValue("J$i", $per_day);
                $sheet->setCellValue("K$i", $per_day_task);
                $sheet->setCellValue("L$i", $formattedTime);
                $sheet->setCellValue("M$i", $description);

                $i++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'Monthly_Report_' . $assignedTo . '.xlsx';
            $filepath = './../report/' . $filename;
            $writer->save($filepath);

            echo $filepath;
        }
    } else {
        echo "no file";
    }
}
?>
