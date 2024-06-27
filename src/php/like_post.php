<?php
session_start();

// データベース接続情報
$host = 'mysql305.phy.lolipop.lan';
$dbname = 'LAA1517436-linedwork';
$username = 'LAA1517436';
$password = 'hyperBassData627';

// データベースに接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

// 投稿IDとアクション（likeまたはunlike）を取得
if (isset($_POST['post_id']) && isset($_POST['action'])) {
    $postId = $_POST['post_id'];
    $action = $_POST['action'];


    $userId = $_SESSION['user']['user_id'];

    if ($action === 'like') {
        // いいねを追加する
        try {
            $stmt = $pdo->prepare("INSERT INTO Good (user_id, post_id) VALUES (?, ?)");
            $stmt->execute([$userId, $postId]);

            // 投稿のいいね数を更新
            $stmt = $pdo->prepare("UPDATE Posts SET post_good = post_good + 1 WHERE post_id = ?");
            $stmt->execute([$postId]);

            // 投稿のいいね数を取得して返す
            $stmt = $pdo->prepare("SELECT post_good FROM Posts WHERE post_id = ?");
            $stmt->execute([$postId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'action' => 'like', 'new_like_count' => $result['post_good']]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    } elseif ($action === 'unlike') {
        // いいねを削除する
        try {
            $stmt = $pdo->prepare("DELETE FROM Good WHERE user_id = ? AND post_id = ?");
            $stmt->execute([$userId, $postId]);

            // 投稿のいいね数を更新
            $stmt = $pdo->prepare("UPDATE Posts SET post_good = post_good - 1 WHERE post_id = ?");
            $stmt->execute([$postId]);

            // 投稿のいいね数を取得して返す
            $stmt = $pdo->prepare("SELECT post_good FROM Posts WHERE post_id = ?");
            $stmt->execute([$postId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'action' => 'unlike', 'new_like_count' => $result['post_good']]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
}
?>
