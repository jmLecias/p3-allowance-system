<?php
require_once('../db_conn.php');
include 'user-allowance-listtile.php'
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
    <div class="header-div">
        <div onclick="handleClick()" class="row-div" style="cursor: pointer">
            <img src="../public/images/ellipse-2.png" style="position: absolute">
            <img src="../public/images/ellipse-1.png" style="margin-left: 15px">
            <h1 class="logo-text">Money minder</h1>
        </div>
        <div class="row-div" style="cursor: pointer">
            <h1 class="logo-text" style="font-size: 14px; margin-right: 10px">Logout</h1>
            <img stye="position: absolute" src="../public/images/icon-account-logout.png">
        </div>
    </div>
    <div class="body-div">
        <div class="body-top-div primary-text">
            User
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
                $allowances_sample = array(
                    new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    new Allowance(1, 2, 5000.55, "House rent allowance", "This is only for food", "nd", "per month"),
                    new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                    new Allowance(1, 2, 1500.45, "Food allowance", "This is only for food", "nd", "per day"),
                    new Allowance(1, 2, 150.00, "Food allowance", "This is only for food", "nd", "per day"),
                );

                foreach ($allowances_sample as $allowance) {
                    echo displayAllowance($allowance, 5, false);
                }
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
</body>

</html>