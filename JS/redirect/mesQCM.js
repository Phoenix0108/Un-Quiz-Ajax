function lance(id) {
    window.location.href = "lectureqcm.html?idQcm=" + id
}
function supp(id) {
    $.ajax({
        url: "http://127.0.0.1/suppQCM",
        type: "POST",
        data: { "idQCM": id },
        success: function () {
            window.refresh
        }
    })
}
$(document).ready(function () {
    $("#btnRetour").click(function () {
        window.location.href = "acceuil.html"
    })
    $("#ajoutQcm").click(function () {
        window.location.href = "AjoutQCM.html"
    })
})