<?php
/**
 * GGS User Setup Script
 * Creates all required users for the GGS organization
 * 
 * Usage: Run this file once to populate the database with all required users
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "include/config.php";

class GGSUserSetup {
    private $conn;
    private $company_id = '1'; // Default company ID
    
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
    
    /**
     * Generate password based on email prefix
     */
    private function generatePassword($email) {
        $prefix = explode('@', $email)[0];
        return $prefix . '@123';
    }
    
    /**
     * Get MD5 hash of password
     */
    private function hashPassword($password) {
        return md5($password);
    }
    
    /**
     * Insert user into database
     */
    private function insertUser($userData) {
        // Check if user already exists
        $checkQuery = "SELECT id FROM employee WHERE email = ?";
        $checkStmt = mysqli_prepare($this->conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "s", $userData['email']);
        mysqli_stmt_execute($checkStmt);
        $result = mysqli_stmt_get_result($checkStmt);
        
        if (mysqli_num_rows($result) > 0) {
            return "User {$userData['email']} already exists - skipped";
        }
        
        // Generate employee ID
        $empid = $this->generateEmpId($userData['user_role']);
        
        // Insert new user
        $query = "INSERT INTO employee (
            empid, full_name, email, password, user_type, user_role, 
            department, address, salary, status, active, 
            created_date, Company_id, Allpannel
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        
        if (!$stmt) {
            return "Error preparing statement: " . mysqli_error($this->conn);
        }
        
        mysqli_stmt_bind_param($stmt, "ssssssissssss", 
            $empid,
            $userData['full_name'],
            $userData['email'], 
            $userData['password_hash'],
            $userData['user_type'],
            $userData['user_role'],
            $userData['department'],
            $userData['address'],
            $userData['salary'],
            $userData['status'],
            $userData['active'],
            $this->company_id,
            $userData['allpannel']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return "✅ Created: {$userData['full_name']} ({$userData['email']})";
        } else {
            return "❌ Error creating {$userData['email']}: " . mysqli_stmt_error($stmt);
        }
    }
    
    /**
     * Generate employee ID based on role
     */
    private function generateEmpId($role) {
        $prefix = '';
        switch(strtolower($role)) {
            case 'admin':
                $prefix = 'ADM';
                break;
            case 'management':
                $prefix = 'MGR';
                break;
            case 'hr specialist':
                $prefix = 'HR';
                break;
            case 'accountant':
                $prefix = 'FIN';
                break;
            default:
                $prefix = 'EMP';
        }
        
        // Get next number for this prefix
        $query = "SELECT MAX(CAST(SUBSTRING(empid, 4) AS UNSIGNED)) as max_num FROM employee WHERE empid LIKE '{$prefix}%'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        $next_num = ($row['max_num'] ?? 0) + 1;
        
        return $prefix . str_pad($next_num, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Define all users to be created
     */
    public function getUserDefinitions() {
        $users = [];
        
        // Admin Users (2)
        for ($i = 1; $i <= 2; $i++) {
            $email = "admin{$i}@ggs.com";
            $users[] = [
                'full_name' => "Admin User {$i}",
                'email' => $email,
                'password' => $this->generatePassword($email),
                'password_hash' => $this->hashPassword($this->generatePassword($email)),
                'user_type' => 'Employee',
                'user_role' => 'admin',
                'department' => 1,
                'address' => 'GGS Office',
                'salary' => '50000',
                'status' => 'Online',
                'active' => 'active',
                'allpannel' => 'Admin'
            ];
        }
        
        // Employee Users (20)
        for ($i = 1; $i <= 20; $i++) {
            $email = "emp{$i}@ggs.com";
            $users[] = [
                'full_name' => "Employee {$i}",
                'email' => $email,
                'password' => $this->generatePassword($email),
                'password_hash' => $this->hashPassword($this->generatePassword($email)),
                'user_type' => 'Employee',
                'user_role' => 'Software Developer',
                'department' => 2,
                'address' => 'GGS Office',
                'salary' => '30000',
                'status' => 'Online',
                'active' => 'active',
                'allpannel' => 'Employee'
            ];
        }
        
        // Manager Users (6)
        for ($i = 1; $i <= 6; $i++) {
            $email = "manager{$i}@ggs.com";
            $users[] = [
                'full_name' => "Manager {$i}",
                'email' => $email,
                'password' => $this->generatePassword($email),
                'password_hash' => $this->hashPassword($this->generatePassword($email)),
                'user_type' => 'Employee',
                'user_role' => 'management',
                'department' => 3,
                'address' => 'GGS Office',
                'salary' => '40000',
                'status' => 'Online',
                'active' => 'active',
                'allpannel' => 'Employee'
            ];
        }
        
        // HR Users (2)
        for ($i = 1; $i <= 2; $i++) {
            $email = "hr{$i}@ggs.com";
            $users[] = [
                'full_name' => "HR Specialist {$i}",
                'email' => $email,
                'password' => $this->generatePassword($email),
                'password_hash' => $this->hashPassword($this->generatePassword($email)),
                'user_type' => 'Employee',
                'user_role' => 'HR Specialist',
                'department' => 4,
                'address' => 'GGS Office',
                'salary' => '35000',
                'status' => 'Online',
                'active' => 'active',
                'allpannel' => 'Employee'
            ];
        }
        
        // Finance Users (4)
        for ($i = 1; $i <= 4; $i++) {
            $email = "finance{$i}@ggs.com";
            $users[] = [
                'full_name' => "Finance Officer {$i}",
                'email' => $email,
                'password' => $this->generatePassword($email),
                'password_hash' => $this->hashPassword($this->generatePassword($email)),
                'user_type' => 'Employee',
                'user_role' => 'Accountant',
                'department' => 5,
                'address' => 'GGS Office',
                'salary' => '32000',
                'status' => 'Online',
                'active' => 'active',
                'allpannel' => 'Employee'
            ];
        }
        
        return $users;
    }
    
    /**
     * Create all users
     */
    public function createAllUsers() {
        $users = $this->getUserDefinitions();
        $results = [];
        
        echo "<h2>🚀 GGS User Setup Process Started</h2>";
        echo "<div style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
        
        foreach ($users as $user) {
            $result = $this->insertUser($user);
            $results[] = $result;
            echo $result . "<br>";
        }
        
        echo "</div>";
        echo "<h3>📊 Summary:</h3>";
        echo "<p><strong>Total Users Processed:</strong> " . count($users) . "</p>";
        
        return $results;
    }
    
    /**
     * Display user credentials for reference
     */
    public function displayCredentials() {
        echo "<h2>📋 GGS User Credentials Reference</h2>";
        echo "<div style='font-family: monospace; background: #e8f5e8; padding: 20px; margin: 20px 0;'>";
        
        $users = $this->getUserDefinitions();
        
        // Group by role
        $roleGroups = [];
        foreach ($users as $user) {
            $roleGroups[$user['user_role']][] = $user;
        }
        
        foreach ($roleGroups as $role => $roleUsers) {
            echo "<h3>🎯 " . strtoupper($role) . " ACCESS:</h3>";
            foreach ($roleUsers as $user) {
                echo "Email: <strong>{$user['email']}</strong> | Password: <strong>{$user['password']}</strong><br>";
            }
            echo "<br>";
        }
        
        echo "</div>";
        
        echo "<h3>🔗 Access URLs:</h3>";
        echo "<ul>";
        echo "<li><strong>Admin:</strong> http://localhost/Jiffy-new/admin/</li>";
        echo "<li><strong>Management:</strong> http://localhost/Jiffy-new/management/</li>";
        echo "<li><strong>Employee:</strong> http://localhost/Jiffy-new/business/</li>";
        echo "<li><strong>HR:</strong> http://localhost/Jiffy-new/business/ (with HR role)</li>";
        echo "<li><strong>Finance:</strong> http://localhost/Jiffy-new/Accounts/</li>";
        echo "</ul>";
    }
}

// Execute the setup
try {
    echo "<!DOCTYPE html><html><head><title>GGS User Setup</title>";
    echo "<style>body{font-family:Arial;max-width:1000px;margin:20px auto;padding:20px;}</style>";
    echo "</head><body>";
    
    $setup = new GGSUserSetup($conn);
    
    // Check if we should run the setup
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'create') {
            $setup->createAllUsers();
            echo "<hr>";
        }
    }
    
    // Always display credentials
    $setup->displayCredentials();
    
    if (!isset($_GET['action'])) {
        echo "<h3>⚠️ Ready to Create Users</h3>";
        echo "<p><a href='?action=create' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>🚀 Create All GGS Users</a></p>";
        echo "<p><em>Click the button above to create all 34 user accounts</em></p>";
    }
    
    echo "</body></html>";
    
} catch (Exception $e) {
    echo "<h2>❌ Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>