<?php 
        require 'php/db.php';

        // 自己遷移がなので、セッション重複回避処理
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // postId を GET パラメータとして受け取る
        $postId = isset($_GET['post_id']) ? $_GET['post_id'] : null;

        // セッションからユーザーIDを取得
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
            die("ログイン情報が見つかりません。");
        }

        $my_userId = $_SESSION['user']['user_id'];


        if(isset($postId)) {
            try {
                $sql = $db -> query("SELECT * FROM Posts WHERE post_id = $postId AND user_id = $my_userId");
                $res = $sql -> fetch(PDO::FETCH_ASSOC);

                $title = $_POST['post_title'] ?? $res['title'] ?? "情報が未入力です";
                $image = $_POST['post_img'] ?? $res['img_path'] ?? null;
                $text = $_POST['post_text'] ?? $res['content'] ?? "情報が未入力です";
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
                <!-- 画像がない場合は非表示にする -->
                <div class="box-base image-box">      
                    <img class="image" src="<?=$image?>">
                </div><br>    
            </div>
            <div class="comments_area">
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
            </div>
        </div>
        <div class="operation">
            <button onclick="location.href='G1-1.php'" class="button-base back">戻る</button>
            <input class="comment-input" placeholder="コメントを入力...">
            <button onclick="location.href='G1-1.php'" class="button-base send">送信</button>
            <?php
            ?>
        </div>
    </div>
</body>
</html>