$(document).ready(function () {
    indexForm = 0
    function changeForm() {
        nbrForm = $(".form").length;
        if (indexForm < 0) {
            indexForm = nbrForm
        }
        $(".form").hide()
        index = indexForm % nbrForm
        $(".form")[index].style.display = "flex";
        console.log(index);
        $("#compte").html((index + 1) + "/" + nbrForm)
    }
    $("#Avant").click(function () {
        indexForm--
        changeForm(indexForm)
    });
    $("#Apres").click(function () {
        indexForm++
        changeForm(indexForm)
    })
})