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

        // 削除ボタンが押されたかの確認＆投稿処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $date = date("Y-m-d H:i:s");
            // $mes = $date . "\n";
            // $mes .= print_r($_FILES, true) . "\n";
            // $mes .= print_r($_POST, true) . "\n";
            // $mes .= print_r($_SESSION, true) . "\n";

            // SQL挿入部
            
            try {
                $sql = $db -> query(
                    "DELETE FROM Posts WHERE post_id = $postId AND user_id = $userId"
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
    <title>伝言地図 - 投稿削除</title>
    <link rel="stylesheet" href="css/G2-1.css">
    <link rel="stylesheet" href="css/side.css">
</head>
<body>
    <div id="sidebar-container"></div>
    <?php include 'side.php'; ?>

    <div class="parent">
        <form id="modify" class="main-part" method="POST">
            <div class="method">以下の投稿を削除しようとしています。<br>本当に実行しますか？</div>
            <div class="box-base title"><?=$title?></div>
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
            <div class="box-base content"><?=$text?></div>
        </form>
        <div class="operation">
            <button onclick="location.href='G2-2.php'" class="button-base back">戻る</button>
            <button type="submit" form="modify" class="button-base delete">削除</button>
        </div>
    </div>
</body>
</html>