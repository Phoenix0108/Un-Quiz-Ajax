function pushReponse(numQuestion, idQcm) {
    cookie = getCookie();
    if (typeof cookie["token"] != "undefined") {
        reponse = $("#valChoix").val()
        $.ajax({
            url: "http://127.0.0.1/pushReponse",
            type: "POST",
            dataType: "json",
            data: {
                "reponse": reponse,
                "idQcm": idQcm,
                "numQuestion": numQuestion,
                "token": cookie["token"]
            },
            success: function (data) {
                if (data.state) {
                    if (data.reponse) {
                        $("#trueReponse")[0].innerHTML = "Bonne réponse"
                        numReponseTrue++
                    } else {
                        $("#trueReponse")[0].innerHTML = "Mauvaise réponse, la bonne réponse était : " + data.True
                    }
                    $("#btnValid").hide()
                    if (numQuestion == numQuestionTotal) {
                        $("#btnResultat").show()
                    } else {
                        $("#btnSuivant").show()
                    }
                }
            },
            error: function (xhr) {
                if (xhr.status == 0) {
                    console.log("pas connection serveur")
                }
                if (xhr.status == 404) {
                    console.log("Contenue introuvable")
                }
            }
        })
    } else {
        console.log("Pas connecter");
    }
}
