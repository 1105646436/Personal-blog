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
        <a href="<?php echo $baseUrl . '/admin/index.php' ?>">
            <img class=" bm-logo" src="<?php echo $baseUrl . '/img/BM.png' ?>" alt="BM">&nbsp;&nbsp;个人首页
        </a>
        <a href="<?php echo $baseUrl . '/admin/user/Information.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/USER.png' ?>" alt="USER">&nbsp;&nbsp;个人信息
        </a>
        <a href="<?php echo $baseUrl . '/admin/user/user_comment.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/CM.png' ?>" alt="CM">&nbsp;&nbsp;评论管理
        </a>
        <a href="<?php echo $baseUrl . '/admin/logout.php'; ?>">
            <img class="bm-logo" src="<?php echo $baseUrl . '/img/ESC.png' ?>" alt="ESC">&nbsp;&nbsp;退出登录
        </a>
    </div>
    <div id="index" class="index">
        <div class="index-space">