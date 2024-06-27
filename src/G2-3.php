<?php
    require 'php/db.php';
    session_start();
    // var_dump($_FILES, $_POST);

    // 変数代入
    $postId = $_GET["post_id"] ?? null;
    $title = $_POST['post_title'] ?? null;
    $image = $_FILES['post_img'] ?? null;
    $text = $_POST['post_text'] ?? null;
    $img_name = $image['name'] ?? null;
    $img_name_tmp = $image['tmp_name'] ?? null;
    $deleteImg = $_POST['deleteImg'] ?? false;
    $error = null;

    $mes = "投稿編集";

    // 投稿の存在確認
    if(isset($postId)) {
        $res = $res2 = $res3 = $target = $uploadPath = null;
        try {
            $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $postId");
            $res = $sql -> fetch(PDO::FETCH_ASSOC);

            $title = $_POST['post_title'] ?? $res['title'] ?? null;
            $image = $_POST['post_img'] ?? $res['img_path'] ?? null;
            $text = $_POST['post_text'] ?? $res['content'] ?? null;
        } catch (PDOException $e) {
            echo '<link rel="stylesheet" href="css/side.css">';
            include 'side.php';
            die('<h3>この投稿は利用できません。</h3>');
        }

        // 投稿ボタンが押されたかの確認＆投稿処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $date = date("Y-m-d H:i:s");
            // $mes = $date . "\n";
            // $mes .= print_r($_FILES, true) . "\n";
            // $mes .= print_r($_POST, true) . "\n";
            // $mes .= print_r($_SESSION, true) . "\n";

            if (!$deleteImg && is_null($img_name)) $img_name = $res['img_path'];

            // まずは画像ファイルの確認をし、ファイル名を確定
            $target = !empty($img_name) && $img_name != $res['img_path'] ? basename($img_name) : null;
            $uploadPath = (!empty($target) && !$deleteImg) ? '../img/posts/'.$target : null;

            // SQL変更部
            try {
                // 内容を更新
                $sql = $db -> query(
                    "UPDATE Posts SET ".
                    "title = '$title', ".
                    "content = '$text', ".
                    "date = '$date' ".
                    "WHERE post_id = $postId "
                );
                $res = $sql -> fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $mes = 'exception occured: '.$e->getMessage();
            }

            // 画像送信部
            if ($deleteImg || isset($uploadPath)) {
                $str = "SELECT img_path FROM Posts WHERE post_id = ".$postId;
                $res2 = $db -> query($str) -> fetch(PDO::FETCH_ASSOC);
                
                if (!empty($res2['img_path']))
                unlink($res2['img_path']);
                
                $str = "UPDATE Posts SET img_path = '$uploadPath' WHERE post_id = ".$postId;
                $res3 = $db -> query($str) -> fetch(PDO::FETCH_ASSOC);
                    
                if (!$deleteImg) {
                    if(!empty($image) && !move_uploaded_file($img_name_tmp, $uploadPath)) {
                        $error = "ファイルのアップロードに失敗しました。";
                    }
                }
            }

            // リダイレクト
            if (isset($res2) || !$error)
                header("Location: G2-2.php?post_id=$postId");
        }
    } else {
        echo '<link rel="stylesheet" href="css/side.css">';
        include 'side.php';
        die('<h3>投稿IDが指定されていません。</h3>');
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>伝言地図 - 投稿編集</title>
    <link rel="stylesheet" href="css/G2-1.css">
    <link rel="stylesheet" href="css/side.css">
</head>
<body>
    <div id="sidebar-container"></div>
    <?php include 'side.php'; ?>

    <div class="parent">
        <form id="modify" class="main-part" method="post" enctype="multipart/form-data">
            <h1 class="method"><?=$mes?></h1>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力..." value="<?=$title?>">
            <div class="box-base image-box">
                <input type="file" name="post_img" accept="image/*"/><br>
                <div>
                    <input type="checkbox" name="deleteImg" value="true">
                    <label for="deleteImg">画像を削除する</label>
                </div>
            </div>
            <textarea name="post_text" class="box-base content" placeholder="本文を入力..."><?=$text?></textarea>
        </form>
        <form id="delete" action="G2-4.php" method="GET">
            <input type="hidden" name="post_id" value="<?=$postId?>">
        </form>
        <div class="operation">
            <button type="submit" form="delete" class="button-base delete">削除</button>
            <button onclick="location.href='G2-2.php'" class="button-base back">戻る</button>
            <button type="submit" form="modify" class="button-base proceed">投稿</button>
        </div>
    </div>
</body>
</html>