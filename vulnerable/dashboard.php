<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Vulnerable</title>
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
        .welcome {
            color: #666;
            font-size: 16px;
        }
        .modules {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .module-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s;
        }
        .module-card:hover {
            transform: translateY(-5px);
        }
        .module-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .module-card h3 {
            color: #333;
            margin-bottom: 10px;
        }
        .module-card p {
            color: #666;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .module-card a {
            display: inline-block;
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .module-card a:hover {
            background: #c0392b;
        }
        .logout-btn {
            background: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .logout-btn a {
            display: inline-block;
            padding: 12px 30px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .logout-btn a:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 Dashboard</h1>
            <p class="welcome">Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
        </div>

        <div class="modules">
            <div class="module-card">
                <div class="icon">💬</div>
                <h3>Comment Module</h3>
                <p>Test XSS vulnerability</p>
                <a href="comment.php">Buka Modul</a>
            </div>

            <div class="module-card">
                <div class="icon">📁</div>
                <h3>File Viewer Module</h3>
                <p>Test LFI vulnerability</p>
                <a href="fileviewer.php">Buka Modul</a>
            </div>
        </div>

        <div class="logout-btn">
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>
</body>
</html>