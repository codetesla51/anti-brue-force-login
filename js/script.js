$(document).ready(function () {
    $("#loginForm").on("submit", function (event) {
        event.preventDefault();

        var formData = {
            uname: $("#uname").val(),
            pass: $("#pass").val(),
            log: true
        };

        $.ajax({
            url: "../controllers/login_contrl.php",
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: "info",
                    title: "Login Response",
                    text: response
                }).then(function () {
                    if (response.includes("Login successful!")) {
                        window.location.href = "dashboard.php";
                    }
                });
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: "There was an error processing your request. Please try again later."
                });
            }
        });
    });
});
