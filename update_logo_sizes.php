<?php
echo "<h2>Adding consistent logo sizing (60px height) to all dummy.png images</h2>\n";

// Define the files and the logo size styling to add
$files_to_update = [
    'admin/sidebar.php',
    'admin/topbar.php', 
    'Accounts/topbar.php',
    'Accounts/sidebar.php',
    'management/topbar.php',
    'management/sidebar.php',
    'project/sidebar.php',
    'project/topbar.php',
    'project/topbar_rs.php',
    'ckeditor/Employee/index.php',
    'ckeditor/Employee/sidebar.php',
    'ckeditor/Employee/topbar.php'
];

$updated_count = 0;
$base_path = __DIR__ . '/';

foreach ($files_to_update as $file) {
    $full_path = $base_path . $file;
    
    if (file_exists($full_path)) {
        $content = file_get_contents($full_path);
        $original_content = $content;
        
        // Replace logo img tags without styling to add consistent 60px height
        $patterns = [
            // Pattern 1: Basic logo without styling
            '/<img src="\.\.\/\.\.\/assets\/images\/dummy\.png" alt="logo">/' => '<img src="./../assets/images/gem.png" alt="logo" style="height: 60px; width: 100px;">',
            
            // Pattern 2: Logo with just class
            '/<img src="\.\.\/\.\.\/assets\/images\/dummy\.png" alt="Image description" class="img-fluid mb-3">/' => '<img src="./../assets/images/gem.png" alt="Image description" class="img-fluid mb-3" style="height: 60px; width: 100px;">',
            
            // Pattern 3: Other variations
            '/<img src="\.\.\/assets\/images\/dummy\.png" alt="logo">/' => '<img src="./../assets/images/gem.png" alt="logo" style="height: 60px; width: 100px;">'
        ];
        
        foreach ($patterns as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }
        
        if ($content !== $original_content) {
            file_put_contents($full_path, $content);
            echo "✅ Updated sizing in: $file<br>\n";
            $updated_count++;
        } else {
            echo "ℹ️ No changes needed: $file<br>\n";
        }
    } else {
        echo "❌ File not found: $file<br>\n";
    }
}

echo "<hr>";
echo "<strong>Total files updated: $updated_count</strong><br>\n";
echo "<p>All logo images now have consistent 60px height sizing!</p>\n";
?>