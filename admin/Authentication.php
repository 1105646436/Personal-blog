<?php
$baseUrl = URL;
session_start();
if (isset($_SESSION['username'])) {
    if (!is_admin($_SESSION['username'])) {
        header("Location: {$baseUrl}/error.php");
        exit;
    }
} else {
    header("Location: {$baseUrl}/admin/login.php");
    exit;
}