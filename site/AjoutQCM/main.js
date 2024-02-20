selection = 0
navForm = true
$(document).ready(function () {
    $("#btnRetour").click(function () {
        window.location.href = "../MesQCM/mesqcm.html"
    })
    function newQCM() {
        $.ajax({
            url: "http://127.0.0.1/AjoutQCM/Backend/ajoutQCM",
            type: "POST",
            dataType: "text",
            data: { "numPage": $("form").length },
            success: function (data) {
                $("#divForm").append(data)
                $(".btnAdd").click(newQCM)
                $(".form").hide()
                $(".compte1")[0].innerHTML = $(".form").length + "/" + $(".form").length
                $(".form")[$(".form").length - 1].style.display = "block"
                selection = $("form").length - 1
                if (navForm) {
                    $("#nav-fleche").show()
                    navForm = false
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', error);
            }
        })
    }
    $(".Avant").click(function () {
        selection--
        if (selection < 0) {
            selection = $("form").length - 1
        }
        index = selection % $("form").length
        $("form").hide()
        $(".compte1")[0].innerHTML = (index + 1) + "/" + $(".form").length
        $("form")[index].style.display = "block"
    })
    $(".Apres").click(function () {
        selection++
        index = selection % $("form").length
        $("form").hide()
        $(".compte1")[0].innerHTML = (index + 1) + "/" + $(".form").length
        $("form")[index].style.display = "block"
    })
    $(".btnAdd").click(newQCM)
    $("#enregistrer").click(function () {
        qcm = {}
        nom = $("#nom").val()
        conforme = true
        for (i = 0; i < $("form").length; i++) {
            question = $(".question")[i].value
            reponse1 = $(".reponse1")[i].value
            reponse2 = $(".reponse2")[i].value
            reponse3 = $(".reponse3")[i].value
            reponse4 = $(".reponse4")[i].value
            inputRadio = 'input[type="radio"][name="radioQCM' + (i + 1) + '"]'
            radio = 0
            for (j = 0; j < $(inputRadio).length; j++) {
                //fais le tour des radios pour savoir lequel est sélectionner
                if ($(inputRadio)[j].checked == true) {
                    radio = $(inputRadio)[j].value
                }
            }
            if (question != "" && reponse1 != "" && reponse2 != "" && reponse3 != "" && reponse4 != "" && (0 < radio && radio < 5)) {
                qcm[question] = [reponse1, reponse2, reponse3, reponse4, radio]
            } else {
                conforme = false
                $("#error").show()
                setTimeout(function () {
                    $("#error").hide()
                }, 2000)
                break
            }
        }
        if (conforme) {
            console.log(qcm)
            $.ajax({
                url: "http://127.0.0.1/AjoutQCM/Backend/SaveQuestion",
                type: "POST",
                dataType: "json",
                data: {
                    "data": qcm,
                    "nom": nom
                },
                success: function () {
                    window.location.href = "../MesQCM/mesqcm.html"
                },
                error: function () {

                }
            })
        }

    })
})
