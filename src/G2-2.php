<?php
require 'php/db.php';

session_start();

// セッションからユーザーIDを取得
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    die("ログイン情報が見つかりません。");
}
$userId = $_SESSION['user']['user_id'];

// postId を GET パラメータとして受け取る
$postId = isset($_GET['postId']) ? $_GET['postId'] : null;

// POST されたデータを処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 必要なデータを取得
    $title = $_POST['post_title'] ?? null;
    $image = $_POST['post_img'] ?? null;
    $text = $_POST['post_text'] ?? null;

    // データベースに追加する関数を呼び出す
    addPostToDatabase($userId, $title, $image, $text);
}

function addPostToDatabase($userId, $title, $image, $text) {
    // データベースに接続
    global $db;

    try {
        // SQL 文を準備
        $sql = $db->prepare("INSERT INTO Posts (user_id, title, img_path, content) VALUES (:user_id, :title, :image, :text)");
        
        // パラメータをバインド
        $sql->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':image', $image, PDO::PARAM_STR);
        $sql->bindParam(':text', $text, PDO::PARAM_STR);
        
        // SQL 文を実行
        $sql->execute();

        // 成功メッセージを表示
        echo "投稿が追加されました。";
    } catch (PDOException $e) {
        // エラーが発生した場合の処理
        echo "エラー: " . $e->getMessage();
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
                <div class="box-base title">"<?=$title?>"</div><br>
                <div class="title-base content">"<?=$text?>"</div>
                <div class="box-base image-box">      
                    <img class="image" src="<?=$image?>">
                </div><br>    
            </div>
            <div class="box-base comments">
                <?php
                // コメント表示部分は修正が必要ないため変更しない
                ?>
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <!-- フォームを追加 -->
            <form method="post" action="">
                <input type="text" name="post_title" placeholder="タイトル">
                <input type="text" name="post_img" placeholder="画像URL">
                <textarea name="post_text" placeholder="投稿内容"></textarea>
                <input type="submit" value="送信" class="button-base send">
            </form>
        </div>
    </div>
</body>
</html>
