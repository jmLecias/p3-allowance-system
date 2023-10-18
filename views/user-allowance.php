<?php
require_once('../db_conn.php');
include 'user-allowance-class.php';
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Allowance Page</title>
</head>

<body>
    <!-- Header / Logo Div -->
    <div class="header-div">
        <div onclick="handleClick()" class="row-div" style="cursor: pointer; padding: 20px">
            <img src="../public/images/ellipse-2.png" style="position: absolute">
            <img src="../public/images/ellipse-1.png" style="margin-left: 15px">
            <h1 class="logo-text">Money minder</h1>
        </div>
        <div class="row-div" style="cursor: pointer">
            <img stye="position: absolute" src="../public/images/icon-account-logout.png">
        </div>
    </div>

    <!-- Content Area -->
    <div class="body-div">
        <div class="body-top-div primary-text">
            Hell0W4rld
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
                    $sql = "SELECT * FROM allowances";
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

                            echo displayAllowance($newAllowance, $expensesCount, false);
                        }
                    } else {
                        echo "No Results";
                    }
                    $conn->close();

                    // DESIGN SAMPLES
                    // $allowances_sample = array(
                    //     new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    //     new Allowance(1, 2, 5000.55, "House rent allowance", "This is only for food", "nd", "per month"),
                    //     new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    //     new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    //     new Allowance(1, 2, 1500.45, "Food allowance", "This is only for food", "nd", "per day"),
                    //     new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    // );

                    // foreach ($allowances_sample as $allowance) {
                    //     echo displayAllowance($allowance, 5, false);
                    // }
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