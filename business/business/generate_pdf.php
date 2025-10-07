<?php
require('./../pdf/fpdf.php');
include "./../include/config.php";

class PDF extends FPDF {
    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Times', 'I', 8);
        $currentDateTime = date('Y-m-d H:i:s');
        $pageNum = 'Page ' . $this->PageNo();
        $url = 'https://jiffy.mineit.tech/project/generate_pdf.php';

        $pageWidth = $this->GetPageWidth();
        $center = $pageWidth / 8;
        $pageNumWidth = $this->GetStringWidth($pageNum) / 2;

        $this->Cell(0, 10, $currentDateTime, 0, 0, 'L');

        $this->SetX($center - $pageNumWidth);
        $this->Cell(0, 10, $pageNum, 0, 0, 'C');

        $this->SetX(-$this->GetStringWidth($url) - 10);
        $this->Cell(0, 10, $url, 0, 0, 'R');
    }

    function GetMultiCellHeight($w, $h, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $height = 0;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $height += $h;
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $height += $h;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
            } else {
                $i++;
            }
        }
        $height += $h;
        return $height;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $notes = $_POST['note'] ?? array();
    $incharges = $_POST['incharge'] ?? array();
    $dueDates = $_POST['dueDate'] ?? array();
    $subject = $_POST['subject'] ?? '';
    $date = $_POST['date'] ?? '';
    $meetingid = $_POST['meetingid'];

    $sql = "SELECT 
        timeline.*, 
        GROUP_CONCAT(attendee.full_name ORDER BY attendee.id ASC SEPARATOR ', ') AS employee_names,
        organizer.full_name AS organizer_name
    FROM 
        `timeline`
    JOIN 
        employee AS attendee 
    ON 
        FIND_IN_SET(attendee.id, timeline.participate_id) > 0
    JOIN 
        employee AS organizer
    ON 
        organizer.id = timeline.emp_id
    WHERE 
        timeline.id = '$meetingid'
    GROUP BY 
        timeline.id";
        
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attendees = $row['employee_names'];
        $organizer = $row['organizer_name'];
    } else {
        $attendees = "No attendees found.";
        $organizer = "Unknown";
    }
}

ob_clean();

$pdf = new PDF();
$pdf->SetTitle('Notes PDF');

function addBorder($pdf) {
    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->Rect(10, 10, $pageWidth - 20, $pageHeight - 20);
}

$pdf->AddPage();
addBorder($pdf);

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 10, 'Minutes of Meeting - ' . $subject, 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(145, 10, "Date & Time", 0, 0, 'R');
$pdf->Cell(45, 10, $date, 0, 1, 'R');

$pdf->Cell(40, 10, "Meeting Organizer", 0, 0, 'L');
$pdf->Cell(40, 10, $organizer, 0, 1, 'L');

$pdf->Cell(40, 10, "Meeting Type", 0, 0, 'L');
$pdf->Cell(40, 10, "Offline", 0, 1, 'L');

$pdf->Cell(40, 10, "Attendees List", 0, 0, 'L');
$pdf->Cell(40, 10, $attendees, 0, 1, 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Activities ' . $subject, 0, 1, 'L');
$pdf->Ln(3);

// Table headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'S.No', 1, 0, 'C');
$pdf->Cell(80, 10, 'Note', 1, 0, 'C');
$pdf->Cell(50, 10, 'Incharge', 1, 0, 'C');
$pdf->Cell(40, 10, 'Due Date', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);

// Populate table with notes, incharge, and due dates
if (is_array($notes)) {
    foreach ($notes as $index => $note) {
        $index += 1;
        $incharge = isset($incharges[$index - 1]) ? $incharges[$index - 1] : '';
        $dueDate = isset($dueDates[$index - 1]) ? $dueDates[$index - 1] : '';

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        
        // Calculate the height of the note cell
        $noteHeight = $pdf->GetMultiCellHeight(80, 10, $note);

        // Set the height of all cells to the height of the note cell
        $pdf->Cell(20, $noteHeight, $index, 1, 0, 'C');
        $pdf->MultiCell(80, 10, $note, 1, 'L');
        $pdf->SetXY($x + 100, $y); // Move x by 20+80
        $pdf->Cell(50, $noteHeight, $incharge, 1, 0, 'C');
        $pdf->Cell(40, $noteHeight, $dueDate, 1, 1, 'C');
    }
} else {
    $pdf->Cell(190, 10, 'No notes found.', 1, 1, 'C');
}

$pdf->Output('Minutes_of_Meeting.pdf', 'I');
?>
