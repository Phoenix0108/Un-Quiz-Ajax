function catchReponse(val) {
    for (i = 0; i < $(".choix").length; i++) {
        $(".choix")[i].style.backgroundColor = "#0076e4";
    }
    $(".choix")[val - 1].style.backgroundColor = "green";
    $("#valChoix").val(val)
    if (0 < $("#valChoix").val() && $("#valChoix").val() < 5) {
        $("#btnValid").removeClass("notAllowed")
        $("#btnValid").addClass("green")
    }
}
function getIdqcmUrl() {
    urlGet = location.search;
    dicValUrl = {};
    uri = urlGet.split("?");
    if (uri.length == 2) {
        body = uri[1]
        paire_valeur = body.split("&");
        for (i = 0; i < paire_valeur.length; i++) {
            paire = paire_valeur[i].split("=");
            if (paire.length == 2) {
                dicValUrl[paire[0]] = paire[1];
            }
        }
        if (dicValUrl) {
            return dicValUrl;
        }
    }
    return false
}

$(document).ready(function () {
    dicValUrl = getIdqcmUrl()
    console.log(dicValUrl);
    numQuestion = 1
    numQuestionTotal = 0
    numReponseTrue = 0
    if (typeof dicValUrl["idQcm"] != "undefined") {
        idQcm = dicValUrl["idQcm"];
        getQuestion(numQuestion, idQcm)
    } else {
        console.log("pas de idQcm");
    }
    $("#btnValid").click(function () {
        if (0 < $("#valChoix").val() && $("#valChoix").val() < 5 && idQcm) {
            pushReponse(numQuestion, idQcm)
        }
    })

    $("#btnSuivant").click(function () {
        numQuestion++
        numQuestionTotal = getQuestion(numQuestion, idQcm)
        $("#trueReponse")[0].innerHTML = ""
        $("#btnValid").show()
        $("#btnSuivant").hide()
        for (i = 0; i < $(".choix").length; i++) {
            $(".choix")[i].style.backgroundColor = "#00ABE4";
        }
    })
    $("#btnResultat").click(function () {
        $("#divQcm").hide()
        $("#divResultat").show()
        $("#score")[0].innerHTML = "Votre Score est de " + numReponseTrue + "/" + numQuestionTotal
    })
})