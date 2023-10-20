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
    <title>Allowance Page</title>
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
        } else {
            header('location:admin-userlist.php');
        }
    } else {
        header('location:admin-userlist.php');
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
            <?php echo $currentUser->firstname.' '.$currentUser->lastname;?>
        </div>
        <div class="list-div">
            <div class="list-header-div">
                <div class="row-div" style="cursor: pointer">
                    <h1 class="secondary-text" style="margin-right: 20px">Allowance list</h1>
                    <img stye="position: absolute" src="../public/images/icon-filter.png">
                </div>
                <div>
                    <button>
                        New allowance
                    </button>
                </div>
            </div>
            <div class="list-body-div">
                <?php
                $sql = "SELECT * FROM allowances WHERE `userID` ='$userID'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($r = $result->fetch_assoc()) {
                        $newAllowance = new Allowance(
                            $r['allowanceID'],
                            $r['userID'],
                            $r['amount'],
                            $r['title'],
                            $r['description'],
                            $r['date'],
                            $r['category']
                        );

                        $sql = "SELECT * FROM expenses WHERE `allowanceID` = '$newAllowance->allowanceID'";
                        $expensesCount = $conn->query($sql)->num_rows;

                        // List Tile Div
                        echo '
                            <div class="row-div listtile-div hover-trigger" style="cursor: pointer">
                                <div class="row-div" style="width: 50%; justify-content: start">
                                    <h1 class="secondary-text" style="font-size: 16px; margin-left: 20px">'.$newAllowance->title.'</h1>
                                    <div class="expenses-count-div">'.$expensesCount.' expenses</div>
                                </div>
                                <div class="row-div" style="width: 40%; justify-content: end">
                                    <h1 class="secondary-text" style="font-size: 15px;  margin-right: 20px">PHP '.$newAllowance->amount.'</h1>
                                    <h1 class="secondary-text" style="font-size: 12px;  margin-right: 20px">'.$newAllowance->category.'</h1>
                                    <div class="expenses-info" style="display:none">
                                        <button style="border-radius: 13px; font-size:12px; padding: 6px 10px; margin-right: 20px">Expenses info</button>
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
        <div class="info-div" style="margin-top: 10px">
            <div class="row-div" style="justify-content: space-between">
                <h1 class="secondary-text" style="margin-right: 10px">Allowance info</h1>
                <img stye="position: absolute" src="../public/images/icon-settings.png">
            </div>
            <h1 class="italic-text" style="margin-top: 30px"> House rent allowance</h1>
            <h1 class="italic-text" style="font-weight: lighter">This allowance is only for monthly rent.</h1>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/user-allowance.js"></script>
</body>

</html>