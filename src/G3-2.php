<?php
// データベース接続情報
$servername = "mysql305.phy.lolipop.lan";
$username = "LAA1517436";
$password = "hyperBassData627";
$dbname = "LAA1517436-linedwork";

// PDOを使用してデータベースに接続
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続失敗: " . $e->getMessage());
}

// セッション開始
session_start();

// セッションから自分のユーザーIDを取得
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    die("ログイン情報が見つかりません。");
}
$my_user_id = $_SESSION['user']['user_id'];

// 相手のユーザーIDを取得（URLのクエリパラメータから取得）
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id === 0) {
    die("ユーザーIDが指定されていません。");
}

// フォロワー数を取得する関数
function getFollowerCount($pdo, $user_id) {
    $sql = "SELECT COUNT(*) as follower_count FROM Followers WHERE followers_user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['follower_count'];
}

// フォロワーリストを取得する関数
function getFollowerList($pdo, $user_id) {
    $sql = "SELECT Users.user_id, Users.user_name FROM Followers
            JOIN Users ON Followers.follower_user_id = Users.user_id
            WHERE Followers.followers_user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// フォロワー数を取得
$follower_count = getFollowerCount($pdo, $user_id);

// フォロワーリストを取得
$follower_list = getFollowerList($pdo, $user_id);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フォロワー表示</title>
    <link rel="stylesheet" href="css/G3-2.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="profile-pic"></div>
            <h1><?php echo htmlspecialchars($_SESSION['user']['user_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        </header>
        <main>
            <h2>フォロワー表示</h2>
            <p>フォロワー数: <?php echo htmlspecialchars($follower_count, ENT_QUOTES, 'UTF-8'); ?></p>
            <ul class="follower-list">
                <?php foreach ($follower_list as $follower): ?>
                    <li class="follower-item">
                        <div class="follower-pic" style="background-color: yellow;"></div> <!-- プロフィール画像の取得方法に応じて変更 -->
                        <span><?php echo htmlspecialchars($follower['user_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <button class="unfollow-btn">解除</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
        <footer>
            <button class="back-btn" onclick="history.back()">戻る</button>
        </footer>
    </div>
</body>
</html>
