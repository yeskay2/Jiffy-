
 <style>
        #popup {
            width: 300px;
            margin: 0 auto;
            display: none;
            text-align: center;
            z-index: 999;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
    </style>

            <form action="./../include/callaction.php" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <div class="card" id="popup">
                    <div class="card-body">
                        <h5 class="card-title">Incoming Call</h5>
                        <p class="card-text" id="popupContent">Caller Name</p>
                        <input class="btn btn-success" id="confirmButton" type="submit" value="Answer" name="ans">
                        <input class="btn btn-danger" id="cancelButton" type="submit" value="Decline" name="ans">
                    </div>
                </div>
            </form>
            <audio id="incomingCallAudio">
                <source src="./../project/script/ring.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                var popupTimer; // Declare a variable to store the timer reference
                var audio = document.getElementById("incomingCallAudio"); // Get the audio element

                function playIncomingCallAudio() {
                    audio.play();
                }

                function closePopup() {
                    document.getElementById('popup').style.display = 'none';
                    clearInterval(popupTimer); // Clear the timer when closing the popup
                    audio.pause(); // Pause the audio
                    audio.currentTime = 0; // Reset audio to the beginning
                }

                function fetchDataAndShowPopup() {
                    fetch(`./../project/call.php?userid=<?php echo $userid ?>`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then(data => {
                            const popupContent = `Incoming Call: ${data.callerName}`;
                            document.getElementById('popupContent').textContent = popupContent;
                            document.getElementById('popup').style.display = 'block';
                            playIncomingCallAudio();

                            popupTimer = setTimeout(closePopup, 30000);
                        })
                        .catch(error => {
                            console.error("Error fetching data:", error);
                        });
                }

                document.getElementById('confirmButton').addEventListener('click', function() {
                    window.location.href = "./../video/index.php?roomID=9475&session_id=<?php echo $userid ?>";
                });

                fetchDataAndShowPopup();
                setInterval(fetchDataAndShowPopup, 3000);
            });
        </script>