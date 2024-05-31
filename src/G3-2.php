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

// GET パラメータから action と user_id を取得
$action = isset($_GET['action']) ? $_GET['action'] : '';
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id === 0) {
    die("ユーザーIDが指定されていません。");
}

// フォローを取得する関数
function getFollowList($pdo, $user_id) {
    $sql = "SELECT Users.user_id, Users.user_name FROM Followers
            JOIN Users ON Followers.followers_user_id = Users.user_id
            WHERE Followers.user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// フォロワーを取得する関数
function getFollowerList($pdo, $user_id) {
    $sql = "SELECT Users.user_id, Users.user_name FROM Followers
            JOIN Users ON Followers.user_id = Users.user_id
            WHERE Followers.followers_user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 表示するリストを取得
if ($action === 'follow') {
    $list = getFollowList($pdo, $user_id);
    $title = "フォロー表示";
} else {
    $list = getFollowerList($pdo, $user_id);
    $title = "フォロワー表示";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/G3-2.css">
</head>
<body>
    <div class="container">
        <header>
            <!-- アイコン画像は後でDBから取得式に変更予定 -->
            <img src="../img/user_icon.jpg" alt="ユーザのアイコン">
            <h1><?php echo htmlspecialchars($_SESSION['user']['user_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
        </header>
        <main>
            <div class="user-list">
                <?php foreach ($list as $user): ?>
                    <div class="user-item">
                        <div class="user-icon" style="background-color: yellow;"></div> 
                        <span class="user-name"><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <button class="unfollow-btn">解除</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <footer>
            <button class="back-btn" onclick="history.back()">戻る</button>
        </footer>
    </div>
</body>
</html>
