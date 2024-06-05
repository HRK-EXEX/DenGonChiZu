<?php
require 'php/db.php';
?>
<?php
require 'php/db.php';

if(isset($postId)) {
    try {
        $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $postId AND user_id = $userId");
        $res = $sql -> fetch(PDO::FETCH_ASSOC);

        $title = $_POST['post_title'] ?? $res['title'] ?? null;
        $image = $_POST['post_img'] ?? $res['img_path'] ?? null;
        $text = $_POST['post_text'] ?? $res['content'] ?? null;
    } catch (Exception $e) {
        // エラーの処理を行う
        echo 'エラーが発生しました: ',  $e->getMessage(), "\n";
    }
}
?>



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
                <div class="box-base title">"<?=$title?>"</div><br>
                <div class="title-base content">"<?=$text?>"</div>
                <div class="box-base image-box">      
                    <img class="image" src="<?=$image?>">
                </div><br>    
            </div>
            <div class="box-base comments">
                <?php
                for($i=0;$i<0;$i++) {
                    echo '<div class="comment-info">
                    <div class="user">    
                        <img class="icon-image" src="../img/NoImage.png">
                        <span class="username"></span>
                    </div>
                    <p>サイコーです。</p>
                    <hr>
                </div>';
                }
                ?>
                <!-- こめんと -->
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <input class="comment-area" placeholder="コメントを入力...">
            <button onclick="location.href='G1-1.php'" class="button-base send">送信</button>
            <?php
            ?>
        </div>
    </div>
</body>
</html>