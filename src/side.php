<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/side.css"/>
    <title>サイドバー</title>
</head>
<body>
    <?php
        $userId = $_SESSION['user']['user_id'] ?? null;
    ?>
    <div class="sidebar">
        <img src="../img/home.png" alt="画像1" onclick="window.location.href='G1-1.php';">
        <img src="../img/icon.png" alt="画像2" onclick="window.location.href='G3-1.php?myFollow=true';">
        <img src="../img/haguruma.png" alt="画像3" onclick="window.location.href='G4-1.php';">

        <?php if (isset($userId)): ?>
            <img src="../img/logout.png" alt="画像4" onclick="window.location.href='G1-7.php';">
        <?php else: ?>
            <img src="../img/login.png" alt="画像4" onclick="window.location.href='G1-6.php';">
        <?php endif; ?>
        
    </div>
</body>
</html>
