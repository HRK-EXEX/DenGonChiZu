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

    //初期化
    $error = false;
    $errorMessage = '';
    
    //delete,G4-4遷移
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_flg'])){
        try {
            $sql='delete from Users where user_id = :user_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            session_destroy();
            header("Location: G4-4.php");
            exit;
        } catch (PDOException $e) {
            $error = true;
            $errorMessage = "エラーが発生しました: " . $e->getMessage();
        }
        
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会</title>
    <!-- bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="css/G4-3.css">
</head>
<body>
    <div class="main">
    <div class="has-text-centered">
    <?php if ($error): ?>
        <p><?php echo $errorMessage; 
            header("Location: G1-1.php");
            exit;            
        ?></p>
    <?php else: ?>
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
    <?php endif; ?>
    </div>
    </div>  
</body>
</html>