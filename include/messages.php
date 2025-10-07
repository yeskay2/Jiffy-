<?php
include_once("config.php");

if(isset($_POST['send'])){
    $outgoing = mysqli_real_escape_string($conn, $_POST['outgoing']);
    $incoming = mysqli_real_escape_string($conn, $_POST['incoming']);
    $messages = mysqli_real_escape_string($conn, $_POST['typingField']);

    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date("d-m:Y h:i:A"); 

    $fileUploaded = false;

    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadFolder = "./../uploads/chat/"; 
        $filename = $_FILES['file']['name'];
        $targetPath = $uploadFolder . $filename;

        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $fileUploaded = true;
        }
    }

    if ($fileUploaded) {
        $saveMsgQuery = "INSERT INTO `messages` (outgoing, incoming, messages, file_path, date)
                        VALUES ('$outgoing', '$incoming', '$messages', '$targetPath', '$currentTime')";
    } else {
        $saveMsgQuery = "INSERT INTO `messages` (outgoing, incoming, messages, date)
                        VALUES ('$outgoing', '$incoming', '$messages', '$currentTime')";
    }

    $runSaveQuery = mysqli_query($conn, $saveMsgQuery);

    if(!$runSaveQuery) {
        echo "Query Failed";
    } else {
        if ($fileUploaded) {
            echo "Message sent and file uploaded successfully.";
        } else {
            echo "Message sent successfully.";
        }
    }
}
?>
