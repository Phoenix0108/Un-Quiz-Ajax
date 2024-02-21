function lance(id) {
    window.location.href = "lectureqcm.html?idQcm=" + id
}
$(document).ready(function () {
    $("#btnRetour").click(function () {
        window.location.href = "acceuil.html"
    })
    $("#ajoutQcm").click(function () {
        window.location.href = "AjoutQCM.html"
    })
})