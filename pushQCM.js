$(document).ready(function () {
    function notEmpty(val) {
        return val != "";
    }
    function verifRadio(rad) {
        return 0 < rad && rad < 5;
    }
    $("#enregistrer").click(function () {
        conforme = true;
        qcm = {};
        nbrForm = $(".form").length;
        nom = $("#nom")[0].value
        if (nbrForm > 0 && notEmpty(nom)) {
            for (i = 0; i < nbrForm; i++) {
                question = $(".question")[i].value;
                reponse1 = $(".reponse1")[i].value;
                reponse2 = $(".reponse2")[i].value;
                reponse3 = $(".reponse3")[i].value;
                reponse4 = $(".reponse4")[i].value;
                nbrRadio = $(".radio" + i).length;
                radioItem = $(".radio" + i);
                reponseTrue = 0;
                for (j = 0; j < nbrRadio; j++) {
                    if (radioItem[j].checked == true) {
                        reponseTrue = radioItem[j].value;
                        break;
                    }
                }
                if (notEmpty(question) && notEmpty(reponse1) && notEmpty(reponse2) && notEmpty(reponse3) && notEmpty(reponse4) && verifRadio(reponseTrue)) {
                    qcm[question] = [reponse1, reponse2, reponse3, reponse4, reponseTrue];
                } else {
                    conforme = false;
                    break;
                }
            }
            if (conforme) {
                $.ajax({
                    url: "http://127.0.0.1/pushQCM",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "qcm": qcm,
                        "nom": nom
                    },
                    success: function (reponse) {
                        if (reponse.state) {
                            window.location.href = "verifQCM.html";
                        }
                    }
                })
            }
        }
    })

})