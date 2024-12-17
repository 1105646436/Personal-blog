<?php
include_once '../init.php';
// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询所有用户
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>


<?php include_once '../templates/admin_header.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户</title>
    <link rel="stylesheet" href="../../css/table.css">
    <style>
        .userspace {
            margin: 20px 0;
            display: flex;
            justify-content: start;
            gap: 10px;
            align-items: center;
        }

        .userspace button {
            border: 1px solid #1c8de2;
            background-color: white;
            padding: 8px;
            border-radius: 5px;
        }

        .img-size {
            width: 60px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="userspace">
        <h1>用户</h1>
        <button> <a href="add_user.php">添加用户</a></button>
    </div>
    <table>
        <tr>
            <!-- <th>ID</th> -->
            <th>头像</th>
            <th>用户名</th>
            <th>昵称</th>
            <th>QQ号</th>
            <th>邮箱</th>
            <th>注册日期</th>
            <th>操作</th>
        </tr>
        <?php
        // 循环遍历用户列表，并以表格形式显示
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // echo "<td>" . $row['id'] . "</td>";
            echo "<td><img class='img-size' src='" . $row['user_imgurl'] . "'/></td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['qq_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['register_date'] . "</td>";
            echo "<td><a href='edit_user.php?id=" . $row['id'] . "'>编辑</a> | <a href='delete_user.php?id=" . $row['id'] . "'>删除</a></td>";
            echo "</tr>";
        }
        ?>
        <tr>
            <!-- <th>ID</th> -->
            <th>头像</th>
            <th>用户名</th>
            <th>昵称</th>
            <th>QQ号</th>
            <th>邮箱</th>
            <th>注册日期</th>
            <th>操作</th>
        </tr>
    </table>

</body>

</html>