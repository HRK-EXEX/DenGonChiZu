<?php session_start(); ?>
<?php 
    require 'php/db.php';
    if(!isset($_SESSION['user'])){
        header("Location: G1-6.php");
        exit;
    }

    // idの取得
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];
    // $user_id = 3;//テスト
    
    //delete,G4-4遷移
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_flg'])){
        $sql=$db->prepare('delete from Users where user_id = ?');
        $sql->execute([$user_id]);
        session_destroy();
        header("Location: G4-4.php");
        exit;
    }
?>

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
    <div class="contents">    
        <h1 class="title is-3">退会を確定しますか</h1>
            <div class="buttons">
                <form action="G4-3.php" method="post"><!-- delete -->
                    <?php
                        echo '<input type="hidden" name="delete_flg" value="true">'; 
                        echo '<input type="hidden" name="user_id" value="' , $user_id ,'">';
                        echo '<button class="button is-danger is-large" type="submit">','退会','</button>';
                    ?>
                </form>
                    <button class="button has-background-grey-light is-large" type="button" onclick="history.back()">戻る</button>
            </div>
    </div>  
</body>
</html>