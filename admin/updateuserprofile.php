<?php
session_start();
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $id = $_POST['userid'];
    $fullName = $_POST['fullName'];
    $dob = $_POST['dob'];
    $doj = $_POST['doj'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];    
    $userType = $_POST['userType'];
    $userRole = $_POST['userRole'];
    $userdpt = $_POST['userdpt'];
    $address = $_POST['address'];
    $roles = isset($_POST['role']) ? implode(",", $_POST['role']) : '';
    $salary = $_POST['salary'];
    $accountnumber = $_POST['account'];

    if (!empty($_FILES['profilePicture']['name'])) {
        $file = $_FILES['profilePicture'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDirectory = './../uploads/employee/';
            $uploadedFileName = basename($file['name']);
            $targetFilePath = $uploadDirectory . $uploadedFileName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                // Use prepared statement to prevent SQL injection
                $query = "UPDATE employee SET full_name = ?, email = ?,
                          phone_number = ?, dob = ?, address = ?,
                          profile_picture = ?, user_role = ?,
                          salary = ?, accountnumber = ?, department = ?,
                          Allpannel = ?, user_type = ?,doj = ? 
                          WHERE id = ?";

                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "sssssssssssssi", $fullName, $email,
                                       $phoneNumber, $dob, $address, $uploadedFileName,
                                       $userRole, $salary, $accountnumber, $userdpt,
                                       $roles, $userType,$doj,$id);

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = 'Details updated successfully';
                    header('location: employees.php');
                    exit;
                } else {
                    $_SESSION['error'] = 'Failed to update details, try again';
                    header('location: employees.php');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Failed to move uploaded file';
                header('location: employees.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Error uploading file';
            header('location: employees.php');
            exit;
        }
    } else {
        // Use prepared statement for update without profile picture
        $query = "UPDATE employee SET full_name = ?, email = ?,
                  phone_number = ?, dob = ?, address = ?,
                  user_role = ?, salary = ?, accountnumber = ?,
                  department = ?, Allpannel = ?, user_type = ? , doj = ?
                  WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssi", $fullName, $email, $phoneNumber,
                               $dob, $address, $userRole, $salary, $accountnumber,
                               $userdpt, $roles, $userType,$doj, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = 'Details updated successfully';
            header('location: employees.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update details, try again';
            header('location: employees.php');
            exit;
        }
    }
}
?>
