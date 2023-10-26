<?php
require_once('../db_conn.php');
include '../entity-classes.php';
include '../header-actions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Add Allowance</title>
</head>

<style>
    table {
        width: 100%;
        padding: 0px 20px;
        border-collapse: collapse;
    }

    td {
        padding: 10px 20px;
        border-bottom: 1px solid #08344E;
    }

    .form-div {
        width: 50%;
        min-height: 300px;
        background-color: #124361;
        border-radius: 10px;
        padding: 20px;
        color: #B5E3FF;
    }

    .narrow-td {
        width: 40%;
    }

    .back-button {
        font-size: 15px;
        color: #B5E3FF;
        margin-bottom: 20px;
    }
</style>

<?php

// If user pressed Edit expense button
$expenseID = "";
$remainingAllowance = "";
$allowanceID = "";
$editExpense = null;
if (isset($_GET["edit-expense"])) {
    $expenseID = $_GET['expenseID'];
    $remainingAllowance = $_GET['remainingAllowance'];

    // Get expense info on database and store inside the editExpense Object
    $sql = "SELECT * FROM expenses WHERE `expenseID` ='$expenseID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            $editExpense = new Expense(
                $r['expenseID'],
                $r['allowanceID'],
                $r['amount'],
                $r['name'],
                $r['remarks'],
                $r['date'],
            );
            $allowanceID = $editExpense->allowanceID;
        }
    }
}

// If user pressed Add expense button
if(isset($_POST["add-expense"])) {
    $allowanceID = $_POST["allowanceID"];
    $remainingAllowance = $_POST['remainingAllowance'];
}

// Function for filling form when Editing Allowance

function fillInput($inputName, $expenseObj)
{
    if ($expenseObj !== null) {
        switch ($inputName) {
            case "name":
                echo $expenseObj->name;
                break;
            case "remarks":
                echo $expenseObj->remarks;
                break;
            case "amount":
                echo $expenseObj->amount;
                break;
            case "date":
                echo date('Y-m-d', strtotime($expenseObj->date));
                break;
            default:
        }
    } else {
        echo "";
    }
}
?>

<!-- Database code Add / Edit Expense-->
<?php
if (isset($_POST['submit-expenseForm'])) {
    // to determine if user is editing or adding
    $editExpenseID = $_POST['expenseID'];
    $allowanceID = $_POST['allowanceID'];
    $remainingAllowance = $_POST['remainingAllowance'];


    // form inputs
    $amount = $_POST['amount'];
    $name = $_POST['name'];
    $remarks = $_POST['remarks'];
    $formDate = $_POST['date'];
    $date = date("M d, Y", strtotime($formDate));

    if (!empty($editExpenseID)) {
        $editSql = "UPDATE expenses SET 
                `name` = '$name', 
                `remarks` = '$remarks',
                `amount` = '$amount', 
                `date` = '$date'
            WHERE `expenseID` = '$editExpenseID'";

        if ($conn->query($editSql) === TRUE) {
            header('location:user-expenses.php?allowanceID='. $allowanceID);
        } else {
            echo '<script>alert("Error: ' . $editSql . ' ' . $conn->error . '");</script>';
        }
    } else {
        $addSql = "INSERT INTO expenses (`allowanceID`, `amount`, `name`, `remarks`, `date`)
                VALUES ('$allowanceID', '$amount', '$name', '$remarks', '$date')";

        if ($conn->query($addSql) === TRUE) {
            header('location:user-expenses.php?allowanceID=' . $allowanceID);
        } else {
            echo '<script>alert("Error: ' . $addSql . ' ' . $conn->error . '");</script>';
        }
    }

    $conn->close();
}
?>

<body>
    <!-- Header / Logo Div -->
    <div class="header-div">
        <div onclick="<?php goToFirstPage($role) ?>" class="row-div" style="cursor: pointer; padding: 20px">
            <img src="../public/images/logo-1.png" style="position:absolute">
            <h1 class="logo-text" style="margin-left: 80px">Money minder</h1>
        </div>
    </div>

    <!-- Content Area -->
    <div class="body-div">
        <div class="body-top-div primary-text">
            <?php
            echo (isset($_GET["edit-expense"])) ? "Edit expense item" : "Add new expense item";
            ?>
        </div>
        <a href="user-expenses.php?allowanceID=<?php echo $allowanceID;?>" class="terriary-text back-button">Back</a>
        <br><br>
        <div class="form-div secondary-text" style="font-size: 18px">
            <form action="expense-addedit.php" method="POST">
                <input type="hidden" name="expenseID" value="<?php echo $expenseID; ?>">
                <input type="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                <input type="hidden" name="remainingAllowance" value="<?php echo $remainingAllowance; ?>">
                <table>
                    <tr>
                        <td class="narrow-td"><label>Name</label></td>
                        <td><input value="<?php fillInput("name", $editExpense); ?>" type="text" name="name"
                                placeholder="Enter expense name" required></td>
                    </tr>
                    <tr>
                        <td><label>Remarks</label></td>
                        <td><input value="<?php fillInput("remarks", $editExpense); ?>" type="text" name="remarks"
                                placeholder="Enter expense description" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Amount</label></td>
                        <td><input value="<?php fillInput("amount", $editExpense); ?>" type="number" name="amount"
                                min="0"
                                max="<?php echo (!isset($_GET["edit-expense"])) ? $remainingAllowance : intval($editExpense->amount) + $remainingAllowance; ?>"
                                placeholder="Remaining allowance: PHP <?php echo number_format($remainingAllowance); ?>"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Date</label></td>
                        <td><input value="<?php fillInput("date", $editExpense); ?>" type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: none"></td>
                        <td style="border-bottom: none">
                            <button type="SUBMIT" name="submit-expenseForm" style="margin-top: 20px; width: 100%">
                                <?php echo (isset($_GET["edit-expense"])) ? "Edit expense" : "Add expense"; ?>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/expense-addedit.js"></script>
</body>

</html>