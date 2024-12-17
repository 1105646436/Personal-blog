<?php
// 包含共享的 PHP 文件
include_once 'includes/config.php';
include_once 'includes/functions.php';

// 初始化结果变量
$result = null;
$searched = false;

// 检查是否提交了搜索关键词
if (isset($_GET['q'])) {
    $searched = true;
    // 连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // 检查数据库连接是否成功
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 获取搜索关键词并防止 SQL 注入
    $search_query = mysqli_real_escape_string($conn, $_GET['q']);

    // 查询包含搜索关键词的文章标题
    $sql = "SELECT * FROM articles WHERE title LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);

    // 关闭数据库连接
    mysqli_close($conn);
}
?>
<!-- 引入头部模板 -->
<?php include_once 'templates/header.php';?>
<head>
    <title>搜索</title>
    <!-- 在这里引入你的样式表 -->
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>

<div class="rongqi">

    <!-- 搜索表单 -->
    <?php if (!$searched): ?>
        <form class="search-all" action="search.php" method="GET">
            <label for="search"><h2 class="search-h">搜索文章:</h2></label>
            <input class="search-text" type="text" id="search" name="q" placeholder = "请输入搜索内容">
            <button class="search-img" type="submit"><img src="./img/search.png"></button>
        </form>
    <?php endif;?>

    <?php if ($searched): ?>
        <ul>
            <?php
echo "<h1>搜索结果</h1>";
if (isset($result) && $result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li class='article'>";
            echo "<div class='artimg'><img class='img' src='" . $row['image_path'] . "' alt='文章图片'></div>";
            echo "<div class='arttit'>";
            echo "<a href='article.php?id=" . $row['id'] . "'>" . "<h3>" . $row['title'] . "</h3>" . "</a>";
            echo "<p class='artp'>" . $row['intro'] . "</p>";
            echo "</div>";
            echo "</li>";
            echo "<hr>";
        }
    } else {
        // 如果未找到匹配的文章，则显示提示信息
        echo "<p>抱歉，未找到匹配的文章。</p>";
    }
}
?>
        </ul>
    <?php endif;?>

    <script src="./js/functions.js"></script>
    <!-- 引入尾部模板 -->
    <?php include_once 'templates/footer.php';?>
</body>
</html>
