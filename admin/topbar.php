<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>
                <a href="dashboard.php" class="header-logo">
                    <img src="./../assets/images/Jiffy-logo.png" alt="logo">
                </a>
            </div>
            <div class="navbar-breadcrumb">
                <h5>Dashboard</h5>
            </div>
            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item nav-icon search-content">
                            <a href="#" class="search-toggle rounded" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-search-line"></i>
                            </a>
                           <div class="iq-search-bar iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownSearch">
                            <form action="#" class="searchbox p-2">
                                <div class="form-group mb-0 position-relative">
                                    <a class="search-link" href="#" id="taskSearchButton"><i class="ri-search-line"></i></a>
                                    <input type="text" class="text search-input" placeholder="Search here..." id="taskSearchInput">
                                </div>
                            </form>
                        </div>

                        </li>

                        <li class="nav-item nav-icon nav-item-icon dropdown">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                                <span class="bg-primary badge-icon" id="notificationCount"></span>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="card shadow-none m-0">
                                    <div class="card-body p-0 ">
                                        <div class="cust-title p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0" style="color:white;">Notifications</h5>
                                                <a class="badge badge-secondary badge-card" href="#"></a>
                                            </div>
                                        </div>
                                        <div class="px-3 pt-0 pb-0 sub-card" style="max-height: 250px; overflow-y: auto;">
                                            <div id="notifications">
                                            </div>
                                            <a class="right-ic btn btn-block position-relative p-2" href="task.php" role="button">
                                                View Task
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-icon nav-item-icon dropdown">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <span class="bg-primary badge-icon" id="messageCount">0</span>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <div class="card shadow-none m-0">
                                    <div class="card-body p-0 ">
                                        <div class="cust-title p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0" style="color:white;">All Messages</h5>
                                                
                                            </div>
                                        </div>
                                        <div class="px-3 pt-0 pb-0 sub-card">
                                        <div id="msg">
                                           
                                        </div>
                                        <a class="right-ic btn btn-block position-relative p-2" href="users.php" role="button">
                                                View Message
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <?php
                        $sql = "SELECT * FROM employee WHERE id = $userid";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $userName = $row["full_name"];
                                $profile = $row["profile_picture"];
                                $greeting = "Hello, " . $userName . "&nbsp;";

                        ?>
                                <li class="nav-item nav-icon dropdown caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle d-flex align-items-center" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="./../uploads/employee/<?php echo $profile; ?>" class="img-fluid rounded-circle" alt="user">
                                        <div class="caption ml-3">
                                            <h6 class="mb-0 line-height"><?php echo $greeting; ?><i class="far fa-grin-hearts"></i></h6>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right border-none" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-item d-flex svg-icon">
                                            <svg class="svg-icon mr-0 text-primary" id="h-01-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <a href="profile.php?session_id=<?php echo $userid; ?>">My Profile</a>
                                        </li>


                                        <li class="dropdown-item  d-flex svg-icon border-top">
                                            <svg class="svg-icon mr-0 text-primary" id="h-05-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <a href="logout.php">Logout</a>
                                        </li>
                                    </ul>
                                </li>


                </div>
                </li>
                </ul>

        <?php
                            }
                        }
        ?>

        </ul>
            </div>
    </div>
    </nav>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchNotifications() {
            $.ajax({
                url: 'get_task_details.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#notifications').empty();

                    for (var i = 0; i < data.notifications.length; i++) {
                        var notification = data.notifications[i];
                        var imagePath = '.././uploads/employee/';
                        var notificationHtml =
                            '<div class="media align-items-center cust-card py-3">' +
                            '<div class="">' +
                            '<img class="avatar rounded-small" src="' + imagePath + notification.image + '" alt="03" width="10%">' +
                            '</div>' +
                            '<div class="media-body ml-3">' +
                            '<div class="d-flex align-items-center justify-content-between">' +
                            '<h6 class="mb-0" style="font-size:14px;">' + notification.message + '</h6>' +
                            '<small class="text-dark" style="font-size:10px;"><b>' + notification.date + '</b></small>' +
                            '</div>' +
                            '<small class="mb-0"style="color:#3d3399;">' + notification.taskName + '</small>' +
                            '</div>' +
                            '</div>';
                        $('#notifications').append(notificationHtml);
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

        fetchNotifications();
        setInterval(fetchNotifications, 5000);
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            function fetchMessages() {
                $.ajax({
                    url: 'getmessage.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#msg').empty();

                        for (var i = 0; i < data.messages.length; i++) {
                            var message = data.messages[i];
                            var imagePath = '.././uploads/employee/';
                            var messageHtml =
                                '<div class="media align-items-center cust-card py-3">' +
                                '<div class="">' +
                                '<img class="avatar rounded-small" src="' + imagePath + message.image + '" alt="03" width="10%">' +
                                '</div>' +
                                '<div class="media-body ml-3">' +
                                '<div class="d-flex align-items-center justify-content-between">' +
                                '<h6 class="mb-0"style="color:#3d3399;">' + message.name + '</h6>' +
                                '</div>' +
                                '<small class="mb-0" style="font-size:14px;">' + message.message + '</small>' +
                                '</div>' +
                                '</div>';
                            $('#msg').append(messageHtml);

                            
                            setTimeout(function() {
                                updateMessageStatus(message.id);
                            }, 300000);
                        }

                        if (data.count > 9) {
                            $('#messageCount').text('9+');
                        } else {
                            $('#messageCount').text(data.count);
                        }
                    },
                    error: function(xhr, status, error) {
                      
                    }
                });
            }

            function updateMessageStatus(messageId) {
                $.ajax({
                    url: 'getmessage.php', 
                    method: 'POST',
                    data: { messageId: messageId },
                    success: function(data) {
                       
                    },
                    error: function(xhr, status, error) {
                       
                    }
                });
            }

            fetchMessages();
            setInterval(fetchMessages, 5000);
        });
    </script>
    <script>
     
$(document).ready(function () {
    if ($(window).width() >= 768) {
        $(".iq-search-bar").removeClass("iq-sub-dropdown dropdown-menu");
    } else {
        $(".iq-search-bar").addClass("iq-sub-dropdown dropdown-menu");
    }
});


$(window).resize(function () {
    if ($(window).width() >= 768) {
        $(".iq-search-bar").removeClass("iq-sub-dropdown dropdown-menu");
    } else {
        $(".iq-search-bar").addClass("iq-sub-dropdown dropdown-menu");
    }
});

    </script>
