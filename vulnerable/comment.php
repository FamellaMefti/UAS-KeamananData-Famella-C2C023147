<?php
session_start();
if (!isset($_SESSION['user'])) die('Harus login!');

$comments = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vulnerable: Tidak ada sanitasi input
    $comment = $_POST['comment'];
    $comments[] = $comment;
}
?>
<!DOCTYPE html>
<html>
<head><title>Komentar - Vulnerable</title></head>
<body>
    <h2>Input Komentar (Vulnerable - XSS)</h2>
    <form method="POST">
        <textarea name="comment"></textarea><br>
        <button type="submit">Submit</button>
    </form>
    
    <h3>Komentar:</h3>
    <?php
    // Vulnerable: Output tidak di-escape
    foreach ($comments as $c) {
        echo "<p>$c</p>";
    }
    ?>
</body>
</html>