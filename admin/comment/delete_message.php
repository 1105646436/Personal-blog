<?php
include_once '../init.php';

// 检查是否是 POST 请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 检查是否设置了删除操作
    if (isset($_POST['delete'])) {
        $message_id = $_POST['delete'];

        // 连接数据库
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // 检查数据库连接是否成功
        if (!$conn) {
            die("数据库连接失败: " . mysqli_connect_error());
        }

        // 准备 SQL 语句
        $sql = "DELETE FROM messages WHERE id = ?";

        // 准备并执行预处理语句
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // 绑定参数
            mysqli_stmt_bind_param($stmt, "i", $message_id);

            // 执行预处理语句
            if (mysqli_stmt_execute($stmt)) {
                // 删除成功，重定向回留言管理页面
                header("Location: message.php");
                exit;
            } else {
                // 删除失败
                echo "删除留言时出现问题：" . mysqli_error($conn);
            }

            // 关闭预处理语句
            mysqli_stmt_close($stmt);
        } else {
            // 准备语句失败
            echo "准备删除留言的 SQL 语句时出现问题：" . mysqli_error($conn);
        }

        // 关闭数据库连接
        mysqli_close($conn);
    } else {
        // 没有设置删除操作
        echo "未指定要删除的留言。";
    }
} else {
    // 不是 POST 请求
    echo "只允许 POST 请求。";
}
