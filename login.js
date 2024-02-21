document.ready(function () {
    $("#login-form").submit(function (event) {
        event.preventDefault(); //  J’empêche la page de reaload comme c’est normalement le cas sur un submit

        //  Je convertie mon form en JSON
        const formData = $("#login-form").serialize();

        // Send AJAX POST request with form data
        $.ajax({
            url: "http://127.0.0.1/login",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (response) {
                if (response.state) {
                    window.location.href = "/acceuil.html"
                }
            },
            error: function (xhr, status, error) {
                // Ton action d’échec
            }
        });
    });

})