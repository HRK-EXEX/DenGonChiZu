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

    if (isset($postId)) {
        try {
            $stmt = $db->prepare("SELECT * FROM Posts WHERE post_id = :postId ");
            $stmt->execute(['postId' => $postId]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($res === false) {
                die("投稿が見つかりません。");
            }

            $title = $_POST['post_title'] ?? $res['title'] ?? "情報が未入力です";
            $image = $_POST['post_img'] ?? $res['img_path'] ?? null;
            $text = $_POST['post_text'] ?? $res['content'] ?? "情報が未入力です";
            $postUserId = $res['user_id'];

            // 投稿画像がない場合は非表示にするチェック
            $imageExists = $image && trim($image) !== '' && file_exists("../img/". $image);
        } catch (Exception $e) {
            echo 'エラーが発生しました: ',  $e->getMessage(), "\n";
        }
    }

    // 投稿に対するコメントを取得する関数
    function getCommentsByPostId($db, $postId) {
        try {
            $stmt = $db->prepare("SELECT c.content, c.date, u.user_name
                                    FROM Comments c 
                                    JOIN Users u ON c.user_id = u.user_id 
                                    WHERE c.post_id = :postId 
                                    ORDER BY c.date ASC");
            $stmt->execute(['postId' => $postId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'エラーが発生しました: ',  $e->getMessage(), "\n";
            return [];
        }
    }

    // コメントを追加する関数
    function addComment($db, $userId, $postId, $content) {
        try {
            $stmt = $db->prepare("INSERT INTO Comments (user_id, post_id, content) VALUES (:userId, :postId, :content)");
            return "コメントが追加されました。";
        } catch (Exception $e) {
            return 'エラーが発生しました: ' . $e->getMessage();
        }
    }

    // コメントの送信処理
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment-input'])) {
        $commentContent = $_POST['comment-input'];

        // コメントが空でないか確認する
        if (!empty($commentContent)) {
            // コメントを追加する
            $result = addComment($db, $my_userId, $postId, $commentContent);
            echo $result;
            
            // ページをリロードして最新のコメントを表示
            header("Refresh:0");
            exit; // 追加処理後にスクリプトを終了
        } else {
            echo "コメントを入力してください。";
        }
    }


    //

    $comments = getCommentsByPostId($db, $postId);
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
        <?php if ($my_userId === $postUserId): ?>
        <div class="edit">
            <button onclick="location.href='G2-3.html'" class="button-base proceed">編集</button>  
        </div>
        <?php endif; ?>
        <div class="show-part">
            <div class="details-part">
                <div class="box-base title"><?=htmlspecialchars($title)?></div><br>
                <?php if ($imageExists): ?>
                <div class="box-base image-box">      
                    <img class="image" src="<?=htmlspecialchars('../img/' . $image)?>">
                </div><br>
                <?php endif; ?>
                <div class="title-base content"><?=htmlspecialchars($text)?></div>
            </div>
            <div class="comments_area">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-info">
                            <div class="user">
                                <!-- SQLは画像取得対応しているからできればimg取得方式に変えたい -->
                                <img class="icon-image" src="../img/user_icon.jpg">
                                <span class="username"><?=htmlspecialchars($comment['user_name'])?></span>
                                <button class="ellipsis">...</button>
                            </div>
                            <div class="comment-box">
                                <p><?=htmlspecialchars($comment['content'])?></p>
                                <small><?=htmlspecialchars($comment['date'])?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>コメントがありません。</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <input class="comment-input" name="comment-input" placeholder="コメントを入力...">
                <button type="submit" class="button-base send">送信</button>
            </form>

        </div>
    </div>
</body>
</html>
