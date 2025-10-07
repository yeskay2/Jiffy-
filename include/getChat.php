<?php
include_once("config.php");
session_start();
$outgoingid = $_SESSION['user_id'];
$incomingid = mysqli_real_escape_string($conn, $_POST['incomingid']);

function getFileIcon($extension, $row) {
    // Define a mapping of file extensions to FontAwesome icons
    $icons = [
        "doc" => "far fa-file-word",   
        "docx" => "far fa-file-word", 
        "pdf" => "far fa-file-pdf", 
        "jpg" => "far fa-file-image", 
        "jpeg" => "far fa-file-image", 
        "png" => "far fa-file-image", 
        "xls" => "far fa-file-excel",
        "xlsx" => "far fa-file-excel",
        "ppt" => "far fa-file-powerpoint",
        "pptx" => "far fa-file-powerpoint",
        "zip" => "far fa-file-archive",
        "rar" => "far fa-file-archive",
        "txt" => "far fa-file-alt",
        "csv" => "far fa-file-csv",
    ];

    if (array_key_exists($extension, $icons)) {
        return '<i class="' . $icons[$extension] . '"></i>';
    } else {
        return ''; 
    }
}

$getMsgQuery = "SELECT * FROM `messages` LEFT JOIN `employee` ON messages.outgoing = employee.id WHERE outgoing = '{$outgoingid}' AND incoming = '{$incomingid}' OR outgoing = '{$incomingid}' AND incoming = '{$outgoingid}'";
$runGetMsgQuery = mysqli_query($conn, $getMsgQuery);

if (!$runGetMsgQuery) {
    echo "Query Failed";
} else {
    if (mysqli_num_rows($runGetMsgQuery) > 0) {
        while ($row = mysqli_fetch_assoc($runGetMsgQuery)) {
            if ($row['outgoing'] == $outgoingid) {
                echo '<div class="responseCard outgoing">
                <div class="response">
                    <!-- name -->
                    <h3 class="name">You</h3>';

                $fileExtension = pathinfo($row["messages"], PATHINFO_EXTENSION);

                if ($fileExtension) {
                    $fileIcon = getFileIcon(strtolower($fileExtension), $row);

                    echo '<div class="file-details">
                        <p class="file-name">' . $row["messages"] . '</p>
                        <p class="file-time">' . date("H:i", strtotime($row["date"])) . '</p>
                        <a href="./../uploads/chat/' . $row["messages"] . '" download>' . $fileIcon . '</a>
                        <a href="https://api.whatsapp.com/send?text=Check%20out%20this%20file:%20' . rawurlencode($row["messages"]) . '">Share via WhatsApp</a>
                    </div>';
                } else {
                    echo '<p class="messages">' . $row["messages"] . '</p>';
                   echo '<p class="file-time">' . $row["date"] . '</p>';

                }

                echo '</div>
            </div>';
            } else {
                echo '<div class="request incoming" style="width:29%; >
                 <div class="response" style="width:100%;">
                <!-- name -->
                <h3 class="name">' . $row["full_name"] . '</h3>';

                $fileExtension = pathinfo($row["messages"], PATHINFO_EXTENSION);

                if ($fileExtension) {
                    $fileIcon = getFileIcon(strtolower($fileExtension), $row);

                    echo '<div class="file-details">
                        <p class="file-name">' . $row["messages"] . '</p>
                        <p class="file-time">' . date("H:i", strtotime($row["date"])) . '</p>
                        <a href="./../uploads/chat/' . $row["messages"] . '" download>' . $fileIcon . '</a>
                        <a href="https://api.whatsapp.com/send?text=Check%20out%20this%20file:%20' . rawurlencode($row["messages"]) . '">Share via WhatsApp</a>
                    </div>';
                } else {
                    echo '<p class="messages">' . $row["messages"] . '</p>';
                   echo '<p class="file-time">' . $row["date"]. '</p>';
                }

                echo '</div>
                </div>';
            }
        }
    } else {
        echo '<div id="errors">No messages are available</div>';
    }
}
?>
