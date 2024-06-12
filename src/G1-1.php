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

<!-- サイドバー実装は↓2行をコピーして。side.cssも読み込んで -->
    <div id="sidebar-container"></div>
    <?php include 'side.php'; ?>

    <div id="content">

    <?php
    session_start();

    
    class Database {
        private $conn;

        public function connect() {
            try {
                $this->conn = new PDO('mysql:host=mysql305.phy.lolipop.lan;dbname=LAA1517436-linedwork;charset=utf8', 'LAA1517436', 'hyperBassData627');
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;
        }
    }

    class Post {
        private $db;

        public function __construct() {
            $database = new Database();
            $this->db = $database->connect();
        }

        public function fetchPosts() {
            $query = '
            SELECT 
                p.user_id, 
                p.post_id,
                p.content, 
                p.title, 
                p.img_path, 
                p.post_good, 
                u.user_name, 
                COUNT(c.comment_id) AS comment_count
            FROM
                Posts p
            JOIN 
                Users u ON p.user_id = u.user_id
            LEFT JOIN 
                Comments c ON p.post_id = c.post_id
            GROUP BY 
                p.user_id, 
                p.post_id,
                p.content, 
                p.title, 
                p.img_path, 
                p.post_good, 
                u.user_name, 
                p.date
            ORDER BY 
                p.date DESC
        ';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //投稿ごとに距離を確保して表示範囲中心から出力する（もしかしたら表示方法変更するかも）
        public function calculatePosition($index, $totalPosts) {
            $centerX = 5000; // 10000px の中央
            $centerY = 5000; // 10000px の中央
            $radius = 1000; // 中心からの距離(調整予定)
            $minDistance = 300; // 最低距離
            $positions = [];
        
            for ($i = 0; $i < $totalPosts; $i++) {
                do {
                    $angle = rand(0, 360) * (M_PI / 180); // ランダムな角度を生成
                    $distance = $radius + rand(0, 4000); // 中心からのランダムな距離
                    $x = $centerX + $distance * cos($angle);
                    $y = $centerY + $distance * sin($angle);
                    $valid = true;
        
                    // 既存の投稿と距離をチェック
                    foreach ($positions as $position) {
                        $dx = $x - $position['x'];
                        $dy = $y - $position['y'];
                        if (sqrt($dx * $dx + $dy * $dy) < $minDistance) {
                            $valid = false;
                            break;
                        }
                    }
                } while (!$valid);
        
                $positions[] = ['x' => $x, 'y' => $y];
            }
        
            return $positions;
        }
        
        
        //取得した情報を使って投稿を表示する
        public function displayPosts() {
            $posts = $this->fetchPosts(); 
            $totalPosts = count($posts); // 合計値から配置間隔の割り出しをする用
            foreach ($posts as $index => $post) {
                $position = $this->calculatePosition($index, $totalPosts);
                echo '<div class="post-container" style="top: ' . $position['y'] . 'px; left: ' . $position['x'] . 'px;">';
                echo '    <div class="user-info">';
                echo '        <a href="G3-1.php?user_id=' . htmlspecialchars($post->user_id) . '">';
                echo '            <img src="../img/user_icon.jpg" alt="ユーザのアイコン">';
                echo '        </a>';

                echo '        <span class="username">' . htmlspecialchars($post->user_name) . '</span>';
                echo '    </div>';
                echo '    <div class="post-content">';
                echo '        <a href="G2-2.php?post_id=' . htmlspecialchars($post->post_id) . '&user_id=' . htmlspecialchars($post->user_id) . '">';
                echo '            <p>' . nl2br(htmlspecialchars($post->content)) . '</p>';
                echo '        </a>';
                // img_pathがnullでない、かつ画像が存在する場合のみ表示
                if (!empty($post->img_path) && file_exists(__DIR__ . '/../img/' . $post->img_path)) {
                    echo '        <img src="' . htmlspecialchars($post->img_path) . '" alt="投稿画像">';
                }
                echo '    </div>';
                echo '    <div class="interaction">';
                echo '        <span class="comment-icon">💬</span>';
                echo '        <span class="comment-count">' . htmlspecialchars($post->comment_count) . '</span>';
                echo '        <span class="like-icon">❤️</span>';
                echo '        <span class="like-count">' . htmlspecialchars($post->post_good) . '</span>';
                echo '    </div>';
                echo '</div>';
            }
        }
    }

    $post = new Post();
    $post->displayPosts();
    ?>
</div>

<!-- ボタンは #content の外に配置 -->
<button id="addCommentButton"></button>

<script src="js/G1-1.js"></script>
</body>
</html>