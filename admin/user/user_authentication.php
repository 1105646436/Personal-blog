<?php
$baseUrl = URL; // 根 URL
session_start();
if (isset($_SESSION['username'])) {
    if (is_admin($_SESSION['username'])) {
        // 使用 URL 和相对路径拼接
        header("Location: {$baseUrl}/admin/dashboard.php");
        exit;
    }
} else {
    header("Location: {$baseUrl}/admin/login.php");
    exit;
}