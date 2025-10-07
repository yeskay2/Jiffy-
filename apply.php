<?php
$companyid = base64_decode($_GET['companyid']);
error_reporting(E_ALL);
$conn = mysqli_connect("localhost", "snh6_jiffy2", "mFbmeGA7HhkYqMt7AVxt", "snh6_jiffy2");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $workExperience = $_POST['workExperience'];
    $source = $_POST['source'];
    $resumePath = "./resume_directory/" . basename($_FILES["resume"]["name"]);
    $id = base64_decode($_GET['jobid']);
    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath)) {
        $sql = "INSERT INTO job_applications (full_name, email, phone, address, work_experience, source, resume_path,jobid,Company_id)
                VALUES ('$fullName', '$email', '$phone', '$address', '$workExperience', '$source', '$resumePath','$id','$companyid')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Unable to move uploaded file.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Application Form | JIFFY</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    textarea {
        height: 100px;
    }
    input[type="file"] {
        margin-top: 10px;
    }
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Application Form</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address">
        <label>Work Experience Level:</label>
        <select id="workExperience" name="workExperience" required>
            <option value="">Select...</option>
            <option value="entryLevel">Entry Level</option>
            <option value="midLevel">Mid Level</option>
            <option value="seniorLevel">Senior Level</option>
        </select>
        <label>How did you hear about this job?</label>
        <label><input type="radio" name="source" value="jobPortal"> Job Portal</label><br>
        <label><input type="radio" name="source" value="socialMedia"> Social Media</label><br>
        <label><input type="radio" name="source" value="referral"> Referral</label><br>
        <label><input type="radio" name="source" value="ourportal"> Our Portal</label><br>
        <label for="resume">Upload Resume:</label>
        <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
