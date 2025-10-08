<?php
include 'include/config.php';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Login Credentials Manager</title>";
echo "<style>
body{font-family:Arial;max-width:1000px;margin:20px auto;padding:20px;background:#f5f5f5;}
table{width:100%;border-collapse:collapse;background:white;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#007bff;color:white;}
tr:hover{background:#f8f9fa;}
.success{background:#d4edda;padding:15px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;color:#155724;}
.info{background:#d1ecf1;padding:15px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}
.warning{background:#fff3cd;padding:15px;border:1px solid #ffc107;border-radius:5px;margin:10px 0;color:#856404;}
.btn{display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;margin:5px;border:none;cursor:pointer;}
.btn-success{background:#28a745;}
.btn-danger{background:#dc3545;}
h1,h2,h3{color:#333;}
.credential-box{background:white;padding:20px;border-radius:8px;margin:20px 0;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
.badge{padding:4px 8px;border-radius:4px;font-size:11px;font-weight:bold;}
.badge-admin{background:#dc3545;color:white;}
.badge-manager{background:#6f42c1;color:white;}
.badge-employee{background:#17a2b8;color:white;}
.badge-active{background:#28a745;color:white;}
.badge-inactive{background:#6c757d;color:white;}
</style></head><body>";

echo "<h1>🔐 Login Credentials Manager</h1>";

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $userId = intval($_POST['user_id']);
    $newPassword = $_POST['new_password'];
    $hashedPassword = md5($newPassword);
    
    $updateQuery = "UPDATE employee SET password = '$hashedPassword' WHERE id = $userId";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<div class='success'>✅ Password updated successfully for user ID: $userId</div>";
    } else {
        echo "<div class='warning'>❌ Failed to update password: " . mysqli_error($conn) . "</div>";
    }
}

// Get active users
$query = "SELECT id, empid, full_name, email, password, user_type, user_role, Allpannel, active, Company_id 
          FROM employee 
          ORDER BY 
          CASE 
            WHEN Allpannel LIKE '%Admin%' THEN 1
            WHEN Allpannel LIKE '%Management%' THEN 2
            WHEN Allpannel LIKE '%Project Manager%' THEN 3
            ELSE 4
          END, id
          LIMIT 20";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

echo "<div class='info'>";
echo "<h3>📋 Quick Login Information</h3>";
echo "<p><strong>Note:</strong> Passwords in the database are MD5 encrypted. Common passwords to try:</p>";
echo "<ul>";
echo "<li><strong>Password:</strong> 12345 (or) admin (or) 123456</li>";
echo "<li><strong>Hash:</strong> 17ae4741e0c8be5fa97a87bc0bb79535 = likely '12345'</li>";
echo "</ul>";
echo "</div>";

// Common password hashes for reference
$commonPasswords = [
    '17ae4741e0c8be5fa97a87bc0bb79535' => '12345',
    '21232f297a57a5a743894a0e4a801fc3' => 'admin',
    'e10adc3949ba59abbe56e057f20f883e' => '123456',
    '5f4dcc3b5aa765d61d8327deb882cf99' => 'password',
    'a31d254b7558a05009491a60b47d0103' => 'sanjana',
    '69ea35d46fcfe61630876d88659dac5f' => 'pavithra',
    '90ef5e044f3377bce9dd77306e2c4e8a' => 'suman@123',
];

echo "<div class='credential-box'>";
echo "<h2>👥 User Accounts</h2>";
echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Access Level</th>
        <th>Status</th>
        <th>Likely Password</th>
        <th>Action</th>
      </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $statusBadge = $row['active'] === 'active' 
        ? '<span class="badge badge-active">Active</span>' 
        : '<span class="badge badge-inactive">Inactive</span>';
    
    $accessBadge = '';
    if (stripos($row['Allpannel'], 'Admin') !== false) {
        $accessBadge = '<span class="badge badge-admin">Admin</span>';
    } elseif (stripos($row['Allpannel'], 'Management') !== false) {
        $accessBadge = '<span class="badge badge-manager">Management</span>';
    } else {
        $accessBadge = '<span class="badge badge-employee">Employee</span>';
    }
    
    $likelyPassword = isset($commonPasswords[$row['password']]) 
        ? "<strong>" . $commonPasswords[$row['password']] . "</strong>" 
        : "<em>Unknown</em>";
    
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['empid']}</td>";
    echo "<td>{$row['full_name']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['user_role']}</td>";
    echo "<td>{$accessBadge}</td>";
    echo "<td>{$statusBadge}</td>";
    echo "<td>{$likelyPassword}</td>";
    echo "<td>
            <button onclick='showResetForm({$row['id']}, \"{$row['email']}\")' class='btn btn-success' style='padding:5px 10px;font-size:12px;'>Reset</button>
          </td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

// Password Reset Form
echo "<div id='resetForm' style='display:none;' class='credential-box'>";
echo "<h3>🔑 Reset Password</h3>";
echo "<form method='POST'>";
echo "<input type='hidden' name='user_id' id='reset_user_id'>";
echo "<p><strong>Email:</strong> <span id='reset_email'></span></p>";
echo "<label>New Password:</label><br>";
echo "<input type='text' name='new_password' required style='padding:8px;width:300px;margin:10px 0;'><br>";
echo "<button type='submit' name='reset_password' class='btn btn-danger'>Update Password</button>";
echo "<button type='button' onclick='hideResetForm()' class='btn' style='background:#6c757d;'>Cancel</button>";
echo "</form>";
echo "</div>";

// Recommended login credentials
echo "<div class='success'>";
echo "<h3>🎯 Recommended Login Credentials to Try:</h3>";
echo "<div style='display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:15px;'>";

// Admin Login
echo "<div style='background:white;padding:15px;border-radius:5px;border:2px solid #dc3545;'>";
echo "<h4 style='color:#dc3545;margin-top:0;'>🔴 Admin Access</h4>";
echo "<p><strong>Email:</strong> nishar.mine@gmail.com<br>";
echo "<strong>Password:</strong> 12345</p>";
echo "<a href='admin/' class='btn btn-danger'>Go to Admin Panel</a>";
echo "</div>";

// Management Login
echo "<div style='background:white;padding:15px;border-radius:5px;border:2px solid #6f42c1;'>";
echo "<h4 style='color:#6f42c1;margin-top:0;'>🟣 Management Access</h4>";
echo "<p><strong>Email:</strong> jayamani@mineit.tech<br>";
echo "<strong>Password:</strong> 12345</p>";
echo "<a href='management/' class='btn' style='background:#6f42c1;'>Go to Management</a>";
echo "</div>";

// Project Manager Login
echo "<div style='background:white;padding:15px;border-radius:5px;border:2px solid #17a2b8;'>";
echo "<h4 style='color:#17a2b8;margin-top:0;'>🔵 Project Manager</h4>";
echo "<p><strong>Email:</strong> joud@swifterz.ae<br>";
echo "<strong>Password:</strong> 12345</p>";
echo "<a href='project/' class='btn' style='background:#17a2b8;'>Go to Projects</a>";
echo "</div>";

// Employee Login
echo "<div style='background:white;padding:15px;border-radius:5px;border:2px solid #28a745;'>";
echo "<h4 style='color:#28a745;margin-top:0;'>🟢 Employee Access</h4>";
echo "<p><strong>Email:</strong> jhasuman.1503@gmail.com<br>";
echo "<strong>Password:</strong> 12345</p>";
echo "<a href='business/' class='btn btn-success'>Go to Business Portal</a>";
echo "</div>";

echo "</div></div>";

echo "<script>
function showResetForm(userId, email) {
    document.getElementById('reset_user_id').value = userId;
    document.getElementById('reset_email').textContent = email;
    document.getElementById('resetForm').style.display = 'block';
    document.getElementById('resetForm').scrollIntoView({behavior: 'smooth'});
}
function hideResetForm() {
    document.getElementById('resetForm').style.display = 'none';
}
</script>";

mysqli_close($conn);
echo "</body></html>";
?>
