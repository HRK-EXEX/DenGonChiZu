<?php 
    require 'php/db.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $postId = isset($_GET['post_id']) ? intval($_GET['post_id']) : null;

    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
        die("ログイン情報が見つかりません。");
    }

    $my_userId = $_SESSION['user']['user_id'];

    if(isset($postId)) {
        try {
            $stmt = $db->prepare("SELECT * FROM Posts WHERE post_id = :postId ");
            $stmt->execute(['postId' => $postId]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            $title = $_POST['post_title'] ?? $res['title'] ?? "情報が未入力です";
            $image = $_POST['post_img'] ?? $res['img_path'] ?? null;
            $text = $_POST['post_text'] ?? $res['content'] ?? "情報が未入力です";
        } catch (Exception $e) {
            echo 'エラーが発生しました: ',  $e->getMessage(), "\n";
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>伝言地図 - 投稿内容</title>
    <link rel="stylesheet" href="css/G2-1.css">
    <link rel="stylesheet" href="css/G2-2.css">
</head>
<body>
    <div class="parent">
        <div class="edit">
            <button onclick="location.href='G2-3.html'" class="button-base proceed">編集</button>  
        </div>
        <div class="show-part">
            <div class="details-part">
                <div class="box-base title"><?=htmlspecialchars($title)?></div><br>
                <?php if ($image): ?>
                <div class="box-base image-box">      
                    <img class="image" src="<?=htmlspecialchars($image)?>">
                </div><br>
                <?php endif; ?>
                <div class="title-base content"><?=htmlspecialchars($text)?></div>
            </div>
            <div class="comments_area">
                <?php
                    for($i=0; $i<5; $i++) {
                        echo '<div class="comment-info">
                            <div class="user">
                                <img class="icon-image" src="../img/NoImage.png">
                                <span class="username">ユーザー名</span>
                                <button class="ellipsis">...</button>
                            </div>
                            <div class="comment-box">
                                <p>コメントの内容がここに入ります。</p>
                            </div>
                        </div>';
                    }
                ?>
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <input class="comment-input" placeholder="コメントを入力...">
            <button onclick="location.href='G1-1.php'" class="button-base send">送信</button>
        </div>
    </div>
</body>
</html>
