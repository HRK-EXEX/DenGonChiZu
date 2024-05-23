<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会</title>
    <!--bulma-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="css/G4-3.css">
</head>
<body>

    <!-- <div class="main"> -->
        <div class="contents">    
            <h1 class="title is-3">退会を確定しますか</h1>
                <div class="buttons">
                    <form action="G4-4.html" method="post">
                        <input type="hidden" name="user_id" value="user_id">
                        <button class="button is-danger is-large" type="submit">退会</button>
                    </form>
                    <button class="button has-background-grey-light is-large" type="button" onclick="history.back()">戻る</button>
                </div>
        </div>
    <!-- </div> -->
</body>
</html>