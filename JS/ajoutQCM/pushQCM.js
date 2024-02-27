$(document).ready(function () {
    function notEmpty(val) {
        return val != "";
    }
    function verifRadio(rad) {
        return 0 < rad && rad < 5;
    }
    $("#enregistrer").click(function () {
        conforme = false;
        qcm = {};
        nbrForm = $(".form").length;
        nom = $("#nom").val();
        if (nbrForm > 0 && notEmpty(nom)) {
            conforme = true;
            for (i = 0; i < nbrForm; i++) {
                question = $(".question")[i].value;
                reponse1 = $(".reponse1")[i].value;
                reponse2 = $(".reponse2")[i].value;
                reponse3 = $(".reponse3")[i].value;
                reponse4 = $(".reponse4")[i].value;
                nbrRadio = $("input[name='r" + i + "']").length;
                radioItem = $("input[name='r" + i + "']");
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
        }
        if (conforme) {
            cookie = getCookie();
            if (typeof cookie["token"] != "undefined") {
                $.ajax({
                    url: "http://127.0.0.1/pushQCM",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "qcm": qcm,
                        "nom": nom,
                        'token': cookie["token"]
                    },
                    success: function (reponse) {
                        if (reponse.state) {
                            window.location.href = "mesqcm.html";
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
            } else {
                console.log("pas connecter")
            }
        } else {
            $("#error").show();
            setTimeout(() => {
                $("#error").hide();
            }, 2000)
        }
    })

})