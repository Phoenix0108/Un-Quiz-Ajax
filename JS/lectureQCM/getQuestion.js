function getQuestion() {
    if (typeof cookie["token"] != "undefined") {
        nbrInfos = 2
        data = {
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
        console.log(data)
        if(nbrInfos >= 3){
            $.ajax({
                url: "http://127.0.0.1/getQuestion",
                type: "POST",
                dataType: "json",
                data:data,
                success: function (data) {
                    if (data.state) {
                        $("#numQuestion").html(data.index);
                        $("#numQuestionTotal").html(data.numQuestionTotal);
                        $("#question").val(data.question)
                        $(".choix")[0].innerHTML = data.reponse1
                        $(".choix")[1].innerHTML = data.reponse2
                        $(".choix")[2].innerHTML = data.reponse3
                        $(".choix")[3].innerHTML = data.reponse4
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
        }else{
            console.log("Il manque un élément", data);
        }
    } else {
        console.log("pas connecté");
    }
}
$(document).ready(function(){
    $("#btnSuivant").click(function () {
        numQuestion = $("#numQuestion").html();
        numQuestionTotal = $("#numQuestionTotal").html();
        numQuestion++;
        if(numQuestion<=numQuestionTotal){
            getQuestion();
            $("#trueReponse")[0].innerHTML = ""
            $("#btnValid").show()
            $("#btnSuivant").hide()
            for (i = 0; i < $(".choix").length; i++) {
                $(".choix")[i].style.backgroundColor = "#00ABE4";
            }
        }else{
            console.log("pas d'autre question");
        }
    })
})
