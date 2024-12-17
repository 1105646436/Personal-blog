<?php
include_once '../init.php';
// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 检查是否存在关于数据
$sql_check = "SELECT * FROM about LIMIT 1";
$result = mysqli_query($conn, $sql_check);

// 如果不存在关于数据，则插入默认数据
if (mysqli_num_rows($result) == 0) {
    $sql_insert_default = "INSERT INTO about (title, content) VALUES ('', '')";
    mysqli_query($conn, $sql_insert_default);
}

// 读取关于数据
$sql_read = "SELECT * FROM about LIMIT 1";
$result = mysqli_query($conn, $sql_read);
$row = mysqli_fetch_assoc($result);

// 关闭连接
mysqli_close($conn);
?>


<?php include_once '../templates/admin_header.php'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加关于</title>
    <style>
        .space {
            margin-bottom: 20px;
        }

        .about_title {
            width: 60%;
            padding: 10px;
            font-size: 18px;
            margin: 10px 0;
        }

        textarea {
            width: 60%;
            padding: 10px;
            margin: 10px 0;
            height: 50vh;
        }

        .about_submit {
            width: 80px;
            height: 40px;
            font-size: 16px;
            border: 1px solid #1c8de2;
            background-color: white;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h2 class="space">添加关于</h2>
    <form action="admin_about.php" method="POST">
        <label for="title">标题:</label><br>
        <input class="about_title" type="text" id="title" name="title" value="<?php echo $row['title']; ?>"><br>
        <label for="content">内容:</label><br>
        <textarea id="content" name="content"><?php echo $row['content']; ?></textarea><br>
        <input class="about_submit" type="submit" value="提交">
    </form>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 准备 SQL 语句
    $sql = "UPDATE about SET title='$title', content='$content'";

    // 执行 SQL 语句
    if (mysqli_query($conn, $sql)) {
        echo "记录更新成功";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // 关闭连接
    mysqli_close($conn);
}
?>