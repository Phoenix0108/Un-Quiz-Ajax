$(document).ready(function () {
    now = new Date()
    now.setTime(now.getTime())
    console.log(now.toUTCString())
    $(".btnFlexForm").click(function () {
        $(".signup-form").toggle()
        $(".login-form").toggle()
    })
    function setcookie(id) {
        now = new Date();
        time = now.getTime()
        expireTime = time + 1000 * 600;
        now.setTime(expireTime)
        console.log(now.toUTCString())
        document.cookie = 'connect_id=' + id + ';expires=' + now.toUTCString() + ';path=/';
    }
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
                $(".stateCo")[0].innerHTML = data.reponse
                if (data.connectid != 0) {
                    setcookie(data.connectid)
                }

            }
        })
    })
    $("#submitSignup").click(function () {
        $.ajax({
            url: "http://127.0.0.1/signup",
            type: "POST",
            dataType: "json",
            data: {
                "nom": $("#signup_name").val(),
                "email": $("#signup_email").val(),
                "password": $("#signup_password").val()
            },
            success: function (data) {
                $(".stateCo")[1].innerHTML = data.reponse
                if (data.connectid != 0) {
                    setcookie(data.connectid)
                }
            }
        })
    })
})
