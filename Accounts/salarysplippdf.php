<?php
require './../PHPMailer/PHPMailer.php';
require './../PHPMailer/SMTP.php';
require './../PHPMailer/Exception.php';
require('./../pdf/fpdf.php');
include "./../include/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST["employee_id"];
    $Deductions = $_POST["Deductions"];
    $netSalary = $_POST["netSalary"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $salary = $_POST['salary'];
    $download = $_POST['download'];

    $salary = number_format($salary, 2);
    $Deductions = number_format($Deductions, 2);
    $netSalary = number_format($netSalary, 2);

    $monthDate = date_create_from_format('m', $month);
    $monthName = date_format($monthDate, 'F');

    $sql = "SELECT employee.*, schedules.* FROM employee 
    JOIN schedules ON employee.Company_id = schedules.Company_id
    WHERE employee.id = $employee_id";
    $result_working_days = $conn->query($sql);
    $row = mysqli_fetch_assoc($result_working_days);

    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Times', 'B', 18);
    $pdf->Cell(0, 10, $row['Company_name'], 0, 1, 'C');

    $pdf->Image($row['logo'], 10, 10, 25);

    $pdf->SetFont('Times', 'B', 16);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Payslip for the month of ' . $monthName . ', ' . $year, 0, 1, 'C');

    $pdf->SetFont('Times', 'B', 14);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Employee Pay Summary', 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 10, "Employee Name", 0, 0, 'L');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, $row['full_name'], 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 10, "Designation", 0, 0, 'L');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, $row['user_role'], 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 10, "Date of Joining", 0, 0, 'L');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, $row['doj'], 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 10, "Pay Period", 0, 0, 'L');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, $monthName . '-' . $year, 0, 1, 'L');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 10, "Account Number", 0, 0, 'L');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, $row['accountnumber'], 0, 1, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(45, 10, 'Earnings', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Amount', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Deductions', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Net Amount', 1, 1, 'C');

    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(45, 10, 'Basic', 1, 0, 'L');
    $pdf->Cell(45, 10, $salary, 1, 0, 'R');
    $pdf->Cell(45, 10, $Deductions, 1, 0, 'R');
    $pdf->Cell(45, 10, $netSalary, 1, 1, 'R');

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(90, 10, 'Total Deductions: Rs.' . $Deductions, 0, 0, 'L');
    $pdf->Cell(90, 10, 'Gross Salary: Rs.' . $netSalary, 0, 1, 'R');

    $invoiceIdNumber = uniqid('payslip_');
    $fileName = $invoiceIdNumber . '.pdf';

    $pdf->Output('F', './payslip/' . $fileName);

    echo json_encode(array('success' => true, 'fileName' => $fileName));

    if ($download == 'mail') {
        try {
            $mailer = new PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = 'jiffymine@gmail.com'; 
            $mailer->Password = 'holxypcuvuwbhylj'; 
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;

            $mailer->setFrom('your_email@gmail.com', 'Your Name');
            $mailer->addAddress($row['email'], $row['full_name']);

            $mailer->addAttachment('./payslip/' . $fileName);
            $mailer->Subject = 'Payslip for ' . $monthName . ' ' . $year;
            $mailer->Body = 'Dear ' . $row['full_name'] . ', 
                            Please find attached your payslip for the month of ' . $monthName . ' ' . $year . '.
                            Regards,
                            ' . $row['Company_name'];;

            $mailer->send();

            echo json_encode(array('success' => true, 'message' => 'Payslip sent successfully via email'));
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'message' => 'Email sending failed: ' . $e->getMessage()));
        }
    }
    exit;
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request'));
    exit;
}
