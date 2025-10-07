<?php
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['manager_id'])) {
        $manager_id = mysqli_real_escape_string($conn, $_POST['manager_id']);
        $query = "SELECT t.*, e.full_name, e.id, e.user_role 
                    FROM team t 
                    JOIN employee e ON t.leader = e.id
                    WHERE t.project_lead = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $manager_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            echo '<option value="" disabled selected>Select Lead</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $leader_name = $row['full_name'];
                $user_role = $row['user_role'];
                if (isset($_POST['projectleadId'])) {
                    $projectleadid = $_POST['projectleadId'];
                    $selected = ($id == $projectleadid) ? 'selected' : ''; 
                } else {
                    $selected = '';
                }
                echo '<option value="' . $id . '" ' . $selected . '>' . $leader_name . '(' . $user_role . ')</option>';
            }
        } else {
            echo '<option value="" disabled>No team leaders found</option>';
        }
    } elseif (isset($_POST['leader_id'])) {
        // Fetch team members based on leader ID
        $leaderid = mysqli_real_escape_string($conn, $_POST['leader_id']);
        $query = "SELECT t.*, e.id, e.full_name, e.user_role
                    FROM team t
                    JOIN employee e ON FIND_IN_SET(e.id, REPLACE(t.employee, ' ', '')) > 0
                    WHERE t.leader = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $leaderid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $members = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $leavetype = $row['full_name'];
                $user_role = $row['user_role'];
                $members[] = array(
                    'value' => $id,
                    'name' => $leavetype . '(' . $user_role . ')'
                );
            }
            echo json_encode($members);
        } else {
            echo json_encode(array('error' => 'No type found'));
        }
    } elseif(isset($_POST['projectId'])) {
        $projectid = $_POST['projectId'];
        $query = "SELECT * FROM objectives WHERE id = $projectid";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo '<option value="" disabled selected>Select Module</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $projectmodules = $row['modules'];
                $modules = explode(',', $projectmodules);
                if (isset($_POST['projectmodules'])) {
                    $selected_module = $_POST['projectmodules'];
                    foreach ($modules as $module) {
                        $selected = ($selected_module == $module) ? 'selected' : ''; 
                        echo '<option value="' . $module . '" ' . $selected . '>' . $module . '</option>';
                    }
                } else {
                    foreach ($modules as $module) {
                        
                        echo '<option value="' . $module . '">' . $module . '</option>';                        
                    }
                }
            }
        } else {
            echo '<option value="" disabled selected hidden class="dropdown-item text-primary">No Modules found</option>';
        }
    }elseif(isset($_POST['taskdataid'])) {
        $projectid = $_POST['taskdataid'];
        $query = "SELECT * FROM objectives WHERE id = $projectid";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo '<option value="" class="dropdown-item text-primary" disabled selected>Select Task</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $projectmodules = $row['tasks'];
                $modules = explode(',', $projectmodules);
                if (isset($_POST['projectmodules'])) {
                    $selected_module = $_POST['projectmodules'];
                    foreach ($modules as $module) {
                        $selected = ($selected_module == $module) ? 'selected' : ''; 
                        echo '<a class="dropdown-item" href="#" data-module="' . htmlspecialchars($task) . '">' . htmlspecialchars($task) . '</a>';                        
                    }
                } else {
                    foreach ($modules as $module) {
                        echo '<a class="dropdown-item" href="#" data-module="' . htmlspecialchars($module) . '">' . htmlspecialchars($module) . '</a>';                                             
                    }
                }
            }
    }else{
        echo '<a class="dropdown-item" href="#" data-module=""><i class="fa fa-exclamation mr-1 text-danger"></i> No task list found</a>';
    }
}
}
?>
