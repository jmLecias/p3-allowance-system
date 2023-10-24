$(document).ready(function () {
    $(".tile-click").click(function (e) {
        var name = $(this).data('name');
        var remarks = $(this).data('remarks');
        var amount = parseInt($(this).data('amount'));
        var date = $(this).data('date');
        
        $(".info-name").html(name);
        $(".info-remarks").html(remarks);
        $(".info-amount-date").html("PHP " + amount.toLocaleString() + " - " + date);
        
        e.stopPropagation();

        // unselects all
        $(".tile-click").removeClass("selected");

        // selects new tile and shows expense info
        $(".info-div").removeClass("hide");
        $(this).addClass("selected");
    });

    $("body").click(function (e) {
        // hides and unselects all
        $(".info-div").addClass("hide");
        $(".tile-click").removeClass("selected");
    });
});