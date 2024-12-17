<?php
include_once '../init.php';

// 检查是否传递了文章ID
if (!isset($_GET['id'])) {
    die("未提供文章ID");
}

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 获取文章ID
$id = $_GET['id'];

// 获取文章信息
$sql = "SELECT * FROM articles WHERE id = $id";
$result = mysqli_query($conn, $sql);

// 检查查询结果
if (mysqli_num_rows($result) == 0) {
    die("找不到对应的文章");
}

$row = mysqli_fetch_assoc($result);

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $title = $_POST['title'];
    $content = $_POST['content'];
    $publish_date = $_POST['publish_date'];
    $img_path = basename($_POST['image_path']);
    $image_path = '/uploads/' . $img_path;

    // 更新文章信息的 SQL 语句，使用参数化查询
    $sql_update = "UPDATE articles SET title=?, content=?, publish_date=?, image_path=? WHERE id=?";

    // 准备 SQL 语句
    $stmt = mysqli_prepare($conn, $sql_update);

    // 绑定参数
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $content, $publish_date, $image_path, $id);

    // 执行更新操作
    if (mysqli_stmt_execute($stmt)) {
        // 更新成功后跳转到文章管理页面
        header("Location: article_management.php");
        exit();
    } else {
        echo "更新文章时出错: " . mysqli_error($conn);
    }

    // 关闭 prepared statement
    mysqli_stmt_close($stmt);
}

// 关闭数据库连接
mysqli_close($conn);
?>

<?php include_once '../templates/admin_header.php'; ?>
<?php
$img_path = $baseUrl . $row['image_path'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑文章</title>
    <style>
        .w-all {
            display: grid;
            grid-template-columns: 6fr 4fr;
        }

        .write input {
            width: 100%;
            height: 36px;
            padding: 10px;
            font-size: 20px;
        }

        .write textarea {
            width: 100%;
            resize: none;
            padding: 10px;
            font-size: 18px
        }

        input:focus,
        textarea:focus {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .w-img {
            text-align: center;
        }

        #intro {
            height: 60px;
        }

        #content {
            height: 270px;
        }

        .publish {
            width: 100%;
            height: 30px;
            margin-top: 15px;
            font-size: 16px;
        }

        .img-url {
            width: 80%;
            height: 50px;
            border: 1px solid #1d2327;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>编辑文章</h1>
    <div class="w-all">
        <div class="write">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="title">标题:</label><br>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>"><br>
                <label for="content">内容:</label><br>
                <textarea id="content" name="content"><?php echo htmlspecialchars($row['content']); ?></textarea><br>
                <label for="publish_date">发布日期:</label><br>
                <input type="text" id="publish_date" name="publish_date"
                    value="<?php echo htmlspecialchars($row['publish_date']); ?>"><br>

                <label for="image_path">图片链接:</label><br>
                <input type="text" id="image_path" name="image_path"
                    value="<?php echo htmlspecialchars($img_path); ?>"><br>
                <button class="publish" type="submit">保存</button>
            </form>
        </div>
        <div class="w-img">
            <h3>上传图片链接</h3>
            <div class="img-url" id="fileLink"></div>
            <form id="uploadForm" action="/templates/upload.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" id="fileInput">
                <button type="submit">上传</button>
            </form>
        </div>
    </div>
    <script>
        document
            .getElementById("uploadForm")
            .addEventListener("submit", function (event) {
                event.preventDefault(); // 阻止表单默认提交行为

                var formData = new FormData(this); // 创建一个FormData对象，包含表单数据
                var baseUrl = "<?php echo $baseUrl; ?>";
                // 使用fetch API发送POST请求
                fetch("/templates/upload.php", {
                    method: "POST",
                    body: formData,
                })
                    .then((response) => response.text()) // 将响应解析为文本
                    .then((data) => {
                        document.getElementById("fileLink").innerHTML =
                            "<p>" + baseUrl + data + "</p>";
                        document.getElementById("fileInput").value = ""; // 清空文件输入框
                    })
                    .catch((error) => console.error("上传文件出错:", error));
            });
    </script>
    <!-- 引入尾部模板 -->
    <?php include_once '../templates/admin_footer.php'; ?>
</body>

</html>