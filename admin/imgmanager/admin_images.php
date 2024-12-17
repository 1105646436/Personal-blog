<?php
include_once '../init.php';
// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 从数据库中获取图片数据
$sql = "SELECT * FROM imgup";
$result = mysqli_query($conn, $sql);

// 关闭连接
mysqli_close($conn);
?>

<?php include_once '../templates/admin_header.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>图片</title>
    <link rel="stylesheet" href="../../css/table.css">
    <style>
        .img-size {
            width: 160px;
            height: 90px;
        }

        .w-img {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>图片</h1>
    <div class="image-container">
        <table>
            <tr>
                <th>图片</th>
                <th>链接</th>
                <th>操作</th>
            </tr>

            <?php
            // 显示图片列表
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td><img class='img-size' src='" . $baseUrl . $row['image_path'] . "'alt='Image'></td>";
                echo "<td><p>" . $baseUrl . $row['image_path'] . "</p></td>";
                echo "<td><button onclick='deleteImage(" . $row['id'] . ")'>删除</button></td> </tr>";
            }
            ?>
        </table>
    </div>
    <div class="w-img">
        <h3>上传图片</h3>
        <form id="uploadForm" action="/templates/upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="fileInput">
            <button type="submit">上传</button>
        </form>
    </div>
    <div id="fileLink"></div>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function (event) {
            event.preventDefault(); // 阻止表单默认提交行为
            var formData = new FormData(this); // 创建一个FormData对象，包含表单数据
            // 使用fetch API发送POST请求
            fetch('/templates/upload.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text()) // 将响应解析为文本
                .then(data => {
                    location.reload();
                })
                .catch(error => console.error('上传文件出错:', error));
        });
    </script>
    <script>
        function deleteImage(id) {
            if (confirm("确定要删除这张图片吗？")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_image.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        window.location.reload();
                    }
                };
                xhr.send("id=" + id);
            }
        }
    </script>
</body>

</html>