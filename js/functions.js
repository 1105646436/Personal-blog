function sendEmail() {
    window.location.href = "mailto:example@example.com";
}
function openGithub() {
    window.location.href = "https://github.com/1105646436";
}
document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("search");

    // 添加获取焦点时的事件监听器
    searchInput.addEventListener("focus", function () {
        if (this.placeholder === "请输入搜索内容") {
            this.value = "";
        }
    });

    // 添加失去焦点时的事件监听器
    searchInput.addEventListener("blur", function () {
        if (this.value === "") {
            this.placeholder = "请输入搜索内容";
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    var usernameInput = document.getElementById("username");

    // 添加获取焦点时的事件监听器
    usernameInput.addEventListener("focus", function () {
        if (this.placeholder === "请输入用户名") {
            this.value = "";
        }
    });

    // 添加失去焦点时的事件监听器
    usernameInput.addEventListener("blur", function () {
        if (this.value === "") {
            this.placeholder = "请输入用户名";
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    var passwordInput = document.getElementById("password");

    // 添加获取焦点时的事件监听器
    passwordInput.addEventListener("focus", function () {
        // 清空输入框的值
        if (this.placeholder === "请输入密码") {
            this.value = "";
        }
    });

    // 添加失去焦点时的事件监听器
    passwordInput.addEventListener("blur", function () {
        // 如果输入框为空，则显示提示文字
        if (this.value === "") {
            this.placeholder = "请输入密码";
        }
    });
});
document.getElementById("qq_number").addEventListener("change", function () {
    var qqNumber = this.value;
    // 构建头像链接
    var avatarUrl =
        "http://q2.qlogo.cn/headimg_dl?dst_uin=" + qqNumber + "&spec=100";
    // 更新头像URL输入框的值
    document.getElementById("qq_imgurl").value = avatarUrl;
    // 更新头像URL
    document.getElementById("qq_avatar").src = avatarUrl;
    // 设置邮箱为QQ邮箱形式
    var qqEmail = qqNumber + "@qq.com";
    // 更新邮箱输入框的值
    document.getElementById("email").value = qqEmail;
    // 请求API获取昵称(api已崩溃)
    // fetch("https://v.api.aa1.cn/api/qqnicheng/index.php?qq=" + qqNumber)
    //     .then((response) => response.text()) // 获取原始的文本响应
    //     .then((data) => {
    //         // 使用正则表达式从 HTML 中提取昵称
    //         const nicknameMatch = data.match(/QQ昵称：(.+?)<br\/>/);
    //         if (nicknameMatch && nicknameMatch[1]) {
    //             // 更新昵称输入框
    //             document.getElementById("qq_name").value = nicknameMatch[1];
    //         } else {
    //             console.error("未找到昵称。");
    //         }
    //     })
    //     .catch((error) => {
    //         console.error("获取数据时发生错误:", error);
    //     });
});
