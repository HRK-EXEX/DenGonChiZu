document.addEventListener('DOMContentLoaded', function() {
    const likeIcons = document.querySelectorAll('.like-icon');

    likeIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const isLiked = this.classList.contains('liked');
            const action = isLiked ? 'unlike' : 'like';

            // AJAXリクエストを送信
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/like_post.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('post_id=' + encodeURIComponent(postId) + '&action=' + action);


            // 成功した場合の処理
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        if (action === 'like') {
                            icon.classList.add('liked');
                        } else if (action === 'unlike') {
                            icon.classList.remove('liked');
                        }
                        icon.nextElementSibling.textContent = response.new_like_count;
                    } else {
                        alert('いいねに失敗しました。');
                    }
                } else {
                    alert('サーバーエラーが発生しました。');
                }
            };
        });
    });
});
