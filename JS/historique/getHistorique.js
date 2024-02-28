cookie = getCookie();
if(typeof cookie['token'] != "undefined"){
    $.ajax({
        url: "http://127.0.0.1/getHistorique",
        type: "POST",
        daaType: "text",
        data: {"token": cookie['token']},
        success: function (data) {
            if(data){
                $("main").html(data);
            }else{
                $("main").html("<h3>Pas d'hitorique</h3>");
            }
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
}
