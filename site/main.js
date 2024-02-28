$(document).ready(function () {
    $(".btnFlexForm").click(function () {
        $(".signup-form").toggle()
        $(".login-form").toggle()
    })
    $("#submitLogin").click(function () {
        $.ajax({
            url: "http://127.0.0.1/Backend/login",
            type: "POST",
            dataType: "json",
            data: {
                "email": $("#login_email").val(),
                "password": $("#login_password").val()
            },
            success: function (data) {
                $(".stateCo")[0].innerHTML = data.reponse
                if (data.check) {
                    window.location.href = "Acceuil/acceuil.html"
                }

            }
        })
    })
    $("#submitSignup").click(function () {
        $.ajax({
            url: "http://127.0.0.1/Backend/signup",
            type: "POST",
            dataType: "json",
            data: {
                "nom": $("#signup_name").val(),
                "email": $("#signup_email").val(),
                "password": $("#signup_password").val()
            },
            success: function (data) {
                $(".stateCo")[1].innerHTML = data.reponse

                if (data.check) {
                    window.location.href = "Acceuil/acceuil.html"
                }
            }
        })
    })
})
