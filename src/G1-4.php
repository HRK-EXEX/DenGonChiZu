<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/G1-4.css"/>
<title>登録内容の確認</title>
</head>
<body>
<div class="main">
    <h1>登録内容をご確認ください</h1>
    <table>
        <tr>
            <td>ユーザ名</td>
            <td><?php echo htmlspecialchars($_POST['username']); ?></td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td><?php echo htmlspecialchars($_POST['mail']); ?></td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td>********</td>
        </tr>
        <tr>
            <td>生年月日</td>
            <td><?php echo htmlspecialchars($_POST['birthdate']); ?></td>
        </tr>
    </table>
    <div class="button-container">
        <button class="btn-back" onclick="history.back()">戻る</button>
        <form action="G1-5.php" method="post">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($_POST['username']); ?>">
            <input type="hidden" name="mail" value="<?php echo htmlspecialchars($_POST['mail']); ?>">
            <input type="hidden" name="pass" value="<?php echo htmlspecialchars($_POST['pass']); ?>">
            <input type="hidden" name="birthdate" value="<?php echo htmlspecialchars($_POST['birthdate']); ?>">
            <button type="submit" class="btn-register">登録確定</button>
        </form>
    </div>
</div>

<script>
// 戻るボタンのクリックイベント
document.querySelector(".btn-back").addEventListener("click", function() {
    window.history.back();
});
</script>
</body>
</html>
