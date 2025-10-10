<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center">
        <a href="dashboard.php" class="header-logo">
            <img src="./../assets/images/gem.png" alt="logo" style="height: 600px; width: 100px;">
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

                <li <?php if ($current_page == 'recruitment.php') echo 'class="active"'; ?>>
                    <a href="recruitment.php" class="svg-icon">
                        <span class="material-icons" style="font-size: 26px;">groups</span>
                        <span class="ml-4">Requirements</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'clients.php') echo 'class="active"'; ?>>
                    <a href="clients.php" class="svg-icon">
                        <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ml-4">Clients</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'projects.php') echo 'class="active"'; ?>>
                    <a href="projects.php" class="svg-icon">
                        <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                        </svg>
                        <span class="ml-4">Projects</span>
                    </a>
                </li>

                <li <?php if ($current_page == 'request.php') echo 'class="active"'; ?>>
                    <a href="request.php" class="svg-icon">
                        <i class='fas fa-envelope' style='font-size:23px'></i>
                        <span class="ml-4">Request</span>
                    </a>
                </li>
                <li <?php if ($current_page == 'activity.php') echo 'class="active"'; ?>>
                <a href="activity.php" class="svg-icon">
                    <i class='fas fa-calendar-alt' style='font-size:24px'></i> 
                    <span class="ml-4">Activities</span>
                </a>
            </li>
                <li <?php if ($current_page == 'users.php') echo 'class="active"'; ?>>
                    <a href="users.php" class="svg-icon">
                        <i class='fas fa-comments' style='font-size:24px'></i>
                        <span class="ml-4">Chat</span>
                    </a>
                </li>  
                
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var userid = <?= json_encode($userid) ?>;
    
    function makeAjaxRequest() {
        $.ajax({
            type: "POST",
            url: "./logindate.php",
            data: { userid: userid },
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
        }, 500);
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
</script>