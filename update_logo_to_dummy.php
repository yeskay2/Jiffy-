<?php
echo "<h2>Updating Jiffy-logo.png to dummy.png</h2>\n";

// Define the files and their logo replacements
$files_to_update = [
    // Management files
    'management/topbar.php',
    'management/sidebar.php',
    
    // Project files  
    'project/sidebar.php',
    'project/topbar.php',
    'project/topbar_rs.php',
    
    // CKEditor files
    'ckeditor/Employee/topbar.php',
    'ckeditor/Employee/sidebar.php',
    'ckeditor/Employee/index.php'
];

$updated_count = 0;
$base_path = __DIR__ . '/';

foreach ($files_to_update as $file) {
    $full_path = $base_path . $file;
    
    if (file_exists($full_path)) {
        $content = file_get_contents($full_path);
        $original_content = $content;
        
        // Replace all instances of Jiffy-logo.png with dummy.png
        $content = str_replace('Jiffy-logo.png', 'dummy.png', $content);
        
        if ($content !== $original_content) {
            file_put_contents($full_path, $content);
            echo "✅ Updated: $file<br>\n";
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
echo "<p>All local logo references have been updated from Jiffy-logo.png to dummy.png!</p>\n";

// Note about external URLs
echo "<hr>";
echo "<h3>Note:</h3>";
echo "<p>Some files contain external URLs (https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png) which are not updated by this script.</p>";
echo "<p>These external references are typically used in email templates and need to be updated manually if needed.</p>";
?>