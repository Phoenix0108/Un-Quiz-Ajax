indexForm = 0
function changeForm() {
    nbrForm = $(".form").length;
    if (indexForm < 0) {
        indexForm = nbrForm
    }
    $(".form").hide()
    index = indexForm % nbrForm
    $(".form")[index].style.display = "flex";
    $("#compte").html((index + 1) + "/" + nbrForm)
}
$(document).ready(function () {
    $("#Avant").click(function () {
        indexForm--
        changeForm()
    });
    $("#Apres").click(function () {
        indexForm++
        changeForm()
    })
})