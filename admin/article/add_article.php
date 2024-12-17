<?php
include_once '../init.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 检查是否有提交的表单数据
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img_path = basename($_POST['image_path']);
    // 获取表单数据
    $title = $_POST['title'];
    $content = $_POST['content'];
    $intro = $_POST['intro'];
    $image_path = '/uploads/' . $img_path;
    // 生成当前日期
    $publish_date = date("Y-m-d");

    // 插入数据到数据库
    $sql = "INSERT INTO articles (title, content, intro, publish_date, image_path) VALUES ('$title', '$content', '$intro', '$publish_date', '$image_path')";

    if (mysqli_query($conn, $sql)) {
        echo "文章添加成功";
        header("Location: article_management.php");
        exit(); // 确保代码不会继续执行
    } else {
        echo "添加文章时出现错误: " . mysqli_error($conn);
    }
}
?>

<?php include_once '../templates/admin_header.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加新文章</title>
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
    <h1>写文章</h1>
    <div class="w-all">
        <div class="write">

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="title">标题:</label><br>
                <input type="text" id="title" name="title" required><br>

                <label for="intro">文章简介:</label><br>
                <textarea id="intro" name="intro" required></textarea><br>

                <label for="content">内容:</label><br>
                <textarea id="content" name="content" required></textarea><br>

                <label for="image_path">首页展示图片链接:</label><br>
                <input type="text" id="image_path" name="image_path" required><br>

                <button class="publish" type="submit">发布</button>
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