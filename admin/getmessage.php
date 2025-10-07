<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];


if (isset($_POST['messageId'])) {
    $messageIdToUpdate = $_POST['messageId'];

    
    $updateQuery = "UPDATE messages SET message_status = 1 WHERE messages_id = $messageIdToUpdate";
    mysqli_query($conn, $updateQuery);

    exit; 
}

$query = "SELECT messages.messages_id, messages.incoming, messages.outgoing, messages.messages, employee.full_name, employee.profile_picture 
          FROM messages 
          JOIN employee ON messages.outgoing = employee.id 
          WHERE messages.incoming = $userid AND messages.message_status = 0";

$result = mysqli_query($conn, $query);

$messages = array();
$messageCount = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messageCount++;

        $uploaderProfilePicture = $row['profile_picture'];        
        $name  = $row['full_name'];
        $msg = $row['messages'];
        $messageId = $row['messages_id'];

        $messages[] = array(
            'id' => $messageId,
            'name' => $name,
            'image' => $uploaderProfilePicture,
            'message' => $msg,
        );
    } 

    // Output the messages
    $response = array(
        'count' => $messageCount, 
        'messages' => $messages
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
