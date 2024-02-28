$(document).ready(function(){
    $("#btnResultat").click(function(){
        data = {};
        if(typeof cookie["token"] != "undefined"){
            data['token'] = cookie["token"];
            nbrInfos = 1;
            
            if(typeof url["idQcm"] != "undefined"){
                data["idQcm"] = url["idQcm"];
                nbrInfos++
            }
            if(typeof url["idHistorique"] != "undefined"){
                data["idHistorique"] = url["idHistorique"]
                nbrInfos++
            }
            if(nbrInfos >= 2){
                $.ajax({
                    url: "http://127.0.0.1/getResultat",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function(data){
                        $("#divQcm").hide();
                        $("#divResultat").show();
                        $("#score").html(data.numReponseTrue+"/"+data.numQuestion);
                    },
                    error: function(){
            
                    }
                })
            }
        }
        
    })
})
