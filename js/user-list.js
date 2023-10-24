$(document).ready(function () {
    $(".setrole-click").click(function (e) {
        $(".overlay").toggle();
    });
    
    $(".inside-click").click(function (e) {
        e.stopPropagation();
    });

    $(".outside-click").click(function () {
        $(".overlay").toggle();
    });
});
