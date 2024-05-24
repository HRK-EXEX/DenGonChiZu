<?php
    require 'php/db.php';

    $title = $_POST['post_title'] ?? "";
    $image = $_POST['post_img'] ?? "";
    $text = $_POST['post_text'] ?? "";


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>伝言地図 - 新規投稿</title>
    <link rel="stylesheet" href="css/G2-1.css">
</head>
<body>
    <div class="main-part">
        <form id="newing" class="parent" method="POST">
            <div class="method">新規投稿</div>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力..." required value="<?=$title?>">
            <div class="box-base image-box">
                <input type="file" name="post_img" accept="image/jpg, image/jpeg, image/png, image/webp" value="<?=$image?>"/>
            </div>
            <textarea name="post_text" class="box-base content" placeholder="本文を入力..." required><?=$text?></textarea>
        </form>
    </div>
    <div class="operation">
        <button onclick="location.href='G2-2.php'" class="button-base back">戻る</button>
        <button type="submit" form="newing" class="button-base proceed">投稿</button>
    </div>
</body>
</html>