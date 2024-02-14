function lance(id) {
    now = new Date()
    now.setTime(now.getTime() + 1000 * 20)
    document.cookie = "idQcm=" + id + ";" + now.toUTCString() + ";path=/";
    window.location.href = "../LectureQCM/lectureqcm.html"
}
$.ajax({
    url: 'http://127.0.0.1/MesQCM/Backend/getQCM',
    type: "POST",
    dataType: "text",
    success: function (data) {
        $(".contentQCM").append(data)
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