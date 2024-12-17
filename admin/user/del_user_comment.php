<?php
session_start();
include_once '../../includes/config.php';
include_once '../../includes/functions.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 处理删除评论请求
if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];
    $username = $_SESSION['username'];

    // 首先检查评论是否属于当前用户，以防止非法操作
    $check_sql = "SELECT id FROM comments WHERE id = $comment_id AND commenter = '$username'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // 删除评论
        $delete_sql = "DELETE FROM comments WHERE id = $comment_id";
        if (mysqli_query($conn, $delete_sql)) {
            // 成功删除后，跳转回原页面
            header("Location: user_comment.php");
            exit;
        } else {
            echo "删除评论时出错: " . mysqli_error($conn);
        }
    } else {
        echo "无法删除此评论，可能因为评论不存在或者您无权操作。";
    }
} else {
    echo "未提供评论ID，无法删除评论。";
}

// 关闭数据库连接
mysqli_close($conn);
?>