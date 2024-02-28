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

function pushReponse() {
    cookie = getCookie();
    reponse = $("#valChoix").val();
    if (typeof cookie["token"] != "undefined") {
        nbrInfos = 3;
        data = {
            "reponse": reponse,
            "numQuestion": numQuestion,
            "token": cookie["token"]
        }
        if(typeof url["idQcm"] != "undefined"){
            //Dans le cas ou c'est un nouveau qcm
            data["idQcm"] = url["idQcm"]
            nbrInfos++;
        }
        if(typeof url["idHistorique"] != "undefined"){
            //dans le cas ou c'est une reprise
            data["idHistorique"] = url["idHistorique"]
            nbrInfos++;
        }
        if(nbrInfos >= 4){
            //Vérifie si id à bien été assigner
            $.ajax({
                url: "http://127.0.0.1/pushReponse",
                type: "POST",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (data.state) {
                        if (data.reponse) {
                            $("#trueReponse")[0].innerHTML = "Bonne réponse"
                        } else {
                            $("#trueReponse")[0].innerHTML = "Mauvaise réponse, la bonne réponse était : " + data.True
                        }
                        $("#btnValid").hide()
                        numQuestion = $("#numQuestion").html();
                        numQuestionTotal = $("#numQuestionTotal").html();
                        console.log(numQuestionTotal)
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
        }else{
            console.log("Il manque un élément", data);
        }
    } else {
        console.log("Pas connecter");
    }
}
$(document).ready(function(){
    $("#btnValid").click(function () {
        console.log("lancer");
        if (0 < $("#valChoix").val() && $("#valChoix").val() < 5) {
            pushReponse()
        }
    })
})

