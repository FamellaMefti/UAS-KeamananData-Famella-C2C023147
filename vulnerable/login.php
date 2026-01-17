<?php
session_start();

$error = '';
$success = '';

// VULNERABLE: Tidak ada rate limiting, password plaintext
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // VULNERABLE: Password lemah dan tidak di-hash
    // Credentials: admin / 123
    if ($username === 'admin' && $password === '123') {
        $_SESSION['user'] = $username;
        $_SESSION['logged_in'] = true;
        $success = 'Login berhasil! Redirecting...';
        header('Refresh: 2; URL=dashboard.php');
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vulnerable Version</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
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
            margin: 20px 0;
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
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #e74c3c;
        }
        .btn {
            width: 100%;
            padding: 12px;
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
        .alert-success {
            background: #efe;
            color: #0a0;
            border: 1px solid #cfc;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #e74c3c;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
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
        .hint p {
            color: #0c5460;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔓 Login Module</h1>
            <span class="badge">VULNERABLE VERSION</span>
        </div>

        <div class="vulnerability-info">
            <h3>⚠️ Kerentanan yang Ada:</h3>
            <ul>
                <li>Password lemah (123)</li>
                <li>Password tidak di-hash (plaintext)</li>
                <li>Tidak ada rate limiting (rentan brute force)</li>
                <li>Tidak ada CAPTCHA</li>
            </ul>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>

        <div class="hint">
            <strong>💡 Hint untuk Testing:</strong>
            <p>Username: <code>admin</code></p>
            <p>Password: <code>123</code></p>
            <p>Coba login berkali-kali untuk melihat tidak ada rate limiting!</p>
        </div>

        <div class="back-link">
            <a href="../index.php">← Kembali ke Home</a>
        </div>
    </div>
</body>
</html>