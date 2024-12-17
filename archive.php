<?php
// 包含共享的 PHP 文件
include_once 'includes/config.php';
include_once 'includes/functions.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询所有博客文章按发布日期倒序排列
$sql = "SELECT * FROM articles ORDER BY publish_date DESC";
$result = mysqli_query($conn, $sql);

// 关闭数据库连接
mysqli_close($conn);
?>
    <!-- 包含头部模板 -->
    <?php include_once 'templates/header.php';?>
<head>
    <title>文章归档</title>
    <link rel="stylesheet" href="../css/archive.css">
</head>

<body>

    <div class="rongqi">
    <h1>文章归档</h1>
    <ul>
    <?php
// 遍历最新文章列表并输出
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li class='article'>";
    echo "<div class='artimg'><img class='img' src='" . $row['image_path'] . "' alt='文章图片'></div>";
    echo "<div class='arttit'>";
    echo "<a href='article.php?id=" . $row['id'] . "'>" . "<h3>" . $row['title'] . "</h3>" . "</a>";
    echo "<p class='artp'>" . $row['intro'] . "</p>";
    echo "<p class='artp'>" . $row['publish_date'] . "</p>";
    echo "</div>";
    echo "</li>";
}
?>
    </ul>
    <!-- 包含尾部模板 -->
    <?php include_once 'templates/footer.php';?>
</body>
</html>
