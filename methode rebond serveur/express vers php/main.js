$(document).ready(function () {
    $.ajax({
        url: "http://127.0.0.1:81/express",
        type: "POST",
        dataType: "json",
        data: { "message": "php réussi" },
        success: function (data) {
            $("span").html(data.message)
        }
    })
})