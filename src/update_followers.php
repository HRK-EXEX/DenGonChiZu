<?php
header('Content-Type: application/json');

$servername = "mysql305.phy.lolipop.lan";
$username = "LAA1517436";
$password = "hyperBassData627";
$dbname = "LAA1517436-linedwork";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($user_id > 0) {
        // フォロワー数を更新
        $stmt = $pdo->prepare("INSERT INTO Followers (user_id, followers_user_id) VALUES (:user_id, :followers_user_id)");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':followers_user_id', 2, PDO::PARAM_INT); // 2はフォロワーのuser_idとします
        $stmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
