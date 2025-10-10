<?php
include 'include/config.php';

echo "========================================\n";
echo "   JIFFY - Quick User Creation Tool\n";
echo "========================================\n\n";

// Pre-filled user details for quick creation
$testUser = [
    'full_name' => 'Karan Manager',
    'email' => 'karan@jiffy.com',
    'password' => 'karan123',
    'user_role' => 'Senior Manager',
    'phone' => '9876543210',
    'department' => 1,
    'access_level' => 'management'
];

echo "Creating user with following details:\n";
echo "--------------------------------------\n";
echo "Name:     {$testUser['full_name']}\n";
echo "Email:    {$testUser['email']}\n";
echo "Password: {$testUser['password']}\n";
echo "Role:     {$testUser['user_role']}\n";
echo "Access:   Management Portal\n\n";

// Generate employee ID
$empid = 'EMP-' . strtoupper(substr($testUser['full_name'], 0, 3)) . '-' . date('His');

// Hash password
$hashedPassword = md5($testUser['password']);

// Check if user already exists
$checkQuery = "SELECT id FROM employee WHERE email = '{$testUser['email']}'";
$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    echo "❌ ERROR: User with email {$testUser['email']} already exists!\n";
    echo "\nExisting user details:\n";
    $existing = mysqli_fetch_assoc($checkResult);
    echo "User ID: {$existing['id']}\n\n";
    echo "You can:\n";
    echo "1. Use existing credentials to login\n";
    echo "2. View all credentials: http://localhost/Jiffy-new/get_credentials.php\n";
    echo "3. Create user with different email: http://localhost/Jiffy-new/create_new_user.php\n";
    exit;
}

// Determine access panels
$allpannel = 'Management,Project Manager,Employee';

// Insert user
$insertQuery = "INSERT INTO employee (
    empid, full_name, email, password, user_type, user_role,
    phone_number, dob, doj, department, address, Allpannel,
    active, Company_id, status, created_date, profile_picture
) VALUES (
    '$empid',
    '{$testUser['full_name']}',
    '{$testUser['email']}',
    '$hashedPassword',
    'Employee',
    '{$testUser['user_role']}',
    '{$testUser['phone']}',
    '1990-01-01',
    '" . date('Y-m-d') . "',
    {$testUser['department']},
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
    
    echo "✅ SUCCESS! User created successfully!\n\n";
    echo "========================================\n";
    echo "       NEW USER CREDENTIALS\n";
    echo "========================================\n\n";
    echo "User ID:      $user_id\n";
    echo "Employee ID:  $empid\n";
    echo "Email:        {$testUser['email']}\n";
    echo "Password:     {$testUser['password']}\n";
    echo "Access Level: Management Portal\n\n";
    echo "========================================\n";
    echo "       LOGIN INFORMATION\n";
    echo "========================================\n\n";
    echo "Management Portal:\n";
    echo "URL: http://localhost/Jiffy-new/management/\n\n";
    echo "To login:\n";
    echo "1. Visit: http://localhost/Jiffy-new/management/\n";
    echo "2. Enter Email: {$testUser['email']}\n";
    echo "3. Enter Password: {$testUser['password']}\n\n";
    echo "========================================\n\n";
} else {
    echo "❌ ERROR: Failed to create user!\n";
    echo "Error: " . mysqli_error($conn) . "\n\n";
}

mysqli_close($conn);
?>
