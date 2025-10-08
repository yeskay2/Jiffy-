<?php
/**
 * Update All Database Connections to PMS Database
 */

set_time_limit(300);
ini_set('max_execution_time', 300);

$rootDir = __DIR__;

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Update Database to PMS</title>";
echo "<style>body{font-family:Arial;max-width:900px;margin:20px auto;padding:20px;background:#f5f5f5;}";
echo ".success{background:#d4edda;padding:15px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;}";
echo ".info{background:#d1ecf1;padding:15px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}";
echo ".warning{background:#fff3cd;padding:15px;border:1px solid #ffeaa7;border-radius:5px;margin:10px 0;}";
echo "pre{background:#2d2d2d;color:#f8f8f2;padding:10px;border-radius:5px;overflow-x:auto;font-size:12px;}";
echo ".btn{display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;margin:5px;}";
echo "</style></head><body>";

echo "<h1>🔄 Update Database Connections to PMS</h1>";

// Patterns to search and replace
$patterns = [
    // Old database name variations
    ['old' => 'snh6_jiffy2', 'new' => 'pms'],
];

$passwordPatterns = [
    ['old' => '"admin"', 'new' => '""'],
    ['old' => "'admin'", 'new' => "''"],
];

function scanPhpFiles($dir) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
            // Skip update scripts themselves
            $basename = basename($file->getFilename());
            if (strpos($basename, 'update_') !== 0 && 
                strpos($basename, 'import_') !== 0 &&
                $basename !== 'update_to_pms.php') {
                $files[] = $file->getRealPath();
            }
        }
    }
    
    return $files;
}

echo "<div class='info'><strong>🔍 Scanning PHP files...</strong></div>";

$phpFiles = scanPhpFiles($rootDir);
echo "<p>Found <strong>" . count($phpFiles) . "</strong> PHP files to process</p>";

$updatedFiles = [];
$filesWithChanges = 0;

echo "<div class='info'><h3>📝 Processing Files:</h3>";
echo "<div style='max-height:400px;overflow-y:auto;background:white;padding:10px;border:1px solid #ddd;'>";

foreach ($phpFiles as $filePath) {
    $relativePath = str_replace($rootDir . DIRECTORY_SEPARATOR, '', $filePath);
    $content = file_get_contents($filePath);
    $originalContent = $content;
    $changed = false;
    
    // Replace database name
    foreach ($patterns as $pattern) {
        if (strpos($content, $pattern['old']) !== false) {
            $content = str_replace($pattern['old'], $pattern['new'], $content);
            $changed = true;
        }
    }
    
    // Replace password in mysqli_connect calls
    // Pattern: mysqli_connect("localhost", "root", "admin"
    $content = preg_replace(
        '/mysqli_connect\(\s*["\']localhost["\']\s*,\s*["\']root["\']\s*,\s*["\']admin["\']/i',
        'mysqli_connect("localhost", "root", ""',
        $content
    );
    
    // Pattern: new mysqli('localhost', 'root', 'admin'
    $content = preg_replace(
        '/new\s+mysqli\(\s*["\']localhost["\']\s*,\s*["\']root["\']\s*,\s*["\']admin["\']/i',
        'new mysqli(\'localhost\', \'root\', \'\'',
        $content
    );
    
    if ($content !== $originalContent) {
        if (file_put_contents($filePath, $content)) {
            echo "<small style='color:green;'>✅ Updated: $relativePath</small><br>";
            $updatedFiles[] = $relativePath;
            $filesWithChanges++;
        } else {
            echo "<small style='color:red;'>❌ Failed: $relativePath</small><br>";
        }
        
        // Flush output
        if (ob_get_level() > 0) {
            ob_flush();
            flush();
        }
    }
}

echo "</div></div>";

echo "<div class='success'>";
echo "<h2>✅ Update Complete!</h2>";
echo "<p><strong>Files updated:</strong> $filesWithChanges</p>";
echo "</div>";

// Test database connection
echo "<div class='info'><h3>🧪 Testing Database Connection</h3>";

$testConn = @new mysqli('localhost', 'root', '', 'pms');
if ($testConn->connect_error) {
    echo "<p style='color:red;'>❌ Connection failed: " . $testConn->connect_error . "</p>";
} else {
    echo "<p style='color:green;'>✅ Successfully connected to PMS database!</p>";
    
    $result = $testConn->query('SHOW TABLES');
    if ($result) {
        $tableCount = $result->num_rows;
        echo "<p style='color:green;'>✅ Database contains <strong>$tableCount tables</strong></p>";
        
        echo "<p><strong>Tables in database:</strong></p>";
        echo "<div style='columns:3;background:white;padding:10px;'>";
        while ($row = $result->fetch_array()) {
            echo "<small>• " . $row[0] . "</small><br>";
        }
        echo "</div>";
    }
    $testConn->close();
}

echo "</div>";

// Summary
if (!empty($updatedFiles)) {
    echo "<div class='warning'><h4>📋 Updated Files:</h4><ol>";
    foreach ($updatedFiles as $file) {
        echo "<li><small>$file</small></li>";
    }
    echo "</ol></div>";
}

echo "<div class='success'>";
echo "<h3>🎉 All Done!</h3>";
echo "<p>Your application is now connected to the <strong>pms</strong> database.</p>";
echo "<div style='text-align:center;margin-top:20px;'>";
echo "<a href='test_connection.php' class='btn'>Test Connection</a>";
echo "<a href='index.php' class='btn' style='background:#28a745;'>Go to Homepage</a>";
echo "<a href='admin/' class='btn' style='background:#6c757d;'>Admin Panel</a>";
echo "</div>";
echo "</div>";

echo "</body></html>";
?>
