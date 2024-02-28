function lance(id) {
    window.location.href = "lectureqcm.html?idQcm=" + id
}
$(document).ready(function () {
    $.ajax({
        url: "http://127.0.0.1/recherche",
        type: "POST",
        dataType: "text",
        data: { "recherche": "" },
        success: function (data) {
            if (data != "") {
                $("#resultat").html(data)
            } else {
                $("#resultat").html('<h3 class="title">Aucun Résultat</h3>')
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
    })
    $("#recherche").keyup(function () {
        $.ajax({
            url: "http://127.0.0.1/recherche",
            type: "POST",
            dataType: "text",
            data: { "recherche": $("#recherche").val() },
            success: function (data) {
                if (data != "") {
                    $("#resultat").html(data)
                } else {
                    $("#resultat").html('<h3 class="title">Aucun Résultat</h3>')
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
        })
    })
})