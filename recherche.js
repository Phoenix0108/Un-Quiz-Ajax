$(document).ready(function () {

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
            }
        })
    })
})