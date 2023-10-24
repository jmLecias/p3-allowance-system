$(document).ready(function () {
    $(".authenticate-click, .footer-click").click(function (e) {
        var action = $(this).data("action");

        if (action === "login") {
            $(".login-form").removeClass("hide");
            $(".register-form").addClass("hide");
            $(".register-form").attr("disabled");
            $(".form-image").attr("src", "../public/images/login-image.png");
            $(".show-password").attr("style", "top: 51.5%");
        } else if (action === "register") {
            $(".register-form").removeClass("hide");
            $(".login-form").addClass("hide");
            $(".login-form").attr("disabled");
            $(".form-image").attr("src", "../public/images/register-image.png");
            $(".show-password").attr("style", "top: 61%");
        }

        // toogles overlay only if login or register button was pressed
        if ($(e.target).hasClass("authenticate-click")) {
            $(".overlay").toggle();
        }
    });
    $(".show-password").click(function (e) {
        var password = $(".password-input");

        if(password.attr("type") === "password") {
            password.attr("type", "text");
            $(this).attr("src", "../public/images/icon-eye-slash.png");
        } else {
            password.attr("type", "password");
            $(this).attr("src", "../public/images/icon-eye.png");
        }
    });

    $(".inside-click").click(function (e) {
        e.stopPropagation();
    });

    $(".outside-click").click(function () {
        $(".overlay").toggle();
    });
});
