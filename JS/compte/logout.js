$(document).ready(function () {
    $("#logout").click(function () {
        document.cookie = "token=0; expires=1; path=/";
        window.location.href = "index.html"
    })
})