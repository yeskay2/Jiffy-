<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <style>      

        .project-details {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 758px;
        }

        h5 {
            color: #333;
            margin-bottom: 10px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-item b {
            color: #555;
        }

        .attachment-link {
            color: #007bff;
            text-decoration: none;
        }

        .attachment-link:hover {
            text-decoration: underline;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="project-details">
        <?php
        include "./../include/config.php";

        if (isset($_GET['id'])) {
            $projectId = $_GET['id'];

            $sql = "SELECT * FROM objectives WHERE id = $projectId";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $projectname = htmlspecialchars($row['project_name']);
                $description = strip_tags($row['description']);
                $progress = htmlspecialchars($row['progress']);
                $priority = htmlspecialchars($row['priority']);       
                $documentAttachment = htmlspecialchars($row['document_attachment']);
                 $dueDate = date('d-m-Y', strtotime(htmlspecialchars($row['due_date'])));
                $startDate = date('d-m-Y', strtotime(htmlspecialchars($row['start_date'])));
                $member = $row['members'];
                $memberNames = array();
               
                $departmentIds = explode(',', $row['department']);
                if ($member !== null) {
                    $memberIDs = explode(',', $member);
                } else {
                    $memberIDs = array();
                }

                $departmentNames = array();
                foreach ($departmentIds as $departmentId) {
                    $sqlDept = "SELECT name FROM department WHERE id = $departmentId";
                    $resultDept = mysqli_query($conn, $sqlDept);
                    if ($resultDept && mysqli_num_rows($resultDept) > 0) {
                        $deptRow = mysqli_fetch_assoc($resultDept);
                        $departmentNames[] = htmlspecialchars($deptRow['name']);
                    }
                }
                if ($member !== null) {
                    $memberIDs = explode(',', $member);

                    foreach ($memberIDs as $memberID) {
                        $sql5 = "SELECT full_name FROM employee WHERE id = $memberID";
                        $result5 = mysqli_query($conn, $sql5);

                        if ($result5 && mysqli_num_rows($result5) > 0) {
                            $memberRow = mysqli_fetch_assoc($result5);
                            $memberNames[] = $memberRow['full_name'];
                        }
                    }
                }

              echo "<h5>$projectname</h5>";
            echo "<div class='detail-item'><b>Description:</b> $description</div>";       
            echo "<div class='detail-item'><b>Progress:</b> ". number_format($progress, 2) ."%</div>";
            echo "<div class='detail-item'><b>Priority:</b> $priority</div>";
            echo "<div class='detail-item'><b>Department:</b> " . implode(', ', $departmentNames) . "</div>";
            echo "<div class='detail-item'><b>Members:</b> " .implode(', ', $memberNames) . "</div>";
            echo "<div class='detail-item'><b>Start Date:</b> $startDate</div>";
            echo "<div class='detail-item'><b>Due Date:</b> $dueDate</div>";
            echo "<div class='detail-item'><b>Document Attachment:</b> <a class='attachment-link' href=\"./../uploads/projects/$documentAttachment\" download>" . basename($documentAttachment) . "</a></div>";
            echo "<div class='detail-item center'>"; // Added 'center' class
            echo "<button onclick='projectreport($projectId, \"$projectname\")'>Project Report</button>";
            echo "</div>";

            } else {
                echo "<p>Project details not available.</p>";
            }
        } else {
            echo "<p>Invalid request.</p>";
        }
        ?>
    </div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
function projectreport(id, name) {
    $.ajax({
        type: "POST",
        url: "projectreport.php",
        data: {
            projectid: id,
            projectname: name
        },
        dataType: "json", // Adjusted dataType to handle JSON response
        success: function (response) {
            if (response.filename) {
                var downloadLink = document.createElement('a');
                downloadLink.href = response.filename; 
                downloadLink.download = response.filename;
                downloadLink.style.display = 'none';
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            } else {
                console.error("PDF generation failed");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}
</script>


</body>
</html>
