<?php


class ScheduleManager {
    private $conn;
    private $companyId;
    public function __construct($conn, $companyId ) {
        $this->conn = $conn;
        $this->companyId = $companyId;
    }

    public function redirectIfNotLoggedIn() {
        if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
            header("location: index.php");
            exit();
        }
    }

    public function addSchedule() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $time_in = mysqli_real_escape_string($this->conn, $_POST['time_in']);
            $time_out = mysqli_real_escape_string($this->conn, $_POST['time_out']);
            $company_name = mysqli_real_escape_string($this->conn, $_POST['company_name']);
            $email = mysqli_real_escape_string($this->conn, $_POST['email']);
            $permonth_days = mysqli_real_escape_string($this->conn, $_POST['permonth_days']);
            $address = mysqli_real_escape_string($this->conn, $_POST['address']);

            $time_in = date('H:i:s', strtotime($time_in));
            $time_out = date('H:i:s', strtotime($time_out));

            $working_hours = $this->calculateWorkingHours($time_in, $time_out);

            $target_dir = "./../uploads/";
           $target_file = $target_dir . uniqid() . "_" . basename($_FILES["logo"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            

            if ($_FILES["logo"]["size"] > 5000000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp"  ) {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                $_SESSION['error'] = "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    $sql = "INSERT INTO schedules (time_in, time_out1, Company_name, logo,Company_id,permonth_days,address,emailid,perday_hours) 
                    VALUES ('$time_in', '$time_out', '$company_name', '$target_file','$this->companyId','$permonth_days','$address','$email ','$working_hours')";
                    $result = mysqli_query($this->conn, $sql);

                    if ($result) {
                        $_SESSION['success'] = 'Schedule details added successfully';
                        header('location: schedules.php');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Something went wrong while adding';
                    }
                } else {
                    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
   public function editSchedule() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $schedule_id = mysqli_real_escape_string($this->conn, $_POST['schedule_id']); 
        $time_in = mysqli_real_escape_string($this->conn, $_POST['time_in']);
        $time_out = mysqli_real_escape_string($this->conn, $_POST['time_out']);
        $company_name = mysqli_real_escape_string($this->conn, $_POST['company_name']);
        $email = mysqli_real_escape_string($this->conn, $_POST['email']);
        $permonth_days = mysqli_real_escape_string($this->conn, $_POST['permonth_days']);
        $address = mysqli_real_escape_string($this->conn, $_POST['address']);

        $time_in = date('H:i:s', strtotime($time_in));
        $time_out = date('H:i:s', strtotime($time_out));

        $working_hours = $this->calculateWorkingHours($time_in, $time_out);

        // Check if a new logo file is uploaded
        if ($_FILES["logo"]["size"] > 0) {
            $target_dir = "./../uploads/";
            $target_file = $target_dir . uniqid() . "_" . basename($_FILES["logo"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if ($_FILES["logo"]["size"] > 5000000) {
                $_SESSION['error'] = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif", "webp"])) {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                $_SESSION['error'] = "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    $logo_update = ", logo = '$target_file'";
                } else {
                    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $logo_update = ""; 
        }
        $sql = "UPDATE schedules SET 
                time_in = '$time_in',
                time_out1 = '$time_out',
                Company_name = '$company_name',
                permonth_days = '$permonth_days',
                address = '$address',
                emailid = '$email',
                perday_hours = '$working_hours'
                $logo_update
                WHERE id = '$schedule_id'";
                
        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            $_SESSION['success'] = 'Schedule details updated successfully';
            header('location: schedules.php');
            exit();
        } else {
            $_SESSION['error'] = 'Something went wrong while updating';
        }
    }
}

    private function calculateWorkingHours($time_in, $time_out)
    {
       
        $datetime_in = new DateTime($time_in);
        $datetime_out = new DateTime($time_out);

        
        $interval = $datetime_out->diff($datetime_in);
       
        $hours = $interval->format('%h');
        $minutes = $interval->format('%i');
     
        $working_hours = $hours + ($minutes / 60);

        return $working_hours;
    }
    public function deleteSchedule() {
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $id = mysqli_real_escape_string($this->conn, $_GET["id"]);
            $query = "DELETE FROM schedules WHERE id = $id";
            $result = mysqli_query($this->conn, $query);
            if ($result) {
                $_SESSION['success'] = 'Schedule deleted successfully';
                header('location: schedules.php');
                exit(); 
            } else {
                $_SESSION['error'] = 'Something went wrong while deleting';
            }
        }
    }

    
}

$scheduleManager = new ScheduleManager($conn,$companyId);
$scheduleManager->redirectIfNotLoggedIn();



?>
