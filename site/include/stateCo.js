$.ajax({
    url: "http://127.0.0.1/include/verifCo",
    type: "POST",
    dataType: "json",
    success: function (data) {
        if (data.stateCo) {

        } else {
            window.location.href = "/"
        }
    }
})