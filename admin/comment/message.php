<?php
include_once '../init.php';
// 处理审核留言
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve'])) {
        $message_id = $_POST['approve'];
        // 连接数据库
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // 检查数据库连接是否成功
        if (!$conn) {
            die("数据库连接失败: " . mysqli_connect_error());
        }

        // 更新留言的审核状态为已审核
        $sql = "UPDATE messages SET approved = TRUE WHERE id = $message_id";
        if (mysqli_query($conn, $sql)) {
            echo "留言已审核成功！";
        } else {
            echo "审核留言时出现问题：" . mysqli_error($conn);
        }

        // 关闭数据库连接
        mysqli_close($conn);
    }
}

// 查询留言
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询留言
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// 检查查询结果
if (!$result) {
    die("查询留言失败: " . mysqli_error($conn));
}
?>


<?php include_once '../templates/admin_header.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言</title>
    <link rel="stylesheet" href="../../css/table.css">
    <style>
        .messpace {
            margin-bottom: 20px;
        }

        input {
            padding: 6px;
            background-color: white;
            color: #1c8de2;
            border: 1 solid #1c8de2;
            border-radius: 5px;
            margin: 1px;
        }
    </style>
</head>

<body>
    <h1 class="messpace">留言</h1>
    <table>
        <tr>
            <!-- <th>ID</th> -->
            <th>QQ号</th>
            <th>昵称</th>
            <th>邮箱</th>
            <th>消息</th>
            <th>提交时间</th>
            <th>审核状态</th>
            <th>操作</th>
        </tr>
        <?php
        // 循环遍历查询结果，并显示在表格中
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            // echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['qq_number'] . "</td>";
            echo "<td>" . $row['qq_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['message'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>" . ($row['approved'] ? '已审核' : '待审核') . "</td>";
            echo "<td>";
            if (!$row['approved']) {
                echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                echo "<input type='hidden' name='approve' value='" . $row['id'] . "'>";
                echo "<input type='submit' value='审核'>";
                echo "</form>";
                echo "<form action='delete_message.php' method='post'>";
                echo "<input type='hidden' name='delete' value='" . $row['id'] . "'>";
                echo "<input type='submit' value='拒绝'>";
                echo "</form>";
            } else {
                echo "<form action='delete_message.php' method='post'>";
                echo "<input type='hidden' name='delete' value='" . $row['id'] . "'>";
                echo "<input type='submit' value='删除'>";
                echo "</form>";
            }
            echo "</td>";
            echo "</tr>";
        }

        // 关闭数据库连接
        mysqli_close($conn);
        ?>
        <tr>
            <!-- <th>ID</th> -->
            <th>QQ号</th>
            <th>昵称</th>
            <th>邮箱</th>
            <th>消息</th>
            <th>提交时间</th>
            <th>审核状态</th>
            <th>操作</th>
        </tr>
    </table>
</body>

</html>