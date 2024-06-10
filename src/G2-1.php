<?php
    require 'php/db.php';
    session_start();
    // var_dump($_FILES, $_POST);

    // 変数代入
    $posted = $_POST['posted'] ?? false;
    $title = $_POST['post_title'] ?? null;
    $image = $_FILES['post_img'] ?? null;
    $text = $_POST['post_text'] ?? null;
    $target = $image['name'] ?? null;
    $error = null;

    if (empty($target)) $target = 'null';

    $mes = "新規投稿";

    // 投稿ボタンが押されたかの確認＆投稿処理
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = date("Y-m-d H:i:s");
        // $mes = $date . "\n";
        // $mes .= print_r($_FILES, true) . "\n";
        // $mes .= print_r($_POST, true) . "\n";
        // $mes .= print_r($_SESSION, true) . "\n";

        try {
            // ファイルが既に存在するかチェック
            if (file_exists($target)) {
                $error = "アップロードされたファイルは既に存在します。";
            }

            // SQL挿入部
            $userId = $_SESSION['user']['user_id'] ?? null;

            if (isset($userId)) {
                $str = "INSERT INTO Posts VALUE (null, $userId, '$title', '$text', null, '$date', 0)";
                
                $sql = $db -> query($str);
                $res = $sql -> fetch(PDO::FETCH_ASSOC);
                $postId = $res['post_id'];

                $uploadPath = isset($target) ? 'img/posts/'.$postId.'-'.$target : null;

                $str = "UPDATE Posts SET img_path = $uploadPath WHERE post_id = ".$postId;

                // 画像送信部
                if (isset($uploadPath)) {
                    $res2 = $db -> query($str) -> fetch(PDO::FETCH_ASSOC);
                    if (!move_uploaded_file($_FILES['post_img']['tmp_name'], $uploadPath)) {
                        $error = "ファイルのアップロードに失敗しました。";
                    }
                }

                // リダイレクト
                if (isset($res2) && !$error)
                    header("Location: G1-1.php");
            } else $error = "この操作を行うにはログインが必要です。";
        } catch (Throwable $e) {
            $title = $text = ''.$e->getMessage()."\n".$str;
        }

        if ($error) $title = $text = ''.$error."\n";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>伝言地図 - 新規投稿</title>
    <link rel="stylesheet" href="css/G2-1.css">
    <link rel="stylesheet" href="css/side.css">
</head>
<body>
    <div id="sidebar-container"></div>
    <?php include 'side.php'; ?>

    <div class="parent">
        <form id="newing" class="main-part" method="post" enctype="multipart/form-data">
            <div class="method"><?=$mes?></div>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力..." required value="<?=$title?>">
            <div class="box-base image-box">
                <input type="file" name="post_img" accept="image/*"/>
            </div>
            <textarea name="post_text" class="box-base content" placeholder="本文を入力..." required><?=$text?></textarea>
        </form>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <button type="submit" form="newing" class="button-base proceed">投稿</button>
        </div>
    </div>
</body>
</html>