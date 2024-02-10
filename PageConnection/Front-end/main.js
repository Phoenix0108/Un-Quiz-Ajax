$(document).ready(function () {
    $(".btnFlexForm").click(function () {
        $(".signup-form").toggle()
        $(".login-form").toggle()
    })
    $("#submitLogin").click(function () {
        $.ajax({
            url: "http://127.0.0.1/login",
            type: "POST",
            dataType: "json",
            data: {
                "email": $("#login_email").val(),
                "password": $("#login_password").val()
            },
            success: function (data) {
                console.log(data.reponse)
            }
        })
    })
    $("#submitSignup").click(function () {
        $.ajax({
            url: "http://127.0.0.1/signup",
            type: "POST",
            dataType: "text",
            data: {
                "nom": $("#signup_name").val(),
                "email": $("#signup_email").val(),
                "password": $("#signup_password").val()
            },
            success: function (data) {
                console.log(data.reponse)
            },
            error: function () {

            }
        })
    })
})
