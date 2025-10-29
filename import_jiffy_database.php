<?php
/**
 * Database Import Script for Jiffy HR System
 * This will import the snh6_jiffy2.sql database to local MySQL as 'pms'
 */

set_time_limit(600); // 10 minutes timeout for large database import

// Configuration
$host = 'localhost';
$username = 'root';
$password = '';
$targetDbName = 'pms';
$sqlFile = __DIR__ . '/pms.sql';

echo "<!DOCTYPE html><html><head><title>Jiffy Database Import</title>";
echo "<style>
body{font-family:Arial;max-width:900px;margin:20px auto;padding:20px;background:#f5f5f5;}
.success{background:#d4edda;padding:15px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;color:#155724;}
.error{background:#f8d7da;padding:15px;border:1px solid #f5c6cb;border-radius:5px;margin:10px 0;color:#721c24;}
.info{background:#d1ecf1;padding:15px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}
.progress{background:#fff3cd;padding:15px;border:1px solid #ffeaa7;border-radius:5px;margin:10px 0;color:#856404;}
h1{color:#333;}
pre{background:#f8f9fa;padding:15px;border-radius:5px;overflow-x:auto;}
</style></head><body>";

echo "<h1>🗄️ Jiffy Database Import Process</h1>";

try {
    // Check if SQL file exists
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile<br>Please make sure the 'pms.sql' file is in the Jiffy-new directory.");
    }
    
    echo "<div class='success'>✓ SQL file found: " . basename($sqlFile) . " (" . number_format(filesize($sqlFile)) . " bytes)</div>";
    
    // Connect to MySQL server
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<div class='success'>✓ Connected to MySQL server successfully</div>";
    
    // Drop existing database if it exists
    $sql = "DROP DATABASE IF EXISTS `$targetDbName`";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='info'>🗑️ Dropped existing '$targetDbName' database if it existed</div>";
    } else {
        throw new Exception("Error dropping database: " . $conn->error);
    }
    
    // Create new database
    $sql = "CREATE DATABASE `$targetDbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>✓ Database '$targetDbName' created successfully</div>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select the new database
    $conn->select_db($targetDbName);
    echo "<div class='success'>✓ Selected database '$targetDbName'</div>";
    
    echo "<div class='progress'>📥 Starting database import process...</div>";
    
    // Read and import the SQL file
    $sqlContent = file_get_contents($sqlFile);
    
    if ($sqlContent === false) {
        throw new Exception("Could not read SQL file content");
    }
    
    // Remove the first line with sandbox mode comment that might cause issues
    $sqlContent = preg_replace('/^\/\*M!999999.*?\*\/\s*/m', '', $sqlContent);
    
    // Split the SQL content into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sqlContent)),
        function($statement) {
            return !empty($statement) && 
                   !preg_match('/^\s*--/', $statement) && 
                   !preg_match('/^\s*\/\*/', $statement);
        }
    );
    
    echo "<div class='info'>📊 Found " . count($statements) . " SQL statements to execute</div>";
    
    $successCount = 0;
    $errorCount = 0;
    $warnings = [];
    
    // Disable foreign key checks temporarily
    $conn->query("SET FOREIGN_KEY_CHECKS=0");
    $conn->query("SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO'");
    
    foreach ($statements as $index => $statement) {
        if (empty(trim($statement))) continue;
        
        // Show progress every 50 statements
        if (($index + 1) % 50 == 0) {
            echo "<div class='progress'>⏳ Processing statement " . ($index + 1) . " of " . count($statements) . "...</div>";
            flush();
        }
        
        $result = $conn->query($statement . ';');
        
        if ($result) {
            $successCount++;
        } else {
            $errorCount++;
            $error = $conn->error;
            
            // Log warnings for certain non-critical errors
            if (strpos($error, 'already exists') !== false || 
                strpos($error, 'Duplicate entry') !== false ||
                strpos($error, "doesn't exist") !== false) {
                $warnings[] = "Statement " . ($index + 1) . ": " . $error;
            } else {
                echo "<div class='error'>❌ Error in statement " . ($index + 1) . ": " . $error . "</div>";
                echo "<pre>" . htmlspecialchars(substr($statement, 0, 200)) . "...</pre>";
            }
        }
    }
    
    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS=1");
    
    echo "<div class='success'>";
    echo "<h3>🎉 Database Import Completed!</h3>";
    echo "<p><strong>Import Summary:</strong></p>";
    echo "<ul>";
    echo "<li>✅ Successful statements: $successCount</li>";
    echo "<li>❌ Failed statements: $errorCount</li>";
    echo "<li>⚠️ Warnings: " . count($warnings) . "</li>";
    echo "</ul>";
    echo "</div>";
    
    // Show warnings if any
    if (!empty($warnings)) {
        echo "<div class='info'>";
        echo "<h4>⚠️ Warnings (non-critical):</h4>";
        echo "<ul>";
        foreach (array_slice($warnings, 0, 10) as $warning) {
            echo "<li>" . htmlspecialchars($warning) . "</li>";
        }
        if (count($warnings) > 10) {
            echo "<li>... and " . (count($warnings) - 10) . " more warnings</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
    // Verify the import
    $result = $conn->query("SHOW TABLES");
    $tableCount = $result->num_rows;
    
    echo "<div class='success'>";
    echo "<h3>📋 Database Verification</h3>";
    echo "<p>✓ Successfully imported <strong>$tableCount tables</strong> into the '$targetDbName' database</p>";
    echo "</div>";
    
    // Show imported tables
    echo "<div class='info'>";
    echo "<h4>📄 Imported Tables:</h4>";
    echo "<div style='columns: 3; column-gap: 20px;'>";
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
        echo "<div>• " . $row[0] . "</div>";
    }
    echo "</div>";
    echo "</div>";
    
    // Check for essential tables
    $essentialTables = ['employee', 'attendance', 'projects', 'tasks', 'department'];
    $missingTables = array_diff($essentialTables, $tables);
    
    if (empty($missingTables)) {
        echo "<div class='success'>✓ All essential tables are present</div>";
    } else {
        echo "<div class='error'>⚠️ Missing essential tables: " . implode(', ', $missingTables) . "</div>";
    }
    
    echo "<div class='success'>";
    echo "<h3>🔗 Next Steps</h3>";
    echo "<ul>";
    echo "<li><a href='admin/' target='_blank'>🔑 Login to Admin Panel</a></li>";
    echo "<li><a href='management/' target='_blank'>💼 Login to Management Portal</a></li>";
    echo "<li><a href='project/' target='_blank'>📊 Login to Project Portal</a></li>";
    echo "<li><a href='business/' target='_blank'>👥 Login to Employee Portal</a></li>";
    echo "<li><a href='http://localhost/phpmyadmin/' target='_blank'>🗄️ Verify in phpMyAdmin</a></li>";
    echo "</ul>";
    echo "<p><strong>Use the existing credentials from your original system to login.</strong></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Import Failed</h3>";
    echo "<strong>Error:</strong> " . $e->getMessage();
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h4>🔧 Troubleshooting:</h4>";
    echo "<ul>";
    echo "<li>Make sure MySQL is running</li>";
    echo "<li>Check if the SQL file is not corrupted</li>";
    echo "<li>Ensure sufficient disk space</li>";
    echo "<li>Try running the script again</li>";
    echo "</ul>";
    echo "</div>";
}

if (isset($conn)) {
    $conn->close();
}

echo "</body></html>";
?>