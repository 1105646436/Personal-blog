<?php
include_once '../init.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 从表单获取数据
    $new_username = $_POST['username'];
    $new_name = $_POST['name'];
    $new_userImgUrl = $_POST['user_imgurl'];
    $new_qq = $_POST['qq_number'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // 准备插入语句
    $sql = "INSERT INTO users (username, name, user_imgurl, email, qq_number, password, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // 绑定变量到预处理语句作为参数
        mysqli_stmt_bind_param($stmt, "ssssisi", $new_username, $new_name, $new_userImgUrl, $new_email, $new_qq, $new_password, $is_admin);

        // 执行预处理语句
        if (mysqli_stmt_execute($stmt)) {
            // 用户创建成功，重定向到用户管理页面
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
}
?>


<?php include_once '../templates/admin_header.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加用户</title>
    <style>
        .add_user {}

        table {
            width: 66%;
        }

        th {
            background-color: #f0f0f1;
        }

        td {
            padding: 8px;
            height: 20px;
        }

        input {
            height: 30px;
        }

        table td input {
            width: 80%;
            padding: 10px;
        }

        .add {
            width: 80px;
            height: 40px;
            border: 1px solid #1c8de2;
            border-radius: 5px;
            color: #1c8de2;
            font-size: 18px;
            background-color: white;
        }
    </style>
</head>

<body>

    <h1>添加用户</h1>

    <form class="add_user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $user_id; ?>"
        method="post">
        <table>
            <tr>
                <td><label for="username">用户名：</label></td>
                <td><input type="text" id="username" name="username" required></td>
            </tr>
            <tr>
                <td><label for="name">昵称：</label></td>
                <td><input type="text" id="name" name="name" required></td>
            </tr>
            <tr>
                <td><label for="userimg">头像链接：</label></td>
                <td><input type="text" id="userimg" name="user_imgurl" required></td>
            </tr>
            <tr>
                <td><label for="qq">QQ：</label></td>
                <td><input type="text" id="qq" name="qq_number" required></td>
            </tr>
            <tr>
                <td><label for="email">邮箱：</label></td>
                <td><input type="email" id="email" name="email" required></td>
            </tr>
            <tr>
                <!-- 新密码字段 -->
                <td><label for="password">密码：</label></td>
                <td><input type="text" id="password" name="password" required></td>
            </tr>
            <tr>
                <!-- 是否为管理员 -->
                <td><label for="is_admin">是否为管理员：</label></td>

                <td><input type="checkbox" id="is_admin" name="is_admin" <?php if ($row['is_admin'] == 1) {
                    echo 'checked';
                }
                ?>>
                </td>
            </tr>
        </table>
        <input class="add" type="submit" value="添加">
    </form>

    <!-- 引入尾部模板 -->
    <?php include_once '../templates/admin_footer.php'; ?>
</body>

</html>