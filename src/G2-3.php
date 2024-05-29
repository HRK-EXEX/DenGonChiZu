<?php
    require 'php/db.php';
    $pid = $_GET["post_id"];
    $posted = $_POST["posted"] ?? false;

    try {
        $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $pid");
        $res = $sql -> fetch(PDO::FETCH_ASSOC);

        $title = $_POST['post_title'] ?? $sql['post_title'];
        $image = $_POST['post_img'] ?? $sql['post_img'];
        $text = $_POST['post_text'] ?? $sql['post_text'];
    } catch (PDOException $e) {
        $title = $image = $text = "exception occured";
    }

    if($posted) {
        
    }
?>

<?php include 'side.php'; ?>

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
        <form id="modify" class="main-part" method="POST">
            <input type="hidden" name="posted" value="true">
            <div class="method">投稿編集</div>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力..." value="<?=$title?>">
            <div class="box-base image-box"><img name="post_img" class="image" src="../img/NoImage.png" value="<?=$image?>"></div>
            <textarea name="post_text" class="box-base content" placeholder="本文を入力..."><?=$text?></textarea>
        </form>
        <div class="operation">
            <button onclick="location.href='G2-4.php'" class="button-base delete">削除</button>
            <button onclick="location.href='G2-2.php'" class="button-base back">戻る</button>
            <button type="submit" form="modify" class="button-base proceed">投稿</button>
        </div>
    </div>
</body>
</html>