$(document).ready(function () {
    cookie = getCookie();
    if (typeof cookie['token'] != "undefined") {
        $.ajax({
            url: "http://127.0.0.1/getCompte",
            type: "POST",
            data: { "token": cookie["token"] },
            success: function (data) {
                $("#nom").html(data.nom);
                $("#email").html(data.email);
            },
            error: function (xhr) {
                if (xhr.status == 0) {
                    console.log("Serveur introuvable");
                }
                if (xhr.status === 404) {
                    console.log("Contenue introuvable")
                }
            }
        })
    } else {
        console.log("pas connecter")
    }

})