<?php

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
    <form class="parent">
        <div class="main-part">
            <div class="method">新規投稿</div>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力...">
            <div class="box-base image-box">
                <input type="file" name="post_img" accept="image" />
            </div>
            <textarea name="post_text" class="box-base content" placeholder="本文を入力..."></textarea>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.html'" class="button-base back">戻る</button>
            <button type="submit" class="button-base proceed">投稿</button>
        </div>
    </form>
</body>
</html>