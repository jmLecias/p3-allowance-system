<?php
session_unset();
session_start();
require_once('../db_conn.php');
include '../entity-classes.php';
?>

<?php
// Login authentication
if (isset($_POST['loginSubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE `email` ='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $r = $result->fetch_assoc();
        $foundUser = new User(
            $r['userID'],
            $r['firstname'],
            $r['lastname'],
            $r['email'],
            $r['password'],
            $r['role'],
        );

        // Authentication
        if ($password === $foundUser->password) {
            $_SESSION['userID'] = $foundUser->userID;
            $_SESSION['name'] = $foundUser->firstname . " " . $foundUser->lastname;
            $_SESSION['role'] = $foundUser->role;

            if ($foundUser->role === "admin") {
                header("Location:user-list.php");
            } else {
                header("Location:user-allowances.php");
            }
        } else {
            echo '<script>alert("Incorrect password");</script>';
        }

    } else {
        echo '<script>alert("Member not found, sign up or re-enter email");</script>';
    }

    $conn->close();
}
// Register to database
if (isset($_POST['registerSubmit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE `email` ='$email'";
    $result = $conn->query($sql);
    $validEmail = ($result->num_rows > 0) ? false : true;

    $sql = "INSERT INTO users (`firstname`, `lastname`, `email`, `password`, `role`)
        VALUES ('$firstname', '$lastname', '$email', '$password', 'member')";


    if ($validEmail) {
        if ($conn->query($sql) === TRUE) {
            session_unset();
            echo '<script>alert("Member registered successfully");</script>';
        } else {
            echo '<script>alert("Failed to add member");</script>';
        }
    } else {
        echo '<script>alert("Email already has an account");</script>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Index Page</title>
</head>

<style>
    .register-btn {
        margin-left: 15px;
        background-color: #dd7a18;
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
        color: #B5E3FF;
    }

    .overlay-form {
        background-color: #124361;
        height: 520px;
        width: 1080px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -260px;
        margin-left: -540px;
        border-radius: 10px;
        overflow: hidden;
    }

    .login-div {
        padding: 60px;
        align-items: center;
    }

    .footer-click {
        cursor: pointer;
        text-decoration: underline;
    }

    .show-password {
        cursor: pointer;
        position: absolute;
        left: 36%;
    }

    .title {
        color: #f99b3c;
        font-weight: 900;
        margin: 0;
        font-size: 75px;
    }

    .title1 {
        color: #B5E3FF;
        font-weight: 700;
        margin: 0;
        font-size: 30px;

    }

    .welcome {
        color: #B5E3FF;
        font-weight: 500;
        font-size: 40px;
        margin: 0;
    }

    .pcon {
        width: 500px;
        height: 500px;
        margin-top: 40px;
        text-align: justify;
        text-justify: inter-word;
        color: white;
    }

    .btn {
        width: 60px;
        height: 30px;
    }

    .body-div {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        width: 90%;
        margin: 3% 5%;
    }

    .text-content {
        text-align: left;
        max-width: 50%;
        padding: 20px;
        color: #B5E3FF;
    }

    .image {
        max-width: 50%;
        border-radius: 10px;
    }

    .button:hover {
        border: 1px solid #B5E3FF;
    }
</style>

<body>
    <!-- Header / Logo Div -->
    <div class="header-div">
        <div class="row-div" style="cursor: pointer; padding: 20px">
            <img src="../public/images/logo-1.png" style="position:absolute">
            <h1 class="logo-text" style="margin-left: 80px">Money minder</h1>
        </div>
        <div class="row-div" style="cursor: pointer">
            <button class="authenticate-click" data-action="login">LOGIN</button>
            <button class="authenticate-click register-btn" data-action="register">REGISTER</button>
        </div>
    </div>

    <!-- Content Area -->
    <div class="body-div row-div">
        <div class="text-content">
            <h3 class="welcome">Welcome to</h3>
            <h1 class="title">Money Minder</h1>
            <h6 class="title1">Your Ultimate Financial Companion</h6>
            <br><br>
            <div class="tertiary-text" style="line-height:1.6;">
                Money Minder is designed to simplify the complexities of
                financial management and empower users to take charge of their
                monetary well-being. With its array of features and user-friendly
                interface, it's an indispensable tool for individuals and businesses
                looking to achieve financial stability and reach their financial goals.
            </div>
            <br>
            <button class="getstarted-click"  data-action="register">Get started →</button>
        </div>
        <img src="../public/images/index_image.jpg" class="image">
    </div>
    <script type="text/javascript" language="javascript" src="../js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/index.js"></script>
</body>
<!-- Overlay/Forms Html -->
<div class="overlay outside-click hide">
    <div class="inside-click overlay-form row-div" style="display:flex">
        <div style="width: 45%">
            <!-- Login Form -->
            <form class="login-form" action="index.php" method="POST">
                <div class="login-div">
                    <h1 class="primary-text" style="font-size: 36px">Login</h1>
                    <input type="email" name="email" placeholder="Email" style="margin-top: 100px" required>
                    <input class="password-input" type="password" name="password" placeholder="Password"
                        style="margin-top: 30px" required>
                    <img src="../public/images/icon-eye.png" class="show-password">
                    <button type="SUBMIT" name="loginSubmit" style="width: 40%;margin: 60px 0px">Log in</button>
                    <h1 class="tertiary-text" style="font-size: 15px">Create an account? <a class="footer-click"
                            data-action="register">Sign
                            up</a></h1>
                </div>
            </form>
            <!-- Register form -->
            <form class="register-form" action="index.php" method="POST">
                <div class="login-div">
                    <h1 class="primary-text" style="font-size: 36px">Register</h1>
                    <input type="text" name="firstname" placeholder="First name" style="margin-top: 60px" required>
                    <input type="text" name="lastname" placeholder="Last name" style="margin-top: 20px" required>
                    <input type="email" name="email" placeholder="Email" style="margin-top: 20px" required>
                    <input class="password-input" type="password" name="password" placeholder="Password"
                        style="margin-top: 20px" required>
                    <img src="../public/images/icon-eye.png" class="show-password">
                    <button type="SUBMIT" name="registerSubmit" style="width: 40%;margin: 40px 0px">Sign up</button>
                    <h1 class="tertiary-text" style="font-size: 15px">Already have an account? <a class="footer-click"
                            data-action="login">Log
                            in</a></h1>
                </div>
            </form>
        </div>
        <div style="width: 54%">
            <img class="form-image" src="..\public\images\login-image.png">
        </div>
    </div>
</div>

</html>