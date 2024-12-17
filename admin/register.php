<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
$baseUrl = URL;
// 检查是否已经登录，如果是，则重定向到仪表盘页面
session_start();
if (isset($_SESSION['username'])) {
    header("Location: {$baseUrl}/admin/index.php");
    exit;
}

// 初始化变量
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 检查用户名
    if (empty(trim($_POST["username"]))) {
        $username_err = "请输入用户名";
    } else {
        $username = trim($_POST["username"]);
        // 检查用户名是否已存在
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "该用户名已被使用";
                }
            } else {
                echo "出现了一些问题，请稍后再试。";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }

    // 检查邮箱
    if (empty(trim($_POST["email"]))) {
        $email_err = "请输入邮箱";
    } else {
        $email = trim($_POST["email"]);
        // 检查邮箱是否已存在
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "该邮箱已被使用";
                }
            } else {
                echo "出现了一些问题，请稍后再试。";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }

    // 检查密码
    if (empty(trim($_POST["password"]))) {
        $password_err = "请输入密码";
    } else {
        $password = trim($_POST["password"]);
    }

    // 验证是否有输入错误
    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        // 如果没有输入错误，将用户数据插入数据库
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (!$conn) {
            die("数据库连接失败: " . mysqli_connect_error());
        }
        // 从表单获取数据
        $name = $_POST['name'];
        $qq = $_POST['qq'];
        $userImgUrl = "http://q1.qlogo.cn/g?b=qq&nk=$qq&s=100";
        // 准备插入语句
        $sql = "INSERT INTO users (username, name, user_imgurl, email, qq_number, password) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // 绑定变量到预处理语句作为参数
            mysqli_stmt_bind_param($stmt, "ssssis", $username, $name, $userImgUrl, $email, $qq, $password);

            // 执行预处理语句
            if (mysqli_stmt_execute($stmt)) {
                // 用户创建成功，重定向到用户管理页面
                header("Location: login.php");
                exit;
            } else {
                echo "出现了一些问题，请稍后再试。";
            }

            // 关闭语句
            mysqli_stmt_close($stmt);
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册</title>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <div class="body">
        <div class="register">
            <h2>用户注册</h2>
            <hr style="margin-bottom:20px;" />
            <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input class="register-input" type="text" id="username" name="username" placeholder="请输入用户名"
                    required></br>
                <p class="remind-font"><span class="remind" id="usernameError"></span></p>
                <input class="register-input spacing" type="text" id="name" name="name" placeholder="请输入昵称"
                    required></br>
                <input class="register-input spacing" type="text" id="qq" name="qq" placeholder="请输入QQ" required></br>
                <input class="register-input" type="email" id="email" name="email" placeholder="请输入邮箱" required></br>
                <p class="remind-font"><span class="remind" id="emailError"></span></p>
                <input class="register-input spacing" type="password" id="password" name="password" placeholder="请输入密码"
                    required>
                <button class="register-input" type="submit">注册</button>
                <p class="login">已有账户 ?<a href="./login.php">现在登录</a></p>
            </form>
        </div>
    </div>
    <script src="../js/register.js"></script>
</body>

</html>