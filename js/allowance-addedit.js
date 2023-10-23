$(document).ready(function () {
    $(".category-change").change(function () {
        var selectedValue = $(this).val();
        if(selectedValue === "date") {
            $(".specific-date").show();
            $(".specific-date").addAttribute("required");
        } else {
            $(".specific-date").hide();
            $(".specific-date").removeAttribute("required");
        }
    });
});
