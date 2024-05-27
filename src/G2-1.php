<?php
    require 'php/db.php';
    $posted = $_POST["posted"] ?? false;

    $title = $_POST['post_title'] ?? "";
    $image = $_FILES['post_img'] ?? "";
    $text = $_POST['post_text'] ?? "";

    $date = "";

    if($posted) {
        $date = date("Y-m-d H:i:s");

        // SQL挿入部
        if ($image) {
            $target = $image['name'];
        }
        // $sql = $db -> query(
        //     "INSERT INTO Posts VALUES
        //     (null, 2147483647, $title, $text, $image, $date, 0)"
        // );
        // $res = $sql -> fetch(PDO::FETCH_ASSOC);

        // header("Location: G1-1.php");
    }
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
    <div class="parent">
        <form id="newing" class="main-part" method="POST">
            <input type="hidden" name="posted" value="true">
            <div class="method">新規投稿</div>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力..." required value="<?=$title?>">
            <div class="box-base image-box">
                <input type="file" name="post_img" accept="image/jpg, image/jpeg, image/png, image/webp" value="<?=$image?>"/>
            </div>
            <textarea name="post_text" class="box-base content" placeholder="本文を入力..." required><?=$text?></textarea>
        </form>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <span><?=$target?></span>
            <button type="submit" form="newing" class="button-base proceed">投稿</button>
        </div>
    </div>
</body>
</html>