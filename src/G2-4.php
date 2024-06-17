<?php
    require 'php/db.php';
    $postId = $_GET["post_id"] ?? null;
    $posted = $_POST["posted"] ?? false;
    $mes = "以下の投稿を削除しようとしています。<br>本当に実行しますか？";

    $title = $_POST['post_title'] ?? null;
    $image = $_FILES['post_img'] ?? null;
    $text = $_POST['post_text'] ?? null;
    $img_name = $image['name'] ?? null;
    $img_name_tmp = $image['tmp_name'] ?? null;
    $img_path = $error = null;

    // 投稿の存在確認
    if(isset($postId)) {
        try {
            $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $postId");
            $res = $sql -> fetch(PDO::FETCH_ASSOC);

            $title = $res['title'] ?? null;
            $img_path = $res['img_path'] ?? null;
            $text = $res['content'] ?? null;
        } catch (PDOException $e) {
            $mes = 'exception occured (select): '.$e->getMessage();
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
                    "DELETE FROM Posts WHERE post_id = $postId"
                );
                $res = $sql -> fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $mes = 'exception occured (delete): '.$e->getMessage();
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
            <h1 class="method"><?=$mes?></h1>
            <div class="box-base title"><?=$title?></div>
            <div class="box-base image-box">
            <?php
                if (isset($res['img_path'])) {
                    echo '<img name="post_img" class="image" src="../img/posts/';
                    if (!empty($res['img_path'])) {;
                        echo basename($img_path);
                    } else echo 'NoImage.png';
                    echo '">';
                }
            ?>
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