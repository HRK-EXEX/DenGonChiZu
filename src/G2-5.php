<?php require 'php/db.php'; ?>
<?php

// コメントIDの取得
$comment_ID = 1; // デフォルトのコメントID
if (isset($_GET['id'])) {
    $comment_ID = intval($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $comment = $_POST['comment'];
    $comment_ID = intval($_POST['comment_ID']);

    if ($action == 'confirm' && !empty($comment)) {
        // コメントを更新
        $stmt = $db->prepare("UPDATE Comments SET content = ? WHERE comment_ID = ?");
        $stmt->bind_param("si", $comment, $comment_ID);

        if ($stmt->execute()) {
            echo "<h1>コメントが更新されました</h1>";
            echo "<p>コメント: " . htmlspecialchars($comment) . "</p>";
        } else {
            echo "エラー: " . $stmt->error;
        }

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->close();
        if(isset($res))
        header("Location:G2-2.php");
    } elseif ($action == 'delete') {
        // コメントをデータベースから削除
        $stmt = $db->prepare("DELETE FROM Comments WHERE comment_ID = ?");
        $stmt->bind_param("i", $comment_ID);

        if ($stmt->execute()) {
            echo "<h1>コメントが削除されました</h1>";
        } else {
            echo "エラー: " . $stmt->error;
        }
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->close();
        if(isset($res))
        header("Location:G2-2.php");
    } else {
        echo "<h1>不明なアクションです</h1>";
    }
}

// コメントを取得
$comment_text = '';
$stmt = $db->prepare("SELECT content FROM Comments WHERE comment_ID = ?");
$stmt->execute([$comment_ID]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $comment_text = $row['content'];
}
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
        <form action="" method="post">
            <textarea class="comment-box" name="comment"><?php echo htmlspecialchars($comment_text); ?></textarea>
            <input type="hidden" name="comment_ID" value="<?php echo $comment_ID; ?>">
            <div class="button-container">
                <button type="button" onclick="location.href='G2-2.php'" class="btn back-btn">戻る</button>
                <button type="submit" name="action" value="confirm" class="btn confirm-btn">確定</button>
                <button type="submit" name="action" value="delete" class="btn delete-btn">削除</button>
            </div>
        </form>
    </div>
</body>
</html>
