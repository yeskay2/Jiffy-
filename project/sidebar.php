<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<?php if ($_SESSION["id"] == 1) { ?>
    <div class="iq-sidebar  sidebar-default ">
        <div class="iq-sidebar-logo d-flex align-items-center">
            <a href="dashboard.php" class="header-logo">
                <img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">
            </a>
            <div class="iq-menu-bt-sidebar ml-0">
                <i class="fas fa-angle-double-left wrapper-menu"></i>
            </div>
        </div>
        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li <?php if ($current_page == 'dashboard.php' || $current_page == 'projectdashboard.php') echo 'class="active"'; ?>>
                        <a href="dashboard.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1L1 9h22L12 1z"></path>
                                <path d="M5 22h14c1.1 0 2-.9 2-2V9H3v11c0 1.1.9 2 2 2z"></path>
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'project.php') echo 'class="active"'; ?>>
                        <a href="project.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                            <span class="ml-4">Projects</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'task.php' && !isset($_GET['condition'])) echo 'class="active"'; ?>>
                        <a href="task.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span class="ml-4">My Task</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'task.php' && isset($_GET['condition'])) echo 'class="active"'; ?>>
                        <a href="task.php?condition=1" class="svg-icon">
                            <i class="material-icons" style="font-size: 24px">group</i>
                            <span class="ml-4">Team Task</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'team.php') echo 'class="active"'; ?>>
                        <a href="team.php" class="svg-icon">
                            <i class='fas fa-users' style='font-size:24px'></i>
                            <span class="ml-4">Create Team</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'timeline.php') echo 'class="active"'; ?>>
                        <a href="timeline.php" class="svg-icon">
                            <i class="material-icons" style="font-size: 24px">timelapse</i>
                            <span class="ml-4">Meeting</span>
                        </a>
                    </li>
                    <!--<li <?php if ($current_page == 'bugtracking.php') echo 'class="active"'; ?>>
                        <a href="bugtracking.php" class="svg-icon">
                            <i class='fas fa-code-branch' style='font-size:23px'></i> 
                            <span class="ml-4">Bug Tracking</span>
                        </a>
                    </li>-->
                   <li <?php if ($current_page == 'employeetracking.php') echo 'class="active"'; ?>>
                        <a href="employeetracking.php" class="svg-icon">
                                <i class='fas fa-map' style='font-size:23px'></i> 
                            <span class="ml-4">Employee Tracker</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'request.php') echo 'class="active"'; ?>>
                        <a href="request.php" class="svg-icon">
                            <i class='fas fa-bug' style='font-size:23px'></i> 
                            <span class="ml-4">Issue Tracker</span>
                        </a>
                    </li>
                 <!----  <li <?php if ($current_page == 'issue.php') echo 'class="active"'; ?>>
                        <a href="issue.php" class="svg-icon">
                             <i class='fas fa-file-alt' style='font-size:23px'></i> 
                            <span class="ml-4">Issue Tracker</span>
                        </a>
                    </li>-->
                    <li <?php if ($current_page == 'leave.php') echo 'class="active"'; ?>>
                        <a href="leave.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4z"></path>
                                <line x1="7" y1="4" x2="17" y2="4"></line>
                                <line x1="7" y1="8" x2="17" y2="8"></line>
                                <line x1="7" y1="12" x2="13" y2="12"></line>
                                <line x1="7" y1="16" x2="17" y2="16"></line>
                            </svg>
                            <span class="ml-4">Manage Leave</span>
                        </a>
                    </li>
                    
                    <li <?php if ($current_page == 'timesheet.php') echo 'class="active"'; ?>>
                        <a href="timesheet.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                                <line x1="15" y1="3" x2="15" y2="21"></line>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="3" y1="15" x2="21" y2="15"></line>
                            </svg>
                            <span class="ml-4">Team Report</span>
                        </a>
                    </li> 
                     <li <?php if ($current_page == 'users.php') echo 'class="active"'; ?>>
                        <a href="users.php" class="svg-icon">
                            <i class='fas fa-comments' style='font-size:24px'></i>
                            <span class="ml-4">Chat</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'ticket.php') echo 'class="active"'; ?>>
                        <a href="ticket.php" class="svg-icon">
                            <i class='fas fa-broadcast-tower' style='font-size:23px'></i>
                            <span class="ml-4">Community</span>
                            <?php
                            $sql = "SELECT COUNT(*) AS count_of_non_nines
                            FROM community
                             WHERE FIND_IN_SET($userid, ring) = 0";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            $count_of_non_nines = $row['count_of_non_nines'];

                            if ($count_of_non_nines > 0) {
                            ?>
                            <span class="d-block bg-danger rounded-circle ml-2" style="width:10px; height:10px;"></span>
                             <?php
                         }
                         ?>

                        </a>
                    </li>
                    <!-- <li <?php if ($current_page == 'holiday.php') echo 'class="active"'; ?>>
                        <a href="holiday.php" class="svg-icon">
                            <i class='fas fa-calendar-alt' style='font-size:24px'></i>
                            <span class="ml-4">Hoildays</span>
                        </a>
                    </li> -->
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
                                http://localhost/mine_jiffy/project/employeetracking.php
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php } elseif ($_SESSION["id"] == 2) { ?>
    <div class="iq-sidebar  sidebar-default ">
        <div class="iq-sidebar-logo d-flex align-items-center">
            <a href="dashboard.php" class="header-logo">
                <img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">
            </a>
            <div class="iq-menu-bt-sidebar ml-0">
                <i class="fas fa-angle-double-left wrapper-menu"></i>
            </div>
        </div>
        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li <?php if ($current_page == 'dashboard.php' || $current_page == 'projectdashboard.php') echo 'class="active"'; ?>>
                        <a href="dashboard.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1L1 9h22L12 1z"></path>
                                <path d="M5 22h14c1.1 0 2-.9 2-2V9H3v11c0 1.1.9 2 2 2z"></path>
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'project.php') echo 'class="active"'; ?>>
                        <a href="project.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                            <span class="ml-4">Projects</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'task.php' && !isset($_GET['condition'])) echo 'class="active"'; ?>>
                        <a href="task.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span class="ml-4">My Task</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'task.php' && isset($_GET['condition'])) echo 'class="active"'; ?>>
                        <a href="task.php?condition=2" class="svg-icon">
                            <i class='fas fa-users' style='font-size:24px'></i>
                            <span class="ml-4">Team Task</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'request.php') echo 'class="active"'; ?>>
                        <a href="request.php" class="svg-icon">
                            <i class='fas fa-bug' style='font-size:23px'></i>
                            <span class="ml-4">Issue Tracker</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'leave.php') echo 'class="active"'; ?>>
                        <a href="leave.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4z"></path>
                                <line x1="7" y1="4" x2="17" y2="4"></line>
                                <line x1="7" y1="8" x2="17" y2="8"></line>
                                <line x1="7" y1="12" x2="13" y2="12"></line>
                                <line x1="7" y1="16" x2="17" y2="16"></line>
                            </svg>
                            <span class="ml-4">Manage Leave</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'timeline.php') echo 'class="active"'; ?>>
                        <a href="timeline.php" class="svg-icon">
                            <i class="material-icons" style="font-size: 24px">timelapse</i>
                            <span class="ml-4">Meeting</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'timesheet.php') echo 'class="active"'; ?>>
                        <a href="timesheet.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                                <line x1="15" y1="3" x2="15" y2="21"></line>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="3" y1="15" x2="21" y2="15"></line>
                            </svg>
                            <span class="ml-4">Team Report</span>
                        </a>
                    </li>                   

                    
                    <li <?php if ($current_page == 'users.php') echo 'class="active"'; ?>>
                        <a href="users.php" class="svg-icon">
                            <i class='fas fa-comments' style='font-size:24px'></i>
                            <span class="ml-4">Chat</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'ticket.php') echo 'class="active"'; ?>>
                        <a href="ticket.php" class="svg-icon">
                            <i class='fas fa-broadcast-tower' style='font-size:23px'></i>
                            <span class="ml-4">Community</span>
                            <?php
                            $sql = "SELECT COUNT(*) AS count_of_non_nines
                            FROM community
                            WHERE FIND_IN_SET($userid, ring) = 0";

                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            $count_of_non_nines = $row['count_of_non_nines'];

                            if ($count_of_non_nines > 0) {
                            ?>
                                <span class="d-block bg-danger rounded-circle ml-2" style="width:10px; height:10px;"></span>
                            <?php
                            }
                            ?>
                        </a>
                    </li>
                </ul>
            </nav>

            <div id="sidebar-bottom" class="position-relative text-center">
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
                                        <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                                                </div>
                                    <div data-toggle="" data-placement="bottom" title="Instagram">
                                        <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                                    </div>

                                    <div data-toggle="" data-placement="bottom" title="YouTube">
                                        <a href="https://www.youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
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
    </div>
<?php } else { ?>
    <div class="iq-sidebar  sidebar-default ">
        <div class="iq-sidebar-logo d-flex align-items-center">
            <a href="dashboard.php" class="header-logo">
                <img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">
            </a>
            <div class="iq-menu-bt-sidebar ml-0">
                <i class="fas fa-angle-double-left wrapper-menu"></i>
            </div>
        </div>
        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li <?php if ($current_page == 'dashboard.php' || $current_page == 'projectdashboard.php') echo 'class="active"'; ?>>
                        <a href="dashboard.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1L1 9h22L12 1z"></path>
                                <path d="M5 22h14c1.1 0 2-.9 2-2V9H3v11c0 1.1.9 2 2 2z"></path>
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'task.php' && !isset($_GET['condition'])) echo 'class="active"'; ?>>
                        <a href="task.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span class="ml-4">My Task</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'leave.php') echo 'class="active"'; ?>>
                        <a href="leave.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4z"></path>
                                <line x1="7" y1="4" x2="17" y2="4"></line>
                                <line x1="7" y1="8" x2="17" y2="8"></line>
                                <line x1="7" y1="12" x2="13" y2="12"></line>
                                <line x1="7" y1="16" x2="17" y2="16"></line>
                            </svg>
                            <span class="ml-4">Manage Leave</span>
                        </a>
                    </li>

                    <li <?php if ($current_page == 'timesheet.php') echo 'class="active"'; ?>>
                        <a href="timesheet.php" class="svg-icon">
                            <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                                <line x1="15" y1="3" x2="15" y2="21"></line>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="3" y1="15" x2="21" y2="15"></line>
                            </svg>
                            <span class="ml-4">Report</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'timeline.php') echo 'class="active"'; ?>>
                        <a href="timeline.php" class="svg-icon">
                            <i class="material-icons" style="font-size: 24px">timelapse</i>
                            <span class="ml-4">Meeting</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'request.php') echo 'class="active"'; ?>>
                        <a href="request.php" class="svg-icon">
                            <i class='fas fa-bug' style='font-size:23px'></i> <!-- Use fas fa-bug for Issue Tracker -->
                            <span class="ml-4">Issue Tracker</span>
                        </a>

                    </li>
                    <li <?php if ($current_page == 'users.php') echo 'class="active"'; ?>>
                        <a href="users.php" class="svg-icon">
                            <i class='fas fa-comments' style='font-size:24px'></i>
                            <span class="ml-4">Chat</span>
                        </a>
                    </li>
                    <li <?php if ($current_page == 'ticket.php') echo 'class="active"'; ?>>
                        <a href="ticket.php" class="svg-icon">
                            <i class='fas fa-broadcast-tower' style='font-size:23px'></i>
                            <span class="ml-4">Community</span>
                            <?php
                            $sql = "SELECT COUNT(*) AS count_of_non_nines
                                FROM community
                                WHERE FIND_IN_SET($userid, ring) = 0";

                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            $count_of_non_nines = $row['count_of_non_nines'];

                            if ($count_of_non_nines > 0) {                        ?>
                                <span class="d-block bg-danger rounded-circle ml-2" style="width:10px; height:10px;"></span>
                            <?php
                            }
                            ?>
                        </a>
                    </li>
                    <!-- <li <?php if ($current_page == 'holiday.php') echo 'class="active"'; ?>>
                        <a href="holiday.php" class="svg-icon">
                            <i class='fas fa-calendar-alt' style='font-size:24px'></i>
                            <span class="ml-4">Hoildays</span>
                        </a>
                    </li> -->
                   
                 </ul>
            </nav>
            <div id="sidebar-bottom" class="position-relative sidebar-bottom">
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
    </div>


<?php } ?>
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
</script>
<script>
    let inactivityTime = 0;
    const inactivityThreshold = 3600000;
    const redirectUrl = 'logout.php';

    function resetTimer() {
        inactivityTime = 0;
    }

    function redirectIfInactive() {
        if (inactivityTime >= inactivityThreshold) {
            window.location.href = redirectUrl;
        } else {
            inactivityTime += 1000;
        }
    }
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keydown', resetTimer);
    setInterval(redirectIfInactive, 1000);
</script>
<style>
    .iq-sidebar .iq-menu .active {
        color: #c72f2e;
        text-decoration: none;
        background-color: #EDEFF6;
        border-left: 4px solid #3d3399;
        transition: all 500ms ease;
        border-radius: 5px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    var userid = <?= json_encode($userid) ?>;

    function makeAjaxRequest() {
        $.ajax({
            type: "POST",
            url: "./../admin/logindate.php",
            data: {
                userid: userid
            },
            dataType: "json",
            success: function(data) {
                console.log("Received data:", data);
                if (data && data.status === "error") {
                    console.error("Error message:", data.message);
                    window.location.href = "logout.php";
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
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
function getUserLocationAndSend() {
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                const locationData = {
                    latitude: latitude,
                    longitude: longitude
                };

                fetch('locationupdate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(locationData)
                })
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw new Error('Failed to update location.');
                    }
                })
                .then(data => {
                    
                })
                .catch(error => {
                    console.error('Error updating location:', error);
                });
            },
            function(error) {
                console.log(`Error getting location: ${error.message}`);
            }
        );
    } else {
        console.log('Geolocation is not supported by this browser.');
    }
}

setInterval(getUserLocationAndSend, 5000);
</script>
<script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
</script>
<?php
$sql = 'SELECT id, status FROM employee WHERE id = ?';
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $status1 = $row['status'];
    
    if ($status1 == 'Offline') {
        mysqli_stmt_close($stmt);
        echo '<script>window.location.href = "index.php";</script>';
        exit;
    }
} else {
    echo '<script>window.location.href = "error.php";</script>';
    exit;
}
$sql = "SELECT * FROM employee WHERE id = '$userid' AND active = 'active' AND status != 'Offline' AND (FIND_IN_SET('Employee', Allpannel) OR FIND_IN_SET('All', Allpannel))";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) == 0) {        
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }
}
if(!isset($userid)){
     echo '<script>window.location.href = "index.php";</script>';
    exit();
}
?>


