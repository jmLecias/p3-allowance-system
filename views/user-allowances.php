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
    <title>Allowance Page</title>
</head>

<!-- Allowance - List Styles -->
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
        box-shadow: 0px 4px 3px 0px rgba(0, 0, 0, 0.25);
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
        margin-left: 20px;
        white-space: nowrap;
    }

    .info-div {
        width: 30%;
        min-height: 400px;
        float: right;
        color: #B5E3FF;
    }

    .edit-allowance-btn {
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
        margin-top: 40px;
        box-shadow: 0px 4px 3px 0px rgba(0, 0, 0, 0.25);
    }
</style>

<?php
// Major variable/information needed
$userID = "";
$name = "";
$role = "";

// Check if admin access or not
if (isset($_GET['admin-access'])) {
    $userID = $_GET['userID'];
    $name = $_GET['admin-access'];
    $role = "admin";
    //get user info in db
} else {
    $userID = $_SESSION['userID'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
}

// Checks if the current user is Admin
$adminAccess = ($role == "admin") ? $name : "";

// Check if user wants to log out
if (isset($_POST['logout_press'])) {
    session_unset();
    session_destroy();
    exit();
}

// Deleting an allowance item
if (isset($_POST['submit_delete'])) {
    $allowanceID = $_POST['allowanceID'];

    $sql = "DELETE FROM allowances WHERE `allowanceID` = '$allowanceID'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo '<script>alert("Error: ' . $sql . ' ' . $conn->error . '");</script>';
    }
}

// Getting the sum of all allowances of user
$totalAllowances = 0;
$sql = "SELECT * FROM allowances WHERE `userID` ='$userID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($r = $result->fetch_assoc()) {
        $totalAllowances += intval($r["amount"]);
    }
}

// Getting the sum of all expenses of user

$totalExpenses = 0;
$sql = "SELECT * FROM allowances WHERE `userID` ='$userID'";
$result_allowances = $conn->query($sql);

if ($result_allowances->num_rows > 0) {
    while ($row_allowances = $result_allowances->fetch_assoc()) {
        $allowanceID = $row_allowances["allowanceID"];

        $sql = "SELECT * FROM expenses WHERE `allowanceID` = $allowanceID";
        $result_expenses = $conn->query($sql);

        if ($result_expenses->num_rows > 0) {
            while ($row_expenses = $result_expenses->fetch_assoc()) {
                $totalExpenses += intval($row_expenses["amount"]);
            }
        }
    }
}

// Calculating the remaining allowance
$remainingAllowance = intval($totalAllowances) - intval($totalExpenses);

?>

<!-- Body of the page -->

<body>
    <!-- Header / Logo Div -->
    <div class="header-div">
        <div onclick="<?php goToFirstPage($role) ?>" class="row-div" style="cursor: pointer; padding: 20px">
            <img src="../public/images/logo-1.png" style="position:absolute">
            <h1 class="logo-text" style="margin-left: 80px">Money minder</h1>
        </div>
        <!-- Logout Button -->
        <div class="row-div logout-press" style="cursor: pointer; color: #B5E3FF;">
            <h6 class="tertiary-text" style="margin-right: 10px; font-size: 15px; font-weight: bold;">LOGOUT</h6>
            <img style="margin-right: 20px" src="../public/images/icon-alternate-sign-out.png">
        </div>
    </div>

    <!-- Content Area -->
    <div class="body-div">
        <!-- Allowance Detailed Info box -->
        <div class="allowance-info-div">
            <table style="font-size: 15px">
                <tr style="font-weight: bold; font-size: 20px">
                    <td class="text-container" style="font-size: 28px">
                        <?php echo $name; ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format($totalAllowances) ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format($totalExpenses) ?>
                    </td>
                    <td>
                        <?php echo "PHP " . number_format($remainingAllowance) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $role; ?>
                    </td>
                    <td>Total allowances</td>
                    <td>All expenses</td>
                    <td>Remaining amount</td>
                </tr>
            </table>
        </div>
        <!-- Allowance List Div-->
        <div class="list-div">
            <!-- Header -->
            <div class="list-header-div">
                <div class="row-div" style="cursor: pointer">
                    <h1 class="secondary-text" style="margin-right: 20px">Allowance list</h1>
                    <img src="../public/images/icon-filter.png">
                </div>
                <div class="<?php isAdmin($role); ?>">
                    <form action="allowance-addedit.php" method="POST">
                        <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                        <button type="SUBMIT" name="add-allowance">New allowance</button>
                    </form>
                </div>
            </div>
            <!-- Display List Tiles -->
            <div class="list-body-div list-click">
                <?php
                $sql = "SELECT * FROM allowances WHERE `userID` ='$userID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($r = $result->fetch_assoc()) {
                        $newAllowance = new Allowance(
                            $r['allowanceID'],
                            $r['userID'],
                            $r['amount'],
                            $r['name'],
                            $r['description'],
                            $r['date'],
                            $r['category']
                        );

                        $totalAllowanceExpenses = 0;
                        $sql = "SELECT * FROM expenses WHERE `allowanceID` = '$newAllowance->allowanceID'";
                        $result_expenses = $conn->query($sql);
                
                        if ($result_expenses->num_rows > 0) {
                            while ($row_expenses = $result_expenses->fetch_assoc()) {
                                $totalAllowanceExpenses += intval($row_expenses["amount"]);
                            }
                        }

                        $sql = "SELECT * FROM expenses WHERE `allowanceID` = '$newAllowance->allowanceID'";
                        $expensesCount = $conn->query($sql)->num_rows;

                        $category = ($newAllowance->category == "date") ? $newAllowance->date : $newAllowance->category;


                        // List Tile Div
                        echo '
                        <div
                            class="row-div listtile-div tile-click allowance' . $newAllowance->allowanceID . '" 
                            style="cursor: pointer"
                            data-id="' . $newAllowance->allowanceID . '"
                            data-name="' . $newAllowance->name . '"
                            data-desc="' . $newAllowance->description . '"
                            data-amount ="' . $newAllowance->amount . '"
                            data-category ="' . $category . '"
                            data-expenses="' . $expensesCount . '"
                            data-texpenses="' . $totalAllowanceExpenses . '"
                        >
                            <div class="row-div" style="width: 40%; justify-content: start">
                                <h1 class="secondary-text text-container" style="font-size: 16px; margin-left: 20px">' . $newAllowance->name . '</h1>
                                <div class="expenses-count-div">' . $expensesCount . ' expenses</div>
                            </div>
                            <div class="row-div" style="width: 50%; justify-content: end">
                                <h1 class="secondary-text" style="font-size: 15px;  margin-right: 20px">PHP ' . number_format(intval($newAllowance->amount)) . '</h1>
                                <h1 class="secondary-text" style="font-size: 12px;  margin-right: 20px">' . $category . '</h1>
                                <div class="expenses-info hide">
                                    <form action="user-expenses.php" method="GET">
                                        <input type="hidden" name="allowanceID" value="' . $newAllowance->allowanceID . '">
                                        <input type="hidden" name="admin-access" value="' . $adminAccess . '">
                                        <button style="border-radius: 13px; font-size:12px; padding: 6px 10px; margin-right: 20px">Expenses info</button>
                                    </form> 
                                </div>
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
        <!-- Allowance Info Div -->
        <div class="info-div hide" style="margin-top: 10px">
            <!-- Allowance info header and Delete button -->
            <div class="row-div" style="justify-content: space-between">
                <h6 class="secondary-text">Allowance info</h6>
                <div class="<?php isAdmin($role) ?>">
                    <img class="delete-allowance-btn   <?php isAdmin($role) ?>" src="../public/images/icon-trash.png"
                        style="cursor: pointer">
                </div>
                <!-- Delete dialog div -->
                <div class="delete-dialog hide">
                    <h6 class="tertiary-text">Delete this allowance?</h6>
                    <div class="row-div" style="justify-content: end">
                        <div class="dialog-btn" data-val="yes">Yes</div>
                        <div class="dialog-btn" data-val="no">No</div>
                    </div>
                </div>
            </div>
            <!-- Allowance name -->
            <h6 class="info-name primary-text" style="margin-top: 25px">Allowance name</h6>
            <!-- Allowance details -->
            <div style="color: #447FA4;">
                <!-- Allowance description -->
                <div class="row-div" style="margin-top: 30px">
                    <img src="../public/images/icon-info-circle.png" style="margin-right: 10px">
                    <h6 class="info-desc tertiary-text">This is the allowance description.</h6>
                </div>
                <!-- Allowance amount and category -->
                <div class="row-div" style="margin-top: 10px;">
                    <img src="../public/images/icon-calendar.png" style="margin-right: 12px">
                    <h6 class="info-amount-category tertiary-text">PHP 5,000 _ per day</h6>
                </div>
                <!-- Allowance total expenses -->
                <div class="row-div" style="margin-top: 10px;">
                    <img src="../public/images/icon-wallet.png" style="margin-right: 12px">
                    <h6 class="info-total-expenses tertiary-text">PHP ??? _ total expenses</h6>
                </div>
                <!-- Allowance expenses count -->
                <div class="row-div" style="margin-top: 10px;">
                    <img src="../public/images/icon-shopping-cart.png" style="margin-right: 12px">
                    <h6 class="info-expenses tertiary-text">3 _ expense items</h6>
                </div>
            </div>
            <div class="<?php isAdmin($role) ?>">
                <form action="allowance-addedit.php" method="GET">
                    <input class="edit-allowance-pass" type="hidden" name="allowanceID" value="">
                    <button class="edit-allowance-btn" type="SUBMIT" name="edit-allowance">Edit allowance</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/user-allowances.js"></script>
</body>

</html>