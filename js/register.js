// 获取表单元素
var form = document.getElementById("registrationForm");
var usernameInput = document.getElementById("username");
var emailInput = document.getElementById("email");
var passwordInput = document.getElementById("password");
var usernameError = document.getElementById("usernameError");
var emailError = document.getElementById("emailError");
var passwordError = document.getElementById("passwordError");

// 监听用户名输入事件
usernameInput.addEventListener("input", function () {
    var username = usernameInput.value.trim();
    if (/^\d/.test(username)) {
        usernameError.textContent = "用户名不能以数字开头";
    } else if (username.length < 5) {
        usernameError.textContent = "用户名不能少于五个字符";
    } else {
        usernameError.textContent = "";
    }
});

// 监听邮箱输入事件
emailInput.addEventListener("input", function () {
    var email = emailInput.value.trim();
    if (!/\S+@\S+\.\S+/.test(email)) {
        emailError.textContent = "请输入有效的邮箱地址";
    } else {
        emailError.textContent = "";
    }
});
