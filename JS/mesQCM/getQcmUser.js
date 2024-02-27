$(document).ready(function () {
    cookie = getCookie();
    if (typeof cookie["token"] != "undefined") {
        $.ajax({
            url: "http://127.0.0.1/getQCMUser",
            type: "POST",
            dataType: "text",
            data: { "token": cookie["token"] },
            success: function (response) {
                if (response) {
                    $("#contentQCM").html(response);
                } else {
                    $("#contentQCM").html("<h3>Pas de QCM</h3>")
                }
            },
            error: function (xhr) {
                if (xhr.status == 0) {
                    console.log("Serveur introuvable");
                }
                if (xhr.status === 404) {
                    console.log("Contenue introuvable")
                }
            }
        });
    } else {
        console.log("pas connecter")
    }
})