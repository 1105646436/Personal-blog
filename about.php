<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';
include_once 'includes/Parsedown.php';

// 引入头部模板
include_once 'templates/header.php';
?>

<head>
    <title>关于</title>
    <link rel="stylesheet" href="./css/prism.css">
    <style>
        body {
            margin-top: 120px;
        }
    </style>
</head>

<body>
    <?php
    // 创建 Parsedown 对象
    $Parsedown = new Parsedown();
    // 设置为不转义 HTML 标签
    $Parsedown->setMarkupEscaped(true);

    // 连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 准备 SQL 查询语句
    $sql = "SELECT * FROM about";
    $result = mysqli_query($conn, $sql);
    // 关闭连接
    mysqli_close($conn);
    // 读取关于内容
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // 使用 Parsedown 对象的 text() 方法将 Markdown 内容解析为 HTML
        $html_content = $Parsedown->text($row['content']);

        // 输出文章标题和内容
        echo "<div class='rongqi'>";
        echo "<h2>关于</h2>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<div>";
        echo $html_content;
        echo "</div>";
        echo "</div>";
    } else {
        echo "没有关于内容。";
    }
    ?>
    <!-- 引入尾部模板 -->
    <?php include_once 'templates/footer.php'; ?>
    <!-- 引入 Prism.js 库 -->
    <script src="./js/prism.js"></script>
    <!-- 引入 Prism.js 的复制插件 -->
    <script src="./js/prism-copy-to-clipboard.min.js"></script>
    <!-- 初始化 Prism.js -->
    <script>
        Prism.highlightAll();
        // 初始化代码高亮

        var codeBlocks = document.querySelectorAll('.code-container pre');
        // 获取所有代码块

        codeBlocks.forEach(function (codeBlock) {
            var button = document.createElement('button');
            // 创建复制按钮

            button.textContent = '复制';
            // 设置按钮文本

            button.className = 'copy-button';
            // 设置按钮类名

            button.addEventListener('click', function () {
                var code = codeBlock.textContent;
                // 获取代码块文本

                navigator.clipboard.writeText(code);
                // 将代码复制到剪贴板
            });

            codeBlock.parentNode.insertBefore(button, codeBlock.nextSibling);
            // 将按钮插入到代码块后面
        });
    </script>
</body>

</html>