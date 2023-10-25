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
$userID = "";
$name = "";
$role = "";
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
}
$currentAllowance = null;
$allowanceID = "";
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
                $r['category']
            );
        }
    }
}

function selectCategory($category, $currentAllowance)
{
    if ($currentAllowance !== null) {
        if ($currentAllowance->category === $category) {
            echo "selected";
        } else {
            echo "";
        }
    }
}

function fillInput($inputName, $currentAllowance)
{
    if ($currentAllowance !== null) {
        switch ($inputName) {
            case "name":
                echo $currentAllowance->name;
                break;
            case "description":
                echo $currentAllowance->description;
                break;
            case "amount":
                echo $currentAllowance->amount;
                break;
            case "date":
                echo date('Y-m-d', strtotime($currentAllowance->date));
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
if (isset($_POST['newAllowance'])) {
    $currentAllowanceID = $_POST['allowanceID'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $formDate = $_POST['date'];
    $date = date("Y-m-d", strtotime($formDate));

    if (!empty($currentAllowanceID)) {
        $editSql = "UPDATE allowances SET 
                `name` = '$name', 
                `description` = '$desc',
                `amount` = '$amount', 
                `category` = '$category', 
                `date` = '$date'
            WHERE `allowanceID` = '$currentAllowanceID'";

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
            echo ($currentAllowance === null) ? "Add new allowance" : "Edit allowance";
            ?>
        </div>
        <div class="form-div secondary-text" style="font-size: 18px">
            <form action="allowance-addedit.php" method="POST">
                <input type="text" name="allowanceID" value="<?php echo $allowanceID;?>" hidden>
                <table>
                    <tr>
                        <td class="narrow-td"><label>Name</label></td>
                        <td><input value="<?php fillInput("name", $currentAllowance); ?>" type="text" name="name"
                                placeholder="Enter allowance name" required></td>
                    </tr>
                    <tr>
                        <td><label>Description</label></td>
                        <td><input value="<?php fillInput("description", $currentAllowance); ?>" type="text"
                                name="description" placeholder="Enter allowance description" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Amount</label></td>
                        <td><input value="<?php fillInput("amount", $currentAllowance); ?>" type="number" name="amount"
                                min="0" placeholder="Enter allowance amount" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Category</label></td>
                        <td>
                            <select class="category-change" name="category" required>
                                <option value="per day" <?php selectCategory("per day", $currentAllowance); ?>>
                                    per day
                                </option>
                                <option value="per week" <?php selectCategory("per week", $currentAllowance); ?>>
                                    per week
                                </option>
                                <option value="per month" <?php selectCategory("per month", $currentAllowance); ?>>
                                    per month
                                </option>
                                <option value="date" <?php selectCategory("date", $currentAllowance); ?>>
                                    specific date
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr class="specific-date" style="display:none">
                        <td><label>Date</label></td>
                        <td><input value="<?php fillInput("date", $currentAllowance); ?>" type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: none"></td>
                        <td style="border-bottom: none">
                            <button type="SUBMIT" name="newAllowance" style="width: 100%; margin-top: 20px">
                                <?php echo ($currentAllowance === null) ? "Add allowance" : "Edit allowance"; ?>
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