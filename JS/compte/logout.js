$(document).ready(function () {
    $("#logout").click(function () {
        document.cookie = "token=0; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
        window.location.href = "index.html"
    })
})