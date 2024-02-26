$(document).ready(function () {
    $(".swap").click(function () {
        if ($("#login-form")[0].style.display == "flex") {
            $("#login-form")[0].style.display = "none";
            $("#signup-form")[0].style.display = "flex";
        } else {
            $("#login-form")[0].style.display = "flex";
            $("#signup-form")[0].style.display = "none";
        }
    })
})