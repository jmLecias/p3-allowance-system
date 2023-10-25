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
    <title>Allowance Page</title>
</head>

<!-- Allowance - List Styles -->
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
</style>

<!-- Fetches Session Data about User -->
<?php
$userID = "";
$name = "";
$role = "";
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
}
?>

<!-- Body of the page -->
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
        <!-- Body Top -->
        <div class="body-top-div primary-text">
            <?php echo $name; ?>
        </div>
        <!-- Allowance List Div-->
        <div class="list-div">
            <!-- Header -->
            <div class="list-header-div">
                <div class="row-div" style="cursor: pointer">
                    <h1 class="secondary-text" style="margin-right: 20px">Allowance list</h1>
                    <img src="../public/images/icon-filter.png">
                </div>
                <div class="">
                    <button onclick="window.location='allowance-addedit.php'">
                        New allowance
                    </button>
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

                        $sql = "SELECT * FROM expenses WHERE `allowanceID` = '$newAllowance->allowanceID'";
                        $expensesCount = $conn->query($sql)->num_rows;

                        $category = ($newAllowance->category == "date") ? $newAllowance->date : $newAllowance->category;
                        // $totalExpenses = 0;

                        // $sql = "SELECT * FROM expenses WHERE `allowanceID` = '$newAllowance->allowanceID'";
                        // $result = $conn->query($sql);
                        // if ($result->num_rows > 0) {
                        //     while ($r = $result->fetch_assoc()) {
                        //         $totalExpenses += intval($r['amount']);
                        //     }
                        // }

                        // List Tile Div
                        echo '
                        <div 
                            class="row-div listtile-div tile-click" 
                            style="cursor: pointer"
                            data-id="'.$newAllowance->allowanceID.'"
                            data-name="' . $newAllowance->name . '"
                            data-desc="' . $newAllowance->description . '"
                            data-amount ="' . $newAllowance->amount . '"
                            data-category ="' . $category . '"
                            data-expenses="' . $expensesCount . '"
                        >
                            <div class="row-div" style="width: 40%; justify-content: start">
                                <h1 class="secondary-text" style="font-size: 16px; margin-left: 20px">' . $newAllowance->name . '</h1>
                                <div class="expenses-count-div">' . $expensesCount . ' expenses</div>
                            </div>
                            <div class="row-div" style="width: 50%; justify-content: end">
                                <h1 class="secondary-text" style="font-size: 15px;  margin-right: 20px">PHP ' . number_format(intval($newAllowance->amount)) . '</h1>
                                <h1 class="secondary-text" style="font-size: 12px;  margin-right: 20px">' . $category . '</h1>
                                <div class="expenses-info hide">
                                    <a href="user-expenses.php?id=' . $newAllowance->allowanceID . '"> 
                                        <button style="border-radius: 13px; font-size:12px; padding: 6px 10px; margin-right: 20px">Expenses info</button>
                                    </a>    
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
            <div class="row-div" style="justify-content: space-between">
                <h1 class="secondary-text" style="font-size: 18px; margin-right: 10px">Allowance info</h1>
                <img class="edit-allowance-btn" data-id="" src="../public/images/icon-edit.png" style="cursor: pointer">
            </div>
            <h1 class="info-name secondary-text" style="margin-top: 25px; font-size: 23px">Allowance name</h1>
            <h1 class="info-desc tertiary-text" style="font-size: 14px; margin-top: 10px">This is the allowance description.</h1>
            <h1 class="info-amount-category tertiary-text" style="font-size: 14px; margin-top: 10px;">PHP 5,000 - per day</h1>
            <h1 class="info-total-expenses tertiary-text" style="font-size: 14px; margin-top: 10px;">PHP 5,000 - total expenses</h1>
            <h1 class="info-expenses tertiary-text" style="font-size: 14px; margin-top: 10px;">3 - expense items</h1>
            <button style="width: 80%; margin-top:30px; background-color: #f25a2c">Delete</button>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/user-allowances.js"></script>
</body>

</html>