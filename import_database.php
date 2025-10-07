<?php
/**
 * Database Import Script for Jiffy HR System
 * This will import your existing snh6_jiffy2.sql database to local MySQL
 */

set_time_limit(300); // 5 minutes timeout for large database import

// Configuration
$host = 'localhost';
$username = 'root';
$password = '';
$newDbName = 'jiffy_local';
$sqlFile = __DIR__ . '/snh6_jiffy2 (1).sql';

echo "<h2>Jiffy Database Import Process</h2>";
echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;'>";

try {
    // Connect to MySQL server
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p>✓ Connected to MySQL server successfully</p>";
    
    // Create new database
    $sql = "CREATE DATABASE IF NOT EXISTS `$newDbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($sql) === TRUE) {
        echo "<p>✓ Database '$newDbName' created successfully</p>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select the new database
    $conn->select_db($newDbName);
    echo "<p>✓ Selected database '$newDbName'</p>";
    
    // Check if SQL file exists
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile<br>Please make sure the 'snh6_jiffy2 (1).sql' file is in the same directory as this script.");
    }
    
    echo "<p>✓ SQL file found: " . basename($sqlFile) . "</p>";
    
    // Read the SQL file content
    $sqlContent = file_get_contents($sqlFile);
    
    if ($sqlContent === false) {
        throw new Exception("Failed to read SQL file");
    }
    
    // Clean up the SQL content - remove comments and split into queries
    $sqlContent = preg_replace('/\/\*.*?\*\//s', '', $sqlContent); // Remove /* */ comments
    $sqlContent = preg_replace('/^--.*$/m', '', $sqlContent);      // Remove -- comments
    $sqlContent = preg_replace('/^\s*$/m', '', $sqlContent);       // Remove empty lines
    
    // Split into individual queries
    $queries = array_filter(array_map('trim', explode(';', $sqlContent)));
    
    echo "<p>Processing " . count($queries) . " SQL statements...</p>";
    echo "<div style='max-height: 200px; overflow-y: auto; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;'>";
    
    $successCount = 0;
    $errorCount = 0;
    
    // Disable foreign key checks temporarily
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    
    foreach ($queries as $index => $query) {
        if (!empty(trim($query))) {
            // Skip USE database commands
            if (stripos($query, 'USE ') === 0) {
                continue;
            }
            
            if ($conn->query($query)) {
                $successCount++;
                echo "<small style='color: green;'>✓ Query " . ($index + 1) . " executed successfully</small><br>";
            } else {
                $errorCount++;
                echo "<small style='color: red;'>✗ Query " . ($index + 1) . " failed: " . htmlspecialchars($conn->error) . "</small><br>";
            }
            
            // Flush output for real-time progress
            if (ob_get_level()) {
                ob_flush();
            }
            flush();
        }
    }
    
    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "</div>";
    echo "<p><strong>Import Summary:</strong></p>";
    echo "<ul>";
    echo "<li>✓ Successfully executed: $successCount queries</li>";
    if ($errorCount > 0) {
        echo "<li>⚠ Failed queries: $errorCount</li>";
    }
    echo "</ul>";
    
    // Verify the import by checking tables
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        $tableCount = $result->num_rows;
        echo "<p>✓ Database contains $tableCount tables after import</p>";
        
        echo "<p><strong>Tables created:</strong></p>";
        echo "<ul style='columns: 2; list-style-type: none;'>";
        while ($row = $result->fetch_array()) {
            echo "<li>• " . $row[0] . "</li>";
        }
        echo "</ul>";
    }
    
    echo "<div style='background: #d4edda; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3 style='color: #155724; margin: 0;'>🎉 Database Import Successful!</h3>";
    echo "<p style='color: #155724; margin: 10px 0 0 0;'>Your Jiffy database has been imported to local MySQL.</p>";
    echo "<p style='color: #155724; margin: 5px 0 0 0;'><strong>Database Details:</strong></p>";
    echo "<ul style='color: #155724; margin: 5px 0 0 20px;'>";
    echo "<li>Host: localhost</li>";
    echo "<li>Database: $newDbName</li>";
    echo "<li>Username: root</li>";
    echo "<li>Password: (empty)</li>";
    echo "</ul>";
    echo "<p style='color: #155724; margin: 10px 0 0 0;'>Now update your PHP files to use the local database connection.</p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3 style='color: #721c24; margin: 0;'>❌ Import Failed</h3>";
    echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Error: " . $e->getMessage() . "</p>";
    echo "<p style='color: #721c24; margin: 10px 0 0 0;'>Please check the error and try again.</p>";
    echo "</div>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

echo "</div>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jiffy Database Import</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .btn { 
            display: inline-block; padding: 10px 20px; background-color: #007bff; 
            color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; 
        }
        .btn:hover { background-color: #0056b3; }
        .next-steps {
            background: white; padding: 20px; border-radius: 5px; margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center; margin: 20px 0;">
            <a href="index.php" class="btn">🏠 Home Page</a>
            <a href="admin/" class="btn">👨‍💼 Admin Panel</a>
            <a href="login.php" class="btn">👤 Employee Login</a>
        </div>
        
        <div class="next-steps">
            <h3>📋 Next Steps</h3>
            <ol>
                <li><strong>Update database connections:</strong> Run the configuration update script</li>
                <li><strong>Test the application:</strong> Try logging in and creating test data</li>
                <li><strong>Security:</strong> Delete this import script after successful setup</li>
            </ol>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="update_connections.php" class="btn" style="background-color: #28a745;">
                    🔄 Update Database Connections
                </a>
            </div>
        </div>
    </div>
</body>
</html>