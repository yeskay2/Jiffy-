<?php
session_start();
require_once "./PHPMailer/PHPMailer.php";
require_once "./PHPMailer/SMTP.php";
require_once "./PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$conn = mysqli_connect("localhost", "root", "", "pms");
 $companyId = base64_decode($_GET['companyid']);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $companyId = base64_decode($_GET['companyid']);
    $fullName = $_POST["fullName"];
    $phoneNumber = $_POST["phoneNumber"];
    $dob = $_POST["dob"];
    $doj = $_POST["doj"];
    $password = md5($_POST["password"]);
    $email = $_POST["email"];
    $userType = $_POST["userType"];
    $userRole = $_POST["userRole"];
    $address = $_POST["address"];
    $dpt = $_POST['userdepartment'];
    
    $employeeidsql = "SELECT MAX(empid) as max_empid FROM employee WHERE Company_id = $companyId";
    $result = mysqli_query($conn, $employeeidsql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $max_empid = $row['max_empid'];

    if ($max_empid) {
        $empidWithoutPrefix = (int) substr($max_empid, 4);
        $next_empid = $empidWithoutPrefix + 1;
    } else {
        $next_empid = 1;
    }

    $employeeid = 'EMP-' . str_pad($next_empid, 4, '0', STR_PAD_LEFT);

    $checkQuery = "SELECT * FROM employee WHERE email = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "s", $email);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['error'] = 'Email already registered';
        header('location: employeeregister.php');
        exit();
    }

    if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] === UPLOAD_ERR_OK) {
        $profilePictureName = $_FILES["profilePicture"]["name"];
        $profilePictureTmpName = $_FILES["profilePicture"]["tmp_name"];
        $uploadDir = "./uploads/employee/";
        $uploadedProfilePicture = $uploadDir . basename($profilePictureName);
        move_uploaded_file($profilePictureTmpName, $uploadedProfilePicture);

        $query = "INSERT INTO employee (full_name,empid,phone_number, email, dob, password, doj, user_type, user_role, profile_picture, address, Company_id,department) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssssis", $fullName,$employeeid, $phoneNumber, $email, $dob, $password, $doj, $userType, $userRole, 
        $profilePictureName, $address, $companyId,$dpt);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            try {
                $sql = "SELECT * FROM schedules WHERE Company_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $companyId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $companyname = $row['Company_name'];

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'jiffymine@gmail.com';
                $mail->Password   = 'holxypcuvuwbhylj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('jiffymine@gmail.com', $companyname);
                $mail->addAddress($email, $fullName);
                $mail->isHTML(true);
                $mail->Subject = 'Welcome to ' . $companyname;
                $mail->Body    = 'Dear ' . $fullName . ',<br><br>
                                  Thank you for registering with ' . $companyname . '.<br>
                                  Your login details are:<br>
                                  Email: ' . $email . '<br>
                                  Password: ' . $_POST["password"] . '<br><br>
                                  Please keep this information safe.<br><br>
                                  Regards,<br>
                                  ' . $companyname . ' Team';

                $mail->send();
                header("Location: welcomepage.php?name=" . urlencode($fullName) . "&companyname=" . urlencode($companyname));
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                header('location: welcomepage.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Something went wrong while adding';
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = 'File not uploaded';
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <!-- Bootstrap CSS -->
        <link href=".assets/images/Jiffy-favicon.png" rel="icon">
    <link href="assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/icon.css">
    <link rel="stylesheet" href="assets/css/card.css">
    <link rel="stylesheet" href="./chat/chat.css">
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            <?php if (isset($_SESSION['error'])): ?>
                alert('<?php echo $_SESSION['error']; ?>');
                <?php unset($_SESSION['error']); // Clear the error after displaying ?>
            <?php endif; ?>
        });
    </script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">User Registration Form</h2>
    <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter employee name" pattern="^[A-Za-z\s.]*$" title="Enter letters only" required>
                    <div class="invalid-feedback">
                        Please enter a valid name (letters and spaces only).
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                    <div class="invalid-feedback">
                        Please provide your date of birth.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required>
                    <div class="invalid-feedback">
                        Please enter a valid phone number.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Password must contain at least one letter, one number, one special character, and be at least 8 characters long." placeholder="Enter password" required>
                    <div class="invalid-feedback">
                        Password must be at least 8 characters long and include letters, numbers, and special characters.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="userType">Type</label>
                    <select name="userType" class="form-control" required>
                        <option value="" disabled selected hidden>Select Type</option>
                        <option value="Trainee">Trainee</option>
                        <option value="Employee">Employee</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a user type.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="userRole">Department</label>
                    <select name="userdepartment" class="form-control" required>
                        <option value="" disabled selected hidden>Select Department</option>
                        <?php
                        $companyId = base64_decode($_GET['companyid']);
                      $sql = "SELECT * FROM department WHERE Company_id = $companyId";                      
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $roleName = $row["name"];
                                echo "<option value='$roleName'>$roleName</option>";
                            }
                        } else {
                            echo "<option value=''>No roles found</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Please select a user role.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="userRole">Role</label>
                    <select name="userRole" class="form-control" required>
                        <option value="" disabled selected hidden>Select Role</option>
                        <?php
                        $companyId = base64_decode($_GET['companyid']);
                      $sql = "SELECT * FROM roles WHERE Company_id = $companyId";                      
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $roleName = $row["name"];
                                echo "<option value='$roleName'>$roleName</option>";
                            }
                        } else {
                            echo "<option value=''>No roles found</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Please select a user role.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="doj">Date of Joining</label>
                    <input type="date" class="form-control" id="doj" name="doj" required>
                    <div class="invalid-feedback">
                        Please provide the date of joining.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" placeholder="Enter address" required></textarea>
                    <div class="invalid-feedback">
                        Please enter your address.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="profilePicture">Upload Profile Picture (JPEG or JPG only)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="profilePicture" name="profilePicture" accept=".jpg, .jpeg" required>
                        <label class="custom-file-label" for="profilePicture">Choose file</label>
                        <div class="invalid-feedback">
                            Please upload a JPEG or JPG file.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
 <!-- Backend Bundle JavaScript -->
        <script src="assets/js/backend-bundle.min.js"></script>

        <!-- Table Treeview JavaScript -->
        <script src="assets/js/table-treeview.js"></script>

        <!-- Chart Custom JavaScript -->
        <script src="assets/js/customizer.js"></script>

        <!-- Chart Custom JavaScript -->
        <script async src="assets/js/chart-custom.js"></script>
        <!-- Chart Custom JavaScript -->
        <script async src="assets/js/slider.js"></script>

        <!-- app JavaScript -->
        <script src="assets/js/app.js"></script>

        <script src="assets/vendor/moment.min.js"></script>
        <script src="./script/bot.js"></script>
        <script src="./script/dashboard.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
<script>
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
</script>

</body>
</html>
