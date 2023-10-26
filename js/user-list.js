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
    $(".logout-press").click(function () {
        $.ajax({
            url:"user-list.php",
            method:"POST",
            data:{logout_press:'yes'},
            success:function(data) {
                location.replace("index.php");
            },
            error:function(xhr, status, error) {
                alert("Error: " + status + " - " + error);
            }
        });
    });
});
