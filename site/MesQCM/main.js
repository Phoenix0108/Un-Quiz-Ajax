function lance(id) {
    now = new Date()
    now.setTime(now.getTime() + 1000 * 20)
    document.cookie = "idQcm=" + id + ";" + now.toUTCString() + ";path=/";
    window.location.href = "../LectureQCM/lectureqcm.html"
}
function supp(id) {
    $.ajax({
        url: "http://127.0.0.1/MesQCM/Backend/delQCM",
        type: "POST",
        data: { idQcm: id },
        success: function () {
            //location.reload()
        }
    })
}
$.ajax({
    url: 'http://127.0.0.1/MesQCM/Backend/getQCM',
    type: "POST",
    dataType: "text",
    success: function (data) {
        if (data == "") {
            $(".contentQCM").append("<span>Aucun résultat</span>")
        } else {

            $(".contentQCM").append(data)
        }
    }
})
$(document).ready(function () {
    $("#btnRetour").click(function () {
        window.location.href = "/Acceuil/acceuil.html"
    })
    $("#ajoutQcm").click(function () {
        window.location.href = "/AjoutQCM/AjoutQCM.html"
    })
})