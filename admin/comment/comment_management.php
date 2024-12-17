<?php
include_once '../init.php';
// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 获取评论列表
$sql = "SELECT 
    a.id AS article_id, 
    a.title AS article_title, 
    c.id AS comment_id, 
    c.commenter, 
    c.comment, 
    c.comment_date,
    c.approved
FROM 
    articles a
INNER JOIN 
    comments c ON a.id = c.article_id
ORDER BY 
    a.id, c.comment_date DESC";

$result = mysqli_query($conn, $sql);

// 关闭数据库连接
mysqli_close($conn);
?>

<?php include_once '../templates/admin_header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>评论</title>
    <link rel="stylesheet" href="../../css/table.css">
    <style>
        .comspace {
            margin-bottom: 20px;
        }
    </style>
</head>

<h1 class="comspace">评论</h1>
<table>
    <tr>
        <th>文章标题</th>
        <th>评论者</th>
        <th>评论内容</th>
        <th>评论日期</th>
        <th>操作</th>
    </tr>

    <?php
    // 使用 mysqli_fetch_assoc 循环输出评论
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['article_title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['commenter']) . "</td>";
        echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
        echo "<td>" . htmlspecialchars($row['comment_date']) . "</td>";
        echo "<td>";

        if ($row['approved']) {
            // 如果评论已审核通过，只显示删除链接
            echo "<a href='delete_comment.php?id=" . intval($row['comment_id']) . "'>删除</a>";
        } else {
            // 如果评论未审核，通过和拒绝链接
            echo "<a href='approve_comment.php?id=" . intval($row['comment_id']) . "'>审核</a> | ";
            echo "<a href='delete_comment.php?id=" . intval($row['comment_id']) . "'>拒绝</a>";
        }

        echo "</td>";
        echo "</tr>";
    }
    ?>
    <tr>
        <th>文章标题</th>
        <th>评论者</th>
        <th>评论内容</th>
        <th>评论日期</th>
        <th>操作</th>
    </tr>
</table>