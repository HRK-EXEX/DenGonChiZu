<?php
require 'php/db.php';

// postId を GET パラメータとして受け取る
$postId = isset($_GET['postId']) ? $_GET['postId'] : null;

// セッションからユーザーIDを取得
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    die("ログイン情報が見つかりません。");
}
$userId = $_SESSION['user']['user_id'];

// 投稿情報を取得してフォームの初期値とする
$title = '';
$image = '';
$text = '';

if (isset($postId)) {
    try {
        $sql = $db->query("SELECT * FROM Posts WHERE post_id = $postId AND user_id = $userId");
        $res = $sql->fetch(PDO::FETCH_ASSOC);

        $title = $res['title'] ?? null;
        $image = $res['img_path'] ?? null;
        $text = $res['content'] ?? null;

    } catch (PDOException $e) {
        die("エラー: " . $e->getMessage());
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
                <div class="box-base title"><?= htmlspecialchars($title) ?></div><br>
                <div class="title-base content"><?= htmlspecialchars($text) ?></div>
                <div class="box-base image-box">      
                    <img class="image" src="<?= htmlspecialchars($image) ?>">
                </div><br>    
            </div>
            <div class="box-base comments">
                <!-- コメント表示部分 -->
                <!-- ここにコメントが表示される予定 -->
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <!-- コメントを入力するフォーム -->
            <form method="POST" action="comment.php">
                <input type="hidden" name="postId" value="<?= htmlspecialchars($postId) ?>">
                <input type="text" name="comment" placeholder="コメントを入力...">
                <input type="submit" value="送信" class="button-base send">
            </form>
        </div>
    </div>
</body>
</html>
