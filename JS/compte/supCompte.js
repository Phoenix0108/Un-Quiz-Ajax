$(document).ready(function () {
    $("#suppression").click(function () {
        if(typeof cookie["token"] != "undefined"){
            $.ajax({
                url: "http://127.0.0.1/supCompte",
                type: "POST",
                dataType: "json",
                data:{"token": cookie["token"]},
                success: function (data) {
                    if(data.state){
                        console.log("deco reussi");
                        setCookie("token", 0, 1);
                        window.location.href = "index.html"
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
        }else{
            console.log("pas connecter")
        }
    })
})