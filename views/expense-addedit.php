<?php
require_once('../db_conn.php');
include 'entity-classes.php';
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
</style>

<?php
$currentAllowance = null;
$currentExpense = null;
$currentAllowanceID = "";
$expenseID = "";
if (isset($_GET['id'])) {
    $expenseID = $_GET['id'];

    $sql = "SELECT * FROM expenses WHERE `expenseID` ='$expenseID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            $currentExpense = new Expense(
                $r['expenseID'],
                $r['allowanceID'],
                $r['amount'],
                $r['name'],
                $r['remarks'],
                $r['date'],
            );
        }
        $currentAllowanceID = $currentExpense->allowanceID;
    }
}
if (isset($_GET['allowanceID'])) {
    $currentAllowanceID = $_GET['allowanceID'];
}

if ($currentExpense !== null) {
    $allowanceID = $currentExpense->allowanceID;
    $sql = "SELECT * FROM allowances WHERE `allowanceID` ='$allowanceID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            $currentAllowance = new Allowance(
                $r['allowanceID'],
                $r['userID'],
                $r['amount'],
                $r['name'],
                $r['description'],
                $r['date'],
                $r['category'],
            );
        }
    }
}

function fillInput($inputName, $currentExpense)
{
    if ($currentExpense !== null) {
        switch ($inputName) {
            case "name":
                echo $currentExpense->name;
                break;
            case "remarks":
                echo $currentExpense->remarks;
                break;
            case "amount":
                echo $currentExpense->amount;
                break;
            case "date":
                echo date('Y-m-d', strtotime($currentExpense->date));
                break;
            default:
        }
    } else {
        echo "";
    }
}
?>

<!-- Database code -->
<?php
if (isset($_POST['newExpense'])) {
    $currentExpenseID = $_POST['expenseID'];
    $currentAllowanceID = $_POST['allowanceID'];
    $amount = $_POST['amount'];
    $name = $_POST['name'];
    $remarks = $_POST['remarks'];
    $formDate = $_POST['date'];
    $date = date("M d, Y", strtotime($formDate));

    if (!empty($currentExpenseID)) {
        $editSql = "UPDATE expenses SET 
                `name` = '$name', 
                `remarks` = '$remarks',
                `amount` = '$amount', 
                `date` = '$date'
            WHERE `expenseID` = '$currentExpenseID'";

        if ($conn->query($editSql) === TRUE) {
            header('location:user-expenses.php?id='.$currentAllowanceID);
        } else {
            echo '<script>alert("Error: ' . $editSql . ' ' . $conn->error . '");</script>';
        }
    } else {
        $addSql = "INSERT INTO expenses (`allowanceID`, `amount`, `name`, `remarks`, `date`)
                VALUES ('$currentAllowanceID', '$amount', '$name', '$remarks', '$date')";

        if ($conn->query($addSql) === TRUE) {
            header('location:user-expenses.php?id='.$currentAllowanceID);
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
        <div onclick="handleClick()" class="row-div" style="cursor: pointer; padding: 20px">
            <img src="../public/images/ellipse-2.png" style="position: absolute">
            <img src="../public/images/ellipse-1.png" style="margin-left: 15px">
            <h1 class="logo-text">Money minder</h1>
        </div>
        <div class="row-div" style="cursor: pointer">
            <img stye="padding-right: 20px" src="../public/images/icon-user.png">
        </div>
    </div>

    <!-- Content Area -->
    <div class="body-div">
        <div class="body-top-div primary-text">
            <?php 
            echo ($currentExpense !== null) ? "Edit expense item" : "Add new expense item";
            ?>
        </div>
        <div class="form-div secondary-text" style="font-size: 18px">
            <form action="expense-addedit.php" method="POST">
                <input type="text" name="expenseID" value="<?php echo $expenseID;?>" hidden>
                <input type="text" name="allowanceID" value="<?php echo $currentAllowanceID;?>" hidden>
                <table>
                    <tr>
                        <td class="narrow-td"><label>Name</label></td>
                        <td><input value="<?php fillInput("name", $currentExpense); ?>" type="text" name="name"
                                placeholder="Enter expense name" required></td>
                    </tr>
                    <tr>
                        <td><label>Remarks</label></td>
                        <td><input value="<?php fillInput("remarks", $currentExpense); ?>" type="text" name="remarks"
                                placeholder="Enter expense description" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Amount</label></td>
                        <td><input value="<?php fillInput("amount", $currentExpense); ?>" type="number" name="amount"
                                min="0" placeholder="Enter expense amount" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Date</label></td>
                        <td><input value="<?php fillInput("date", $currentExpense); ?>" type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: none"></td>
                        <td style="border-bottom: none">
                            <button type="SUBMIT" name="newExpense" style="width: 100%; margin-top: 20px">
                                <?php echo ($currentExpense === null) ? "Add allowance" : "Edit allowance"; ?>
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