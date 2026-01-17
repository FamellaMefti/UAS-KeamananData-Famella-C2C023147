<?php
session_start();
if (!isset($_SESSION['user'])) die('Harus login!');

// Secure: Whitelist file yang diizinkan
$allowed_files = [
    'file1' => 'data/document1.txt',
    'file2' => 'data/document2.txt',
];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Secure: Validasi ID dengan whitelist
    if (!isset($allowed_files[$id])) {
        die('File tidak ditemukan!');
    }
    
    $file_path = $allowed_files[$id];
    
    // Secure: File disimpan di folder non-public
    if (file_exists($file_path)) {
        $content = file_get_contents($file_path);
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>File Viewer - Secure</title></head>
<body>
    <h2>File Viewer (Secure)</h2>
    <ul>
        <li><a href="?id=file1">Document 1</a></li>
        <li><a href="?id=file2">Document 2</a></li>
    </ul>
</body>
</html>
```

