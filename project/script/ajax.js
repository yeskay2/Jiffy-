(function($) {
    var notificationSound = new Audio('./script/msg.mp3');
    var messageSound = new Audio('./script/msg.mp3');

    function playNotificationSound() {
        notificationSound.play();
        setTimeout(function() {
            notificationSound.pause();
            notificationSound.currentTime = 0;
        }, 5000);
    }

    function playMessageSound() {
        messageSound.play();
        setTimeout(function() {
            messageSound.pause();
            messageSound.currentTime = 0;
        }, 5000);
    }

    function fetchNotifications() {
        $.ajax({
            url: 'get_task_details.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#notifications').empty();
                var notificationsToRing = [];
                for (var i = 0; i < data.notifications.length; i++) {
                    var notification = data.notifications[i];
                    var ring = notification.ring;
                    var imagePath = '.././uploads/employee/';
                    var notificationHtml =
                        '<a href="viewtask.php?taskid=' + notification.taskId + '">' +
                        '<div class="media align-items-center cust-card py-3">' +
                        '<div class="">' +
                        '<img class="avatar rounded-small" src="' + imagePath + notification.image + '" alt="03" width="10%">' +
                        '</div>' +
                        '<div class="media-body ml-3">' +
                        '<div class="d-flex align-items-center justify-content-between">' +
                        '<h6 class="mb-0" style="font-size:14px;">' + notification.uploader + '</h6>' +
                        '<small class="text-dark" style="font-size:10px;"><b>' + notification.date + '</b></small>' +
                        '</div>' +
                        '<small class="mb-0" style="color:#3d3399;">' + notification.taskName + '</small>' +
                        '<h6 class="mb-0" style="font-size:14px;"><i class="lni-phone contact-icon"></i>' + notification.message + '</h6>' +
                        '</div>' +
                        '</div>' +
                        '</a>';

                    $('#notifications').append(notificationHtml);
                    if (ring == 0) {
                        notificationsToRing.push(notification.taskId);
                    }
                }
                if (notificationsToRing.length > 0) {
                    playNotificationSound();
                    setTimeout(function() {
                        for (var j = 0; j < notificationsToRing.length; j++) {
                            updateRingAfter5Seconds(notificationsToRing[j]);
                        }
                    }, 200);
                }
                if (data.count > 9) {
                    $('#notificationCount').text('9+');
                } else {
                    $('#notificationCount').text(data.count);
                }
            },
            error: function(xhr, status, error) {
               
            }
        });
    }

    function updateRingAfter5Seconds(taskId) {
        $.ajax({
            url: 'getmessage.php',
            method: 'POST',
            data: { id: taskId, ring: 1 },
            success: function(response) {
                
            },
            error: function(xhr, status, error) {
               
            }
        });
    }

    function setupNotificationInterval() {
        setInterval(fetchNotifications, 200);
    }

    $(function() {
        fetchNotifications();
        setupNotificationInterval();
    });
})(jQuery);

$(document).ready(function () {
    var ringtone = new Audio('./script/msg.mp3');

    function fetchMessages() {
        $.ajax({
            url: 'getmessage.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.count > 9) {
                    $('#messageCount').text('9+');
                } else {
                    $('#messageCount').text(data.count);
                }
                $('#msg').empty();
                var messagesToRing = [];
                for (var i = 0; data.messages && i < data.messages.length; i++) {
                    var message = data.messages[i];
                    var tablename = message.tablename;
                    var imagePath = '.././uploads/employee/';
                    var messageHtml =
                        '<div class="media align-items-center cust-card py-3">' +
                        '<div class="">' +
                        '<img class="avatar rounded-small" src="' + imagePath + message.image + '" alt="03" width="10%">' +
                        '</div>' +
                        '<div class="media-body ml-3" style="word-break: break-all;">' +
                        '<div class="d-flex align-items-center justify-content-between">' +
                        '<h6 class="mb-0"style="color:#3d3399;">' + message.name + '</h6>' +
                        '</div>' +
                        '<small class="mb-0" style="font-size:14px;">' + message.message + '</small>' +
                        '</div>' +
                        '</div>';
                    $('#msg').append(messageHtml);
                    if (message.ring == 0) {
                        messagesToRing.push(message.id);
                    }
                    setTimeout(function () {
                        updateMessageRingAfter5Seconds(message.id, tablename);
                    }, 200);
                }
                if (messagesToRing.length > 0) {
                    playMessageSound();
                    setTimeout(function () {
                        stopMessageSound();
                        for (var j = 0; j < messagesToRing.length; j++) {
                            updateMessageRingAfter5Seconds(messagesToRing[j], tablename);
                        }
                    }, 200);
                }
            },
            error: function (xhr, status, error) {
              
            }
        });
    }

    function updateMessageRingAfter5Seconds(messageId, tablename) {
        $.ajax({
            url: 'getmessage.php',
            method: 'POST',
            data: {
                messageid: messageId,
                ringid: 1,
                name: tablename,
            },
            success: function (response) {
              
            },
            error: function (xhr, status, error) {
               
            }
        });
    }

    function playMessageSound() {
        ringtone.play();
    }

    function stopMessageSound() {
        setTimeout(function () {
            ringtone.pause();
            ringtone.currentTime = 0;
        }, 200);
    }

    function setupMessageInterval() {
        setInterval(fetchMessages, 200);
    }

    fetchMessages();
    setupMessageInterval();
});
