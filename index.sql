-- 创建数据库
-- CREATE DATABASE IF NOT EXISTS blog;

-- 使用数据库
-- USE blog;

-- 创建文章表
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    publish_date DATE NOT NULL,
    image_path VARCHAR(255),
    intro TEXT
);

-- 创建用户表
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_imgurl VARCHAR(255),
    username VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    qq_number VARCHAR(20) NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    register_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 创建评论表
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    commenter VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);

-- 创建留言表
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    qq_number VARCHAR(20) NOT NULL,
    qq_name VARCHAR(100) NOT NULL,
    qq_imgurl VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved BOOLEAN DEFAULT FALSE
);

-- 创建关于表
CREATE TABLE IF NOT EXISTS about (
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
);

-- 创建上传图片表
CREATE TABLE IF NOT EXISTS imgup(
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255)
);

-- 插入管理员用户数据
INSERT INTO users (user_imgurl, username, name, qq_number, email, password, is_admin) VALUES
('http://q2.qlogo.cn/headimg_dl?dst_uin=2841216434&spec=100','admin', '野猫', '2841216434','2841216434@qq.com', 'admin', TRUE);

-- 插入关于页面数据
INSERT INTO `about` (`title`, `content`) VALUES
('关于', '## 这是我的个人博客，基于php、mysql、nginx搭建的\r\n- 这个博客是我分享生活点滴、感悟与知识的窗口，是我与这个世界对话的桥梁。在这里，我记录下我眼中的世界，我笔下的故事，我内心的思考。\r\n- 这个博客的初衷是希望能够通过我的文字，传递出我对生活的热爱与感悟，同时也希望能够在这里找到志同道合的朋友，共同交流、分享、成长。\r\n- 在这里，我力求保持真实、坦诚和独立的风格。我相信，只有真实的文字才能打动人心，只有坦诚的态度才能赢得信任，只有独立的思考才能产生有价值的内容。');

-- 插入初始文章数据
INSERT INTO `articles` (`id`, `title`, `content`,  `image_path`, `intro`) VALUES
(14, '世界，您好！', '欢迎使用个人博客。这是您的第一篇文章。编辑或删除它，然后开始写作吧！',  '/uploads/hello-world.png', '欢迎使用个人博客。这是您的第一篇文章!');

-- 插入初始评论数据
INSERT INTO `comments` (`id`, `article_id`, `commenter`, `comment`,  `approved`) VALUES
(10, 14, 'admin', '您好，这是一条评论。若需要审核或删除评论，请访问仪表盘的评论界面。', 1);

-- 插入图片数据
INSERT INTO `imgup` (`id`, `image_path`) VALUES
(1, '/uploads/hello-world.png');

-- 插入留言数据
INSERT INTO `messages` (`id`, `qq_number`, `qq_name`, `qq_imgurl`, `email`, `message`, `approved`) VALUES
(1, '2841216434', '野猫', 'http://q2.qlogo.cn/headimg_dl?dst_uin=2841216434&spec=100', '2841216434@qq.com', 'test~', 1)
