// 他のHTMLファイルを読み込む関数
function loadHTML(url, elementId) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Error loading HTML:', error));
    }

    // サイドバーを読み込む
    loadHTML('side.html', 'sidebar-container');


var content = document.getElementById("content");
var isDragging = false;
var initialX, initialY;

// マウスが押された時のイベントリスナーの設定
content.addEventListener("mousedown", function(event) {
    if (event.target.id !== "addCommentButton") {
        isDragging = true;
        initialX = event.clientX - content.offsetLeft;
        initialY = event.clientY - content.offsetTop;
        content.style.cursor = "grabbing";
        content.addEventListener("mousemove", mousemoveHandler);
    }
});

// マウスが離された時のイベントリスナーの設定
document.addEventListener("mouseup", function() {
    if (isDragging) {
        isDragging = false;
        content.style.cursor = "grab";
        content.removeEventListener("mousemove", mousemoveHandler);
    }
});

// マウスが動いた時のイベントリスナーの設定
function mousemoveHandler(event) {
    if (isDragging) {
        var newX = event.clientX - initialX;
        var newY = event.clientY - initialY;
        content.style.left = newX + "px";
        content.style.top = newY + "px";
    }
}

var addCommentButton = document.getElementById("addCommentButton");

// ボタンがクリックされた時のイベントリスナーの設定
addCommentButton.addEventListener("click", function(event) {
    // クリックしたときのマウス座標を取得
    var mouseX = event.clientX;
    var mouseY = event.clientY;

    // #content の位置を取得
    var contentRect = content.getBoundingClientRect();
    var contentLeft = contentRect.left;
    var contentTop = contentRect.top;

    // マウス座標を #content からの相対座標に変換
    var relativeX = mouseX - contentLeft;
    var relativeY = mouseY - contentTop;

    // 座標情報をURLのクエリパラメータに追加して画面遷移
    // var url = `newPage.html?x=${relativeX}&y=${relativeY}`;
    // window.location.href = url;

    //確認用
    alert(`Relative X: ${relativeX}px`);
    alert(`Relative Y: ${relativeY}px`);
});
