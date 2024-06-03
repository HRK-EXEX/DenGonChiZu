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

// 相手のユーザー名を取得
$sql = "SELECT user_name FROM Users WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("指定されたユーザーが見つかりません。");
}

// フォロー状態を確認する関数
function isFollowing($pdo, $my_user_id, $user_id) {
    $sql = "SELECT COUNT(*) as count FROM Followers WHERE user_id = :my_user_id AND followers_user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':my_user_id', $my_user_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
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

// フォロー処理
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'follow') {
        // フォローデータを挿入
        $sql = "INSERT INTO Followers (user_id, followers_user_id) VALUES (:my_user_id, :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':my_user_id', $my_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($_GET['action'] == 'unfollow') {
        // フォローデータを削除
        $sql = "DELETE FROM Followers WHERE user_id = :my_user_id AND followers_user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':my_user_id', $my_user_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    // フォロー数を更新
    header("Location: ".$_SERVER['PHP_SELF']."?user_id=".$user_id);
    exit;
}

// ユーザー名、フォロー数、フォロワー数を取得
$user_name = $user['user_name'];
$follow_count = getFollowCount($pdo, $user_id);
$follower_count = getFollowerCount($pdo, $user_id);

// フォロー状態を確認
$is_following = isFollowing($pdo, $my_user_id, $user_id);
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
            <h1><?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php if ($is_following): ?>
                <a href="?user_id=<?php echo $user_id; ?>&action=unfollow" class="follow-btn">フォロー解除</a>
            <?php else: ?>
                <a href="?user_id=<?php echo $user_id; ?>&action=follow" class="follow-btn">フォロー</a>
            <?php endif; ?>
        </header>
        <main>
            <a href="G3-2.php?action=follow&user_id=<?php echo $user_id; ?>" class="link"><?php echo $follow_count; ?> フォロー</a>
            <a href="G3-2.php?action=followers&user_id=<?php echo $user_id; ?>" class="link"><?php echo $follower_count; ?> フォロワー</a>
        </main>
        <footer>
            <button onclick="location.href='G1-1.php'" class="btn back-btn">戻る</button>
        </footer>
    </div>
</body>
</html>
