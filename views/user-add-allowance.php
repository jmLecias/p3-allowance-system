<!DOCTYPE html>
<html>
<head>
    <title>Create New Allowance Form</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="categorize.js"></script>
</head>
<body>
</html>
    <div class="bank-info">
        <h2>Money minder</h2>
    </div>
<body>
    <h1>Allowance Form</h1>
    </div>
    <form id="allowanceForm" action="submit_allowance.php" method="POST">
        <label for="employeeName">Employee Name:</label>
        <input type="text" id="employeeName" name="employeeName" required><br><br>

        <label for="allowanceType">Allowance Type:</label>
        <select id="allowanceType" name="allowanceType" required>
            <option value="housing">Housing Allowance</option>
            <option value="transportation">Transportation Allowance</option>
            <option value="food">Food Allowance</option>
        </select><br><br>

        <label for="allowanceAmount">Allowance Amount:</label>
        <input type="number" id="allowanceAmount" name="allowanceAmount" min="0" required><br><br>

        <label for="allowanceStartDate">Start Date:</label>
        <input type="date" id="allowanceStartDate" name="allowanceStartDate" required><br><br>

        <label for="allowanceEndDate">End Date:</label>
        <input type="date" id="allowanceEndDate" name="allowanceEndDate" required><br><br>

        <input type="submit" value="Create Allowance">
    </form>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("form").addEventListener("submit", function(event) {
            event.preventDefault();
            const allowanceName = event.target.allowance_name.value;
            const allowanceAmount = event.target.allowance_amount.value;
            const allowanceCategory = event.target.allowance_category.value;

            if (allowanceCategory === "day") {
            } else if (allowanceCategory === "week") {
            } else if (allowanceCategory === "month") {
            } else if (allowanceCategory === "specific_date") {
            }
        });
    });
</script>
</html>
