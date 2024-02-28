function supQCM(id){
    cookie = getCookie();
    if(typeof cookie['token'] != "undefined"){
        $.ajax({
            url: "http://127.0.0.1/supHistorique",
            type: "POST",
            data: {
                "token": cookie['token'],
                "id_note": id
            },
            success: function () {
                location.reload(true);
            },
            error: function (xhr) {
                if (xhr.status == 0) {
                    console.log("Serveur introuvable");
                }
                if (xhr.status === 404) {
                    console.log("Contenue introuvable")
                }
            }
        })
    }else{
        console.log("pas connecter")
    }
}
