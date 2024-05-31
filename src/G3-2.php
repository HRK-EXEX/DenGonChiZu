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

// フォロー、フォロワーを表示したいユーザーIDを取得（URLのクエリパラメータから取得）
$display_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($display_user_id === 0) {
    die("ユーザーIDが指定されていません。");
}

if ($action !== 'follow' && $action !== 'followers') {
    die("表示アクションが指定されていません。");
}

// フォロワーリストを取得する関数
function getFollowerList($pdo, $user_id) {
    $sql = "SELECT Users.user_id, Users.user_name 
            FROM Followers 
            JOIN Users ON Followers.user_id = Users.user_id 
            WHERE Followers.followers_user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// フォローリストを取得する関数
function getFollowingList($pdo, $user_id) {
    $sql = "SELECT Users.user_id, Users.user_name 
            FROM Followers 
            JOIN Users ON Followers.followers_user_id = Users.user_id 
            WHERE Followers.user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 取得したフォロワーリストを表示する関数
function displayFollowerList($follower_list) {
    echo '<h2>フォロワー表示</h2>';
    echo '<ul class="follower-list">';
    foreach ($follower_list as $follower) {
        echo '<li class="follower-item">';
        echo '<div class="follower-pic" style="background-color: yellow;"></div>'; // プロフィール画像の取得方法に応じて変更
        echo '<span>' . htmlspecialchars($follower['user_name'], ENT_QUOTES, 'UTF-8') . '</span>';
        echo '<button class="unfollow-btn">解除</button>';
        echo '</li>';
    }
    echo '</ul>';
}

// 取得したフォローリストを表示する関数
function displayFollowingList($following_list) {
    echo '<h2>フォロー表示</h2>';
    echo '<ul class="following-list">';
    foreach ($following_list as $following) {
        echo '<li class="following-item">';
        echo '<div class="following-pic" style="background-color: yellow;"></div>'; // プロフィール画像の取得方法に応じて変更
        echo '<span>' . htmlspecialchars($following['user_name'], ENT_QUOTES, 'UTF-8') . '</span>';
        echo '<button class="unfollow-btn">解除</button>';
        echo '</li>';
    }
    echo '</ul>';
}

// フォロー、フォロワーリストを表示する処理
if ($action === 'followers') {
    $follower_list = getFollowerList($pdo, $display_user_id);
    $following_list = [];
} else {
    $follower_list = [];
    $following_list = getFollowingList($pdo, $display_user_id);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フォロー・フォロワー表示</title>
    <link rel="stylesheet" href="css/G3-2.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="profile-pic"></div>
            <h1><?php echo htmlspecialchars($_SESSION['user']['user_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        </header>
        <main>
            <?php
            // フォロワーリストを表示
            if ($action === 'followers') {
                displayFollowerList($follower_list);
            } else {
                // フォローリストを表示
                displayFollowingList($following_list);
            }
            ?>
        </main>
        <footer>
            <button class="back-btn" onclick="history.back()">戻る</button>
        </footer>
    </div>
</body>
</html>
