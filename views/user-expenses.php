<?php
session_start();
require_once('../db_conn.php');
include 'entity-classes.php';
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

    .allowance-info-div {
        color: #B5E3FF;
        background-color: #124361;
        width: 100%;
        min-height: 100px;
        border-radius: 15px;
        font-size: 20px;
        padding: 10px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        padding: 0px 20px;
        border-collapse: collapse;
    }

    td {
        padding: 10px 20px;
    }
</style>

<?php
$userID = "";
$name = "";
$role = "";
$allowanceID = "";
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
}
if (isset($_GET['id'])) {
    $allowanceID = $_GET['id'];
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
} else {
    header('location:user-allowances.php');
}
$category = ($currentAllowance->category == "date") ? $currentAllowance->date : $currentAllowance->category;

$sql = "SELECT * FROM expenses WHERE `allowanceID` = '$currentAllowance->allowanceID'";
$result = $conn->query($sql);
$totalExpenses = 0;

if ($result->num_rows > 0) {
    while ($r = $result->fetch_assoc()) {
        $totalExpenses += intval($r['amount']);
    }
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
            <?php echo $name ?>
        </div>
        <div class="allowance-info-div">
            <table style="font-size: 15px">
                <tr style="font-weight: bold; font-size: 20px">
                    <td>
                        <?php echo $currentAllowance->name; ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format(intval($currentAllowance->amount)); ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format(intval($totalExpenses)); ?>
                    </td>
                    <td>
                        <?php echo $category; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $currentAllowance->description; ?>
                    </td>
                    <td>Allowance amount</td>
                    <td>Total expenses</td>
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
                <div class="">
                    <button onclick="window.location='expense-addedit.php'">
                        New Expense
                    </button>
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
                                class="row-div listtile-div hover-trigger tile-click" 
                                style="cursor: pointer"
                                data-name="' . $newExpense->name . '"
                                data-remarks="' . $newExpense->remarks . '"
                                data-amount="' . $newExpense->amount . '"
                                data-date="' . $newExpense->date . '"
                            >
                                <div class="row-div" style="width: 50%; justify-content: start">
                                    <h1 class="secondary-text" style="font-size: 16px; margin-left: 20px">' . $newExpense->name . '</h1>
                                    <div class="expenses-count-div"> 0 itemss</div>
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
        <div class="info-div hide" style="margin-top: 10px">
            <div class="row-div" style="justify-content: space-between">
                <h1 class="secondary-text" style="font-size: 18px; margin-right: 10px">Expense info</h1>
                <img src="../public/images/icon-edit.png" style="cursor: pointer">
            </div>
            <h1 class="info-name secondary-text" style="margin-top: 25px; font-size: 23px">Expense name</h1>
            <h1 class="info-remarks tertiary-text" style="font-size: 14px; margin-top: 10px">This expense was used for house rent</h1>
            <h1 class="info-amount tertiary-text" style="font-size: 14px; margin-top: 10px;">PHP 5,000</h1>
            <h1 class="info-date tertiary-text" style="font-size: 14px; margin-top: 10px;">Dec 18, 2023</h1>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/user-expenses.js"></script>
</body>

</html>