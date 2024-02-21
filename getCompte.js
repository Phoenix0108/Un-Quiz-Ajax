$(document).ready(function () {
    $.ajax({
        url: "http://127.0.0.1/getCompte",
        type: "POST",
        success: function (data) {
            $("#nom").html(data.nom);
            $("#email").html(data.email);
        }
    })
})