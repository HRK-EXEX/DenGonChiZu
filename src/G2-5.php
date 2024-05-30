<?php
require 'php/db.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>コメント編集</title>
    <link rel="stylesheet" href="css/G2-5.css">
    <link rel="stylesheet" href="css/side.css">
</head>
<body>
    <div class="main-content">
        <h1>コメント編集</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST['action'];
            $comment = $_POST['comment'];

            switch ($action) {
                case 'confirm':
                    // 確定ボタンが押された場合の処理
                    echo "<h1>コメントが確定されました</h1>";
                    echo "<p>コメント: " . htmlspecialchars($comment) . "</p>";
                    break;
                case 'delete':
                    // 削除ボタンが押された場合の処理
                    echo "<h1>コメントが削除されました</h1>";
                    break;
                default:
                    // 予期しないアクション
                    echo "<h1>不明なアクションです</h1>";
            }
        } else {
        ?>
        
        <form action="" method="post">
            <textarea class="comment-box" name="comment"></textarea>
            <div class="button-container">
                <button type="button" onclick="location.href='G2-2.html'" class="btn back-btn">戻る</button>
                <button type="submit" name="action" value="confirm" class="btn confirm-btn">確定</button>
                <button type="submit" name="action" value="delete" class="btn delete-btn">削除</button>
            </div>
        </form>
        
        <?php
        }
        ?>
    </div>
</body>
</html>

          