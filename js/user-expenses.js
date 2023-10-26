$(document).ready(function () {
    $("body").click(function (e) {
        // hides and unselects all
        $(".info-div").addClass("hide");
        $(".tile-click").removeClass("selected");
        $(".delete-dialog").addClass("hide");
    });
    $(".info-div").click(function (e) {
        e.stopPropagation();
        $(".delete-dialog").addClass("hide");
    });
    $(".tile-click").click(function (e) {
        e.stopPropagation();

        var expenseID = $(this).data('id');
        var name = $(this).data('name');
        var remarks = $(this).data('remarks');
        var amount = parseInt($(this).data('amount'));
        var date = $(this).data('date');
        
        $(".dialog-btn").attr("data-id", expenseID);
        $(".edit-pass").attr("value", expenseID);
        $(".info-name").html(name);
        $(".info-remarks").html(remarks);
        $(".info-amount-date").html("PHP " + amount.toLocaleString() + " - " + date);
        
        // unselects all
        $(".tile-click").removeClass("selected");

        // selects new tile and shows expense info
        $(".info-div").removeClass("hide");
        $(this).addClass("selected");
    });
    $(".delete-expense-btn").click(function (e) {
        e.stopPropagation();
        $(".delete-dialog").removeClass("hide");
    });
    $(".dialog-btn").click(function (e) {
        var expenseID = $(this).data('id');
        var value = $(this).data('val');

        if (value == "yes") {
            $.ajax({
                url:"user-expenses.php",
                method:"POST",
                data:{expenseID:expenseID, submit_delete: 'YES'},
                success:function(data) {
                    $('.expense'+expenseID).remove();
                    $(".info-div").addClass("hide");
                    location.reload();
                },
                error:function(xhr, status, error) {
                    alert("Error: " + status + " - " + error);
                }
            });
        }
    });
});