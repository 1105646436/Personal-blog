<?php
include_once '../init.php';

// 检查是否传递了文章ID
if (!isset($_GET['id'])) {
    die("未提供文章ID");
}

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 获取文章ID
$id = $_GET['id'];

// 准备删除文章的 SQL 语句
$sql = "DELETE comments, articles 
FROM articles 
LEFT JOIN comments 
ON articles.id = comments.article_id 
WHERE articles.id = $id;
";

// 执行删除操作
if (mysqli_query($conn, $sql)) {
    // 删除成功，重定向回文章管理页面
    header("Location: article_management.php");
    exit;
} else {
    echo "删除文章时出错: " . mysqli_error($conn);
}

// 关闭数据库连接
mysqli_close($conn);
