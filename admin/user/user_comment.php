<?php
// 包含共享的 PHP 文件
include_once '../../includes/config.php';
include_once '../../includes/functions.php';
include_once './user_authentication.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询用户评论
$username = $_SESSION['username'];
$sql = "SELECT a.title, c.comment, c.id, c.approved
        FROM articles a  
        LEFT JOIN comments c ON a.id = c.article_id 
        WHERE c.commenter = '$username'";
$result = mysqli_query($conn, $sql);

// 检查查询结果
if (!$result) {
    die("查询失败: " . mysqli_error($conn));
}

// 关闭数据库连接
mysqli_close($conn);
?>

<?php include_once '../templates/user_header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>评论</title>
    <link rel="stylesheet" href="../../css/table.css">
</head>

<body>
    <h1>评论</h1>
    <table>
        <thead>
            <tr>
                <th>文章标题</th>
                <th>评论内容</th>
                <th>管理员是否审核</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 使用循环输出每条评论
            while ($row = mysqli_fetch_assoc($result)) {
                // 根据审核状态显示不同内容
                $audit = ($row['approved'] == 1) ? "是" : "否";

                echo "<tr>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['comment'] . "</td>";
                echo "<td>" . $audit . "</td>";
                echo "<td><a href='del_user_comment.php?id=" . $row['id'] . "'>删除</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php include_once '../templates/user_footer.php'; ?>