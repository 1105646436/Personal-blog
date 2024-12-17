<?php
include_once '../init.php';
// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询所有博客文章
$sql = "SELECT * FROM articles";
$result = mysqli_query($conn, $sql);

// 关闭数据库连接
mysqli_close($conn);
?>

<?php include_once '../templates/admin_header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章</title>
    <link rel="stylesheet" href="../../css/table.css">
    <style>
        .art-title {
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .art-title button {
            border: 1px solid #1c8de2;
            background-color: white;
            padding: 8px;
            border-radius: 5px;
        }
    </style>
</head>
<div class="art-title">
    <h1>文章</h1>
    <button><a href="add_article.php">写文章</a></button>
</div>
<table>
    <tr>
        <!-- <th>ID</th> -->
        <th>标题</th>
        <th>发布日期</th>
        <th>操作</th>
    </tr>
    <?php
    // 循环遍历文章列表，并以表格形式显示
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        // echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['publish_date'] . "</td>";
        echo "<td><a href='edit_article.php?id=" . $row['id'] . "'>编辑</a> | <a href='delete_article.php?id=" . $row['id'] . "'>删除</a></td>";
        echo "</tr>";
    }
    ?>
    <tr>
        <!-- <th>ID</th> -->
        <th>标题</th>
        <th>发布日期</th>
        <th>操作</th>
    </tr>
</table>
<br>