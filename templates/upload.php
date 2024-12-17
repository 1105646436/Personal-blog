<?php
// 包含共享的 PHP 文件
include_once '../includes/config.php';
include_once '../includes/functions.php';

// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 检查是否有文件上传
if (isset($_FILES['file'])) {
    $uploadDir = '../uploads/'; // 上传文件存储目录
    $uploadedFile = $uploadDir . basename($_FILES['file']['name']);

    // 检查文件类型
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'avif');
    $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if (!in_array(strtolower($fileExtension), $allowedTypes)) {
        echo '只能上传图片格式的文件';
        exit;
    }

    // 移动上传的文件到目标目录
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
        // 获取上传文件的路径
        // $baseUrl = URL; 
        // $fileUrl = $baseUrl . '/uploads/' . basename($_FILES['file']['name']);
        $fileUrl = '/uploads/' . basename($_FILES['file']['name']);

        // 检查数据库中是否已经存在相同的 image_path
        $checkQuery = "SELECT * FROM imgup WHERE image_path = '$fileUrl'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) == 0) {
            // 如果不存在相同的 image_path，则插入数据库
            $insertQuery = "INSERT INTO imgup (image_path) VALUES ('$fileUrl')";
            if (mysqli_query($conn, $insertQuery)) {
                // 输出上传文件的链接
                echo $fileUrl;
            } else {
                echo '上传文件失败';
            }
        } else {
            echo '该文件已经上传过了';
        }
    } else {
        echo '上传文件失败';
    }
}

// 关闭数据库连接
mysqli_close($conn);
?>



<?php
// 以下为使用upload功能的html代码
// <form id="uploadForm" action="/templates/upload.php" method="POST" enctype="multipart/form-data">
//    <!-- 添加 accept="image/*" 属性来限制文件类型为图片格式 -->
// <input type="file" name="file" id="fileInput" accept="image/*">
// <button type="submit">上传</button>
// </form>
// <div id="fileLink"></div>

// <script>
// document.getElementById('uploadForm').addEventListener('submit', function(event) {
//     event.preventDefault(); // 阻止表单默认提交行为

//     var formData = new FormData(this); // 创建一个FormData对象，包含表单数据

//     // 使用fetch API发送POST请求
//     fetch('/templates/upload.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.text()) // 将响应解析为文本
//     .then(data => {
//         document.getElementById('fileLink').innerHTML = '<a href="' + data + '">' + data + '</a>'; // 显示上传文件的链接
//         document.getElementById('fileInput').value = ''; // 清空文件输入框
//     })
//     .catch(error => console.error('上传文件出错:', error));
// });
// </script>
?>
<!-- <body>
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
</body> -->