<?php
function is_admin($username)
{
    // 连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 检查数据库连接是否成功
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 查询用户是否为管理员
    $sql = "SELECT is_admin FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // 如果查询失败，返回 false
    if (!$result) {
        mysqli_close($conn);
        return false;
    }

    // 获取查询结果
    $row = mysqli_fetch_assoc($result);

    // 关闭数据库连接
    mysqli_close($conn);

    // 如果用户存在且为管理员，则返回 true，否则返回 false
    return $row['is_admin'] ? true : false;
}

session_start();