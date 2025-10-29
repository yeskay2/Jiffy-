<?php
include 'include/config.php';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Add Custom Demo Credentials</title>";
echo "<style>
body{font-family:Arial;max-width:1200px;margin:20px auto;padding:20px;background:#f5f5f5;}
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
.mgr{border-left-color:#28a745;}
.proj{border-left-color:#007bff;}
.emp{border-left-color:#6c757d;}
</style></head><body>";

echo "<h1>👥 Add Custom @ggs.com Demo Credentials</h1>";

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_credentials'])) {
    
    // Custom users as per your requirements
    $customUsers = [
        // 2 Management Users
        [
            'empid' => 'EMP-MGR-001',
            'full_name' => 'Alice Manager',
            'email' => 'alice.manager@ggs.com',
            'password' => 'manager123',
            'user_type' => 'Employee',
            'user_role' => 'management',
            'phone' => '9876543201',
            'dob' => '1985-03-15',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Management Office',
            'allpannel' => 'Management,Project Manager,Employee',
            'active' => 'active',
            'type' => 'Manager'
        ],
        [
            'empid' => 'EMP-MGR-002',
            'full_name' => 'Bob Manager',
            'email' => 'bob.manager@ggs.com',
            'password' => 'manager123',
            'user_type' => 'Employee',
            'user_role' => 'management',
            'phone' => '9876543202',
            'dob' => '1987-07-22',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Management Office',
            'allpannel' => 'Management,Project Manager,Employee',
            'active' => 'active',
            'type' => 'Manager'
        ],
        
        // 2 Project Manager Users
        [
            'empid' => 'EMP-PM-001',
            'full_name' => 'Charlie Project Manager',
            'email' => 'charlie.project@ggs.com',
            'password' => 'project123',
            'user_type' => 'Employee',
            'user_role' => 'Project Manager',
            'phone' => '9876543301',
            'dob' => '1988-04-10',
            'doj' => date('Y-m-d'),
            'department' => 2,
            'address' => 'Project Office',
            'allpannel' => 'Project Manager,Employee',
            'active' => 'active',
            'type' => 'Project Manager'
        ],
        [
            'empid' => 'EMP-PM-002',
            'full_name' => 'Diana Project Manager',
            'email' => 'diana.project@ggs.com',
            'password' => 'project123',
            'user_type' => 'Employee',
            'user_role' => 'Project Manager',
            'phone' => '9876543302',
            'dob' => '1986-11-25',
            'doj' => date('Y-m-d'),
            'department' => 2,
            'address' => 'Project Office',
            'allpannel' => 'Project Manager,Employee',
            'active' => 'active',
            'type' => 'Project Manager'
        ],
        
        // 10 Employee Users
        [
            'empid' => 'EMP-DEV-001',
            'full_name' => 'Emily Developer',
            'email' => 'emily.developer@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Software Developer',
            'phone' => '9876543401',
            'dob' => '1992-01-15',
            'doj' => date('Y-m-d'),
            'department' => 3,
            'address' => 'Development Floor',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-DES-001',
            'full_name' => 'Frank Designer',
            'email' => 'frank.designer@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'UI/UX Designer',
            'phone' => '9876543402',
            'dob' => '1993-02-20',
            'doj' => date('Y-m-d'),
            'department' => 3,
            'address' => 'Design Studio',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-QA-001',
            'full_name' => 'Grace Tester',
            'email' => 'grace.tester@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Testing Engineer',
            'phone' => '9876543403',
            'dob' => '1991-03-12',
            'doj' => date('Y-m-d'),
            'department' => 3,
            'address' => 'QA Lab',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-HR-001',
            'full_name' => 'Henry HR Specialist',
            'email' => 'henry.hr@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'HR Specialist',
            'phone' => '9876543404',
            'dob' => '1989-04-18',
            'doj' => date('Y-m-d'),
            'department' => 4,
            'address' => 'HR Department',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-ACC-001',
            'full_name' => 'Isabella Accountant',
            'email' => 'isabella.accounts@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Accountant',
            'phone' => '9876543405',
            'dob' => '1990-05-30',
            'doj' => date('Y-m-d'),
            'department' => 5,
            'address' => 'Accounts Department',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-MKT-001',
            'full_name' => 'Jack Marketing',
            'email' => 'jack.marketing@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Marketing Specialist',
            'phone' => '9876543406',
            'dob' => '1994-06-14',
            'doj' => date('Y-m-d'),
            'department' => 6,
            'address' => 'Marketing Floor',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-SUP-001',
            'full_name' => 'Kate Support',
            'email' => 'kate.support@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Technical Support',
            'phone' => '9876543407',
            'dob' => '1992-07-08',
            'doj' => date('Y-m-d'),
            'department' => 7,
            'address' => 'Support Center',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-SAL-001',
            'full_name' => 'Liam Sales',
            'email' => 'liam.sales@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Sales Representative',
            'phone' => '9876543408',
            'dob' => '1991-08-22',
            'doj' => date('Y-m-d'),
            'department' => 8,
            'address' => 'Sales Floor',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-ANA-001',
            'full_name' => 'Mia Analyst',
            'email' => 'mia.analyst@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Business Analyst',
            'phone' => '9876543409',
            'dob' => '1993-09-16',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Analysis Wing',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ],
        [
            'empid' => 'EMP-OPS-001',
            'full_name' => 'Noah Operations',
            'email' => 'noah.operations@ggs.com',
            'password' => 'emp123',
            'user_type' => 'Employee',
            'user_role' => 'Operations Manager',
            'phone' => '9876543410',
            'dob' => '1987-10-05',
            'doj' => date('Y-m-d'),
            'department' => 1,
            'address' => 'Operations Center',
            'allpannel' => 'Employee',
            'active' => 'active',
            'type' => 'Employee'
        ]
    ];
    
    $added = 0;
    $skipped = 0;
    $errors = [];
    
    echo "<div class='info'><h3>🔄 Processing " . count($customUsers) . " users...</h3></div>";
    
    foreach ($customUsers as $user) {
        // Check if user already exists
        $checkQuery = "SELECT id FROM employee WHERE email = '{$user['email']}'";
        $checkResult = mysqli_query($conn, $checkQuery);
        
        if (mysqli_num_rows($checkResult) > 0) {
            echo "<div class='error'>⚠️ Skipped: {$user['full_name']} ({$user['email']}) - Already exists</div>";
            $skipped++;
            continue;
        }
        
        // Hash password
        $hashedPassword = md5($user['password']);
        
        // Insert user
        $insertQuery = "INSERT INTO employee (
            empid, full_name, email, password, user_type, user_role, 
            phone_number, dob, doj, department, address, Allpannel, 
            active, Company_id, status, created_date, profile_picture
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
            'Offline',
            NOW(),
            'user.png'
        )";
        
        if (mysqli_query($conn, $insertQuery)) {
            $userId = mysqli_insert_id($conn);
            echo "<div class='success'>✅ Added: {$user['full_name']} ({$user['email']}) - ID: $userId</div>";
            $added++;
        } else {
            $error = mysqli_error($conn);
            $errors[] = "Failed to add {$user['full_name']}: $error";
            echo "<div class='error'>❌ Failed: {$user['full_name']} - $error</div>";
        }
    }
    
    // Summary
    echo "<div class='info'>";
    echo "<h3>📊 Summary</h3>";
    echo "<strong>Total Users Processed:</strong> " . count($customUsers) . "<br>";
    echo "<strong>Successfully Added:</strong> $added<br>";
    echo "<strong>Skipped (Already Exist):</strong> $skipped<br>";
    echo "<strong>Errors:</strong> " . count($errors) . "<br>";
    echo "</div>";
    
    if ($added > 0) {
        echo "<div class='success'>";
        echo "<h3>🎉 Credentials Added Successfully!</h3>";
        echo "<p>You can now use these credentials to login to different portals:</p>";
        echo "</div>";
        
        // Display credentials by category
        echo "<h2>🔑 Login Credentials</h2>";
        
        // Management Users
        echo "<div class='credential-card mgr'>";
        echo "<h3>🟢 Management Portal Users</h3>";
        echo "<p><strong>URL:</strong> <a href='management/' target='_blank'>http://localhost/Jiffy-new/management/</a></p>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Email</th><th>Password</th></tr>";
        foreach ($customUsers as $user) {
            if ($user['type'] == 'Manager') {
                echo "<tr><td>{$user['full_name']}</td><td>{$user['email']}</td><td>{$user['password']}</td></tr>";
            }
        }
        echo "</table>";
        echo "</div>";
        
        // Project Manager Users
        echo "<div class='credential-card proj'>";
        echo "<h3>🔵 Project Portal Users</h3>";
        echo "<p><strong>URL:</strong> <a href='project/' target='_blank'>http://localhost/Jiffy-new/project/</a></p>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Email</th><th>Password</th></tr>";
        foreach ($customUsers as $user) {
            if ($user['type'] == 'Project Manager') {
                echo "<tr><td>{$user['full_name']}</td><td>{$user['email']}</td><td>{$user['password']}</td></tr>";
            }
        }
        echo "</table>";
        echo "</div>";
        
        // Employee Users
        echo "<div class='credential-card emp'>";
        echo "<h3>⚫ Employee Portal Users</h3>";
        echo "<p><strong>URL:</strong> <a href='business/' target='_blank'>http://localhost/Jiffy-new/business/</a></p>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Email</th><th>Password</th><th>Role</th></tr>";
        foreach ($customUsers as $user) {
            if ($user['type'] == 'Employee') {
                echo "<tr><td>{$user['full_name']}</td><td>{$user['email']}</td><td>{$user['password']}</td><td>{$user['user_role']}</td></tr>";
            }
        }
        echo "</table>";
        echo "</div>";
    }
    
} else {
    // Show form
    echo "<div class='info'>";
    echo "<h3>📋 What will be added:</h3>";
    echo "<ul>";
    echo "<li><strong>2 Management Users</strong> (alice.manager@ggs.com, bob.manager@ggs.com) - Password: manager123</li>";
    echo "<li><strong>2 Project Manager Users</strong> (charlie.project@ggs.com, diana.project@ggs.com) - Password: project123</li>";
    echo "<li><strong>10 Employee Users</strong> (emily.developer@ggs.com, frank.designer@ggs.com, etc.) - Password: emp123</li>";
    echo "</ul>";
    echo "<p>All emails follow the @ggs.com domain pattern as requested.</p>";
    echo "</div>";
    
    echo "<form method='POST'>";
    echo "<button type='submit' name='add_credentials' class='btn btn-success'>🚀 Add All Demo Credentials</button>";
    echo "</form>";
}

echo "<br><div class='info'>";
echo "<h3>🔗 Quick Links</h3>";
echo "<a href='.' class='btn'>🏠 Home</a>";
echo "<a href='admin/' class='btn'>👑 Admin Panel</a>";
echo "<a href='management/' class='btn'>💼 Management</a>";
echo "<a href='project/' class='btn'>📊 Project Portal</a>";
echo "<a href='business/' class='btn'>👥 Employee Portal</a>";
echo "</div>";

echo "</body></html>";
?>