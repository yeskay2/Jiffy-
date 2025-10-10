<?php
echo "<h2>Adding 60px height styling to all remaining logo images</h2>\n";

// Define files and their specific logo patterns to update
$updates = [
    // Accounts files
    'Accounts/topbar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    'Accounts/sidebar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    
    // Management files
    'management/topbar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    'management/sidebar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    
    // Project files
    'project/topbar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    'project/topbar_rs.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    
    // CKEditor files  
    'ckeditor/Employee/topbar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    'ckeditor/Employee/sidebar.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="logo">',
        'new' => '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">'
    ],
    'ckeditor/Employee/index.php' => [
        'old' => '<img src="./../assets/images/dummy.png" alt="Image description" class="img-fluid mb-3">',
        'new' => '<img src="./../assets/images/dummy.png" alt="Image description" class="img-fluid mb-3" style="height: 60px; width: 100px;">'
    ]
];

$updated_count = 0;
$base_path = __DIR__ . '/';

foreach ($updates as $file => $replacement) {
    $full_path = $base_path . $file;
    
    if (file_exists($full_path)) {
        $content = file_get_contents($full_path);
        $original_content = $content;
        
        // Replace the specific old string with the new one
        $content = str_replace($replacement['old'], $replacement['new'], $content);
        
        if ($content !== $original_content) {
            file_put_contents($full_path, $content);
            echo "✅ Added 60px height styling to: $file<br>\n";
            $updated_count++;
        } else {
            echo "ℹ️ Already has styling or no match: $file<br>\n";
        }
    } else {
        echo "❌ File not found: $file<br>\n";
    }
}

echo "<hr>";
echo "<strong>Total files updated: $updated_count</strong><br>\n";
echo "<p>All logo images now have consistent 60px height!</p>\n";

// Handle project/sidebar.php which has multiple logo instances
$project_sidebar = $base_path . 'project/sidebar.php';
if (file_exists($project_sidebar)) {
    $content = file_get_contents($project_sidebar);
    $original_content = $content;
    
    // Replace all instances in project sidebar
    $content = str_replace('<img src="./../assets/images/dummy.png" alt="logo">', '<img src="./../assets/images/dummy.png" alt="logo" style="height: 60px; width: 100px;">', $content);
    
    if ($content !== $original_content) {
        file_put_contents($project_sidebar, $content);
        echo "✅ Updated multiple logos in: project/sidebar.php<br>\n";
    } else {
        echo "ℹ️ No changes needed in: project/sidebar.php<br>\n";
    }
}
?>