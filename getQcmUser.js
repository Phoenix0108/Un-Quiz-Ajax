document.ready(function () {
    $.ajax({
        url: "http://127.0.0.1/getQcmUser",
        type: "POST",
        dataType: "text",
        success: function (response) {
            if (response.state) {
                $("#contentQCM").append(response.data);
            }
        },
        error: function (xhr, status, error) {
            // Ton action d’échec
        }
    });
})