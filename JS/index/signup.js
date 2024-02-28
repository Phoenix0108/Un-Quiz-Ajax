$(document).ready(function () {
    $("#signup-form").submit(function (event) {
        event.preventDefault(); //  J’empêche la page de reaload comme c’est normalement le cas sur un submit

        //  Je convertie mon form en JSON
        const formData = $("#signup-form").serialize();

        // Send AJAX POST request with form data
        $.ajax({
            url: "http://127.0.0.1/signup",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (response) {
                if (response.state) {
                    setCookie("token", response.token, 600);
                    window.location.href = "acceuil.html"
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
        });
    });

})