<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>伝言地図 - 投稿内容</title>
    <link rel="stylesheet" href="css/G2-1.css">
    <link rel="stylesheet" href="css/G2-2.css">
</head>
<body>
    <div class="parent">
        <div class="edit">
            <button onclick="location.href='G2-3.html'" class="button-base proceed">編集</button>  
        </div>
        <div class="show-part">
            <div class="details-part">
                <div class="box-base title"><?= htmlspecialchars($title) ?></div>
                <div class="title-base content"><?= htmlspecialchars($text) ?></div>
                <?php if ($image): ?>
                    <div class="box-base image-box">
                        <img class="image" src="<?= htmlspecialchars($image) ?>">
                    </div>
                <?php endif; ?>
                <div class="comments">
                    <!-- コメントの表示ロジックを追加 -->
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="comment-info">
                            <div class="user">
                                <img class="icon-image" src="../img/NoImage.png" alt="ユーザーアイコン">
                                <span class="username">ユーザー名</span>
                                <button class="options-button">…</button>
                            </div>
                            <div class="comment-box">
                                <p>サイコーです。</p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <input class="comment-input" placeholder="コメントを入力...">
            <button onclick="location.href='G1-1.php'" class="button-base send">送信</button>
        </div>
    </div>
</body>
</html>
