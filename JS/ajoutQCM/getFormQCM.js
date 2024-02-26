$(document).ready(function () {
    $("#getFormQCM").click(function () {
        nbrFormQCM = $(".form").length;
        $.ajax({
            url: "http://127.0.0.1/getFormQCM",
            type: "POST",
            dataType: "text",
            data: { "nbrFormQCM": nbrFormQCM },
            success: function (reponse) {
                if (reponse.state) {
                    $("#divForm").append(reponse.data);
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
    });
})