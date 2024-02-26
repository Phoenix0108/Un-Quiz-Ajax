document.ready(function () {
    $.ajax({
        url: "http://127.0.0.1/getQcmUser",
        type: "POST",
        dataType: "text",
        success: function (response) {
            if (response.state) {
                $("#contentQCM").append(response.data);
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
})