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
            echo (false) ? "Edit expense item" : "Add new expense item";
            ?>
        </div>
        <div class="form-div secondary-text" style="font-size: 18px">
            <form action="expense-addedit.php" method="POST">
                <table>
                    <tr>
                        <td class="narrow-td"><label>Name</label></td>
                        <td><input type="text" name="name" placeholder="Enter expense name" required></td>
                    </tr>
                    <tr>
                        <td><label>Remarks</label></td>
                        <td><input type="text" name="remarks" placeholder="Enter expense description" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Amount</label></td>
                        <td><input type="number" name="amount" min="0" placeholder="Enter expense amount" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Date</label></td>
                        <td><input type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: none"></td>
                        <td style="border-bottom: none">
                            <button type="SUBMIT" name="newExpense" style="width: 100%; margin-top: 20px">Add
                                allowance</button>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['newExpense'])) {
        $amount = $_POST['amount'];
        $name = $_POST['name'];
        $remarks = $_POST['remarks'];
        $date = date("M d, Y", strtotime($formDate));

        $sql = "INSERT INTO expenses (`allowanceID`, `amount`, `name`, `remarks`, `date`)
            VALUES ('2', '$amount', '$name', '$remarks', '$date')";

        if ($conn->query($sql) === TRUE) {
            header('location:user-allowances.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/expense-addedit.js"></script>
</body>

</html>