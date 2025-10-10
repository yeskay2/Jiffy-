<style>
.search-suggestions {
    position: absolute;
    top: 100%; 
    left: 0;
    width: 100%;
    max-height: 200px;
    overflow-y: auto; 
    background-color: #fff;
    border: 1px solid #ccc;
    border-top: none;
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.suggestion-item {
    padding: 8px 12px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.suggestion-item:hover {
    background-color: #f0f0f0;
}

.suggestion-item:first-child {
    border-top: 1px solid #ccc;
}

.suggestion-item:last-child {
    border-bottom: 1px solid #ccc;
}
@media (max-width: 768px) {
    .search-suggestions {
        max-height: 150px;
    }
}

@media (max-width: 576px) {
    .search-suggestions {
        max-height: 120px;
    }
}
</style>

<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>
                <a href="dashboard.php" class="header-logo">
                    <img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">
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
                    <ul class="navbar-nav ml-auto navbar-list align-items-center" id="navspace">
                        <!-- <li class="nav-item nav-icon search-content">
                        
                           <div class="iq-search-bar" aria-labelledby="dropdownSearch">
                            <form action="#" class="searchbox p-2">
                            <div class="form-group mb-0 position-relative">
                                <a class="search-link" href="#" id="taskSearchButton"><i class="ri-search-line"></i></a>
                                <input type="text" class="text search-input" placeholder="Search here..." id="taskSearchInput">
                                <div id="searchSuggestions" class="search-suggestions"></div>
                            </div>
                        </form>
                        </div>
                        </li> -->

                        <li class="nav-item nav-icon nav-item-icon dropdown">
                            <style>
                                /* Ensure both badges are hidden when there are no messages/notifications */
#messageCount, #notificationCount {
    display: none;
}

/* This class will be added when there are unread items */
.badge-icon {
    display: inline-block; /* Make it visible */
    background-color: #primary-color; /* Your badge background color */
    border-radius: 50%; /* For round badges */
    padding: 5px; /* Adjust padding to fit the badge */
    color: white; /* Text color */
}

                            </style>
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                                <span class="bg-primary badge-icon" id="notificationCount"></span>
                            </a>
                        <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <div class="card shadow-none m-0">
                                <div class="card-body p-0">
                                    <div class="cust-title p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0 text-white">Notifications</h5>
                                            <a class="badge badge-secondary badge-card" href="#"></a>
                                        </div>
                                    </div>
                                    <div class="px-3 pt-0 pb-0 sub-card" style="max-height: 250px; overflow-y: auto;">
                                        <div id="notifications">
                                            <!-- Your notification content goes here -->
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
                            <style>
                                /* Ensure the badge is hidden when there are no messages */
#messageCount {
    display: none;
}

/* This class will be added when there are unread messages */
.badge-icon {
    display: inline-block; /* Make it visible */
    background-color: #primary-color; /* Your badge color */
    border-radius: 50%; /* If you want it round */
    padding: 5px; /* Adjust padding to fit the badge */
    color: white; /* Text color */
}

                            </style>
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
                                    <div class="card-body p-0">
                                        <div class="cust-title p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0 text-white">All Messages</h5>
                                            </div>
                                        </div>
                                        <div class="px-3 pt-0 pb-0 sub-card" style="max-height: 200px; overflow-y: auto;">
                                            <div id="msg">
                                                <!-- Your content goes here -->
                                            </div>
                                            <a class="right-ic btn btn-block position-relative p-2" href="users.php" role="button">
                                                View Message
                                            </a>
                                        </div>
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
                                            <a href="profile.php">My Profile</a>
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
<script  src="./script/ajax.js"></script>
<script>   
  // Initialize notification and message counts to 0 (no unread items)
let messageCount = 0; 
let notificationCount = 0; 

// General function to update the count display for notifications/messages
function updateBadgeCount(elementId, count) {
    const badgeElement = document.getElementById(elementId);
    
    if (count > 0) {
        badgeElement.textContent = count;
        badgeElement.classList.add('badge-icon'); // Add class to show the badge
    } else {
        badgeElement.classList.remove('badge-icon'); // Remove class to hide the badge
        badgeElement.textContent = ''; // Clear the text content
    }
}

// Example: Set initial message and notification counts (replace with real logic)
messageCount = 5; // Replace this with the actual number of unread messages
notificationCount = 2; // Replace this with the actual number of unread notifications
updateBadgeCount('messageCount', messageCount);
updateBadgeCount('notificationCount', notificationCount);

// Event listener for viewing notifications (reset count when viewed)
document.getElementById('dropdownMenuButton2').addEventListener('click', function() {
    messageCount = 0;
    updateBadgeCount('messageCount', messageCount);
});

// Event listener for viewing messages (reset count when viewed)
document.getElementById('dropdownMenuButton').addEventListener('click', function() {
    notificationCount = 0;
    updateBadgeCount('notificationCount', notificationCount);
});


</script>

<script>
// Initialize message count to 0 (no messages)
let messageCount = 0; 

// Function to update the message count display
function updateMessageCount(count) {
    const messageCountElement = document.getElementById('messageCount');
    
    if (count > 0) {
        messageCountElement.textContent = count;
        messageCountElement.classList.add('badge-icon'); // Add class to make it visible
    } else {
        messageCountElement.classList.remove('badge-icon'); // Remove class to hide it
        messageCountElement.textContent = ''; // Clear the text content
    }
}

// Example: Update the message count (replace this with your logic)
messageCount = 5; // Replace with actual number of unread messages
updateMessageCount(messageCount);

// Add event listener to reset the message count when the dropdown is viewed
document.getElementById('dropdownMenuButton2').addEventListener('click', function() {
    messageCount = 0;
    updateMessageCount(messageCount);
});


</script>