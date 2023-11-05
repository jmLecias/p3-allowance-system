<?php
session_start();
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
    <title>Expenses Page</title>
</head>

<style>
    .list-div {
        width: 67%;
        margin-bottom: 30px;
        min-height: 400px;
        float: left;
    }

    .list-header-div {
        display: flex;
        width: 100%;
        min-height: 60px;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
        color: #B5E3FF;
    }

    .list-body-div {
        width: 100%;
        color: #B5E3FF;
    }

    .listtile-div {
        justify-content: space-between;
        width: 100%;
        min-height: 55px;
        background-color: #124361;
        margin-bottom: 6px;
        color: #B5E3FF;
        border-radius: 10px;
    }

    .listtile-div:hover {
        outline: 2px #fdac5b solid;
        color: #F99B3C;
    }

    .selected {
        outline: 2px #fdac5b solid;
        color: #F99B3C;
    }

    .expenses-count-div {
        margin-bottom: 5px;
        border-radius: 3px;
        border: 1px solid;
        padding: 3px 5px;
        font-size: 10px;
        margin-left: 20px
    }

    .info-div {
        width: 30%;
        min-height: 400px;
        float: right;
        color: #B5E3FF;
    }

    .edit-expense-btn {
        font-size: 14px;
        border-radius: 5px;
        width: 55%;
        margin-top: 30px;
        background-color: #de8b39;
    }

    .delete-dialog {
        position: absolute;
        transform: translate(190px, 50px);
    }

    table {
        width: 100%;
        padding: 0px 20px;
        border-collapse: collapse;
    }

    td {
        padding: 10px 20px;
    }


    .allowance-info-div {
        color: #B5E3FF;
        background-color: #124361;
        width: 100%;
        min-height: 100px;
        border-radius: 15px;
        font-size: 20px;
        padding: 10px;
        margin-bottom: 20px;
        box-shadow: 0px 4px 3px 0px rgba(0, 0, 0, 0.25);
        cursor: pointer;
    }
</style>

<?php

// Major variable/information needed
$name = "";
$role = "";
$allowanceID = "";

// Check if admin access or not
if (isset($_GET['admin-access']) && $_GET['admin-access'] != "") {
    $name = $_GET['admin-access'];
    $role = "admin";
    $allowanceID = $_GET['allowanceID'];
} else {
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    $allowanceID = $_GET['allowanceID'];
}

// Getting allowance info and stor inside displayAllowance Object
$displayAllowance = null;
$sql = "SELECT * FROM allowances WHERE `allowanceID` ='$allowanceID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($r = $result->fetch_assoc()) {
        $displayAllowance = new Allowance(
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

// To display the  actual date if category = date
$category = ($displayAllowance->category == "date") ? $displayAllowance->date : $displayAllowance->category;

// Getting the sum of all expenses in the current allowance
$totalExpenses = 0;
$sql = "SELECT * FROM expenses WHERE `allowanceID` = '$allowanceID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($r = $result->fetch_assoc()) {
        $totalExpenses += intval($r['amount']);
    }
}

// Calculating the remaining allowance
$remainingAllowance = intval($displayAllowance->amount) - intval($totalExpenses);

// Deleting an allowance item
if (isset($_POST['submit_delete'])) {
    $expenseID = $_POST['expenseID'];

    $sql = "DELETE FROM expenses WHERE `expenseID` = '$expenseID'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo '<script>alert("Error: ' . $sql . ' ' . $conn->error . '");</script>';
    }
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
            <?php echo $name ?>
        </div>
        <!-- Allowance Detailed Info box -->
        <div class="allowance-info-div" onclick="<?php goToFirstPage($role)?>">
            <table style="font-size: 15px">
                <tr style="font-weight: bold; font-size: 20px">
                    <td class="text-container">
                        <?php echo $displayAllowance->name; ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format(intval($displayAllowance->amount)); ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format($totalExpenses); ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format($remainingAllowance); ?>
                    </td>
                    <td>
                        <?php echo $category; ?>
                    </td>
                </tr>
                <tr style="font-weight: normal; font-size: 14px">
                    <td><?php echo $displayAllowance->description; ?></td>
                    <td>Allowance amount</td>
                    <td>Total expenses</td>
                    <td>Remaining amount</td>
                    <td>Category</td>
                </tr>
            </table>
        </div>
        <div class="list-div">
            <div class="list-header-div">
                <div class="row-div" style="cursor: pointer">
                    <h1 class="secondary-text" style="margin-right: 20px">Expenses list</h1>
                    <img stye="position: absolute" src="../public/images/icon-filter.png">
                </div>
                <div class="<?php isAdmin($role)?>">
                    <form action="expense-addedit.php" method="POST">
                        <input type="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                        <input type="hidden" name="remainingAllowance" value="<?php echo $remainingAllowance; ?>">
                        <button type="SUBMIT" name="add-expense">New Expense</button>
                    </form>
                </div>
            </div>
            <div class="list-body-div">
                <?php
                $sql = "SELECT * FROM expenses WHERE `allowanceID` ='$allowanceID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($r = $result->fetch_assoc()) {
                        $newExpense = new Expense(
                            $r['expenseID'],
                            $r['allowanceID'],
                            $r['amount'],
                            $r['name'],
                            $r['remarks'],
                            $r['date'],
                        );

                        // List Tile Div
                        echo '
                            <div 
                                class="row-div listtile-div hover-trigger tile-click expense' . $newExpense->expenseID . '" 
                                style="cursor: pointer"
                                data-id="' . $newExpense->expenseID . '"
                                data-name="' . $newExpense->name . '"
                                data-remarks="' . $newExpense->remarks . '"
                                data-amount="' . $newExpense->amount . '"
                                data-date="' . $newExpense->date . '"
                            >
                                <div class="row-div" style="width: 50%; justify-content: start">
                                    <h1 class="secondary-text" style="font-size: 16px; margin-left: 20px">' . $newExpense->name . '</h1>
                                </div>
                                <div class="row-div" style="width: 40%; justify-content: end">
                                    <h1 class="secondary-text" style="font-size: 15px;  margin-right: 20px">PHP ' . number_format(intval($newExpense->amount)) . '</h1>
                                    <h1 class="secondary-text" style="font-size: 12px;  margin-right: 20px">' . $newExpense->date . '</h1>
                                </div>
                            </div>
                        ';
                    }
                } else {
                    echo "No Results";
                }
                $conn->close();
                ?>
            </div>
        </div>
        <!-- Expense info div -->
        <div class="info-div hide" style="margin-top: 10px">
            <!-- Allowance info header and Delete button -->
            <div class="row-div" style="justify-content: space-between">
                <h1 class="secondary-text">Expense info</h1>
                <div class="<?php isAdmin($role)?>">
                    <img class="delete-expense-btn" src="../public/images/icon-trash.png" style="cursor: pointer">
                </div>
                <!-- Delete dialog div -->
                <div class="delete-dialog hide">
                    <h6 class="tertiary-text">Delete this expense?</h6>
                    <div class="row-div" style="justify-content: end">
                        <div class="dialog-btn" data-val="yes">Yes</div>
                        <div class="dialog-btn" data-val="no">No</div>
                    </div>
                </div>
            </div>

            <!-- Expense name -->
            <h6 class="info-name primary-text" style="margin-top: 25px">Expense name</h6>
            <!-- Expense details -->
            <div style="color: #447FA4;">
                <!-- Expense remarks -->
                <div class="row-div" style="margin-top: 30px">
                    <img src="../public/images/icon-info-circle.png" style="margin-right: 10px">
                    <h6 class="info-remarks tertiary-text">This is the allowance description.</h6>
                </div>
                <!-- Expense amount -->
                <div class="row-div" style="margin-top: 10px">
                    <img src="../public/images/icon-wallet.png" style="margin-right: 12px">
                    <h6 class="info-amount tertiary-text">PHP 3,000</h6>
                </div>
                <!-- Expense date -->
                <div class="row-div" style="margin-top: 10px;">
                    <img src="../public/images/icon-calendar.png" style="margin-right: 12px">
                    <h6 class="info-date tertiary-text">Dec 18, 2023</h6>
                </div>
            </div>
            <div class="<?php isAdmin($role)?>">
                <form action="expense-addedit.php" method="GET">
                    <input class="edit-pass" type="hidden" name="expenseID">
                    <input type="hidden" name="remainingAllowance" value="<?php echo $remainingAllowance; ?>">
                    <button type="SUBMIT" name="edit-expense" class="edit-expense-btn">Edit expense</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/user-expenses.js"></script>
</body>

</html>