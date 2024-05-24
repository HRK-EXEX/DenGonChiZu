<?php
    require 'php/db.php';
    $pid = $_GET["post_id"];
    $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $pid");
    $res = $sql -> fetch(PDO::FETCH_ASSOC);

    $title = $sql['post_id'];
    $image = $sql['post_img'];
    $text = $sql['post_text'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>伝言地図 - 投稿編集</title>
    <link rel="stylesheet" href="css/G2-1.css">
</head>
<body>
    <div class="parent">
        <div class="main-part">
            <div class="method">投稿編集</div>
            <input class="box-base title" placeholder="投稿タイトルを入力...">
            <div class="box-base image-box"><img class="image" src="../img/NoImage.png"></div>
            <textarea class="box-base content" placeholder="本文を入力..."></textarea>
        </div>
        <div class="operation">
            <button onclick="location.href='G2-4.php'" class="button-base delete">削除</button>
            <button onclick="location.href='G2-2.php'" class="button-base back">戻る</button>
            <button onclick="location.href='G2-2.php'" class="button-base proceed">投稿</button>
        </div>
    </div>
</body>
</html>