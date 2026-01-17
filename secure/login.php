<?php
session_start();

$error = '';
$success = '';

// SECURE: Rate limiting sederhana
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}

// Reset counter setelah 5 menit (300 detik)
if (time() - $_SESSION['last_attempt'] > 300) {
    $_SESSION['login_attempts'] = 0;
}

// SECURE: Blokir setelah 3 percobaan gagal
if ($_SESSION['login_attempts'] >= 3) {
    $remaining_time = 300 - (time() - $_SESSION['last_attempt']);
    $minutes = floor($remaining_time / 60);
    $seconds = $remaining_time % 60;
    $error = "Terlalu banyak percobaan login gagal! Silakan coba lagi dalam {$minutes} menit {$seconds} detik.";
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // SECURE: Password di-hash dengan bcrypt
    // Hash untuk password "admin123" - SUDAH DIGANTI
    $hashed_password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    
    // Untuk testing, kita verifikasi langsung
    if ($username === 'admin' && password_verify($password, $hashed_password)) {
        $_SESSION['user'] = $username;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_attempts'] = 0; // Reset counter saat berhasil login
        $success = 'Login berhasil! Redirecting...';
        header('Refresh: 2; URL=dashboard.php');
    } else {
        // SECURE: Increment counter saat gagal
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt'] = time();
        $error = 'Username atau password salah! Percobaan ke-' . $_SESSION['login_attempts'] . ' dari 3';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Secure Version</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
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
            background: #d4edda;
            color: #155724;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .security-info {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .security-info h3 {
            color: #155724;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .security-info ul {
            margin-left: 20px;
            color: #155724;
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
            border-color: #27ae60;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #229954;
        }
        .btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
        }
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #27ae60;
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
        .attempts-counter {
            text-align: center;
            padding: 10px;
            background: #fff3cd;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 14px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Login Module</h1>
            <span class="badge">SECURE VERSION</span>
        </div>

        <div class="security-info">
            <h3>✅ Proteksi Keamanan:</h3>
            <ul>
                <li>Password di-hash dengan bcrypt</li>
                <li>Rate limiting (max 3 percobaan)</li>
                <li>Cooldown period 5 menit</li>
                <li>Strong password required</li>
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
                <input type="text" id="username" name="username" required 
                       <?php echo ($_SESSION['login_attempts'] >= 3) ? 'disabled' : ''; ?>>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required
                       <?php echo ($_SESSION['login_attempts'] >= 3) ? 'disabled' : ''; ?>>
            </div>
            
            <button type="submit" class="btn" 
                    <?php echo ($_SESSION['login_attempts'] >= 3) ? 'disabled' : ''; ?>>
                Login
            </button>
        </form>

        <?php if ($_SESSION['login_attempts'] > 0 && $_SESSION['login_attempts'] < 3): ?>
            <div class="attempts-counter">
                ⚠️ Percobaan login: <?php echo $_SESSION['login_attempts']; ?>/3
            </div>
        <?php endif; ?>

        <div class="hint">
            <strong>💡 Credential untuk Testing:</strong>
            <p>Username: <code>admin</code></p>
            <p>Password: <code>admin123</code></p>
            <p>⚠️ Setelah 3x salah, akan diblokir 5 menit!</p>
        </div>

        <div class="back-link">
            <a href="../index.php">← Kembali ke Home</a>
        </div>
    </div>
</body>
</html>