function lance(id) {
    window.location.href = "lectureqcm.html?idQcm=" + id
}
function supp(id) {
    cookie = getCookie();
    if (typeof cookie["token"] != "undefined") {
        $.ajax({
            url: "http://127.0.0.1/suppQCM",
            type: "POST",
            dataType: "json",
            data: {
                "idQcm": id,
                "token": cookie["token"]
            },
            success: function () {
                location.reload(true)
            }
        });
    } else {
        console.log("pas connecter")
    }
}
$(document).ready(function () {
    $("#btnRetour").click(function () {
        window.location.href = "acceuil.html"
    })
    $("#ajoutQcm").click(function () {
        window.location.href = "AjoutQCM.html"
    })
})