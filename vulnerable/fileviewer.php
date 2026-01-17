<?php
session_start();

// Cek login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$file_content = '';
$error = '';
$requested_file = '';

// VULNERABLE: Tidak ada validasi path, rentan LFI
if (isset($_GET['file'])) {
    $requested_file = $_GET['file'];
    
    // VULNERABLE: Langsung baca file tanpa whitelist
    if (file_exists($requested_file)) {
        $file_content = file_get_contents($requested_file);
    } else {
        $error = 'File tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Viewer - Vulnerable</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 30px;
            text-align: center;
        }
        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .badge {
            display: inline-block;
            background: #fee;
            color: #c00;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .vulnerability-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .vulnerability-info h3 {
            color: #856404;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .vulnerability-info ul {
            margin-left: 20px;
            color: #856404;
            font-size: 13px;
        }
        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
        .form-section h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: 'Courier New', monospace;
        }
        .form-group input:focus {
            outline: none;
            border-color: #e74c3c;
        }
        .btn {
            padding: 12px 30px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #c0392b;
        }
        .file-list {
            margin-top: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .file-list h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .file-list ul {
            list-style: none;
        }
        .file-list li {
            margin: 5px 0;
        }
        .file-list a {
            color: #e74c3c;
            text-decoration: none;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        .file-list a:hover {
            text-decoration: underline;
        }
        .content-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
        .content-section h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .file-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 500px;
            overflow-y: auto;
            color: #333;
        }
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-danger {
            background: #fee;
            color: #c00;
            border: 1px solid #fcc;
        }
        .hint {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #17a2b8;
        }
        .hint strong {
            color: #0c5460;
        }
        .hint code {
            background: #d1ecf1;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        .hint p {
            color: #0c5460;
            font-size: 13px;
            margin-top: 5px;
        }
        .back-link {
            text-align: center;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .back-link a {
            color: #e74c3c;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📁 File Viewer Module</h1>
            <span class="badge">VULNERABLE VERSION</span>
        </div>

        <div class="vulnerability-info">
            <h3>⚠️ Kerentanan yang Ada:</h3>
            <ul>
                <li>Tidak ada whitelist file</li>
                <li>Path traversal tidak diblokir (rentan LFI)</li>
                <li>Tidak ada validasi tipe file</li>
                <li>File disimpan di folder public</li>
            </ul>
        </div>

        <div class="form-section">
            <h2>Buka File</h2>
            <form method="GET" action="">
                <div class="form-group">
                    <label for="file">Path File:</label>
                    <input type="text" id="file" name="file" 
                           value="<?php echo htmlspecialchars($requested_file); ?>" 
                           placeholder="data.txt">
                </div>
                <button type="submit" class="btn">View File</button>
            </form>

            <div class="file-list">
                <h3>📄 Contoh File yang Tersedia:</h3>
                <ul>
                    <li><a href="?file=data.txt">data.txt</a></li>
                    <li><a href="?file=config.txt">config.txt</a></li>
                </ul>
            </div>

            <div class="hint">
                <strong>💡 Payload LFI untuk Testing (Windows):</strong>
                <p><code>../../../xampp/apache/conf/httpd.conf</code></p>
                <p><code>../../../xampp/php/php.ini</code></p>
                <p><code>../../../windows/system.ini</code></p>
                <br>
                <strong>💡 Payload LFI untuk Testing (Linux):</strong>
                <p><code>../../../../etc/passwd</code></p>
                <p><code>../../../../etc/hosts</code></p>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="content-section">
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            </div>
        <?php endif; ?>

        <?php if ($file_content): ?>
            <div class="content-section">
                <h2>📄 Isi File: <?php echo htmlspecialchars($requested_file); ?></h2>
                <div class="file-content"><?php echo htmlspecialchars($file_content); ?></div>
            </div>
        <?php endif; ?>

        <div class="back-link">
            <a href="dashboard.php">← Kembali ke Dashboard</a> | 
            <a href="../index.php">🏠 Home</a>
        </div>
    </div>
</body>
</html>