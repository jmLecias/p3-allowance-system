$(document).ready(function () {
    $("body").click(function (e) {
        // hides and unselects all
        $(".info-div").addClass("hide");
        $(".tile-click .expenses-info").addClass("hide");
        $(".tile-click").removeClass("selected");
        $(".delete-dialog").addClass("hide");
    });
    $(".info-div").click(function (e) {
        e.stopPropagation();
        $(".delete-dialog").addClass("hide");
    });
    $(".tile-click").click(function (e) {
        e.stopPropagation();

        var allowanceID = $(this).data('id');
        var name = $(this).data('name');
        var desc = $(this).data('desc');
        var amount = parseInt($(this).data('amount'));
        var category = $(this).data('category');
        var expenses = $(this).data('expenses');
        var tExpenses = $(this).data('tExpenses');

        $(".dialog-btn").attr("data-id", allowanceID);
        $(".edit-allowance-pass").attr("value", allowanceID);
        $(".info-name").html(name);
        $(".info-desc").html(desc);
        $(".info-amount-category").html("PHP " + amount.toLocaleString() + " _ " + category);
        $(".info-expenses").html(expenses.toLocaleString() + " expense items");
        // $(".info-total-expenses").html("PHP " + tExpenses.toLocaleString() + " - Total expenses");

        // unselect all first
        $(".tile-click .expenses-info").addClass("hide");
        $(".tile-click").removeClass("selected");
        $(".delete-dialog").addClass("hide");

        // select the new tile and show allowance info
        $(".info-div").removeClass("hide");
        $(this).find(".expenses-info").removeClass("hide");
        $(this).addClass("selected");
    });
    $(".delete-allowance-btn").click(function (e) {
        e.stopPropagation();
        $(".delete-dialog").removeClass("hide");
    });
    $(".logout-press").click(function () {
        $.ajax({
            url:"user-allowances.php",
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
    $(".dialog-btn").click(function (e) {
        var allowanceID = $(this).data('id');
        var value = $(this).data('val');

        if (value == "yes") {
            $.ajax({
                url:"user-allowances.php",
                method:"POST",
                data:{allowanceID:allowanceID, submit_delete: 'YES'},
                success:function(data) {
                    $('.allowance'+allowanceID).remove();
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