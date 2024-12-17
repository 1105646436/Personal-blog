<?php
// 包含共享的 PHP 文件
include_once 'includes/config.php';
include_once 'includes/functions.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查连接是否成功
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 处理留言提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qq_number = $_POST['qq_number'];
    $qq_name = $_POST['qq_name'];
    $qq_imgurl = $_POST['qq_imgurl'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $created_at = date('Y-m-d H:i:s'); // 获取当前时间

    // 准备 SQL 语句
    $sql = "INSERT INTO messages (qq_number, qq_name, qq_imgurl, email, message, created_at) VALUES (?, ?, ?, ?, ?, ?)";

    // 准备并执行预处理语句
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $qq_number, $qq_name, $qq_imgurl, $email, $message, $created_at);
    $stmt->execute();

    // 检查是否成功插入数据
    if ($stmt->affected_rows > 0) {
        echo "
        <script>
            alert('您的留言已成功提交!(审核后将显示!)');
            window.location.href ='./contact.php'
        </script>
        ";
    } else {
        echo "
        <script>
            alert('您的留言提交失败，请稍后重试');
        </script>
        ";
    }

    // 关闭预处理语句
    $stmt->close();
}

// 查询已审核的留言
$sql = "SELECT * FROM messages WHERE approved = TRUE ORDER BY created_at DESC";
$result = $conn->query($sql);

// 关闭数据库连接
$conn->close();
?>
<!-- 引入头部模板 -->
<?php include_once 'templates/header.php'; ?>

<head>
    <title>联系</title>
    <link rel="stylesheet" href="../css/contact.css">
</head>

<body>


    <div class="rongqi">
        <h1>留言板</h1>
        <p>发表你独特的见解吧！</p>

        <!-- 联系表单 -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="message">
                <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="datum">
                <label for="qq_imgurl"></label>
                <input type="hidden" id="qq_imgurl" name="qq_imgurl">
                <img id="qq_avatar" src="./img/image.png" width="36" height="36" alt="QQ头像"><br><br>
                <label for="qq_number">QQ：</label>
                <input type="text" id="qq_number" name="qq_number" required><br><br>
                <label for="qq_name">昵称：</label>
                <input type="text" id="qq_name" name="qq_name" required><br><br>
                <label for="email">邮箱：</label>
                <input type="email" id="email" name="email" required><br><br>
            </div>
            <input class="send" type="submit" value="发表留言">
        </form>

        <!-- 显示已审核的留言 -->
        <h2>留言：</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='comment'><div class='avatar'><div><img width='66' height='66' alt='avatar' src='" . $row["qq_imgurl"] . "'></div>";
                // echo "<p><strong>QQ号：</strong>" . $row["qq_number"] . "</p>";
                echo "<div><p style='font-size:16px; line-height:33px; '><strong>" . $row["qq_name"] . "</strong></p><p style='font-size:12px; line-height:33px; text-align:center;'>" . $row["created_at"] . "</p></div>";
                // echo "<p><strong>邮箱：</strong>" . $row["email"] . "</p>";
                echo "<p style='font-size:16px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row["message"] . "</p></div></div>";
            }
        } else {
            echo "<p>暂无留言~</p>";
        }
        ?>

    </div>

    <!-- 引入尾部模板 -->
    <?php include_once 'templates/footer.php'; ?>

    <!-- JavaScript代码 -->
    <script src="./js/functions.js"></script>
</body>

</html>