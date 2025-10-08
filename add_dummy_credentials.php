<?php
include 'include/config.php';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Add Dummy Credentials</title>";
echo "<style>
body{font-family:Arial;max-width:900px;margin:20px auto;padding:20px;background:#f5f5f5;}
.success{background:#d4edda;padding:15px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;color:#155724;}
.error{background:#f8d7da;padding:15px;border:1px solid #f5c6cb;border-radius:5px;margin:10px 0;color:#721c24;}
.info{background:#d1ecf1;padding:15px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}
.credential-card{background:white;padding:20px;border-radius:8px;margin:15px 0;box-shadow:0 2px 8px rgba(0,0,0,0.1);border-left:4px solid #007bff;}
.btn{display:inline-block;padding:12px 24px;background:#007bff;color:white;text-decoration:none;border-radius:5px;margin:5px;border:none;cursor:pointer;font-size:14px;}
.btn-success{background:#28a745;}
.btn-danger{background:#dc3545;}
h1{color:#333;}
table{width:100%;border-collapse:collapse;background:white;margin:15px 0;}
th,td{padding:10px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#007bff;color:white;}
</style></head><body>";

echo "<h1>👥 Add Dummy/Demo Credentials</h1>";

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_dummies'])) {
    
    // Dummy users to add
    $dummyUsers = [
        [
            'empid' => 'EMP-DEMO-001',
            'full_name' => 'Admin Demo',
            'email' => 'admin@demo.com',
            'password' => 'admin123',
            'user_type' => 'Employee',
            'user_role' => 'System Administrator',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Demo Address',
            'allpannel' => 'Admin,Management,Project Manager,Employee,All',
            'active' => 'active'
        ],
        [
            'empid' => 'EMP-DEMO-002',
            'full_name' => 'Manager Demo',
            'email' => 'manager@demo.com',
            'password' => 'manager123',
            'user_type' => 'Employee',
            'user_role' => 'Project Manager',
            'phone' => '1234567891',
            'dob' => '1992-01-01',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Demo Address',
            'allpannel' => 'Management,Project Manager,Employee',
            'active' => 'active'
        ],
        [
            'empid' => 'EMP-DEMO-003',
            'full_name' => 'Project Manager Demo',
            'email' => 'project@demo.com',
            'password' => 'project123',
            'user_type' => 'Employee',
            'user_role' => 'Project Manager',
            'phone' => '1234567892',
            'dob' => '1993-01-01',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Demo Address',
            'allpannel' => 'Project Manager,Employee',
            'active' => 'active'
        ],
        [
            'empid' => 'EMP-DEMO-004',
            'full_name' => 'Employee Demo',
            'email' => 'employee@demo.com',
            'password' => 'employee123',
            'user_type' => 'Employee',
            'user_role' => 'Software Developer',
            'phone' => '1234567893',
            'dob' => '1995-01-01',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Demo Address',
            'allpannel' => 'Employee',
            'active' => 'active'
        ],
        [
            'empid' => 'EMP-DEMO-005',
            'full_name' => 'HR Demo',
            'email' => 'hr@demo.com',
            'password' => 'hr123',
            'user_type' => 'Employee',
            'user_role' => 'HR Manager',
            'phone' => '1234567894',
            'dob' => '1991-01-01',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Demo Address',
            'allpannel' => 'Management,Employee',
            'active' => 'active'
        ],
        [
            'empid' => 'EMP-TEST-001',
            'full_name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'test123',
            'user_type' => 'Employee',
            'user_role' => 'Tester',
            'phone' => '9999999999',
            'dob' => '1994-01-01',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Test Address',
            'allpannel' => 'Employee',
            'active' => 'active'
        ]
    ];
    
    $added = 0;
    $skipped = 0;
    $errors = [];
    
    foreach ($dummyUsers as $user) {
        // Check if user already exists
        $checkQuery = "SELECT id FROM employee WHERE email = '{$user['email']}'";
        $checkResult = mysqli_query($conn, $checkQuery);
        
        if (mysqli_num_rows($checkResult) > 0) {
            $skipped++;
            continue;
        }
        
        // Hash password
        $hashedPassword = md5($user['password']);
        
        // Insert user
        $insertQuery = "INSERT INTO employee (
            empid, full_name, email, password, user_type, user_role, 
            phone_number, dob, doj, department, address, Allpannel, 
            active, Company_id, created_date
        ) VALUES (
            '{$user['empid']}',
            '{$user['full_name']}',
            '{$user['email']}',
            '$hashedPassword',
            '{$user['user_type']}',
            '{$user['user_role']}',
            '{$user['phone']}',
            '{$user['dob']}',
            '{$user['doj']}',
            {$user['department']},
            '{$user['address']}',
            '{$user['allpannel']}',
            '{$user['active']}',
            '1',
            NOW()
        )";
        
        if (mysqli_query($conn, $insertQuery)) {
            $added++;
        } else {
            $errors[] = "Failed to add {$user['email']}: " . mysqli_error($conn);
        }
    }
    
    echo "<div class='success'>";
    echo "<h2>✅ Dummy Credentials Added!</h2>";
    echo "<p><strong>Successfully added:</strong> $added users</p>";
    if ($skipped > 0) {
        echo "<p><strong>Skipped (already exists):</strong> $skipped users</p>";
    }
    echo "</div>";
    
    if (!empty($errors)) {
        echo "<div class='error'>";
        echo "<h3>❌ Errors:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></div>";
    }
}

// Show existing demo users
$demoQuery = "SELECT id, empid, full_name, email, user_role, Allpannel, active 
              FROM employee 
              WHERE email LIKE '%@demo.com' OR email LIKE '%@test.com' 
              ORDER BY id";
$demoResult = mysqli_query($conn, $demoQuery);
$hasDemoUsers = mysqli_num_rows($demoResult) > 0;

?>

<div class='info'>
    <h2>📋 What This Does</h2>
    <p>This script will add the following dummy/demo user accounts to your database for testing:</p>
    <ul>
        <li><strong>Admin Demo</strong> - Full system access (All modules)</li>
        <li><strong>Manager Demo</strong> - Management + Project access</li>
        <li><strong>Project Manager Demo</strong> - Project management access</li>
        <li><strong>Employee Demo</strong> - Basic employee access</li>
        <li><strong>HR Demo</strong> - HR/Management access</li>
        <li><strong>Test User</strong> - Simple test account</li>
    </ul>
    <p><strong>Note:</strong> All passwords follow the pattern: [role]123 (e.g., admin123, employee123)</p>
</div>

<?php if ($hasDemoUsers): ?>
<div class='credential-card'>
    <h2>🎯 Existing Demo/Test Accounts</h2>
    <table>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Access Level</th>
            <th>Status</th>
        </tr>
        <?php 
        mysqli_data_seek($demoResult, 0);
        while ($row = mysqli_fetch_assoc($demoResult)): 
        ?>
        <tr>
            <td><?php echo $row['empid']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['user_role']; ?></td>
            <td><?php echo $row['Allpannel']; ?></td>
            <td><?php echo $row['active']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php endif; ?>

<div class='credential-card'>
    <h2>➕ Add Demo Credentials</h2>
    <form method='POST'>
        <p>Click the button below to add all dummy credentials to your database:</p>
        <button type='submit' name='add_dummies' class='btn btn-success'>
            ✨ Add Dummy Credentials
        </button>
    </form>
</div>

<div class='credential-card' style='border-left-color:#28a745;'>
    <h2>🔐 Demo Login Credentials</h2>
    <p>After adding, you can use these credentials to login:</p>
    
    <div style='display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:15px;'>
        
        <div style='background:#fff3cd;padding:15px;border-radius:5px;'>
            <h4 style='margin:0 0 10px 0;color:#856404;'>👑 Admin Access</h4>
            <p style='margin:5px 0;'><strong>Email:</strong> admin@demo.com</p>
            <p style='margin:5px 0;'><strong>Password:</strong> admin123</p>
            <a href='admin/' class='btn btn-danger' style='margin-top:10px;'>Go to Admin</a>
        </div>
        
        <div style='background:#e7e7ff;padding:15px;border-radius:5px;'>
            <h4 style='margin:0 0 10px 0;color:#6f42c1;'>💼 Manager Access</h4>
            <p style='margin:5px 0;'><strong>Email:</strong> manager@demo.com</p>
            <p style='margin:5px 0;'><strong>Password:</strong> manager123</p>
            <a href='management/' class='btn' style='background:#6f42c1;margin-top:10px;'>Go to Management</a>
        </div>
        
        <div style='background:#cfe2ff;padding:15px;border-radius:5px;'>
            <h4 style='margin:0 0 10px 0;color:#0d6efd;'>📊 Project Manager</h4>
            <p style='margin:5px 0;'><strong>Email:</strong> project@demo.com</p>
            <p style='margin:5px 0;'><strong>Password:</strong> project123</p>
            <a href='project/' class='btn' style='background:#0d6efd;margin-top:10px;'>Go to Projects</a>
        </div>
        
        <div style='background:#d1e7dd;padding:15px;border-radius:5px;'>
            <h4 style='margin:0 0 10px 0;color:#0f5132;'>👤 Employee Access</h4>
            <p style='margin:5px 0;'><strong>Email:</strong> employee@demo.com</p>
            <p style='margin:5px 0;'><strong>Password:</strong> employee123</p>
            <a href='business/' class='btn btn-success' style='margin-top:10px;'>Go to Business</a>
        </div>
        
        <div style='background:#f8d7da;padding:15px;border-radius:5px;'>
            <h4 style='margin:0 0 10px 0;color:#842029;'>👥 HR Access</h4>
            <p style='margin:5px 0;'><strong>Email:</strong> hr@demo.com</p>
            <p style='margin:5px 0;'><strong>Password:</strong> hr123</p>
            <a href='management/' class='btn' style='background:#dc3545;margin-top:10px;'>Go to HR</a>
        </div>
        
        <div style='background:#e2e3e5;padding:15px;border-radius:5px;'>
            <h4 style='margin:0 0 10px 0;color:#41464b;'>🧪 Test Account</h4>
            <p style='margin:5px 0;'><strong>Email:</strong> test@test.com</p>
            <p style='margin:5px 0;'><strong>Password:</strong> test123</p>
            <a href='business/' class='btn' style='background:#6c757d;margin-top:10px;'>Go to Portal</a>
        </div>
        
    </div>
</div>

<div style='text-align:center;margin:30px 0;'>
    <a href='get_credentials.php' class='btn'>📋 View All Credentials</a>
    <a href='test_connection.php' class='btn btn-success'>🧪 Test Connection</a>
    <a href='index.php' class='btn' style='background:#6c757d;'>🏠 Go to Homepage</a>
</div>

<?php
mysqli_close($conn);
?>

</body>
</html>
