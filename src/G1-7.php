<?php
session_start();
require 'php/db.php';

if (isset($_SESSION['user'])) {
    // ユーザーがログインしている場合、ログアウト処理を行う
    $_SESSION = array();
    session_destroy();
} else {
    // ユーザーがログインしていない場合、ログインページにリダイレクトする
    header("Location: G1-6.php");
    exit;
}
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
        <button onclick="location.href='G1-1.php'">TOP画面に戻る</button>
    </div>
</body>
</html>
