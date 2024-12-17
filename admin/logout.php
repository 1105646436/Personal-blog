<?php
// 启动会话
session_start();

// 如果用户已经登录，则销毁会话
if (isset($_SESSION['username'])) {
    // 销毁会话变量
    $_SESSION = array();

    // 如果要清除的更彻底，那么同时删除会话 cookie
    // 注意：这样不仅销毁了会话中的数据，还会销毁会话本身
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // 最后销毁会话
    session_destroy();
}

// 重定向到登录页面
header("Location: ../index.php");
exit;
