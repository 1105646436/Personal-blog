<!DOCTYPE html>
<html lang="cmn-hans">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo $baseUrl . '/css/admin_header.css'; ?>" />
</head>

<body>
    <div class="back-nav">
        <img class="back-index" src="<?php echo $baseUrl . '/favicon.ico'; ?>" alt="Favicon">
        <a class="back-index2" href="<?php echo $baseUrl . '/index.php' ?>">回到主页</a>
    </div>
    <div id="sidenav" class="sidenav">
        <a href="<?php echo $baseUrl . '/admin/dashboard.php' ?>">
            <img class=" bm-logo" src="<?php echo $baseUrl . '/img/BM.png' ?>" alt="BM">&nbsp;&nbsp;管理首页
        </a>
        <a href="<?php echo $baseUrl . '/admin/article/article_management.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/SMP.png' ?>" alt="SMP">&nbsp;&nbsp;文章管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/comment/comment_management.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/CM.png' ?>" alt="CM">&nbsp;&nbsp;评论管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/user/user_management.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/USER.png' ?>" alt="USER">&nbsp;&nbsp;用户管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/comment/message.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/NOTE.png' ?>" alt="NOTE">&nbsp;&nbsp;留言管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/imgmanager/admin_images.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/IMG.png' ?>" alt="IMG">&nbsp;&nbsp;图片管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/about/admin_about.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/ABOUT.png' ?>" alt="ABOUT">&nbsp;&nbsp;关于管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/logout.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/ESC.png' ?>" alt="ESC">&nbsp;&nbsp;退出登录
        </a>
    </div>
    <div id="index" class="index">
        <div class="index-space">