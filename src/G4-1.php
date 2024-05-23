<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員情報確認</title>
    <!-- bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="css/G4-1.css">
</head>
<body>

    <div class="main">

    <header>
    <!-- サイドバー読み込み位置  -->
    </header>

    <div class="title">
        <div class="left-column">
            <h4>会員情報</h4>
        </div>
        <div class="right-column">
            <button class="button is-danger is-large" onclick="location.href='G4-3.html'">退会</button>
        </div>
    </div>
    <hr  color="black">

    <!-- selectで情報取得,user_idを送信  -->

    <form action="G4-2.html" method="post">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-half is-offset-one-quarter">
                    <table class="table is-striped is-fullwidth">
                        <tbody>
                            <input type="hidden" name="user_id" value="user_id">
                                <tr><th>ユーザー名</th><td>〇〇〇〇</td></tr>
                                <tr><th>メールアドレス</th><td>aaaa@s.asojuku</td></tr>
                                <tr><th>パスワード</th><td>********</td></tr>
                                <tr><th>生年月日</th><td>2024/05/13</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="columns is-centered">
            <div class="buttons-container">
                <div class="column is-narrow">
                    <button class="button has-background-grey-light is-large" onclick="location.href='./G1-1.html'">戻る</button>
                </div>
                <div class="column is-narrow">
                    <input class="button is-info is-large" type="submit" value="変更">
                </div>
            </div>
        </div>
    </form>

</div>

</body>
</html>