<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>G1-1</title>
<link rel="stylesheet" href="css/G1-1.css">
<link rel="stylesheet" href="css/side.css">
</head>
<body>

    <div id="sidebar-container"></div>

    <div id="content">
        <!-- 投稿座標部分 -->
        <div class="post-container" style="top: 200px; left: 300px;">
            <div class="user-info">
                <img src="../img/user_icon.jpg" alt="ユーザのアイコン">
                <span class="username">ユーザ名</span>
            </div>
            <div class="post-content">
                <p>投稿内容がここに表示されます。投稿内容がここに表示されます。投稿内容がここに表示されます。</p>
            </div>
            <div class="interaction">
                <span class="comment-icon">💬</span>
                <span class="comment-count">5</span>
                <span class="like-icon">❤️</span>
                <span class="like-count">10</span>
            </div>
        </div>

        <!-- 後で投稿部分はphp関数化する -->
        <div class="post-container" style="top: 400px; left: 700px;">
            <div class="user-info">
                <img src="../img/user_icon.jpg" alt="ユーザのアイコン">
                <span class="username">ユーザ名</span>
            </div>
            <div class="post-content">
                <p>投稿内容がここに表示されます。投稿内容がここに表示されます。投稿内容がここに表示されます。
                    投稿内容がここに表示されます。投稿内容がここに表示されます。投稿内容がここに表示されます。
                </p>
                <img src="../img/user_icon.jpg" alt="投稿画像">

            </div>
            <div class="interaction">
                <span class="comment-icon">💬</span>
                <span class="comment-count">25</span>
                <span class="like-icon">❤️</span>
                <span class="like-count">190</span>
            </div>
        </div>
    </div>

    <!-- ボタンは #content の外に配置 -->
    <button id="addCommentButton"></button>

    <script src="js/G1-1.js"></script>
</body>
</html>
