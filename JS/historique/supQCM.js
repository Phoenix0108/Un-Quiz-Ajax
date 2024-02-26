function supQCM(idQcm) {
    $.ajax({
        url: "http://127.0.0.1/supHistorique",
        type: "POST",
        success: function () {
            window.refresh(true)
        }
    })
}