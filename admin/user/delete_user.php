<?php
include_once '../init.php';

// 检查是否传递了要删除的用户ID
if (!isset($_GET['id'])) {
    // 如果没有传递用户ID，则返回到用户管理页面
    header("Location: user_management.php");
    exit;
}

// 获取要删除的用户ID
$user_id = $_GET['id'];

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 准备删除语句
$sql = "DELETE FROM users WHERE id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    // 绑定变量到预处理语句作为参数
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    // 设置参数
    $param_id = $user_id;

    // 执行预处理语句
    if (mysqli_stmt_execute($stmt)) {
        // 用户删除成功，重定向到用户管理页面
        header("Location: user_management.php");
        exit;
    } else {
        echo "出现了一些问题，请稍后再试。";
    }

    // 关闭语句
    mysqli_stmt_close($stmt);
}

// 关闭连接
mysqli_close($conn);
