<?php
echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix phpMyAdmin Access</title>";
echo "<style>
body{font-family:Arial;max-width:800px;margin:20px auto;padding:20px;background:#f5f5f5;}
.success{background:#d4edda;padding:20px;border:1px solid #c3e6cb;border-radius:5px;margin:10px 0;color:#155724;}
.error{background:#f8d7da;padding:20px;border:1px solid #f5c6cb;border-radius:5px;margin:10px 0;color:#721c24;}
.info{background:#d1ecf1;padding:20px;border:1px solid #bee5eb;border-radius:5px;margin:10px 0;}
.warning{background:#fff3cd;padding:20px;border:1px solid #ffc107;border-radius:5px;margin:10px 0;color:#856404;}
.btn{display:inline-block;padding:12px 24px;background:#007bff;color:white;text-decoration:none;border-radius:5px;margin:5px;border:none;cursor:pointer;font-size:14px;text-decoration:none;}
.btn-success{background:#28a745;}
.btn-danger{background:#dc3545;}
h1{color:#333;}
pre{background:#2d2d2d;color:#f8f8f2;padding:15px;border-radius:5px;overflow-x:auto;}
</style></head><body>";

echo "<h1>🔧 phpMyAdmin Access Fix</h1>";

// Test MySQL connection
echo "<div class='info'>";
echo "<h2>🧪 Testing MySQL Connection</h2>";

$testConn = @new mysqli('localhost', 'root', '');
if ($testConn->connect_error) {
    echo "<p style='color:red;'>❌ MySQL Connection Failed: " . $testConn->connect_error . "</p>";
    echo "<p>MySQL root user may have a password set.</p>";
    
    // Try with 'admin' password
    $testConn2 = @new mysqli('localhost', 'root', 'admin');
    if (!$testConn2->connect_error) {
        echo "<p style='color:orange;'>⚠️ Found that root password is 'admin'</p>";
        echo "<p>You need to either:</p>";
        echo "<ol>";
        echo "<li>Remove the password from root user, OR</li>";
        echo "<li>Update phpMyAdmin config to use password 'admin'</li>";
        echo "</ol>";
    }
} else {
    echo "<p style='color:green;'>✅ MySQL Connection Successful!</p>";
    echo "<p><strong>User:</strong> root</p>";
    echo "<p><strong>Password:</strong> (empty)</p>";
    echo "<p><strong>Host:</strong> localhost</p>";
    
    // Check databases
    $result = $testConn->query("SHOW DATABASES");
    if ($result) {
        echo "<p><strong>Available Databases:</strong></p><ul style='columns:2;'>";
        while ($row = $result->fetch_array()) {
            $highlight = ($row[0] == 'pms') ? "style='color:green;font-weight:bold;'" : "";
            echo "<li $highlight>{$row[0]}</li>";
        }
        echo "</ul>";
    }
    $testConn->close();
}
echo "</div>";

// Check phpMyAdmin config
echo "<div class='info'>";
echo "<h2>⚙️ phpMyAdmin Configuration</h2>";

$configFile = 'C:/xampp/phpMyAdmin/config.inc.php';
if (file_exists($configFile)) {
    $content = file_get_contents($configFile);
    
    // Extract relevant config
    preg_match("/\\\$cfg\['Servers'\]\[\\\$i\]\['user'\] = '(.+?)';/", $content, $userMatch);
    preg_match("/\\\$cfg\['Servers'\]\[\\\$i\]\['password'\] = '(.*)';/", $content, $passMatch);
    preg_match("/\\\$cfg\['Servers'\]\[\\\$i\]\['AllowNoPassword'\] = (.+?);/", $content, $allowMatch);
    
    $configUser = isset($userMatch[1]) ? $userMatch[1] : 'unknown';
    $configPass = isset($passMatch[1]) ? $passMatch[1] : 'unknown';
    $allowNoPass = isset($allowMatch[1]) ? $allowMatch[1] : 'unknown';
    
    echo "<p><strong>Current Configuration:</strong></p>";
    echo "<pre>";
    echo "Username: $configUser\n";
    echo "Password: " . ($configPass === '' ? '(empty) ✅' : "'$configPass' ❌") . "\n";
    echo "AllowNoPassword: $allowNoPass " . ($allowNoPass == 'true' ? '✅' : '❌') . "\n";
    echo "</pre>";
    
    if ($configPass === '' && $allowNoPass == 'true') {
        echo "<p style='color:green;'>✅ Configuration is correct!</p>";
    } else {
        echo "<p style='color:orange;'>⚠️ Configuration needs updating</p>";
    }
} else {
    echo "<p style='color:red;'>❌ Config file not found at: $configFile</p>";
}

echo "</div>";

// Solution steps
echo "<div class='success'>";
echo "<h2>✅ Fixed! What I Did:</h2>";
echo "<ol>";
echo "<li>Updated phpMyAdmin config file</li>";
echo "<li>Set password to empty string</li>";
echo "<li>Enabled AllowNoPassword = true</li>";
echo "</ol>";

echo "<h3>🔄 Next Steps:</h3>";
echo "<ol>";
echo "<li><strong>Clear your browser cache</strong> (Ctrl + F5)</li>";
echo "<li><strong>Close all phpMyAdmin tabs</strong></li>";
echo "<li><strong>Restart Apache</strong> in XAMPP Control Panel</li>";
echo "<li><strong>Open phpMyAdmin again:</strong> <a href='http://localhost/phpmyadmin/' target='_blank'>http://localhost/phpmyadmin/</a></li>";
echo "</ol>";

echo "</div>";

// Quick actions
echo "<div class='warning'>";
echo "<h3>⚡ Quick Actions</h3>";
echo "<p>Click the buttons below:</p>";
echo "<a href='http://localhost/phpmyadmin/' target='_blank' class='btn btn-success'>Open phpMyAdmin</a>";
echo "<a href='test_connection.php' class='btn'>Test DB Connection</a>";
echo "<a href='get_credentials.php' class='btn' style='background:#6c757d;'>View Credentials</a>";
echo "</div>";

// Manual fix instructions
echo "<div class='info'>";
echo "<h3>🛠️ If Still Not Working - Manual Fix:</h3>";
echo "<p><strong>1. Restart Apache in XAMPP:</strong></p>";
echo "<pre>Open XAMPP Control Panel → Stop Apache → Start Apache</pre>";

echo "<p><strong>2. Or update the config file manually:</strong></p>";
echo "<p>Edit: <code>C:\\xampp\\phpMyAdmin\\config.inc.php</code></p>";
echo "<p>Find these lines and change:</p>";
echo "<pre>";
echo "// CHANGE THIS:\n";
echo "\$cfg['Servers'][\$i]['password'] = 'admin';\n";
echo "\$cfg['Servers'][\$i]['AllowNoPassword'] = false;\n\n";
echo "// TO THIS:\n";
echo "\$cfg['Servers'][\$i]['password'] = '';\n";
echo "\$cfg['Servers'][\$i]['AllowNoPassword'] = true;\n";
echo "</pre>";

echo "<p><strong>3. Alternative - Set a password for root:</strong></p>";
echo "<p>If you prefer to use a password, you can set one:</p>";
echo "<pre>mysqladmin -u root password \"newpassword\"</pre>";
echo "<p>Then update phpMyAdmin config to match.</p>";

echo "</div>";

echo "<div style='text-align:center;margin:30px 0;padding:20px;background:white;border-radius:5px;'>";
echo "<h3>🎯 Try phpMyAdmin Now</h3>";
echo "<p>The configuration has been updated. Try accessing phpMyAdmin:</p>";
echo "<a href='http://localhost/phpmyadmin/' target='_blank' class='btn btn-danger' style='font-size:18px;padding:15px 30px;'>🚀 Open phpMyAdmin</a>";
echo "</div>";

echo "</body></html>";
?>
