<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center">
        <a href="dashboard.php" class="header-logo">
            <img src="./../assets/images/Jiffy-logo.png" alt="logo">
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
                        <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 1L1 9h22L12 1z"></path>
                            <path d="M5 22h14c1.1 0 2-.9 2-2V9H3v11c0 1.1.9 2 2 2z"></path>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>           

                <li <?php if ($current_page == 'clients.php') echo 'class="active"'; ?>>
                    <a href="clients.php" class="svg-icon">
                        <i class="fas fa-user-tie" style="font-size: 26px;"></i>
                        <span class="ml-4">Clients</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'salary.php') echo 'class="active"'; ?>>
                    <a href="salary.php" class="svg-icon">
                        <i class="far fa-list-alt" style="font-size: 26px;"></i>
                        <span class="ml-4">Salary List</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'invoice.php') echo 'class="active"'; ?>>
                    <a href="invoice.php" class="svg-icon">
                        <span class="material-icons" style="font-size: 28px;">
                            receipt_long
                        </span>
                        <span class="ml-4">Invoice</span>
                    </a>
                </li>
              

                <li <?php if ($current_page == 'leave.php') echo 'class="active"'; ?>>
                    <a href="leave.php" class="svg-icon">
                        <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        <span class="ml-4">Manage Leave</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'users.php') echo 'class="active"'; ?>>
                    <a href="users.php" class="svg-icon">
                        <i class='fas fa-comments' style='font-size:24px'></i>
                        <span class="ml-4">Chat</span>
                    </a>
                </li>             

                <li <?php if ($current_page == 'request.php') echo 'class="active"'; ?>>
                    <a href="request.php" class="svg-icon">
                        <i class='fas fa-envelope' style='font-size:23px'></i>
                        <span class="ml-4">Request</span>                 
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
                                    <a href="https://teams.live.com/l/invite/FEAaynm6-v4owfj-xo"><i
                                            class="fab fa-microsoft"></i></a>
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
                                    <a href="https://chat.whatsapp.com/ER00JIEmQ5zIYZe8083xg6"><i
                                            class="fab fa-whatsapp"></i></a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the active menu item
    var activeMenuItem = document.querySelector('.iq-menu .active');

    if (activeMenuItem) {
        // Scroll the sidebar to bring the active menu item into view
        scrollIntoView(activeMenuItem);
    }
});

function scrollIntoView(element) {
    var sidebarMenu = document.querySelector('.iq-sidebar-menu');
    var elementRect = element.getBoundingClientRect();
    var sidebarRect = sidebarMenu.getBoundingClientRect();

    // Calculate the scroll position to bring the element into view
    var scrollPosition = elementRect.top - sidebarRect.top - (sidebarMenu.clientHeight / 2) + (element.clientHeight / 2);
    
    // Scroll the sidebar to the calculated scroll position
    sidebarMenu.scrollTop = scrollPosition;
}
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
</script>