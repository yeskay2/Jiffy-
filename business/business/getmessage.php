<?php
session_start();
include "./../include/config.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$userid = $_SESSION["user_id"];

if (isset($_POST['id']) && isset($_POST['ring'])) {
    $notificationId = $_POST['id'];
    $newRingValue = $_POST['ring'];

    $updateStmt = $conn->prepare("UPDATE tasks SET ring = ? WHERE id = ? AND ring = 0");
    $updateStmt->bind_param("ii", $newRingValue, $notificationId);
    
    if ($updateStmt->execute()) {
        echo "Ring value updated successfully";
        exit;
    } else {
        echo "Error updating ring value: " . $updateStmt->error;
    }

    $updateStmt->close();
} elseif (isset($_POST['messageid']) && isset($_POST['ringid'])) {
    $messageId = $_POST['messageid'];
    $newRingValue = $_POST['ringid'];

    $updateStmt = $conn->prepare("UPDATE messages SET ring = ? WHERE messages_id = ? AND ring = 0");
    $updateStmt->bind_param("ii", $newRingValue, $messageId);

    if ($updateStmt->execute()) {
        echo "Ring value updated successfully";
        exit;
    } else {
        echo "Error updating ring value: " . $updateStmt->error;
    }

    $updateStmt->close();
}

$messages = array();
$messageCount = 0;

$query = "SELECT m.messages_id, m.ring, m.incoming, m.outgoing, m.messages, e.full_name, e.profile_picture 
          FROM messages m 
          JOIN employee e ON m.outgoing = e.id 
          WHERE m.incoming = ? AND m.message_status = 0";

$selectStmt = $conn->prepare($query);
$selectStmt->bind_param("i", $userid);
$selectStmt->execute();

$result = $selectStmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messageCount++;

        $uploaderProfilePicture = $row['profile_picture'];
        $name = $row['full_name'];
        $msg = $row['messages'];
        $messageId = $row['messages_id'];
        $ring = $row['ring'];

        $messages[] = array(
            'id' => $messageId,
            'name' => $name,
            'image' => $uploaderProfilePicture,
            'message' => $msg,
            'ring' => $ring,
            'tablename' => 'messages'     
        );
    }
}

$notifications = array();
$notificationCount = 0;

$sql = "SELECT t.*, e.profile_picture AS uploaderProfilePicture, e.full_name
        FROM teamrequried t
        JOIN employee e ON t.TeamLead = e.id
        WHERE (t.to = ? OR t.forward = ?) AND t.view = 0";

$selectTeamStmt = $conn->prepare($sql);
$selectTeamStmt->bind_param("ii", $userid, $userid);
$selectTeamStmt->execute();

$resultTeam = $selectTeamStmt->get_result();

if ($resultTeam && $resultTeam->num_rows > 0) {
    while ($row = $resultTeam->fetch_assoc()) {
        $uploaderProfilePicture = $row['uploaderProfilePicture'];
        $taskName = $row['Subject'];
        $messageId = $row['Id'];
        $name = $row['full_name'];
        $ring = $row['ring'];
        $type = $row['type'];
        $notificationCount++;
        
        if (empty($taskName)) {
            $taskName = $row['RequiredRole'];
        }
        if ($type != 'request') {
            $message = "<span class='text-primary' style='font-size:12px;'>$name sent $type request</span>";
        } else {
            $message = "<span class='text-primary' style='font-size:12px;'>$name sent $type</span>";
        }
       
        $messages[] = array(
            'id' => $messageId,
            'name' => $message,
            'image' => $uploaderProfilePicture,
            'message' => $taskName,
            'ring' => 1,
            'tablename' => 'teamrequried'               
        );
    }
}

$response = array(
    'count' => $messageCount + $notificationCount,
    'messages' => $messages
);

header('Content-Type: application/json');
echo json_encode($response);

$selectStmt->close();
$selectTeamStmt->close();
$conn->close();
?>
