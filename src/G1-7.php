<?php
session_start();

$_SESSION = array();

session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト画面</title>
    <link rel="stylesheet" href="css/G1-7.css">
</head>
<body>
    <div class="container">
        <div class="message">ログアウトしました</div>
        <button onclick="location.href='index.html'">TOP画面に戻る</button>
    </div>
</body>
</html>
