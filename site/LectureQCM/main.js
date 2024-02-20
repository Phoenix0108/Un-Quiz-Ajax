numQuestion = 1
numQuestionTotal = 0
numReponseTrue = 0
function catchQuestion() {
    $.ajax({
        url: "http://127.0.0.1/LectureQCM/Backend/getQuestion",
        type: "POST",
        dataType: "json",
        data: { "numQuestion": numQuestion },
        success: function (data) {
            if (data.state) {
                numQuestionTotal = data.numQuestionTotal
                $("#indexQuestion")[0].innerHTML = "N° question : " + data.index + "/" + data.numQuestionTotal
                $(".question")[0].innerHTML = data.question
                console.log(data.reponse1)
                $(".choix")[0].innerHTML = data.reponse1
                $(".choix")[1].innerHTML = data.reponse2
                $(".choix")[2].innerHTML = data.reponse3
                $(".choix")[3].innerHTML = data.reponse4
            }
        }

    })
}

function catchReponse(val) {
    for (i = 0; i < $(".choix").length; i++) {
        $(".choix")[i].style.backgroundColor = "#00ABE4";
    }
    $(".choix")[val - 1].style.backgroundColor = "green";
    $("#valChoix").val(val)
}
$(document).ready(function () {
    catchQuestion()
    $("#btnRetour").click(function () {
        window.location.href = "../MesQCM/mesqcm.html"
    })
    $("#btnValid").click(function () {
        reponse = $("#valChoix").val()
        $.ajax({
            url: "http://127.0.0.1/LectureQCM/Backend/verifReponse",
            type: "POST",
            dataType: "json",
            data: {
                "reponse": reponse,
                "numQuestion": numQuestion
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
            }
        })
    })
    $("#btnSuivant").click(function () {
        numQuestion++
        catchQuestion()
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
    $("#retourAcceuil").click(function () {
        window.location.href = "../Acceuil/acceuil.html"
    })
})