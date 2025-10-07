<?php
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle updating reactions
    $commentId = $_POST['commentId'];
    $reactionType = $_POST['reactionType'];
    $employeeId = $_POST['employeeId'];

    $checkSql = "SELECT id FROM community WHERE id = ? AND FIND_IN_SET(?, employeeid) > 0 AND Company_id = '$companyId'";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "is", $commentId, $employeeId);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        echo json_encode(['success' => false, 'message' => 'Employee has already liked the comment']);
    } else {
        $updateColumn = ($reactionType === 'like') ? 'likes' : 'emojis';
        $updateSql = "UPDATE community SET $updateColumn = $updateColumn + 1, employeeid = CONCAT(employeeid, ', ', ?) WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "si", $employeeId, $commentId);
        $updateResult = mysqli_stmt_execute($updateStmt);

        if ($updateResult) {
            echo json_encode(['success' => true, 'message' => 'Reaction updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update reaction']);
        }

        mysqli_stmt_close($updateStmt);
    }
} else {
    $sql = "SELECT community.id, community.user_id, community.date, community.employeeid, community.text, 
            employee.id AS user_id, 
            employee.full_name, employee.profile_picture, community.likes, community.emojis 
            FROM community JOIN employee ON employee.id = community.user_id
            AND community.Company_id = '$companyId'";
    $result = mysqli_query($conn, $sql);

    $community = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $community[] = [
            'id' => $row['id'],
            'author' => $row['full_name'],
            'text' => $row['text'],
            'avatar' => $row['profile_picture'],
            'likes' => $row['likes'],
            'emojis' => $row['emojis'],
            'employeeid' =>  $row['employeeid'],
            'user_id' => $row['user_id']  
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($community);
}
?>
