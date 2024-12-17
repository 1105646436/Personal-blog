<?php
// 包含共享的 PHP 文件
include_once '../includes/config.php';
include_once '../includes/functions.php';
include_once './Authentication.php';

$username = $_SESSION['username'];
// 连接数据库
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// 检查数据库连接是否成功
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 查询用户昵称
$sql = "SELECT name FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
// 关闭数据库连接
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>仪表盘</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<?php include_once './templates/admin_header.php'; ?>
<h1>仪表盘</h1>
<p>欢迎回来，<?php echo $row['name']; ?>！</p>
<?php include_once './templates/admin_footer.php'; ?>