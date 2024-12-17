<?php
include_once '../init.php';

// 检查是否传递了要编辑的用户ID
if (!isset($_GET['id'])) {
    // 如果没有传递用户ID，则返回到用户管理页面
    header("Location: user_management.php");
    exit;
}

// 获取要编辑的用户ID
$user_id = $_GET['id'];

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询要编辑的用户信息
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);

// 检查查询结果
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $name = $row['name'];
    $userImgUrl = $row['user_imgurl'];
    $email = $row['email'];
    $qq = $row['qq_number'];
    $userImgUrl = $row['user_imgurl'];
    $password = $row['password'];
    // 其他用户信息可以根据需要添加
} else {
    // 如果未找到用户，则返回到用户管理页面
    header("Location: user_management.php");
    exit;
}

// 关闭数据库连接
mysqli_close($conn);

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $new_username = $_POST['username'];
    $new_name = $_POST['name'];
    $new_userImgUrl = $_POST['user_imgurl'];
    $new_email = $_POST['email'];
    $new_qq = $_POST['qq_number'];
    $new_password = $_POST['password']; // 新密码
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // 是否为管理员

    // 更新用户信息
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 检查数据库连接是否成功
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 准备更新语句
    $sql = "UPDATE users SET username=?, name=?, user_imgurl=?, email=?, qq_number=?, password=?,is_admin=? WHERE id=?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // 绑定变量到预处理语句作为参数
        mysqli_stmt_bind_param($stmt, "ssssisii", $new_username, $new_name, $new_userImgUrl, $new_email, $new_qq, $new_password, $is_admin, $user_id);

        // 执行预处理语句
        if (mysqli_stmt_execute($stmt)) {
            // 用户信息更新成功，重定向到用户管理页面
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
    <title>编辑用户</title>
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

    <h1>编辑用户</h1>
    <form class="add_user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $user_id; ?>"
        method="post">
        <table>
            <tr>
                <td><label for="username">用户名：</label></td>
                <td><input type="text" id="username" name="username" value="<?php echo $username; ?>" required></td>
            </tr>
            <tr>
                <td><label for="name">昵称：</label></td>
                <td><input type="text" id="name" name="name" value="<?php echo $name; ?>" required></td>
            </tr>
            <tr>
                <td><label for="userimg">头像链接：</label></td>
                <td><input type="text" id="userimg" name="user_imgurl" value="<?php echo $userImgUrl; ?>" required></td>
            </tr>
            <tr>
                <td><label for="qq">QQ：</label></td>
                <td><input type="text" id="qq" name="qq_number" value="<?php echo $qq; ?>" required></td>
            </tr>
            <tr>
                <td><label for="email">邮箱：</label></td>
                <td><input type="email" id="email" name="email" value="<?php echo $email; ?>" required></td>
            </tr>
            <tr>
                <!-- 新密码字段 -->
                <td><label for="password">新密码：</label></td>
                <td><input type="text" id="password" name="password" value="<?php echo $password; ?>"></td>
            </tr>
            <tr>
                <!-- 是否为管理员 -->
                <td><label for="is_admin">是否为管理员：</label></td>
                <td><input type="checkbox" id="is_admin" name="is_admin" <?php if ($row['is_admin'] == 1) {
                    echo 'checked';
                } ?>></td>
            </tr>
        </table>
        <input class="add" type="submit" value="保存">
    </form>


    <!-- 引入尾部模板 -->
    <?php include_once '../templates/admin_footer.php'; ?>
</body>

</html>