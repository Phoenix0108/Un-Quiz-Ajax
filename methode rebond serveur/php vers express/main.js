$(document).ready(function(){
    $.ajax({
        url: "http://127.0.0.1/index.php",
        type: "POST",
        dataType: "json",
        data:{"message": "réussi"},
        success: function(data){
            $("span").html(data.message)
        }
    })
})