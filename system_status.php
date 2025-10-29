<?php
/**
 * XAMPP Service Status Checker and Database Import Tool
 * This bypasses phpMyAdmin and provides direct database import
 */

echo "<!DOCTYPE html><html><head><title>XAMPP Recovery & Database Import</title>";
echo "<style>
body{font-family:Arial;max-width:1000px;margin:20px auto;padding:20px;background:#f5f5f5;}
.success{background:#d4edda;padding:15px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;color:#155724;}
.error{background:#f8d7da;padding:15px;border:1px solid #f5c6cb;border-radius:5px;margin:10px 0;color:#721c24;}
.info{background:#d1ecf1;padding:15px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}
.warning{background:#fff3cd;padding:15px;border:1px solid #ffeaa7;border-radius:5px;margin:10px 0;color:#856404;}
.btn{display:inline-block;padding:12px 24px;background:#007bff;color:white;text-decoration:none;border-radius:5px;margin:5px;border:none;cursor:pointer;font-size:14px;}
.btn-success{background:#28a745;}
.btn-danger{background:#dc3545;}
h1{color:#333;}
pre{background:#f8f9fa;padding:15px;border-radius:5px;overflow-x:auto;max-height:300px;}
</style></head><body>";

echo "<h1>🔧 XAMPP Recovery & Database Import Tool</h1>";

// Check MySQL connection
$mysqlWorking = false;
$conn = null;

try {
    $conn = new mysqli('localhost', 'root', '');
    if (!$conn->connect_error) {
        $mysqlWorking = true;
        echo "<div class='success'>✓ MySQL is running and accessible</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ MySQL connection failed: " . $e->getMessage() . "</div>";
}

// Check Apache
$apacheWorking = false;
if (function_exists('apache_get_version')) {
    $apacheWorking = true;
    echo "<div class='success'>✓ Apache is running</div>";
} else {
    echo "<div class='warning'>⚠ Apache status unclear (but PHP is working since you can see this page)</div>";
}

// Check for pms.sql file
$sqlFile = __DIR__ . '/pms.sql';
$fileExists = file_exists($sqlFile);

echo "<div class='info'>";
echo "<h3>📋 System Status</h3>";
echo "<ul>";
echo "<li>MySQL: " . ($mysqlWorking ? "✅ Working" : "❌ Not working") . "</li>";
echo "<li>Apache/PHP: ✅ Working (you can see this page)</li>";
echo "<li>Database file (pms.sql): " . ($fileExists ? "✅ Found" : "❌ Not found") . "</li>";
echo "</ul>";
echo "</div>";

if ($mysqlWorking && $fileExists) {
    // Show import options
    echo "<div class='success'>";
    echo "<h3>🚀 Ready to Import Database!</h3>";
    echo "<p>Everything is ready. You can now import your database.</p>";
    echo "<a href='import_jiffy_database.php' class='btn btn-success'>🗄️ Import Database Now</a>";
    echo "</div>";
    
} elseif ($mysqlWorking && !$fileExists) {
    echo "<div class='warning'>";
    echo "<h3>📁 Missing Database File</h3>";
    echo "<p>MySQL is working but the pms.sql file is missing.</p>";
    echo "<p><strong>Please copy pms.sql to:</strong> <code>C:\\xampp\\htdocs\\Jiffy-new\\pms.sql</code></p>";
    echo "</div>";
    
} elseif (!$mysqlWorking) {
    echo "<div class='error'>";
    echo "<h3>🔧 MySQL Not Running</h3>";
    echo "<p>MySQL needs to be started. Try these solutions:</p>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<h4>🛠️ Solution Options:</h4>";
    echo "<ol>";
    echo "<li><strong>XAMPP Control Panel:</strong> Open C:\\xampp\\xampp-control.exe and start MySQL</li>";
    echo "<li><strong>Command Line:</strong> Run the recovery scripts created</li>";
    echo "<li><strong>Manual Start:</strong> Use the buttons below</li>";
    echo "</ol>";
    echo "</div>";
    
    // Manual service control
    if (isset($_POST['start_mysql'])) {
        echo "<div class='info'>Attempting to start MySQL...</div>";
        $output = [];
        $return_code = 0;
        exec('cd /d "C:\xampp\mysql\bin" && start /b mysqld --defaults-file=my.ini', $output, $return_code);
        echo "<pre>Command executed. Please refresh this page in 10 seconds to check status.</pre>";
        echo "<script>setTimeout(function(){location.reload();}, 10000);</script>";
    }
    
    echo "<form method='post'>";
    echo "<button type='submit' name='start_mysql' class='btn btn-success'>🚀 Try to Start MySQL</button>";
    echo "</form>";
}

// Show system information
echo "<div class='info'>";
echo "<h3>🔍 System Information</h3>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "<li><strong>Current Time:</strong> " . date('Y-m-d H:i:s') . "</li>";
echo "<li><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "</ul>";
echo "</div>";

// Quick links
echo "<div class='info'>";
echo "<h3>🔗 Quick Links</h3>";
echo "<a href='http://localhost/phpmyadmin/' class='btn' target='_blank'>phpMyAdmin (if working)</a>";
echo "<a href='admin/' class='btn'>Jiffy Admin</a>";
echo "<a href='management/' class='btn'>Management Portal</a>";
echo "<a href='project/' class='btn'>Project Portal</a>";
echo "<a href='business/' class='btn'>Employee Portal</a>";
echo "</div>";

// Show recent MySQL error log if accessible
if ($mysqlWorking && $conn) {
    echo "<div class='info'>";
    echo "<h3>📊 Database Status</h3>";
    
    $result = $conn->query("SHOW DATABASES");
    if ($result) {
        echo "<p><strong>Available Databases:</strong></p>";
        echo "<ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    }
    echo "</div>";
}

if ($conn) {
    $conn->close();
}

echo "</body></html>";
?>