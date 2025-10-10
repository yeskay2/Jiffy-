<!-- Line Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
<style>
ul.submenu {
    display: none; /* Hide submenu by default */
    list-style-type: none; /* Remove bullets */
    padding-left: 20px; /* Indent submenu items */
}

li.active > ul.submenu {
    display: block; /* Show submenu when the parent item is active */
}

li > a {
    display: flex;
    align-items: center;
}

li > a .svg-icon {
    margin-right: 10px; /* Adjust spacing between icon and text */
}

</style>
<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<div class="iq-sidebar  sidebar-default " sidebar-default>
    <div class="iq-sidebar-logo d-flex align-items-center">
        <a href="dashboard.php" class="header-logo">
            <img src="./../assets/images/gem.png" alt="logo" style="height: 60px; width: 100px;">
        </a>
        <div class="iq-menu-bt-sidebar ml-0">
            <i class="fas fa-angle-double-left wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li <?php if ($current_page == 'dashboard.php') echo 'class="active"'; ?>>
                    <a href="dashboard.php" class="svg-icon">
                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 1L1 9h22L12 1z"></path>
                            <path d="M5 22h14c1.1 0 2-.9 2-2V9H3v11c0 1.1.9 2 2 2z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'recruitment.php') echo 'class="active"'; ?>>
                    <a href="recruitment.php" class="svg-icon">
                        <span class="material-icons" style="font-size: 26px;">
                            groups
                        </span>
                        <span class="ml-3">Recruitment</span>
                    </a>
                </li> 
                 <li <?php if ($current_page == 'task.php' && !isset($_GET['condition'])) echo 'class="active"'; ?>>
                        <a href="task.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span class="ml-3">My Task</span>
                        </a>
                    </li>
                <li <?php if ($current_page == 'employees.php') echo 'class="active"'; ?>>
                    <a href="employees.php" class="svg-icon">
                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ml-3">Employees</span>
                    </a>
                </li>
                 <li <?php if ($current_page == 'salary.php') echo 'class="active"'; ?>>
                    <a href="salary.php" class="svg-icon">
                        <i class="far fa-list-alt" style="font-size: 26px;"></i>
                        <span class="ml-3">Salary List</span>
                    </a>
                </li>

               <li class="parent-item <?php if (in_array($current_page, ['schedules.php', 'addhoildays.php', 'department.php', 'role.php', 'company_info.php'])) echo 'active'; ?>">
                    <a href="#companyDetailsMenu" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class='fas fa-envelope-open-text' style='font-size:24px'></i>
                        <span class="ml-3 mr-2">Company Details</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="companyDetailsMenu" class="iq-submenu collapse <?php if (in_array($current_page, ['schedules.php', 'addhoildays.php', 'department.php', 'role.php', 'company_info.php'])) echo 'show'; ?>" data-parent="#iq-sidebar-toggle">
                        <li <?php if ($current_page == 'addhoildays.php') echo 'class="active"'; ?>>
                            <a href="addhoildays.php">
                                <i class='fas fa-calendar-alt' style='font-size:24px'></i>
                                <span class="ml-3">Leave Policy</span>
                            </a>
                        </li>
                        <li <?php if ($current_page == 'department.php') echo 'class="active"'; ?>>
                            <a href="department.php" >
                                <i class="fa fa-users" style='font-size:24px'></i>
                                <span class="ml-3">Department</span>
                            </a>
                        </li>
                        <li <?php if ($current_page == 'role.php') echo 'class="active"'; ?>>
                            <a href="role.php">
                                <span class="material-icons" style="font-size: 26px;">sensor_occupied</span>
                                <span class="ml-3">Role</span>
                            </a>
                        </li>
                        <li <?php if ($current_page == 'schedules.php') echo 'class="active"'; ?>>
                            <a href="schedules.php">
                                <i class='fas fa-info-circle' style='font-size:24px'></i>
                                <span class="ml-3">Company Info</span>
                            </a>
                        </li>
                    </ul>
                </li>

            
                 <li <?php if ($current_page == 'request.php') echo 'class="active"'; ?>>
                    <a href="request.php" class="svg-icon">
                        <i class='fas fa-bug' style='font-size:24px'></i>
                        <span class="ml-3">Issue Tracking</span>
                    </a>
                </li>


              

                <li <?php if ($current_page == 'attendence.php') echo 'class="active"'; ?>>
                    <a href="attendence.php" class="svg-icon">
                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="8"></circle>
                            <path d="M12 6v6l4 2"></path>
                        </svg>
                        <span class="ml-3">Attendance</span>
                    </a>
                </li>              
                

                <li <?php if ($current_page == 'announcement.php') echo 'class="active"'; ?>>
                    <a href="announcement.php" class="svg-icon">
                        <span class="material-icons" style="font-size: 25px; font-weight: bold;">volume_up</span>
                        <span class="ml-3">Announcements</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'events.php') echo 'class="active"'; ?>>
                    <a href="events.php" class="svg-icon">
                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="ml-3">Events</span>
                    </a>
                </li>            

                <li <?php if ($current_page == 'monthlyreport.php') echo 'class="active"'; ?>>
                    <a href="monthlyreport.php" class="svg-icon">
                        <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="3" x2="9" y2="21"></line>
                            <line x1="15" y1="3" x2="15" y2="21"></line>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="3" y1="15" x2="21" y2="15"></line>
                        </svg>
                        <span class="ml-3">Monthly Report</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'users.php') echo 'class="active"'; ?>>
                    <a href="users.php" class="svg-icon">
                        <i class='fas fa-comments' style='font-size:24px'></i>
                        <span class="ml-3">Chat</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'live.php') echo 'class="active"'; ?>>
                    <a href="live.php" class="svg-icon">
                        <i class="fas fa-map-marker-alt" style='font-size:24px'></i>
                        <span class="ml-3">Live</span>
                    </a>
                </li>
                <!-- <li class=" ">
                <a href="q&a.php" class="svg-icon">
                    <i class="fas fa-question" style='font-size:24px'></i>
                    <span class="ml-3">Question</span>
                </a>
            </li>-->
                        
            </ul>
        </nav>
        <div id="sidebar-bottom" class="position-relative text-center" style="padding-bottom: 50% !important; ">
            <div class="card border-none mb-0 shadow-none">
                <div class="card-body p-0">
                    <div class="sidebarbottom-content">

                        <div class="back-face">
                            <div>
                                <p>&nbsp;<span id="typewriter" style="color:#3d3399; font-weight:bold;">
                                        Let's Connect Through ...</span>
                                </p>
                            </div>
                            <ul style="margin-bottom: -10px;">
                                <div data-toggle="" data-placement="bottom" title="Teams">
                                    <a href="https://teams.live.com/l/invite/FEAaynm6-v4owfj-xo"><i class="fab fa-microsoft"></i></a>
                                </div>
                                <div data-toggle="" data-placement="bottom" title="Twitter">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </div>
                                <div data-toggle="" data-placement="bottom" title="Instagram">
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                                <div data-toggle="" data-placement="bottom" title="Youtube">
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </div>
                                <div data-toggle="" data-placement="right" title="">
                                    <a href="https://chat.whatsapp.com/ER00JIEmQ5zIYZe8083xg6"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    var userid = <?= json_encode($userid) ?>;

    function makeAjaxRequest() {
        $.ajax({
            type: "POST",
            url: "logindate.php",
            data: {
                userid: userid
            },
            dataType: "json",
            success: function(data) {
                console.log("Received data:", data);
                if (data && data.status === "error") {
                  
                    window.location.href = "logout.php";
                }
            },
            error: function(xhr, status, error) {
                
            }
        });
    }

    $(document).ready(function() {
        makeAjaxRequest();

        setInterval(function() {
            makeAjaxRequest();
        }, 5000);
    });
</script>

<script>
    const text = "Let's Connect Through ...";
    const typewriterElement = document.getElementById("typewriter");
    let i = 0;

    function typeWriter() {
        typewriterElement.innerHTML = text.slice(0, i);
        i = (i + 1) % (text.length + 1);
        setTimeout(typeWriter, 100);
    }

    typeWriter();
    document.addEventListener('DOMContentLoaded', function() {
    var toggles = document.querySelectorAll('.toggle-submenu');
    
    toggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            var parent = toggle.parentElement;
            var submenu = parent.querySelector('.submenu');
            
            if (submenu.style.display === 'block' || submenu.style.display === '') {
                submenu.style.display = 'none';
            } else {
                submenu.style.display = 'block';
            }
        });
    });
});
</script>
