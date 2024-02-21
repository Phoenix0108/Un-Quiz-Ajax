$(document).ready(function () {
    $("#suppression").click(function () {
        $.ajax({
            url: "http://127.0.0.1/supCompte",
            type: "POST",
            success: function () {
                window.location.href = "index.html"
            }
        })
    })
})