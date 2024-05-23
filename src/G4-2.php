
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員情報変更</title>
    <!--bulma-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="css/G4-2.css">
</head>
<body>

<?php require 'php/db.php'; ?>

    <div class="main">

    <header>
    <!-- サイドバー読み込み位置 -->
    </header>

    <div class="title">
        <h4>会員情報変更</h4>
    </div>
    <hr  color="black">

    <!-- id受け取り,selectで情報表示 -->

    <?php
    // idの取得
    $user_id = $_[''];
    $sql=$pdo->prepare('select * from User where user_id=?');
    $sql->execute([$_POST['$user_id']]);
    $sql->execute([$user_id]);
    $result = $sql->fetch(PDO::FETCH_ASSOC);
?>

    <form action="*" method="post"><!-- update -->
        <div class="table-container">
            <!-- <table class="table is-striped"></table> -->
            <!-- <table class="table"> -->
                <!-- <div class="column is-half is-offset-one-quarter"> -->
                    <div class="column is-offset-one-quarter">
                    <table class="table is-striped is-fullwidth">
                <tbody>
                    <input type="hidden" name="user_id" value="user_id">
                    <tr><th>ユーザー名</th><td><input type="text" name="name"></td></tr>
                    <tr><th>メールアドレス</th><td><input type="email"  name="mail"></td></tr>
                    <tr><th>パスワード</th><td><input type="password" name="pass"></td></tr>
                    <tr><th>生年月日</th><td><input type="date" name="birth"></td></tr>
                </tbody>
            </table>
        </div>
    </div>
        <p>
            <input class="button is-info is-large" type = "submit"  value="変更"></button>
        </p>
         <!-- update後G1-1に遷移 -->
    </form>
</div>

</body>
</html>