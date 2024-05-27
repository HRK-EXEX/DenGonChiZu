<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/G1-3.css"/>
    <title>会員登録</title>
</head>
<body>
    <div class="main">
    
    <form  action="G1-4.php"  method="post">
        <p>
            <label for="username">ユーザ名</label><br>
            <div class="box1">
                <input type="text" id="username" name="username"  placeholder="ユーザ名を入力してください" required>
            </div>
        </p>
        <p>
            <label for="mail">メールアドレス</label><br>
            <div class="box1">
                <input type="email" id="mail" name="mail"  placeholder="メールアドレスを入力してください" required>
            </div>
        </p>
        <p>
            <label for="pass">パスワード</label><br>
            <div class="box2">
                <input type="password" id="pass" name="pass"  placeholder="パスワードを入力してください" required>
            </div>
        </p>
        <p>
            <label for="birthdate">生年月日</label><br>
            <div class="box3">
                <input type="date" id="birthdate" name="birthdate" required>
            </div>
        </p>
        <button type="submit" class="btn">登録</button>
    </form>

</div>

    <script>

    </script>
</body>
</html>
