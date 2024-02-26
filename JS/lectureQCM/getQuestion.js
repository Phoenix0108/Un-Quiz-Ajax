function getQuestion(numQuestion, idQcm) {
    $.ajax({
        url: "http://127.0.0.1/getQuestion",
        type: "POST",
        dataType: "json",
        data: {
            "numQuestion": numQuestion,
            "idQcm": idQcm
        },
        success: function (data) {
            if (data.state) {
                $("#indexQuestion")[0].innerHTML = "N° question : " + data.index + "/" + data.numQuestionTotal
                $("#question").val(data.question)
                console.log(data.reponse1)
                $(".choix")[0].innerHTML = data.reponse1
                $(".choix")[1].innerHTML = data.reponse2
                $(".choix")[2].innerHTML = data.reponse3
                $(".choix")[3].innerHTML = data.reponse4
                return data.numQuestionTotal
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
}