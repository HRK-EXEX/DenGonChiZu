<!-- G1-1遷移先座標受け取り関数 -->

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Page</title>
<link rel="stylesheet" href="css/newPage.css">
</head>
<body>
    <div id="content">
        <!-- ここにコンテンツを追加 -->
    </div>

    <script>
        // URLのクエリパラメータから座標を取得
        function getQueryParams() {
            var params = {};
            var queryString = window.location.search.slice(1);
            var pairs = queryString.split("&");
            pairs.forEach(function(pair) {
                var keyValue = pair.split("=");
                params[keyValue[0]] = decodeURIComponent(keyValue[1]);
            });
            return params;
        }

        var params = getQueryParams();
        var mouseX = params.x;
        var mouseY = params.y;

        // 座標を使用して投稿位置
        console.log(`X座標: ${mouseX}, Y座標: ${mouseY}`);

        
    </script>
</body>
</html>
