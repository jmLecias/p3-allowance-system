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

// If user pressed Edit allowance button
$allowanceID = "";
$editAllowance = null;
if(isset($_GET["edit-allowance"])) {
    $allowanceID = $_GET['allowanceID'];

    // Get allowance info on database and store inside the editAllowance Object
    $sql = "SELECT * FROM allowances WHERE `allowanceID` ='$allowanceID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            $editAllowance = new Allowance(
                $r['allowanceID'],
                $r['userID'],
                $r['amount'],
                $r['name'],
                $r['description'],
                $r['date'],
                $r['category']
            );
        }
    }
}

// If user pressed Add allowance button
$userID = "";
if(isset($_POST["add-allowance"])) {
    $userID = $_POST["userID"];
}

// Function for selecting category when Editing Allowance
function selectCategory($category, $allowanceObj)
{
    if ($allowanceObj !== null) {
        if ($allowanceObj->category === $category) {
            echo "selected";
        } else {
            echo "";
        }
    }
}

// Function for filling form when Editing Allowance
function fillInput($inputName, $allowanceObj)
{
    if ($allowanceObj !== null) {
        switch ($inputName) {
            case "name":
                echo $allowanceObj->name;
                break;
            case "description":
                echo $allowanceObj->description;
                break;
            case "amount":
                echo $allowanceObj->amount;
                break;
            case "date":
                echo date('Y-m-d', strtotime($allowanceObj->date));
                break;
            default:
        }
    } else {
        echo "";
    }
}
?>

<!-- Database code Add / Edit Allowance-->
<?php
if (isset($_POST['submit-allowanceForm'])) {
    // to determine if user is editing or adding
    $editAllowanceID = $_POST['allowanceID'];
    $userID = $_POST['userID'];

    // form inputs
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $formDate = $_POST['date'];
    $date = date("M d, Y", strtotime($formDate));

    if (!empty($editAllowanceID)) {
        $editSql = "UPDATE allowances SET 
                `name` = '$name', 
                `description` = '$desc',
                `amount` = '$amount', 
                `category` = '$category', 
                `date` = '$date'
            WHERE `allowanceID` = '$editAllowanceID'";

        if ($conn->query($editSql) === TRUE) {
            header('location:user-allowances.php');
        } else {
            echo '<script>alert("Error: ' . $editSql . ' ' . $conn->error . '");</script>';
        }
    } else {
        $addSql = "INSERT INTO allowances (`userID`, `amount`, `name`, `description`, `date`, `category`)
            VALUES ('$userID', '$amount', '$name', '$desc', '$date', '$category')";

        if ($conn->query($addSql) === TRUE) {
            header('location:user-allowances.php');
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
            <?php echo (isset($_GET["edit-allowance"])) ? "Edit allowance" : "Add new allowance"; ?>
        </div>
        <a href="user-allowances.php" class="terriary-text back-button">Back</a>
        <br><br>
        <div class="form-div secondary-text" style="font-size: 18px">
            <form action="allowance-addedit.php" method="POST">
                <input type="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                <table>
                    <tr>
                        <td class="narrow-td"><label>Name</label></td>
                        <td><input value="<?php fillInput("name", $editAllowance); ?>" type="text" name="name"
                                placeholder="Enter allowance name" required></td>
                    </tr>
                    <tr>
                        <td><label>Description</label></td>
                        <td><input value="<?php fillInput("description", $editAllowance); ?>" type="text"
                                name="description" placeholder="Enter allowance description" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Amount</label></td>
                        <td><input value="<?php fillInput("amount", $editAllowance); ?>" type="number" name="amount"
                                min="0" placeholder="Enter allowance amount" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Category</label></td>
                        <td>
                            <select class="category-change" name="category" required>
                                <option value="per day" <?php selectCategory("per day", $editAllowance); ?>>
                                    per day
                                </option>
                                <option value="per week" <?php selectCategory("per week", $editAllowance); ?>>
                                    per week
                                </option>
                                <option value="per month" <?php selectCategory("per month", $editAllowance); ?>>
                                    per month
                                </option>
                                <option value="date" <?php selectCategory("date", $editAllowance); ?>>
                                    specific date
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr class="specific-date" style="display:none">
                        <td><label>Date</label></td>
                        <td><input value="<?php fillInput("date", $editAllowance); ?>" type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: none"></td>
                        <td style="border-bottom: none">
                            <button type="SUBMIT" name="submit-allowanceForm"  style="margin-top: 20px; width: 100%">
                                <?php echo (isset($_GET["edit-allowance"])) ? "Edit allowance" : "Add allowance"; ?>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/allowance-addedit.js"></script>
</body>

</html>