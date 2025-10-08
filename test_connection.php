<?php
// Quick database connection test
echo "<h3>Database Connection Test</h3>";

try {
    $conn = new mysqli('localhost', 'root', 'admin', 'snh6_jiffy2');
    
    if ($conn->connect_error) {
        echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Successfully connected to snh6_jiffy2 database!</p>";
        
        $result = $conn->query('SHOW TABLES');
        if ($result) {
            echo "<p style='color: green;'>📊 Found " . $result->num_rows . " tables in the database</p>";
            
            // List some key tables
            $tables = [];
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            
            $keyTables = ['employee', 'attendance', 'announcements', 'department', 'schedules'];
            echo "<p><strong>Key tables found:</strong></p><ul>";
            foreach ($keyTables as $table) {
                if (in_array($table, $tables)) {
                    echo "<li style='color: green;'>✅ $table</li>";
                } else {
                    echo "<li style='color: red;'>❌ $table (missing)</li>";
                }
            }
            echo "</ul>";
        }
        
        $conn->close();
    }
} catch(Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo '<br><a href="update_all_connections.php" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Update All Connections</a>';
echo '<br><br><a href="index.php" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Test Homepage</a>';
?>