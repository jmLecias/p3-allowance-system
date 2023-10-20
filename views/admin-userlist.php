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
        overflow-y: auto;
        scroll-behavior: smooth;
        width: 100%;
        height: 75vh;
        border-radius: 10px;
        background: #124361;
        color: #B5E3FF;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .list-div::-webkit-scrollbar {
        width: 0px;
    }

    .sticky-div {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .list-top-div {
        position: sticky;
        top: 0;
        z-index: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        min-height: 55px;
        background: #124361;
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

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .role-form {
        background-color: #124361;
        min-height: 600px;
        min-width: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -300px;
        margin-left: -250px;
        padding: 20px;
        border-radius: 10px;
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
            <div class="sticky-div">
                <div class="list-top-div">
                    <h1 class="secondary-text">User list</h1>
                    <div class="filter-div">
                        <h1 class="secondary-text" style="margin: 0px 15px; font-size: 15px">ROLE</h1>
                        <img stye="margin-right: 15px" src="../public/images/icon-arrow-down.png">
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            echo '
                <table>
                    <tr class="sticky-div" style="top:55px">
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
                            <td style="padding-right:50px">' . $newUser->userID . '</td>
                            <td style="padding-right:100px">
                                <a href="user-allowance.php?id=' . $newUser->userID . '">'
                        . $newUser->firstname . ' ' . $newUser->lastname . '
                                </a>
                            </td>
                            <td>' . $newUser->email . ' </td>
                            <td>
                                <div class="row-div setrole-click" style="justify-content: space-between">
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
    <script type="text/javascript" language="javascript" src="../js/admin-userlist.js"></script>
</body>
<div class="outside-click overlay">
    <div class="inside-click" style="display:flex">
        <form class="role-form">
            <label class="secondary-text" style="margin: 0px 15px; font-size: 15px" for="user-role">User</label>
            <input type="radio" id="user-role" name="role" value="user">
            <label class="secondary-text" style="margin: 0px 15px; font-size: 15px" for="admin-role">Admin</label>
            <input type="radio" id="admin-role" name="role" value="admin">
            <button type="submit">Assign Role</button>
        </form>
    </div>
</div>

</html>