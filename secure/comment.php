<?php
session_start();
if (!isset($_SESSION['user'])) die('Harus login!');

// Secure: Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$comments = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Secure: Validasi CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token invalid!');
    }
    
    // Secure: Sanitasi input
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
    $comments[] = $comment;
}
?>
<!DOCTYPE html>
<html>
<head><title>Komentar - Secure</title></head>
<body>
    <h2>Input Komentar (Secure)</h2>
    <form method="POST">
        <textarea name="comment"></textarea><br>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button type="submit">Submit</button>
    </form>
    
    <h3>Komentar:</h3>
    <?php foreach ($comments as $c): ?>
        <p><?= $c ?></p>
    <?php endforeach; ?>
</body>
</html>