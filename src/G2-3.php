<?php
    require 'php/db.php';
    $postId = $_GET["post_id"] ?? null;
    $userId = $_GET["user_id"] ?? null;
    $posted = $_POST["posted"] ?? false;
    $mes = "投稿編集";

    // 投稿の存在確認
    if(isset($postId)) {
        try {
            $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $postId AND user_id = $userId");
            $res = $sql -> fetch(PDO::FETCH_ASSOC);

            $title = $_POST['post_title'] ?? $res['title'] ?? null;
            $image = $_POST['post_img'] ?? $res['img_path'] ?? null;
            $text = $_POST['post_text'] ?? $res['content'] ?? null;
        } catch (PDOException $e) {
            $title = $text = 'exception occured: '.$e->getMessage();
        }

        // 投稿ボタンが押されたかの確認＆投稿処理
        if ($posted) {
            $date = date("Y-m-d H:i:s");
            // $mes = $date . "\n";
            // $mes .= print_r($_FILES, true) . "\n";
            // $mes .= print_r($_POST, true) . "\n";
            // $mes .= print_r($_SESSION, true) . "\n";

            // SQL挿入部
            try {
                $sql = $db -> query(
                    "UPDATE Posts SET
                        title = $title,
                        content = $text,
                        img_path = $target,
                        'date' = $date
                    WHERE post_id = $postId AND user_id = $userId"
                );
                $res = $sql -> fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $title = $text = 'exception occured: '.$e->getMessage();
            }

            // リダイレクト
            if (isset($res))
                header("Location: G1-1.php");
        }
    } else die('<h3>このポストは利用できません。</h3>');
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
        <form id="modify" class="main-part" method="POST">
            <input type="hidden" name="posted" value="true">
            <div class="method"><?=$mes?></div>
            <input name="post_title" class="box-base title" placeholder="投稿タイトルを入力..." value="<?=$title?>">
            <div class="box-base image-box">
            <img name="post_img" class="image" src="../img/
            <?php
                if (isset($res['img_path'])) {
                    if ($res['img_path']) {;
                        echo $image.'.png">';
                    } else echo '../img/NoImage.png';
                }
            ?>
            ">
            </div>
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