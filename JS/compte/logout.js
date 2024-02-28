$(document).ready(function () {
    $("#logout").click(function () {
        setCookie("token", 0, 1);
        window.location.href = "index.html"
    })
})