$(document).ready(function () {
    $(".setrole-click").click(function (e) {
        $(".overlay").toggle();
        
        var userID = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var role = $(this).data('role');

        $(".user-info-id").attr("value", userID);
        $(".user-info-name").html(name);
        $(".user-info-email").html(email);
        if (role === "admin") {
            $('.role-change option[value="admin"]').prop('selected', true);
        } else if (role === "member") {
            $('.role-change option[value="member"]').prop('selected', true);
        }
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
