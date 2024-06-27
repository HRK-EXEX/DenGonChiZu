<?php
// データベース接続情報
$dsn = 'mysql:host=mysql305.phy.lolipop.lan;dbname=LAA1517436-linedwork;charset=utf8';
$user = 'LAA1517436';
$password = 'hyperBassData627';

$username = $_POST['username'];
$mail = $_POST['mail'];
$pass = $_POST['pass'];
$birthdate = $_POST['birthdate'];

$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

try {
    // データベースに接続
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースにデータを挿入
    $stmt = $dbh->prepare("INSERT INTO Users (user_name, mail, pass, birthday) VALUES (:username, :mail, :pass, :birthdate)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':pass', $hashedPass); 
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->execute();

    // 登録が完了したらユーザー情報を取得してセッションに保存
    $stmt = $dbh->prepare("SELECT * FROM Users WHERE mail = :mail");
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // セッションにユーザー情報を保存
    session_start();
    $_SESSION['user'] = $user;

    $message = "登録完了。";



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

            <a href="G1-1.php" class="button">TOP画面に戻る</a>

        
    </div>
</body>
</html>

