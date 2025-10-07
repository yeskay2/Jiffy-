<?php
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"][0])) {
        $taskid = isset($_POST['taskid']) ? $_POST['taskid'] : '';
        $uploadDirectory = "outputimage/";

        foreach ($_FILES["image"]["name"] as $key => $fileName) {
            $fileName = preg_replace('/[^A-Za-z0-9\-_.]/', '', $fileName);
            $uniqueFilename = uniqid() . '_' . $fileName;
            $tempFile = $_FILES["image"]["tmp_name"][$key];
            $targetFile = $uploadDirectory . $uniqueFilename;

            if (move_uploaded_file($tempFile, $targetFile)) {
                // Check if the task ID already exists in the database
                $query = "SELECT * FROM tasks WHERE id = '$taskid'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    // Task ID exists, fetch the existing outputfilepath
                    $row = mysqli_fetch_assoc($result);
                    $existingOutputFilePath = $row['outputfilepath'];

                    // Concatenate the new filename with existing outputfilepath
                    $newOutputFilePath = $existingOutputFilePath ? $existingOutputFilePath . ',' . $uniqueFilename : $uniqueFilename;

                    // Update the outputfilepath in the database
                    $updateSql = "UPDATE tasks SET outputfilepath = '$newOutputFilePath' WHERE id = '$taskid'";
                    if (mysqli_query($conn, $updateSql)) {
                        echo "File '$uniqueFilename' uploaded and updated in the database successfully.\n";
                    } else {
                        echo "Error updating filename '$uniqueFilename' into database: " . mysqli_error($conn) . "\n";
                    }
                } else {
                    echo "Task ID '$taskid' does not exist in the database.\n";
                }
            } else {
                echo "Error uploading file '$fileName'.\n";
            }
        }
    } else {
        echo "No files uploaded.\n";
    }
} else {
    echo "Invalid request method.\n";
}
?>
