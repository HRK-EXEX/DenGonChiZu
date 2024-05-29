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

// ユーザーIDを取得（URLのクエリパラメータから取得する例）
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 1;  // デフォルトで1番のユーザーとする

// ユーザー情報を取得するSQL
$sql = "SELECT user_name FROM Users WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("ユーザーが見つかりません。");
}
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
            <h1><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <button class="follow-btn">フォロー</button>
        </header>
        <main>
            <!-- ここにフォローやフォロワーの情報を追加する場合は、別途クエリが必要です -->
            <a href="G3-2.html" class="link">1000フォロー</a>
            <a href="G3-2.html" class="link">20000フォロワー</a>
        </main>
        <footer>
            <button onclick="location.href='G1-1.php'" class="btn back-btn">戻る</button>
        </footer>
    </div>
</body>
</html>
