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
            <td>aaaa</td> 
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td>example@example.com</td> 
        </tr>
        <tr>
            <td>パスワード</td>
            <td>********</td> 
        </tr>
        <tr>
            <td>生年月日</td>
            <td>1990-01-01</td> 
        </tr>
    </table>
    <div class="button-container">
        <button class="btn-back">戻る</button>
        <button class="btn-register">登録確定</button>
    </div>
</div>

<script>
    // 戻るボタンのクリックイベント
    document.querySelector(".btn-back").addEventListener("click", function() {
        window.location.href = "G1-3.html";
    });

    // 登録ボタンのクリックイベント
    document.querySelector(".btn-register").addEventListener("click", function() {
        window.location.href = "G1-5.html";
    });
</script>
</body>
</html>
