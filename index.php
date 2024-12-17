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

// 查询最新的博客文章列表
$sql = "SELECT id, title, image_path, intro FROM articles ORDER BY publish_date DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

// 关闭数据库连接
mysqli_close($conn);
?>
<!-- 头部模板 -->
<?php include_once 'templates/header.php'; ?>

<head>
    <link rel="stylesheet" href="./css/index.css">
</head>

<div class="module">
    <div class="avatar">
        <img class="yuan" src="./img/avatar.jpg" alt="cat" width="100%" height="auto" />
    </div>
    <div class="signature">
        <p>欲买桂花同载酒,终不似,少年游。</p>
    </div>
    <div class="contact">
        <button onclick="sendEmail()"><img class="contact-img" src="./img/mail.png" alt="邮箱"></button>
        <button onclick="openGithub()"><img class="contact-img" src="./img/github.png" alt="github"></button>
    </div>
</div>
</div>
<div class="rongqi">
    <article>
        <h1 style="margin-top:30px">Article</h1>
        <ul>
            <?php
            // 遍历最新文章列表并输出
            $alternate = false; // 控制输出方式的变量
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li class='article'>";

                if ($alternate) {
                    // 输出图片
                    echo "<div class='artimg'><img class='imgleft' src='" . $row['image_path'] . "' alt='文章图片'></div>";
                }

                echo "<div class='arttit'>";
                echo "<a href='article.php?id=" . $row['id'] . "'>" . "<h3>" . $row['title'] . "</h3>" . "</a>";
                // 输出简介
                echo "<p class='artp'>" . $row['intro'] . "</p>";
                echo "</div>";

                if (!$alternate) {
                    // 输出图片
                    echo "<div class='artimg'><img class='imgright' src='" . $row['image_path'] . "' alt='文章图片'></div>";
                }

                echo "</li>";

                // 更新输出方式
                $alternate = !$alternate;
            }

            ?>
        </ul>
    </article>
    <script src="./js/functions.js"></script>
    <!-- 尾部模板 -->
    <?php include_once 'templates/footer.php'; ?>