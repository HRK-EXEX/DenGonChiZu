<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Navigation</title>
    <link rel="stylesheet" href="css/G1-2.css">
</head>
<body>
    <div class="container">
        <button class="button" id="loginButton">ログイン</button>
        <button class="button red" id="registerButton">会員登録</button>
        <button class="button yellow" id="guestButton">ゲスト</button>
    </div>

    <script>
        document.getElementById("loginButton").addEventListener("click", function() {
            window.location.href = "G1-6.php";
        });

        document.getElementById("registerButton").addEventListener("click", function() {
            window.location.href = "G1-3.php";
        });

        document.getElementById("guestButton").addEventListener("click", function() {
            window.location.href = "G1-1.php";
        });
    </script>
</body>
</html>
