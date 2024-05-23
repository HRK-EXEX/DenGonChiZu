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

    <?php
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
            $query = 'SELECT * FROM Posts ORDER BY date DESC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function calculatePosition($index, $totalPosts) {
            $centerX = 5000; // 10000px の中央
            $centerY = 5000; // 10000px の中央
            $angle = (2 * M_PI / $totalPosts) * $index; // 円周上の等間隔の角度
            $radius = 500; // 中心からの距離(調整予定)
            $x = $centerX + $radius * cos($angle);
            $y = $centerY + $radius * sin($angle);
            return ['x' => $x, 'y' => $y];
        }

        public function displayPosts() {
            $posts = $this->fetchPosts();//posts情報を取得
            $totalPosts = count($posts);//合計値から配置間隔の割り出しをする用
            foreach ($posts as $index => $post) {
                $position = $this->calculatePosition($index, $totalPosts);
                echo '<div class="post-container" style="top: ' . $position['y'] . 'px; left: ' . $position['x'] . 'px;">';
                echo '    <div class="user-info">';
                echo '        <img src="../img/user_icon.jpg" alt="ユーザのアイコン">';
                echo '        <span class="username">' . htmlspecialchars($post->username) . '</span>';
                echo '    </div>';
                echo '    <div class="post-content">';
                echo '        <p>' . nl2br(htmlspecialchars($post->content)) . '</p>';
                if (!empty($post->image)) {
                    echo '        <img src="' . htmlspecialchars($post->image) . '" alt="投稿画像">';
                }
                echo '    </div>';
                echo '    <div class="interaction">';
                echo '        <span class="comment-icon">💬</span>';
                echo '        <span class="comment-count">' . htmlspecialchars($post->comment_count) . '</span>';
                echo '        <span class="like-icon">❤️</span>';
                echo '        <span class="like-count">' . htmlspecialchars($post->like_count) . '</span>';
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
