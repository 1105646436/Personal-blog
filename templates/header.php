<?php
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
// 查询用户的头像 URL
$sql = "SELECT user_imgurl FROM users WHERE username = '$username'";
$userResult = mysqli_query($conn, $sql);
$userData = mysqli_fetch_assoc($userResult);
$userImgUrl = $userData['user_imgurl'];

// 关闭数据库连接
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人博客</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .white-bg {
            background-color: rgba(255, 255, 255, 0.80);
        }
    </style>
    <script>
        window.addEventListener('scroll', function () {
            var header = document.querySelector('.header');
            if (window.scrollY > 0) {
                header.classList.add('white-bg');
            } else {
                header.classList.remove('white-bg');
            }
        });
    </script>

</head>

<body>
    <div class="top">
        <header>
            <div class="header">
                <div class="nav">
                    <img class="logo" src="./favicon.ico" alt="favicon.ico">
                    <nav>
                        <ul class="liebiao">
                            <li><a href="index.php">首页</a></li>
                            <li><a href="archive.php">归档</a></li>
                            <li><a href="contact.php">留言</a></li>
                            <li><a href="about.php">关于</a></li>
                            <li><a href="search.php">搜索</a></li>
                            <li>
                                <?php if ($userImgUrl): ?>
                                    <a href="./admin/index.php"><img class="login" src="<?php echo $userImgUrl; ?>"
                                            alt="User Image"></a>
                                <?php else: ?>
                                    <a href="./admin/login.php"><img class="login" src="../img/image.png" alt="Login"></a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>