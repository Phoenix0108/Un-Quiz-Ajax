$(document).ready(function () {
    $("#getFormQCM").click(function () {
        nbrFormQCM = $(".form").length;
        $.ajax({
            url: "http://127.0.0.1/getFormQCM",
            type: "POST",
            dataType: "text",
            data: { "nbrFormQCM": nbrFormQCM },
            success: function (reponse) {
                if (reponse.state) {
                    $("#divForm").append(reponse.data);
                }
            }
        });
    });
})