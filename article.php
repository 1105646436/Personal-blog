<?php
// 包含共享的 PHP 文件
include_once 'includes/config.php';
include_once 'includes/functions.php';
include_once 'includes/Parsedown.php';

// 检查是否传入了文章 ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // 如果未传入文章 ID，重定向到主页或其他错误处理页面
    header("Location: index.php");
    exit;
}

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}
session_start();
// 如果用户已经登录并且会话中存在用户名，则将其存储在 $username 变量中
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // 用户未登录，将 $username 设置为 null 或其他默认值
    $username = null;
}
// 获取文章 ID
$article_id = mysqli_real_escape_string($conn, $_GET['id']);

// 查询指定 ID 的文章
$sql = "SELECT * FROM articles WHERE id = '$article_id'";
$result = mysqli_query($conn, $sql);

// 检查是否找到了指定文章
if (mysqli_num_rows($result) == 0) {
    // 如果未找到文章，重定向到主页或其他错误处理页面
    header("Location: error.php");
    exit;
}

// 获取文章内容
$row = mysqli_fetch_assoc($result);

// 查询文章的评论
$comment_sql = "SELECT c.id AS comment_id, 
       c.article_id, 
       c.commenter, 
       c.comment, 
       c.comment_date, 
       u.user_imgurl, 
       u.name AS commenter_name
FROM comments c
INNER JOIN users u ON c.commenter = u.username
WHERE c.article_id = '$article_id'
AND c.approved = TRUE
ORDER BY c.comment_date DESC;
";
$comment_result = mysqli_query($conn, $comment_sql);

// 检查用户是否登录
session_start();
$user_logged_in = isset($_SESSION['username']);

// 关闭数据库连接
mysqli_close($conn);
?>
<!-- 头部模板 -->
<?php include_once 'templates/header.php'; ?>

<head>
    <link rel="stylesheet" href="./css/article.css">
    <link rel="stylesheet" href="./css/prism.css">
    <style>
        .bg-img {
            width: 100%;
            height: 50vh;
            background-image: url(<?php echo '.' . $row['image_path'] ?>);
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    // 创建 Parsedown 对象
    $Parsedown = new Parsedown();
    // 设置为不转义 HTML 标签
    $Parsedown->setMarkupEscaped(true);
    // 使用 Parsedown 对象的 text() 方法将 Markdown 内容解析为 HTML
    $html_content = $Parsedown->text($row['content']);
    // 在文章内容部分将解析后的 HTML 内容输出到页面
    ?>
    <div class="rongqi">
        <!-- 文章内容 -->
        <div class="bg-img">
            <h1><?php echo $row['title']; ?></h1>
            <p>发布日期：<?php echo $row['publish_date']; ?></p>
            <p>简介：<?php echo $row['intro']; ?></p>
        </div>
        <!-- 在文章内容部分将解析后的 HTML 内容输出到页面 -->
        <div><?php echo $html_content; ?></div>
        <hr />
        <!-- 评论区 -->
        <div class="comments">

            <h3 class="com-tit">发表评论</h3>
            <!-- 如果用户已登录，则显示评论提交表单 -->
            <?php if ($user_logged_in): ?>
                <!-- 评论提交表单 -->
                <form action="submit_comment.php" method="post">
                    <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                    <label for="comment">评论内容：</label><br>
                    <textarea class="comment" id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
                    <input class="com-btn" type="submit" value="提交评论">
                </form>
            <?php else: ?>
                <p><a style="color:gold;" href="./admin/login.php">登录</a>后才能评论。</p>
                <p>还没有账号？快去<a style="color:gold;" href="./admin/register.php">注册</a>吧！</p>
            <?php endif; ?>
        </div>
        <?php
        if (mysqli_num_rows($comment_result) > 0) {
            while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                echo "<div class='acomment'><div class='avatar'><div><img width='66' height='66' alt='avatar' src='" . $comment_row['user_imgurl'] . "'></div>";
                echo "<div><p style='font-size:16px; line-height:33px; '><strong>" . $comment_row['commenter_name'] . "</strong></p><p style='font-size:12px; line-height:33px; text-align:center;'>" . $comment_row['comment_date'] . "</p></div>";
                echo "<p style='font-size:16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $comment_row['comment'] . "</p></div></div>";
            }
        } else {
            echo "<p class='comments'>暂无评论</p>";
        }
        ?>
        <!-- 尾部模板 -->
        <?php include_once 'templates/footer.php'; ?>
        <!-- 引入 Prism.js 库 -->
        <script src="./js/prism.js"></script>
        <!-- 引入 Prism.js 的复制插件 -->
        <script src="./js/prism-copy-to-clipboard.min.js"></script>
        <!-- 初始化 Prism.js -->
        <script>
            Prism.highlightAll();
            // 初始化代码高亮

            var codeBlocks = document.querySelectorAll('.code-container pre');
            // 获取所有代码块

            codeBlocks.forEach(function (codeBlock) {
                var button = document.createElement('button');
                // 创建复制按钮

                button.textContent = '复制';
                // 设置按钮文本

                button.className = 'copy-button';
                // 设置按钮类名

                button.addEventListener('click', function () {
                    var code = codeBlock.textContent;
                    // 获取代码块文本

                    navigator.clipboard.writeText(code);
                    // 将代码复制到剪贴板
                });

                codeBlock.parentNode.insertBefore(button, codeBlock.nextSibling);
                // 将按钮插入到代码块后面
            });
        </script>
</body>

</html>