<?php
// データベース接続情報
$dsn = 'mysql:host=mysql305.phy.lolipop.lan;dbname=LAA1517436-linedwork;charset=utf8';
$user = 'LAA1517436';
$password = 'hyperBassData627';

// POSTデータを取得
$username = $_POST['username'];
$mail = $_POST['mail'];
$pass = $_POST['pass'];
$birthdate = $_POST['birthdate'];

try {
    // データベースに接続
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースにデータを挿入
    $stmt = $dbh->prepare("INSERT INTO Users (username, mail, pass, birthdate) VALUES (:username, :mail, :pass, :birthdate)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':pass', password_hash($pass, PASSWORD_DEFAULT));
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->execute();

    $message = "登録が完了しました。";
} catch (PDOException $e) {
    $message = "エラーが発生しました: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/G1-5.css">
    <title>登録完了</title>
</head>
<body>
    <div class="container">
        <h1><?php echo $message; ?></h1>
        <?php if ($message == "登録が完了しました。"): ?>
            <p>以下の情報で登録が完了しました：</p>
            <table>
                <tr>
                    <td>ユーザー名</td>
                    <td><?php echo htmlspecialchars($username); ?></td>
                </tr>
                <tr>
                    <td>メールアドレス</td>
                    <td><?php echo htmlspecialchars($mail); ?></td>
                </tr>
                <tr>
                    <td>生年月日</td>
                    <td><?php echo htmlspecialchars($birthdate); ?></td>
                </tr>
            </table>
        <?php endif; ?>
        <a href="G1-3.html">TOP画面に戻る</a>
    </div>
</body>
</html>
