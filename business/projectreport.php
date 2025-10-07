<?php
session_start();
include "./../include/config.php";
require('./../pdf/fpdf.php');
$current_month = date("m");
$current_year = date("Y");
error_reporting(E_ALL);
ini_set('display_errors', 1);

class PDFWithHeader extends FPDF
{
    private $taskNumber = 0;
    private $projectname;

    function Header()
    {
        $this->Image('./../assets/images/mine-logo.png', 15, 18, 15);
        $this->SetFont('Times', 'B', 13);
        $this->Cell(20);
        $this->Cell(0, 20, 'Merrys Info-Tech & New-Gen Educare', 0, 1, 'L');
        $this->Ln(3);

        $this->SetFont('Times', 'B', 18);
        $this->Cell(0, 10, $this->projectname . '- Project Report', 0, 1, 'C');
        $this->Ln(7);

        $this->SetLineWidth(0.3);
        $this->SetDrawColor(50, 50, 50);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 180, $this->GetY());
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 8, 'Page ' . $this->PageNo(), 0, 0, 'C');

        $this->SetLineWidth(0.5);
        $this->Rect(10, 10, 190, 277);
    }

    function AddTask($taskName, $description, $dueDate, $endTime, $startTime, $status, $category, $createdAt, $uploaderName, $assignedName)
    {
        $endTimeFormatted = $endTime ? date('d/m/Y H:i', strtotime($endTime)) : '';
        $startTimeFormatted = $startTime ? date('d/m/Y H:i', strtotime($startTime)) : '';

        $this->taskNumber++;

        $this->SetFont('Times', 'B', 16);
        $this->MultiCell(0, 10, 'Task Details', 0, 'C');
        $this->Ln(5);

        $this->SetFont('Times', 'B', 13);
        $this->Cell(50, 10, $this->taskNumber . '. ' . "Task", 0, 0, 'L');
        $this->SetFont('Times', '', 14);
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $taskName, 0, 1, 'L');

        $this->SetFont('Times', '', 13);

        $this->Cell(50, 10, "Description", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, strip_tags($description), 0, 1, 'L');

        $this->Cell(50, 10, "Due Date", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $dueDate, 0, 1, 'L');

        $this->Cell(50, 10, "End Time", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $endTimeFormatted, 0, 1, 'L');

        $this->Cell(50, 10, "Start Time", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $startTimeFormatted, 0, 1, 'L');

        $this->Cell(50, 10, "Status", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $status, 0, 1, 'L');

        $this->Cell(50, 10, "Category", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $category, 0, 1, 'L');

        $this->Cell(50, 10, "Assigned At", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $createdAt, 0, 1, 'L');

        $this->Cell(50, 10, "Assigned By", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $uploaderName, 0, 1, 'L');

        $this->Cell(50, 10, "Assigned To", 0, 0, 'B');
        $this->Cell(1);
        $this->Cell(3, 10, ":", 0, 0, 'L');
        $this->Cell(3);
        $this->Cell(0, 10, $assignedName, 0, 1, 'L');

        $this->Ln();
        $this->SetLineWidth(0.2);
        $this->SetDrawColor(150, 150, 150);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 180, $this->GetY());
        $this->Ln();
    }

    public function setProjectName($projectname)
    {
        $this->projectname = $projectname;
    }
}

function generatePDF($projectid, $projectname, $modules,$dec,$projectmanagername,$members)
{
    global $conn;

    $sql = "SELECT tasks.task_name, tasks.description, tasks.due_date, tasks.end_time, tasks.start_time, tasks.status, tasks.category, tasks.created_at,
        employee.full_name AS uploader_name, assigned.full_name AS assigned_name 
        FROM tasks 
        JOIN employee ON tasks.uploaderid = employee.id 
        JOIN employee AS assigned ON tasks.assigned_to = assigned.id
        WHERE tasks.projectid = ? AND tasks.status = 'Completed'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $projectid);
    $stmt->execute();
    $result = $stmt->get_result();

    $pdf = new PDFWithHeader();
    $pdf->setProjectName($projectname);
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();

    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Project Name", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, $projectname, 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Modules", 0, 0, 'L');
    $pdf->Ln(13);
    $pdf->SetFont('Times', '', 14);
    
    $departments = explode(", ", $modules);
    $index = 1;
    foreach ($departments as $department) {
        $pdf->Cell(10, 10, $index . '.', 0, 0, 'L');
        $pdf->Cell(0, 10, ucfirst(trim($department)), 0, 1, 'L');
        $index++;
    }

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Description", 0, 0, 'L');
    $pdf->Ln(13);
    $pdf->SetFont('Times', '', 13);
    $text = $dec;
    $pdf->MultiCell(0, 10, $text, 0, 'J');

    $pdf->Ln(7);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Project Manager", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10,$projectmanagername, 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Involved Members", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10,$members, 0, 1, 'L');


    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Actual Start Date", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, "23-04-2024", 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Actual End Date", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, "24-05-2024", 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Total Hours", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, "225", 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Hours Per Day", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, "4", 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Project Budget", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, "5,00,000", 0, 1, 'L');

    $pdf->Ln(3);
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(50, 10, "Involved Resources", 0, 0, 'L');
    $pdf->SetFont('Times', '', 14);
    $pdf->Cell(1);
    $pdf->Cell(3, 10, ":", 0, 0, 'L');
    $pdf->Cell(3);
    $pdf->Cell(0, 10, "2", 0, 1, 'L');

    $pdf->Ln(7);
    $pdf->SetLineWidth(0.2);
    $pdf->SetDrawColor(50, 50, 50);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 180, $pdf->GetY());

    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);

    while ($row = $result->fetch_assoc()) {
        $dueDate = $row['due_date'] ? date('d/m/Y', strtotime($row['due_date'])) : '';
        $endTime = $row['end_time'] ? date('d/m/Y H:i', strtotime($row['end_time'])) : '';
        $startTime = $row['start_time'] ? date('d/m/Y H:i', strtotime($row['start_time'])) : '';

        $pdf->AddTask(
            $row['task_name'],
            $row['description'],
            $dueDate,
            $endTime,
            $startTime,
            $row['status'],
            $row['category'],
            $row['created_at'],
            $row['uploader_name'],
            $row['assigned_name']
        );
    }

    $rand = rand(100, 9999);
    $filename = "./projecrreport/project_report-$rand.pdf";
    $pdf->Output('F', $filename);

    return $filename;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $projectid = $_GET["projectid"];
    $projectname = $_GET["projectname"];
    $sql = "SELECT 
    p.project_name, 
    p.description, 
    p.progress, 
    p.priority, 
    p.document_attachment, 
    p.modules,
    DATE_FORMAT(p.due_date, '%d-%m-%Y') AS due_date,
    DATE_FORMAT(p.start_date, '%d-%m-%Y') AS start_date,
    p.budget, 
    p.members, 
    p.department, 
    p.lead_id, 
    p.id AS project_id,
    p.no_resource,
    p.no_resources_requried,
    p.project_manager_id,
    COALESCE(p.location, 'Office') AS location,
    p.totalhours,
    p.perday,
    e.full_name AS project_manager_name,
    e.profile_picture AS project_manager_profile,
    GROUP_CONCAT(DISTINCT emp.full_name) AS members,
    GROUP_CONCAT(DISTINCT emp.profile_picture) AS member_images,
    GROUP_CONCAT(DISTINCT d.name) AS departments
    FROM objectives p
    LEFT JOIN employee e ON p.project_manager_id = e.id
    LEFT JOIN employee emp ON FIND_IN_SET(emp.id, p.members)
    LEFT JOIN department d ON FIND_IN_SET(d.id, p.department)
    WHERE p.id =  $projectid 
    GROUP BY p.id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $modules = $row['modules'];
    $dec = $row['description'];
    $projectmanagername = $row['project_manager_name'];
    $members = $row['members'];
    $filename = generatePDF($projectid, $projectname, $modules,$dec,$projectmanagername,$members);

    header('Content-Type: application/json');
    echo json_encode(["filename" => $filename]);
}
?>
