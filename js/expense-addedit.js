$(document).ready(function() {
    $('.cancel-addedit').click(function() {
        $('.allowance-id-form').submit();
    });
    $('.submit-addedit').click(function() {
        $('.expense-addedit-form').submit();
        $('.allowance-id--form').submit();
    });
});
