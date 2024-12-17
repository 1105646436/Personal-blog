<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

// 检查是否传入了文章 ID 和评论内容
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['article_id']) && isset($_POST['comment'])) {
    // 获取提交的数据并进行简单的验证
    $article_id = $_POST['article_id'];
    $comment = $_POST['comment'];

    // 连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 检查数据库连接是否成功
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 防止 SQL 注入
    $article_id = mysqli_real_escape_string($conn, $article_id);
    $comment = mysqli_real_escape_string($conn, $comment);

    // 获取评论者用户名（假设已经在 session 中存储了）
    session_start();
    // 如果用户已经登录并且会话中存在用户名，则将其存储在 $username 变量中
    if (isset($_SESSION['username'])) {
        $commenter = $_SESSION['username'];
    } else {
        $commenter = 'null';
    }

    // 如果评论者为空，说明用户未登录，不能提交评论
    if (empty($commenter)) {
        die("未登录，无法提交评论。");
    }

    // 构造插入评论的 SQL 语句
    $sql = "INSERT INTO comments (article_id, commenter, comment) VALUES ('$article_id', '$commenter', '$comment')";

    // 执行 SQL 查询
    if (mysqli_query($conn, $sql)) {
        // 评论成功添加到数据库中，重定向到文章页面
        header("Location: article.php?id=$article_id");
    } else {
        // 添加评论到数据库失败，显示错误信息
        echo "提交评论时出错：" . mysqli_error($conn);
    }

    // 关闭数据库连接
    mysqli_close($conn);
} else {
    // 如果未传入必要的参数，重定向到主页或其他错误处理页面
    header("Location: index.php");
    exit;
}
