$(document).ready(function () {
    $(".tile-click").click(function (e) {
        e.stopPropagation();

        var expenseID = $(this).data('id');
        var name = $(this).data('name');
        var remarks = $(this).data('remarks');
        var amount = parseInt($(this).data('amount'));
        var date = $(this).data('date');
        
        $(".edit-expense-btn").attr("data-id", expenseID);
        $(".info-name").html(name);
        $(".info-remarks").html(remarks);
        $(".info-amount-date").html("PHP " + amount.toLocaleString() + " - " + date);
        
        // unselects all
        $(".tile-click").removeClass("selected");

        // selects new tile and shows expense info
        $(".info-div").removeClass("hide");
        $(this).addClass("selected");
    });
    $(".edit-expense-btn").click(function (e) {
        e.stopPropagation();
        var expenseID = $(this).data('id');
        window.location.href = "expense-addedit.php?id="+expenseID;
    });
    $("body").click(function (e) {
        // hides and unselects all
        $(".info-div").addClass("hide");
        $(".tile-click").removeClass("selected");
    });
});