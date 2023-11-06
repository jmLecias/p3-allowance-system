<?php
session_start();
require_once('../db_conn.php');
include '../entity-classes.php';
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
        min-height: 300px;
        min-width: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -300px;
        margin-left: -250px;
        padding: 40px;
        border-radius: 10px;
    }

    .name-redirect {
        background: none;
        border: none;
        color: inherit;
        font-size: 18px;
        text-align: left;
        cursor: pointer;
    }

    .inside-click {
        color: #B5E3FF;
    }
</style>

<?php
// Check if user wants to log out
if (isset($_POST['logout_press'])) {
    session_unset();
    session_destroy();
    exit();
}

// Check if admin edited a user's role
if (isset($_POST['submit-userForm'])) {
    $userID = $_POST['userID'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET `role` = '$role' WHERE `userID` = '$userID'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("User role edited successfully!");</script>';
    } else {
        echo '<script>alert("Error: ' . $sql . ' ' . $conn->error . '");</script>';
    }
}
?>

<body>
    <!-- Header / Logo Div -->
    <div class="header-div">
        <div onclick="" class="row-div" style="cursor: pointer; padding: 20px">
            <img src="../public/images/logo-1.png" style="position:absolute">
            <h1 class="logo-text" style="margin-left: 80px">Money minder</h1>
        </div>
        <div class="row-div logout-press" style="cursor: pointer; color: #B5E3FF;">
            <h6 class="tertiary-text" style="margin-right: 10px; font-size: 15px; font-weight: bold;">LOGOUT</h6>
            <img style="margin-right: 20px" src="../public/images/icon-alternate-sign-out.png">
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
                        $r['password'],
                        $r['role'],
                    );

                    // UserList Table Row Div
                    echo '
                        <tr>
                            <td style="padding-right:50px">' . $newUser->userID . '</td>
                            <td style="padding-right:100px">
                                <form action="user-allowances.php" method="GET">
                                    <input type="hidden" name="userID" value="' . $newUser->userID . '">
                                    <input class="name-redirect" type="SUBMIT" name="admin-access" value="' . $newUser->firstname . ' ' . $newUser->lastname . '">
                                </form>
                            </td>   
                            <td>' . $newUser->email . ' </td>
                            <td>
                                <div 
                                    class="row-div setrole-click" 
                                    style="justify-content: space-between;"
                                    data-id="' . $newUser->userID . '"    
                                    data-name="' . $newUser->firstname." ". $newUser->lastname . '"
                                    data-email="' . $newUser->email .'"    
                                    data-role="' . $newUser->role . '"  
                                >
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
    <script type="text/javascript" language="javascript" src="../js/user-list.js"></script>
</body>
<div class="overlay outside-click">
    <div class="inside-click" style="display:flex">
        <form action="user-list.php" class="role-form" method="POST">
            <input class="user-info-id" type="hidden" name="userID" value="">
            <h6 class="primary-text">Edit user role?</h6>
            <br><br>
            <h6 class="user-info-name secondary-text">Name here</h6>
            <h6 class="user-info-email secondary-text">Email here</h6>
            <br>
            <select class="role-change" name="role" required>
                <option value="member">Member</option>
                <option value="admin">Admin</option>
            </select>
            <br>
            <br>
            <br>
            <button type="SUBMIT" name="submit-userForm">Assign new role</button>
        </form>
    </div>
</div>

</html>