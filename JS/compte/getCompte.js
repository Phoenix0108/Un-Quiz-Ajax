$(document).ready(function () {
    $.ajax({
        url: "http://127.0.0.1/getCompte",
        type: "POST",
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
})