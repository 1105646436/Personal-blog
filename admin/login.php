<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';

// 检查是否已经登录，如果是管理员，则重定向到管理员仪表盘页面
session_start();
if (isset($_SESSION['username'])) {
    if (is_admin($_SESSION['username'])) {
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: ../index.php");
        exit;
    }
}

// 连接到数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 检查是否提交了登录表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 处理登录逻辑
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 查询用户信息
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // 验证密码
        if ($password === $user['password']) {
            // 登录成功，将用户名保存到 session 中
            $_SESSION['username'] = $username;
            // 如果是管理员，重定向到管理员仪表盘页面
            if (is_admin($username)) {
                header("Location: dashboard.php");
                exit;
            } else {
                // 否则，重定向到主页
                header("Location: ../index.php");
                exit;
            }
        } else {
            // 登录失败，显示错误信息
            $login_error = "用户名或密码错误，请重试。";
        }
    } else {
        // 登录失败，显示错误信息
        $login_error = "用户名或密码错误，请重试。";
    }
}

// 关闭数据库连接
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="cmn-hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="body">
        <div class="login">
            <h2>登录</h2>
            <hr />
            <?php
            if (isset($login_error)) {
                echo "<p>$login_error</p>";
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input class="login-input" type="text" id="username" name="username" placeholder="请输入用户名"
                    required><br><br>
                <input class="login-input" type="password" id="password" name="password" placeholder="请输入密码"
                    required><br><br>
                <button class="login-input" type="submit">登录</button>
                <p class="register">没有账户 ?<a href="./register.php">现在注册</a></p>
            </form>
        </div>
    </div>
    <script src="../js/functions.js"></script>
</body>

</html>