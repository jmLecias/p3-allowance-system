document.addEventListener("DOMContentLoaded", function() {
    const categorySelect = document.querySelector("select[name='allowance_category']");
    const specificDateInput = document.querySelector("input[name='specific_date']");

    categorySelect.addEventListener("change", function() {
        if (categorySelect.value === "specific_date") {
            specificDateInput.style.display = "block"; 
        } else {
            specificDateInput.style.display = "none"; 
        }
    });
});
