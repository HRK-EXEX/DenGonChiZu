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

// 表示するユーザーID（後で変更）
$user_id = 1;

// 相手のユーザーIDを取得（URLのクエリパラメータから取得）
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id === 0) {
    die("ユーザーIDが指定されていません。");
}


// フォロー数を取得する関数
function getFollowCount($pdo, $user_id) {
    $sql = "SELECT COUNT(*) as follow_count FROM Followers WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['follow_count'];
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

// フォロー数とフォロワー数を取得
$follow_count = getFollowCount($pdo, $user_id);
$follower_count = getFollowerCount($pdo, $user_id);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="css/G3-1.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="profile-pic"></div>
            <h1><?php echo htmlspecialchars($_SESSION['user']['user_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <button class="follow-btn">フォロー</button>
        </header>
        <main>
            <a href="G3-2.html" class="link"><?php echo $follow_count; ?> フォロー</a>
            <a href="G3-2.html" class="link"><?php echo $follower_count; ?> フォロワー</a>
        </main>
        <footer>
            <button onclick="location.href='G1-1.php'" class="btn back-btn">戻る</button>
        </footer>
    </div>
</body>
</html>
