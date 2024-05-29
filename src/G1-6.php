<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // データベース接続情報
    $dsn = 'mysql:host=mysql305.phy.lolipop.lan;dbname=LAA1517436-linedwork;charset=utf8';
    $user = 'LAA1517436';
    $password = 'hyperBassData627';

    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    try {
        // データベースに接続
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ユーザー情報を取得
        $stmt = $dbh->prepare("SELECT user_id, pass FROM Users WHERE mail = :mail");
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // パスワードの検証
        if ($result && password_verify($pass, $result['pass'])) {
            $_SESSION['user_id'] = $result['user_id'];
            // ログイン成功後、G1-1.phpにリダイレクト
            header("Location: G1-1.php");
            exit();
        } else {
            $error_message = "メールアドレスまたはパスワードが間違っています。";
        }
    } catch (PDOException $e) {
        $error_message = "エラー: " . $e->getMessage();
    }

    // データベース接続を閉じる
    $dbh = null;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/G1-6.css"/>
    <title>ログイン</title>
</head>
<body>
    <div class="form-container">
        <!-- エラーメッセージの表示 -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form action="G1-6.php" method="POST">
            <div class="input-group">
                <label for="mail">メールアドレス</label><br>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div class="input-group">
                <label for="pass">パスワード</label><br>
                <input type="password" id="pass" name="pass" required>
            </div>
            <div class="link-container">
                <a href="G1-3.html">会員登録</a>
            </div>
            <div class="link-container">
                <a href="G1-1.html">ゲストログイン</a>
            </div>
            <div class="button-container">
                <button class="button is-medium" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</body>
</html>
