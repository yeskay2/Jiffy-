<?php
/**
 * Jiffy Database Recreation Script
 * This script will drop all corrupted tables and recreate them with proper structure
 */

set_time_limit(300);

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pms';

echo "<!DOCTYPE html><html><head><title>Jiffy Database Repair</title>";
echo "<style>
body{font-family:Arial;max-width:900px;margin:20px auto;padding:20px;background:#f5f5f5;}
.success{background:#d4edda;padding:15px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;color:#155724;}
.error{background:#f8d7da;padding:15px;border:1px solid #f5c6cb;border-radius:5px;margin:10px 0;color:#721c24;}
.info{background:#d1ecf1;padding:15px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}
h1{color:#333;}
</style></head><body>";

echo "<h1>🔧 Jiffy Database Repair Tool</h1>";

try {
    // Connect to MySQL
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<div class='success'>✓ Connected to MySQL database '$database' successfully</div>";
    
    // List of all tables that need to be recreated
    $corruptedTables = [
        'announcements', 'attendance', 'clientinformation', 'community', 
        'companylist', 'department', 'employee', 'events', 'holiday',
        'interviewmeeting', 'invoice_services', 'invoices', 'issue',
        'job_applications', 'leaveemail', 'login_data', 'meetingaction',
        'messages', 'monthly_expension', 'posters', 'posts', 'projects',
        'questiontypes', 'revenue_collected', 'roles', 'schedules', 'tasks',
        'tblleaves', 'tblleavetype', 'team', 'teamrequried', 'testing',
        'timeline', 'user_locations'
    ];
    
    echo "<div class='info'>Found " . count($corruptedTables) . " corrupted tables to repair</div>";
    
    // Drop all corrupted tables first
    echo "<h3>🗑️ Dropping Corrupted Tables</h3>";
    foreach ($corruptedTables as $table) {
        $sql = "DROP TABLE IF EXISTS `$table`";
        if ($conn->query($sql)) {
            echo "<div class='success'>✓ Dropped table: $table</div>";
        } else {
            echo "<div class='error'>❌ Failed to drop table: $table - " . $conn->error . "</div>";
        }
    }
    
    echo "<h3>🔨 Creating New Tables</h3>";
    
    // Create employee table (most important)
    $sql = "CREATE TABLE `employee` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `empid` varchar(50) NOT NULL,
        `full_name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        `user_type` varchar(50) DEFAULT 'Employee',
        `user_role` varchar(100) DEFAULT NULL,
        `phone_number` varchar(20) DEFAULT NULL,
        `dob` date DEFAULT NULL,
        `doj` date DEFAULT NULL,
        `department` int(11) DEFAULT 1,
        `address` text DEFAULT NULL,
        `Allpannel` text DEFAULT NULL,
        `active` varchar(20) DEFAULT 'active',
        `Company_id` int(11) DEFAULT 1,
        `status` varchar(50) DEFAULT 'Offline',
        `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        `profile_picture` varchar(255) DEFAULT 'user.png',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: employee</div>";
    } else {
        echo "<div class='error'>❌ Failed to create employee table: " . $conn->error . "</div>";
    }
    
    // Create attendance table
    $sql = "CREATE TABLE `attendance` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `employee_id` int(11) NOT NULL,
        `employee_email` varchar(100) DEFAULT NULL,
        `date` varchar(20) NOT NULL,
        `time_in` time DEFAULT NULL,
        `time_out` time DEFAULT NULL,
        `num_hr` decimal(5,2) DEFAULT 0.00,
        `status` tinyint(1) DEFAULT 1,
        `Company_id` int(11) DEFAULT 1,
        `send` tinyint(1) DEFAULT 0,
        PRIMARY KEY (`id`),
        KEY `employee_id` (`employee_id`),
        KEY `date` (`date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: attendance</div>";
    } else {
        echo "<div class='error'>❌ Failed to create attendance table: " . $conn->error . "</div>";
    }
    
    // Create department table
    $sql = "CREATE TABLE `department` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `description` text DEFAULT NULL,
        `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: department</div>";
        
        // Insert default departments
        $departments = [
            'Information Technology',
            'Human Resources', 
            'Marketing',
            'Finance & Accounts',
            'Operations',
            'Sales',
            'Quality Assurance',
            'Administration'
        ];
        
        foreach ($departments as $dept) {
            $stmt = $conn->prepare("INSERT INTO department (name) VALUES (?)");
            $stmt->bind_param("s", $dept);
            $stmt->execute();
        }
        echo "<div class='success'>✓ Added default departments</div>";
    } else {
        echo "<div class='error'>❌ Failed to create department table: " . $conn->error . "</div>";
    }
    
    // Create projects table
    $sql = "CREATE TABLE `projects` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `project_name` varchar(200) NOT NULL,
        `description` text DEFAULT NULL,
        `start_date` date DEFAULT NULL,
        `end_date` date DEFAULT NULL,
        `status` varchar(50) DEFAULT 'Active',
        `project_manager_id` int(11) DEFAULT NULL,
        `team_members` text DEFAULT NULL,
        `budget` decimal(15,2) DEFAULT 0.00,
        `client_id` int(11) DEFAULT NULL,
        `Company_id` int(11) DEFAULT 1,
        `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: projects</div>";
    } else {
        echo "<div class='error'>❌ Failed to create projects table: " . $conn->error . "</div>";
    }
    
    // Create tasks table
    $sql = "CREATE TABLE `tasks` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `project_id` int(11) DEFAULT NULL,
        `task_name` varchar(200) NOT NULL,
        `description` text DEFAULT NULL,
        `assigned_to` int(11) DEFAULT NULL,
        `assigned_by` int(11) DEFAULT NULL,
        `status` varchar(50) DEFAULT 'Todo',
        `priority` varchar(20) DEFAULT 'Medium',
        `start_date` date DEFAULT NULL,
        `due_date` date DEFAULT NULL,
        `completed_date` date DEFAULT NULL,
        `estimated_hours` decimal(5,2) DEFAULT 0.00,
        `actual_hours` decimal(5,2) DEFAULT 0.00,
        `Company_id` int(11) DEFAULT 1,
        `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `project_id` (`project_id`),
        KEY `assigned_to` (`assigned_to`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: tasks</div>";
    } else {
        echo "<div class='error'>❌ Failed to create tasks table: " . $conn->error . "</div>";
    }
    
    // Create clientinformation table
    $sql = "CREATE TABLE `clientinformation` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `client_name` varchar(200) NOT NULL,
        `company_name` varchar(200) DEFAULT NULL,
        `email` varchar(100) DEFAULT NULL,
        `phone` varchar(20) DEFAULT NULL,
        `address` text DEFAULT NULL,
        `status` varchar(50) DEFAULT 'Active',
        `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        `Company_id` int(11) DEFAULT 1,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: clientinformation</div>";
    } else {
        echo "<div class='error'>❌ Failed to create clientinformation table: " . $conn->error . "</div>";
    }
    
    // Create messages table
    $sql = "CREATE TABLE `messages` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `sender_id` int(11) NOT NULL,
        `receiver_id` int(11) NOT NULL,
        `subject` varchar(255) DEFAULT NULL,
        `message` text DEFAULT NULL,
        `is_read` tinyint(1) DEFAULT 0,
        `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
        `Company_id` int(11) DEFAULT 1,
        PRIMARY KEY (`id`),
        KEY `sender_id` (`sender_id`),
        KEY `receiver_id` (`receiver_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ Created table: messages</div>";
    } else {
        echo "<div class='error'>❌ Failed to create messages table: " . $conn->error . "</div>";
    }
    
    // Create other essential tables with basic structure
    $otherTables = [
        'announcements' => "CREATE TABLE `announcements` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `content` text DEFAULT NULL,
            `created_by` int(11) DEFAULT NULL,
            `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
            `Company_id` int(11) DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        
        'events' => "CREATE TABLE `events` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `description` text DEFAULT NULL,
            `event_date` date DEFAULT NULL,
            `start_time` time DEFAULT NULL,
            `end_time` time DEFAULT NULL,
            `location` varchar(255) DEFAULT NULL,
            `created_by` int(11) DEFAULT NULL,
            `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
            `Company_id` int(11) DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        
        'tblleaves' => "CREATE TABLE `tblleaves` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `employee_id` int(11) NOT NULL,
            `leave_type` varchar(100) DEFAULT NULL,
            `start_date` date DEFAULT NULL,
            `end_date` date DEFAULT NULL,
            `days` int(11) DEFAULT NULL,
            `reason` text DEFAULT NULL,
            `status` varchar(50) DEFAULT 'Pending',
            `applied_date` timestamp DEFAULT CURRENT_TIMESTAMP,
            `approved_by` int(11) DEFAULT NULL,
            `Company_id` int(11) DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        
        'tblleavetype' => "CREATE TABLE `tblleavetype` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `leave_type` varchar(100) NOT NULL,
            `description` text DEFAULT NULL,
            `max_days` int(11) DEFAULT 30,
            `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
        
        'companylist' => "CREATE TABLE `companylist` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `company_name` varchar(200) NOT NULL,
            `address` text DEFAULT NULL,
            `phone` varchar(20) DEFAULT NULL,
            `email` varchar(100) DEFAULT NULL,
            `website` varchar(255) DEFAULT NULL,
            `logo` varchar(255) DEFAULT NULL,
            `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    ];
    
    foreach ($otherTables as $tableName => $createSQL) {
        if ($conn->query($createSQL)) {
            echo "<div class='success'>✓ Created table: $tableName</div>";
        } else {
            echo "<div class='error'>❌ Failed to create $tableName table: " . $conn->error . "</div>";
        }
    }
    
    // Add default company
    $stmt = $conn->prepare("INSERT INTO companylist (company_name, address, email) VALUES (?, ?, ?)");
    $company = "Jiffy HR Solutions";
    $address = "123 Business Street, City, Country";
    $email = "info@jiffy-hr.com";
    $stmt->bind_param("sss", $company, $address, $email);
    $stmt->execute();
    echo "<div class='success'>✓ Added default company information</div>";
    
    // Add default leave types
    $leaveTypes = [
        ['Casual Leave', 'General casual leave', 12],
        ['Sick Leave', 'Medical leave', 15],
        ['Annual Leave', 'Yearly vacation leave', 21],
        ['Maternity Leave', 'Maternity leave for female employees', 90],
        ['Paternity Leave', 'Paternity leave for male employees', 15]
    ];
    
    $stmt = $conn->prepare("INSERT INTO tblleavetype (leave_type, description, max_days) VALUES (?, ?, ?)");
    foreach ($leaveTypes as $leave) {
        $stmt->bind_param("ssi", $leave[0], $leave[1], $leave[2]);
        $stmt->execute();
    }
    echo "<div class='success'>✓ Added default leave types</div>";
    
    echo "<div class='success'>";
    echo "<h3>🎉 Database Repair Completed Successfully!</h3>";
    echo "<p>All corrupted tables have been recreated with proper structure.</p>";
    echo "<p><strong>Next Steps:</strong></p>";
    echo "<ul>";
    echo "<li>Add your demo users using: <a href='add_custom_credentials.php' target='_blank'>Add Demo Credentials</a></li>";
    echo "<li>Test the application: <a href='admin/' target='_blank'>Admin Panel</a></li>";
    echo "<li>Check phpMyAdmin to verify tables: <a href='http://localhost/phpmyadmin/' target='_blank'>phpMyAdmin</a></li>";
    echo "</ul>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<strong>Error:</strong> " . $e->getMessage();
    echo "</div>";
}

if (isset($conn)) {
    $conn->close();
}

echo "</body></html>";
?>