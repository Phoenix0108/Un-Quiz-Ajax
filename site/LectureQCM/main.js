function catchReponse(val) {
    $("#valReponse").value = val
}
$(document).ready(function () {
    $("#btnRetour").click(function () {
        window.location.href = "../MesQCM/mesqcm.html"
    })
    $("#btnValid").click(function () {
        reponse = $("#valReponse").value
        $.ajax({
            url: "http://127.0.0.1/LectureQCM/Backend/VerifReponse",
            type: "POST",
            dataType: "json",
            data: { "reponse": reponse },
            succes: function (data) {

            }
        })
    })
})