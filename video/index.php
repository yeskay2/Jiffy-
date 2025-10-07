<?php
include "./../include/config.php";

if (isset($_GET['session_id'])) {
    $session_id = $_GET['session_id'];
} else {
    $session_id = 0;
}

// Set a default value for $userName
$userName = "user";

if ($session_id == 0) {
    $userName = "user";
} else {
    // Try to fetch the username from the database when $session_id is not 0
    $sql = "SELECT * FROM employee WHERE id = $session_id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userName = str_replace(" ", "", $row["full_name"]);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jiffy Sync | Jiffy</title>
    <link rel="stylesheet" href="style.css"/> 
</head>
<body>

    <div id="root"></div>
    <form id="delete-form" action="#" method="POST">
        <input type="hidden" name="name" value="<?php echo  $session_id ?>" />
    </form>
</body>

<!-- Script -->

<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>

<script>
    window.onload = function () {
        function getUrlParams(url) {
            let urlStr = url.split('?')[1];
            const urlSearchParams = new URLSearchParams(urlStr);
            const result = Object.fromEntries(urlSearchParams.entries());
            return result;
        }

        const roomID = getUrlParams(window.location.href)['roomID'] || (Math.floor(Math.random() * 10000) + "");
        const userID = "<?php echo $userName ?>";
        const userName = userID;
        const appID = 2124171023;
        const serverSecret = "04c856c4b223b9447717d9ae8241c43a";
        const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);

        const zp = ZegoUIKitPrebuilt.create(kitToken);
        zp.joinRoom({
            container: document.querySelector("#root"),
            sharedLinks: [{
                name: 'Invite link',
                url: window.location.protocol + '//' + window.location.host  + window.location.pathname + '?roomID=' + roomID,
            }],
            scenario: {
                mode: ZegoUIKitPrebuilt.VideoConference,
            },
            turnOnMicrophoneWhenJoining: true,
            turnOnCameraWhenJoining: true,
            showMyCameraToggleButton: true,
            showMyMicrophoneToggleButton: true,
            showAudioVideoSettingsButton: true,
            showScreenSharingButton: true,
            showTextChat: true,
            showUserList: true,
            maxUsers: 50,
            layout: "Auto",
            showLayoutButton: true,
        });

       
        const customLeaveButton = document.getElementById("QeMJj1LEulq1ApqLHxuM");
        customLeaveButton.addEventListener("click", function () {
            window.location.href = 'new-page.html';
            zp.leaveRoom();
        });
    }
</script>

</html>
