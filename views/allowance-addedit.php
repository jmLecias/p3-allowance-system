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
        padding:20px;
        color: #B5E3FF;
    }

    .narrow-td {
        width: 40%;
    }
</style>

<?php
$currentUser;
if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    $sql = "SELECT * FROM users WHERE `userID` ='$userID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            $currentUser = new User(
                $r['userID'],
                $r['firstname'],
                $r['lastname'],
                $r['email'],
                $r['role'],
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
            Add new allowance
        </div>
        <div class="form-div secondary-text" style="font-size: 18px">
            <!-- CONTENT -->
            <form action="allowance-addedit.php" method="POST">
                <table>
                    <tr>
                        <td class="narrow-td"><label>Name</label></td>
                        <td><input type="text" name="name" placeholder="Enter allowance name" required></td>
                    </tr>
                    <tr>
                        <td><label>Description</label></td>
                        <td><input type="text" name="description" placeholder="Enter allowance description" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Amount</label></td>
                        <td><input type="number" name="amount" min="0" placeholder="Enter allowance amount" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Category</label></td>
                        <td>
                            <select class="category-change" name="category" required>
                                <option value="per day"> per day</option>
                                <option value="per week">per week</option>
                                <option value="per month">per month</option>
                                <option value="date">specific date</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="specific-date" style="display:none">
                        <td><label>Date</label></td>
                        <td><input type="date" name="date"></td>
                    </tr>
                    <tr>
                        <td style="border-bottom: none"></td>
                        <td style="border-bottom: none">
                            <button type="SUBMIT" name="newAllowance" style="width: 100%; margin-top: 20px">Add allowance</button>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['newAllowance'])) {
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $formDate = $_POST['date'];
        $date = date("M d, Y", strtotime($formDate));

        $sql = "INSERT INTO allowances (`userID`, `amount`, `name`, `description`, `date`, `category`)
            VALUES ('1', '$amount', '$name', '$desc', '$date', '$category')";

        if ($conn->query($sql) === TRUE) {
            header('location:user-allowance.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        //header('location:register.php');
    }
    ?>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/allowance-addedit.js"></script>
</body>

</html>