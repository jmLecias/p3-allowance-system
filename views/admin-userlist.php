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
    <title>Admin Page</title>
</head>

<style>
    table {
        width: 100%;
        padding: 0px 20px;
        border-collapse: collapse;
    }

    a {
        text-decoration: none;
        color: inherit;
        font-size: inherit;
        font-family: inherit;
    }


    th {
        background: #08344E;
        text-align: left;
        padding: 10px 20px;
    }

    td {
        padding: 10px 20px;
        border-bottom: 1px solid #08344E;
        cursor: pointer;
    }

    tr:hover {
        background: #27658B;
    }

    .list-div {
        width: 100%;
        border-radius: 10px;
        background: #124361;
        color: #B5E3FF;
        min-height: 400px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .list-top-div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
    }

    .filter-div {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        border-radius: 10px;
        background: #1D5578;
        min-width: 95px;
        height: 35px;
        padding-right: 15px;
        cursor: pointer;
    }
</style>

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
        <div class="body-top-div primary-text" style="margin-bottom: 20px">
            Admin interface
        </div>
        <div class="list-div">
            <div class="list-top-div">
                <h1 class="secondary-text">User list</h1>
                <div class="filter-div">
                    <h1 class="secondary-text" style="margin: 0px 15px; font-size: 15px">ROLE</h1>
                    <img stye="margin-right: 15px" src="../public/images/icon-arrow-down.png">
                </div>
            </div>
            <?php
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            echo '
                <table>
                    <tr>
                        <th class="id-sort">ID</th>
                        <th class="name-sort">NAME</th>
                        <th class="email-sort">EMAIL</th>
                        <th class="role-sort">ROLE</th>
                    </tr>
            ';

            if ($result->num_rows > 0) {
                while ($r = $result->fetch_assoc()) {
                    $newUser = new User(
                        $r['userID'],
                        $r['firstname'],
                        $r['lastname'],
                        $r['email'],
                        $r['role'],
                    );

                    // UserList Table Row Div
                    echo '
                        <tr>
                            <td style="padding-right:50px">'. $newUser->userID . '</td>
                            <td style="padding-right:100px">
                                <a href="user-allowance.php?id='.$newUser->userID.'">' 
                                    . $newUser->firstname . ' ' . $newUser->lastname .'
                                </a>
                            </td>
                            <td>' . $newUser->email . ' </td>
                            <td>
                                <div class="row-div" style="justify-content: space-between">
                                    <div>' . $newUser->role . '</div>
                                    <img stye="" src="../public/images/icon-edit.png">
                                </div>
                            </td>
                        </tr> 
                    ';
                }
            } else {
                echo "No Results";
            }
            echo '</table>';
            $conn->close();
            ?>
        </div>
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/user-allowance.js"></script>
</body>

</html>