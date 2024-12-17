<?php
include_once '../init.php';

// 检查是否传递了评论ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // 如果未传递评论ID，重定向到评论管理页面或其他错误处理页面
    header("Location: comment_management.php");
    exit;
}

// 获取评论ID
$comment_id = $_GET['id'];

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 防止 SQL 注入
$comment_id = mysqli_real_escape_string($conn, $comment_id);

// 执行删除操作
$sql = "DELETE FROM comments WHERE id = '$comment_id'";
if (mysqli_query($conn, $sql)) {
    // 删除成功，重定向到评论管理页面
    header("Location: comment_management.php");
} else {
    // 删除失败，显示错误信息
    echo "删除评论时出错：" . mysqli_error($conn);
}

// 关闭数据库连接
mysqli_close($conn);
