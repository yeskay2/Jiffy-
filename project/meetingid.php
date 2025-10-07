<?php
$conn = mysqli_connect("localhost", "snh6_jiffy2", "mFbmeGA7HhkYqMt7AVxt", "snh6_jiffy2");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = isset($_POST['response']) ? $_POST['response'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $meetingId = isset($_GET['meetingid']) ? $_GET['meetingid'] : '';
    $userId = isset($_GET['userid']) ? $_GET['userid'] : '';


  

    $sql = "SELECT * FROM meetingaction WHERE user_id = ? AND meeting_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $userId, $meetingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE meetingaction SET response = ?, remark = ? WHERE user_id = ? AND meeting_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $response, $remark, $userId, $meetingId);
    } else {
        $sql = "INSERT INTO meetingaction (meeting_id, response, remark, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $meetingId, $response, $remark, $userId);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Meeting Invitation Response Submitted');</script>";
        
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Invitation Response</title>
    <style>
        
        body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.response-options {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

label {
    display: inline-block;
    margin-right: 20px;
}

.radio-label {
    font-size: 18px;
}

.remark-field {
    margin-bottom: 20px;
}

textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
}

button {
    display: block;
    width: 100%;
    padding: 12px;
    font-size: 18px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Meeting Invitation Response</h2>
        <form action="#
        " method="post">
            <div class="response-options">
                <label>
                    <input type="radio" name="response" value="accept" required>
                    <span class="radio-label">Accept</span>
                </label>
                <label>
                    <input type="radio" name="response" value="decline" required>
                    <span class="radio-label">Decline</span>
                </label>
            </div>
            <div class="remark-field">
                <label for="remark">Remarks (optional):</label>
                <textarea id="remark" name="remark" rows="4" cols="50"></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
