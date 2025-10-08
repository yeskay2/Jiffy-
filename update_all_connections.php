<?php
/**
 * Update All Database Connections Script
 * This will find and update all remaining database connections in your project
 */

set_time_limit(120);

$rootDir = __DIR__;
$oldConnection = 'mysqli_connect("localhost", "snh6_jiffy2", "mFbmeGA7HhkYqMt7AVxt", "snh6_jiffy2")';
$newConnection = 'mysqli_connect("localhost", "root", "", "pms")';

echo "<h2>🔄 Database Connection Update Process</h2>";
echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;'>";

// Function to scan directory recursively
function scanDirectory($dir, $extensions = ['php']) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
            if (in_array($ext, $extensions)) {
                $files[] = $file->getRealPath();
            }
        }
    }
    
    return $files;
}

// Function to update file content
function updateFileContent($filePath, $oldPattern, $newPattern) {
    $content = file_get_contents($filePath);
    if ($content === false) {
        return false;
    }
    
    $originalContent = $content;
    
    // Replace the old connection string
    $content = str_replace($oldPattern, $newPattern, $content);
    
    // Check if any changes were made
    if ($content !== $originalContent) {
        if (file_put_contents($filePath, $content) !== false) {
            return true;
        }
    }
    
    return false;
}

try {
    echo "<p>🔍 Scanning for PHP files with old database connections...</p>";
    
    // Get all PHP files
    $phpFiles = scanDirectory($rootDir, ['php']);
    
    echo "<p>📁 Found " . count($phpFiles) . " PHP files to check</p>";
    
    $updatedFiles = [];
    $alreadyUpdated = [];
    $noChangesNeeded = [];
    
    echo "<div style='max-height: 300px; overflow-y: auto; background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 5px;'>";
    
    foreach ($phpFiles as $file) {
        // Skip update scripts
        if (strpos(basename($file), 'update_') === 0 || strpos(basename($file), 'test_') === 0 || 
            strpos(basename($file), 'import_') === 0 || strpos(basename($file), 'cleanup') === 0) {
            continue;
        }
        
        $relativePath = str_replace($rootDir . DIRECTORY_SEPARATOR, '', $file);
        
        // Check if file contains the old connection string
        $content = file_get_contents($file);
        
        if (strpos($content, 'mFbmeGA7HhkYqMt7AVxt') !== false) {
            // File still has old credentials
            if (updateFileContent($file, $oldConnection, $newConnection)) {
                $updatedFiles[] = $relativePath;
                echo "<small style='color: green;'>✓ Updated: $relativePath</small><br>";
            } else {
                echo "<small style='color: orange;'>⚠ Could not update: $relativePath</small><br>";
            }
        } elseif (strpos($content, 'mysqli_connect("localhost", "root", "", "snh6_jiffy2")') !== false) {
            // File already has correct local connection
            $alreadyUpdated[] = $relativePath;
            echo "<small style='color: blue;'>✓ Already updated: $relativePath</small><br>";
        } else {
            // No database connection found
            $noChangesNeeded[] = $relativePath;
            echo "<small style='color: #666;'>- No DB connection: $relativePath</small><br>";
        }
        
        // Flush output for real-time progress
        if (ob_get_level()) {
            ob_flush();
        }
        flush();
    }
    
    echo "</div>";
    
    echo "<div style='margin: 20px 0;'>";
    echo "<h3>📊 Update Summary</h3>";
    echo "<ul>";
    echo "<li><strong>Files updated this run:</strong> " . count($updatedFiles) . "</li>";
    echo "<li><strong>Files already correct:</strong> " . count($alreadyUpdated) . "</li>";
    echo "<li><strong>Files with no DB connection:</strong> " . count($noChangesNeeded) . "</li>";
    echo "<li><strong>Total files processed:</strong> " . count($phpFiles) . "</li>";
    echo "</ul>";
    echo "</div>";
    
    // Show updated files
    if (!empty($updatedFiles)) {
        echo "<div style='background: #e8f5e8; padding: 15px; border: 1px solid #4caf50; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4 style='color: #2e7d2e; margin: 0 0 10px 0;'>📝 Files Updated This Run:</h4>";
        echo "<ul style='color: #2e7d2e; margin: 0;'>";
        foreach ($updatedFiles as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
    // Show already updated files
    if (!empty($alreadyUpdated)) {
        echo "<div style='background: #cce7ff; padding: 15px; border: 1px solid #007bff; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4 style='color: #004085; margin: 0 0 10px 0;'>✅ Files Already Using Local Database:</h4>";
        echo "<ul style='color: #004085; margin: 0;'>";
        foreach ($alreadyUpdated as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
    // Test the database connection
    echo "<div style='margin: 20px 0;'>";
    echo "<h3>🧪 Testing Database Connection</h3>";
    
    $testConn = @mysqli_connect('localhost', 'root', '', 'snh6_jiffy2');
    if ($testConn) {
        echo "<p style='color: green;'>✅ Successfully connected to local database 'snh6_jiffy2'</p>";
        
        // Test a simple query
        $result = @mysqli_query($testConn, "SHOW TABLES");
        if ($result) {
            $tableCount = mysqli_num_rows($result);
            echo "<p style='color: green;'>✅ Database contains $tableCount tables</p>";
            
            // Show some key tables
            echo "<p style='color: green;'><strong>Key tables found:</strong></p>";
            echo "<ul style='color: green; columns: 3;'>";
            while ($row = mysqli_fetch_array($result)) {
                $tableName = $row[0];
                if (in_array($tableName, ['employee', 'attendance', 'announcements', 'department', 'schedules', 'login_data'])) {
                    echo "<li><strong>$tableName</strong></li>";
                } else {
                    echo "<li>$tableName</li>";
                }
            }
            echo "</ul>";
        }
        
        mysqli_close($testConn);
    } else {
        echo "<p style='color: red;'>❌ Failed to connect to local database. Error: " . mysqli_connect_error() . "</p>";
        echo "<p style='color: orange;'>Make sure MySQL is running in XAMPP and the database 'snh6_jiffy2' exists.</p>";
    }
    echo "</div>";
    
    echo "<div style='background: #d4edda; padding: 20px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3 style='color: #155724; margin: 0 0 15px 0;'>🎉 Database Connection Update Complete!</h3>";
    echo "<p style='color: #155724; margin: 0 0 10px 0;'>Your Jiffy application should now be connected to your local MySQL database.</p>";
    echo "<p style='color: #155724; margin: 0;'><strong>What to do next:</strong></p>";
    echo "<ol style='color: #155724; margin: 10px 0 0 20px;'>";
    echo "<li>Test your application by visiting the homepage</li>";
    echo "<li>Try the admin login or employee registration</li>";
    echo "<li>Check if data is loading correctly</li>";
    echo "<li>Delete this update script for security</li>";
    echo "</ol>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3 style='color: #721c24; margin: 0;'>❌ Update Failed</h3>";
    echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Error: " . $e->getMessage() . "</p>";
    echo "</div>";
}

echo "</div>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Update Complete</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .btn { 
            display: inline-block; padding: 12px 24px; background-color: #007bff; 
            color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px;
            transition: background-color 0.3s;
        }
        .btn:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; }
        .btn-success:hover { background-color: #1e7e34; }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="text-align: center; margin: 30px 0;">
            <a href="index.php" class="btn btn-success">🏠 Test Homepage</a>
            <a href="admin/" class="btn">👨‍💼 Admin Panel</a>
            <a href="login.php" class="btn">👤 Employee Login</a>
            <a href="employeeregister.php?companyid=MQ==" class="btn">👥 Register Employee</a>
        </div>
        
        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
            <h3>🚀 Your Jiffy HR System is Now Ready!</h3>
            <p>The frontend and backend are now connected to your local MySQL database.</p>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <h4>📋 Connection Details</h4>
                <table style="margin: 0 auto; text-align: left;">
                    <tr><td><strong>Host:</strong></td><td style="padding-left: 20px;">localhost</td></tr>
                    <tr><td><strong>Database:</strong></td><td style="padding-left: 20px;">snh6_jiffy2</td></tr>
                    <tr><td><strong>Username:</strong></td><td style="padding-left: 20px;">root</td></tr>
                    <tr><td><strong>Password:</strong></td><td style="padding-left: 20px;">(empty)</td></tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>