<?php require 'php/db.php'; ?>
<?php
    //初期化
    $error = false;
    $errorMessage = '';

    // update処理,G1-1に遷移
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_flg'])){
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $birth = $_POST['birth'];

        try{
            $sql = 'update Users set user_name=:name, mail=:mail, pass=:pass, birthday=:birth where user_id=:user_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name',$name );
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':birth', $birth);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            header("Location: G1-1.php");
            exit;
        }catch(PDOException $e){
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
    <title>会員情報変更</title>
    <!--bulma-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="css/G4-2.css">
</head>
<body>

    <div class="main">

    <header>
    <!-- サイドバー読み込み位置 -->
    </header>

    <div class="title">
        <h4>会員情報変更</h4>
    </div>
    <hr class="hr">

    <?php
        $user_id = $_POST['user_id'];
        try{
            $sql='select * from Users where user_id = :user_id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $error = true;
            $errorMessage = "エラーが発生しました: " . $e->getMessage();
        }
    ?>

        <?php if ($error): ?>
            <p><?php echo $errorMessage; 
                header("Location: G1-1.php");
                exit;            
            ?></p>
        <?php else: ?>

    <form action="G4-2.php" method="post">
        <div class="table-container">
            <div class="column is-offset-one-quarter">
                <table class="table is-striped is-fullwidth">
                    <?php    
                        '<tbody>';
                        echo '<input type="hidden" name="user_flg" value="true">';
                        echo '<input type="hidden" name="user_id" value="' , $user_id ,'">';
                        echo '<tr>','<th>ユーザー名</th>','<td>','<input type="text" name="name" value="', htmlspecialchars($result['user_name']) ,'" "required">','</td>','</tr>';
                        echo '<tr>','<th>メールアドレス</th>','<td>','<input type="email"  name="mail" value="', htmlspecialchars($result['mail']) ,'" "required" >','</td>','</tr>';
                        echo '<tr>','<th>パスワード</th>','<td>','<input type="password" name="pass" required>','</td>','</tr>';
                        echo '<tr>','<th>生年月日</th>','<td>','<input type="date" name="birth" value="', htmlspecialchars($result['birthday']) ,'" "required">','</td>','</tr>';
                        '</tbody>';
                    ?>
                </table>
            </div>
        </div>
        <p>
            <input class="button is-info is-large" type = "submit"  value="変更"></button>
        </p>
    </form>
    <?php endif; ?>
    </div>
</body>
</html>