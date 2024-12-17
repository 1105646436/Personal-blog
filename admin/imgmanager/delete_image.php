<?php
include_once '../init.php';

// 检查是否接收到要删除的图片的ID
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // 连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }

    // 查询要删除的图片路径
    $sql_select_image = "SELECT image_path FROM imgup WHERE id = $id";
    $result = mysqli_query($conn, $sql_select_image);
    $row = mysqli_fetch_assoc($result);
    $image_path = $row['image_path'];

    // 删除数据库中的图片数据
    $sql_delete = "DELETE FROM imgup WHERE id = $id";
    if (mysqli_query($conn, $sql_delete)) {
        // 删除成功后，删除对应的图片文件
        $upload_dir = '../../uploads/';
        $image_file = basename($image_path);
        $file_path = $upload_dir . $image_file;
        // $file_path = $image_path;
        if (unlink($file_path)) {
            echo "图片删除成功";
        } else {
            echo "图片删除成功，但无法删除图片文件";
        }
    } else {
        echo "删除失败: " . mysqli_error($conn);
    }

    // 关闭数据库连接
    mysqli_close($conn);
}
