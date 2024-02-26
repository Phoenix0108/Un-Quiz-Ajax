$(document).ready(function () {
    $("#suppression").click(function () {
        $.ajax({
            url: "http://127.0.0.1/supCompte",
            type: "POST",
            success: function () {
                window.location.href = "index.html"
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
    })
})