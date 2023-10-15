$(document).ready(function () {
    $(".hover-trigger").hover(
        function () {
            $(this).find(".expenses-info").show();
        },
        function () {
            $(this).find(".expenses-info").hide();
        }
    );
})