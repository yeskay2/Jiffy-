<?php
include 'include/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
    $access_level = mysqli_real_escape_string($conn, $_POST['access_level']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $department = intval($_POST['department']);
    
    // Generate employee ID
    $empid = 'EMP-' . strtoupper(substr($full_name, 0, 3)) . '-' . date('His');
    
    // Hash password
    $hashedPassword = md5($password);
    
    // Check if email already exists
    $checkQuery = "SELECT id FROM employee WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        $error_message = "❌ Email already exists! Please use a different email.";
    } else {
        // Determine access panels based on selection
        $allpannel = '';
        switch($access_level) {
            case 'admin':
                $allpannel = 'Admin,Management,Project Manager,Employee,All';
                break;
            case 'management':
                $allpannel = 'Management,Project Manager,Employee';
                break;
            case 'project_manager':
                $allpannel = 'Project Manager,Employee';
                break;
            case 'employee':
                $allpannel = 'Employee';
                break;
        }
        
        // Insert user
        $insertQuery = "INSERT INTO employee (
            empid, full_name, email, password, user_type, user_role,
            phone_number, dob, doj, department, address, Allpannel,
            active, Company_id, status, created_date, profile_picture
        ) VALUES (
            '$empid',
            '$full_name',
            '$email',
            '$hashedPassword',
            'Employee',
            '$user_role',
            '$phone',
            '1990-01-01',
            '" . date('Y-m-d') . "',
            $department,
            'Default Address',
            '$allpannel',
            'active',
            '1',
            'Offline',
            NOW(),
            'user.png'
        )";
        
        if (mysqli_query($conn, $insertQuery)) {
            $user_id = mysqli_insert_id($conn);
            $success_message = "✅ User created successfully!";
            $new_user_details = [
                'id' => $user_id,
                'empid' => $empid,
                'email' => $email,
                'password' => $password,
                'access_level' => $access_level
            ];
        } else {
            $error_message = "❌ Failed to create user: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User - Jiffy</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .success {
            background: #d4edda;
            border: 2px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .error {
            background: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .credential-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #28a745;
        }
        .credential-box h3 {
            margin-bottom: 15px;
            color: #28a745;
        }
        .credential-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .credential-item:last-child {
            border-bottom: none;
        }
        .links {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
        }
        .links a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .links a:hover {
            background: #5a6268;
        }
        .access-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }
        .access-option {
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .access-option:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        .access-option input[type="radio"] {
            width: auto;
            margin-right: 10px;
        }
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👤 Create New User</h1>
        <p class="subtitle">Add a new user to the Jiffy system</p>

        <?php if (isset($success_message)): ?>
            <div class="success">
                <h3><?php echo $success_message; ?></h3>
                <div class="credential-box">
                    <h3>📋 New User Credentials:</h3>
                    <div class="credential-item">
                        <strong>Employee ID:</strong>
                        <span><?php echo $new_user_details['empid']; ?></span>
                    </div>
                    <div class="credential-item">
                        <strong>Email:</strong>
                        <span><?php echo $new_user_details['email']; ?></span>
                    </div>
                    <div class="credential-item">
                        <strong>Password:</strong>
                        <span style="color: #dc3545; font-weight: bold;"><?php echo $new_user_details['password']; ?></span>
                    </div>
                    <div class="credential-item">
                        <strong>User ID:</strong>
                        <span><?php echo $new_user_details['id']; ?></span>
                    </div>
                    <div class="credential-item">
                        <strong>Access Level:</strong>
                        <span><?php echo ucfirst(str_replace('_', ' ', $new_user_details['access_level'])); ?></span>
                    </div>
                </div>
                <p style="margin-top: 15px;">
                    <strong>Login URL based on access level:</strong><br>
                    <?php
                    switch($new_user_details['access_level']) {
                        case 'admin':
                            echo '<a href="admin/" style="color: #155724;">Admin Panel: http://localhost/Jiffy-new/admin/</a>';
                            break;
                        case 'management':
                            echo '<a href="management/" style="color: #155724;">Management Portal: http://localhost/Jiffy-new/management/</a>';
                            break;
                        case 'project_manager':
                            echo '<a href="project/" style="color: #155724;">Project Manager: http://localhost/Jiffy-new/project/</a>';
                            break;
                        case 'employee':
                            echo '<a href="business/" style="color: #155724;">Employee Portal: http://localhost/Jiffy-new/business/</a>';
                            break;
                    }
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error">
                <strong><?php echo $error_message; ?></strong>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" placeholder="user@example.com" required>
            </div>

            <div class="form-group">
                <label>Password <span class="required">*</span></label>
                <input type="text" name="password" placeholder="Enter password" required>
            </div>

            <div class="form-group">
                <label>Phone Number <span class="required">*</span></label>
                <input type="tel" name="phone" placeholder="1234567890" required>
            </div>

            <div class="form-group">
                <label>User Role/Designation <span class="required">*</span></label>
                <input type="text" name="user_role" placeholder="e.g., Manager, Developer, HR" required>
            </div>

            <div class="form-group">
                <label>Department <span class="required">*</span></label>
                <select name="department" required>
                    <option value="1">IT Department</option>
                    <option value="2">HR Department</option>
                    <option value="3">Finance Department</option>
                    <option value="4">Operations</option>
                    <option value="5">Marketing</option>
                </select>
            </div>

            <div class="form-group">
                <label>Access Level <span class="required">*</span></label>
                <div class="access-grid">
                    <div class="access-option">
                        <input type="radio" name="access_level" value="admin" id="admin">
                        <label for="admin" style="display: inline; margin: 0;">
                            <strong>🔴 Admin</strong><br>
                            <small>Full system access</small>
                        </label>
                    </div>
                    <div class="access-option">
                        <input type="radio" name="access_level" value="management" id="management" checked>
                        <label for="management" style="display: inline; margin: 0;">
                            <strong>🟣 Management</strong><br>
                            <small>Management + Projects</small>
                        </label>
                    </div>
                    <div class="access-option">
                        <input type="radio" name="access_level" value="project_manager" id="project_manager">
                        <label for="project_manager" style="display: inline; margin: 0;">
                            <strong>🔵 Project Manager</strong><br>
                            <small>Project management</small>
                        </label>
                    </div>
                    <div class="access-option">
                        <input type="radio" name="access_level" value="employee" id="employee">
                        <label for="employee" style="display: inline; margin: 0;">
                            <strong>🟢 Employee</strong><br>
                            <small>Basic access</small>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" name="create_user" class="btn">
                ✨ Create User
            </button>
        </form>

        <div class="links">
            <h3>Quick Links:</h3>
            <a href="get_credentials.php">📋 View All Credentials</a>
            <a href="add_dummy_credentials.php">👥 Add Demo Users</a>
            <a href="test_connection.php">🔌 Test Connection</a>
        </div>
    </div>
</body>
</html>
