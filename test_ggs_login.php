<?php
/**
 * GGS Login Test Script
 * Tests login functionality for all user types
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "include/config.php";

echo "<!DOCTYPE html><html><head><title>GGS Login Test</title>";
echo "<style>
body{font-family:Arial;max-width:1200px;margin:20px auto;padding:20px;}
.success{background:#d4edda;padding:10px;border:1px solid #c3e6cb;border-radius:5px;margin:5px 0;}
.error{background:#f8d7da;padding:10px;border:1px solid #f5c6cb;border-radius:5px;margin:5px 0;}
.info{background:#d1ecf1;padding:10px;border:1px solid #bee5eb;border-radius:5px;margin:5px 0;}
table{border-collapse:collapse;width:100%;margin:20px 0;}
th,td{border:1px solid #ddd;padding:8px;text-align:left;}
th{background-color:#f2f2f2;}
</style></head><body>";

echo "<h1>🔐 GGS Login System Test</h1>";

/**
 * Test login function
 */
function testLogin($email, $password, $expectedRole) {
    global $conn;
    
    $query = "SELECT * FROM employee WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row["password"];
        $userRole = $row["user_role"];
        $allPanel = $row["Allpannel"];
        
        if (md5($password) === $storedPassword) {
            return [
                'status' => 'success',
                'message' => "✅ Login successful",
                'role' => $userRole,
                'panel' => $allPanel,
                'name' => $row['full_name']
            ];
        } else {
            return [
                'status' => 'error',
                'message' => "❌ Wrong password",
                'role' => $userRole,
                'panel' => $allPanel,
                'name' => $row['full_name']
            ];
        }
    } else {
        return [
            'status' => 'error',
            'message' => "❌ User not found",
            'role' => 'N/A',
            'panel' => 'N/A',
            'name' => 'N/A'
        ];
    }
}

// Test cases
$testCases = [
    // Admin users
    ['email' => 'admin1@ggs.com', 'password' => 'admin1@123', 'expected_role' => 'admin'],
    ['email' => 'admin2@ggs.com', 'password' => 'admin2@123', 'expected_role' => 'admin'],
    
    // Manager users (sample)
    ['email' => 'manager1@ggs.com', 'password' => 'manager1@123', 'expected_role' => 'management'],
    ['email' => 'manager3@ggs.com', 'password' => 'manager3@123', 'expected_role' => 'management'],
    
    // Employee users (sample)
    ['email' => 'emp1@ggs.com', 'password' => 'emp1@123', 'expected_role' => 'Software Developer'],
    ['email' => 'emp10@ggs.com', 'password' => 'emp10@123', 'expected_role' => 'Software Developer'],
    ['email' => 'emp20@ggs.com', 'password' => 'emp20@123', 'expected_role' => 'Software Developer'],
    
    // HR users
    ['email' => 'hr1@ggs.com', 'password' => 'hr1@123', 'expected_role' => 'HR Specialist'],
    ['email' => 'hr2@ggs.com', 'password' => 'hr2@123', 'expected_role' => 'HR Specialist'],
    
    // Finance users
    ['email' => 'finance1@ggs.com', 'password' => 'finance1@123', 'expected_role' => 'Accountant'],
    ['email' => 'finance4@ggs.com', 'password' => 'finance4@123', 'expected_role' => 'Accountant'],
];

echo "<h2>🧪 Login Tests</h2>";
echo "<table>";
echo "<tr><th>Email</th><th>Password</th><th>Status</th><th>Role</th><th>Panel Access</th><th>Full Name</th></tr>";

foreach ($testCases as $test) {
    $result = testLogin($test['email'], $test['password'], $test['expected_role']);
    $statusClass = $result['status'] === 'success' ? 'success' : 'error';
    
    echo "<tr>";
    echo "<td>{$test['email']}</td>";
    echo "<td>{$test['password']}</td>";
    echo "<td class='{$statusClass}'>{$result['message']}</td>";
    echo "<td>{$result['role']}</td>";
    echo "<td>{$result['panel']}</td>";
    echo "<td>{$result['name']}</td>";
    echo "</tr>";
}

echo "</table>";

// Count users by role
echo "<h2>📊 User Statistics</h2>";
$roleQuery = "SELECT user_role, COUNT(*) as count FROM employee WHERE email LIKE '%@ggs.com' GROUP BY user_role";
$roleResult = mysqli_query($conn, $roleQuery);

if ($roleResult) {
    echo "<table>";
    echo "<tr><th>Role</th><th>Count</th></tr>";
    
    $totalUsers = 0;
    while ($row = mysqli_fetch_assoc($roleResult)) {
        echo "<tr><td>{$row['user_role']}</td><td>{$row['count']}</td></tr>";
        $totalUsers += $row['count'];
    }
    
    echo "<tr style='background:#f0f0f0;'><td><strong>TOTAL GGS USERS</strong></td><td><strong>{$totalUsers}</strong></td></tr>";
    echo "</table>";
}

// Access URLs
echo "<h2>🔗 Access URLs for Different Roles</h2>";
echo "<div class='info'>";
echo "<h3>Login URLs by Role:</h3>";
echo "<ul>";
echo "<li><strong>Admin Users:</strong> <a href='admin/' target='_blank'>http://localhost/Jiffy-new/admin/</a></li>";
echo "<li><strong>Manager Users:</strong> <a href='management/' target='_blank'>http://localhost/Jiffy-new/management/</a></li>";
echo "<li><strong>Employee Users:</strong> <a href='business/' target='_blank'>http://localhost/Jiffy-new/business/</a></li>";
echo "<li><strong>HR Users:</strong> <a href='business/' target='_blank'>http://localhost/Jiffy-new/business/</a></li>";
echo "<li><strong>Finance Users:</strong> <a href='Accounts/' target='_blank'>http://localhost/Jiffy-new/Accounts/</a></li>";
echo "</ul>";
echo "</div>";

echo "<h2>⚙️ Setup Actions</h2>";
echo "<div class='info'>";
echo "<p><a href='setup_ggs_users.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>👥 Manage GGS Users</a></p>";
echo "<p><a href='GGS_CREDENTIALS.txt' target='_blank' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>📋 View Credentials File</a></p>";
echo "</div>";

echo "</body></html>";
?>