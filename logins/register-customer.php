<?php
include "./../config/config.php";

if (isset($_POST['submit'])) {
    // Input validation
    if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['username'])) {
        echo "<script>alert('One or more inputs are missing');</script>";
    } else {
        $email = $_POST['email'];
        $username = $_POST['username'];
        
        // Check if email or username already exists in the database
        $checkEmailQuery = $conn->prepare("SELECT COUNT(*) FROM customer WHERE email = ?");
        $checkEmailQuery->bind_param("s", $email);
        $checkEmailQuery->execute();
        $checkEmailQuery->bind_result($emailExists);
        $checkEmailQuery->fetch();
        $checkEmailQuery->close();
        
        $checkUsernameQuery = $conn->prepare("SELECT COUNT(*) FROM customer WHERE username = ?");
        $checkUsernameQuery->bind_param("s", $username);
        $checkUsernameQuery->execute();
        $checkUsernameQuery->bind_result($usernameExists);
        $checkUsernameQuery->fetch();
        $checkUsernameQuery->close();
        
        // If email or username already exists, show an error
        if ($emailExists > 0) {
            echo "<script>alert('Email already exists. Please use a different email address.');</script>";
        } elseif ($usernameExists > 0) {
            echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        } else {
            $password = $_POST['password'];
            
            // Check if password length is at least 8 characters
            if (strlen($password) < 8) {
                echo "<script>alert('Password must be at least 8 characters long.');</script>";
            } else {
                if ($password == $_POST['confirm_password']) {
                    $fullname = $_POST['fullname'];

                    // Prepare the statement with positional placeholders
                    $insert = $conn->prepare("INSERT INTO customer (fullname, email, mypassword, username) VALUES (?, ?, ?, ?)");

                    // Hash the password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Bind the parameters
                    $insert->bind_param("ssss", $fullname, $email, $hashedPassword, $username);

                    // Execute the query
                    if ($insert->execute()) {
                        echo "<script>window.location.href='./login-customer.php'</script>";
                    } else {
                        echo "<script>alert('Error: Could not execute the query.');</script>";
                    }
                } else {
                    echo "<script>alert('Passwords do not match.');</script>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../assets/css/homepage.css">
    <link rel="stylesheet" href="./../assets/css/choose.css">
    <title>QuickBite</title>
</head>
<body>
    <header>
        <div class="logo">
        <a href="./../index.php"><img src="./../assets/image/icon/download.png" alt=""></a>
        </div>
        <nav>
            <ul>
                <a href="./../shop.php">
                    <li>Shop</li>
                </a>
                <a href="./cart.php">
                    <li>Cart</li>
                </a>
            </ul>
        </nav>
        <div class="btn">
            <a href="./../choose.php">Login</a>
        </div>
    </header>
    <hr>
    <div class="choose">
        <div class="box">
            <div class="chooseBoxTitle"><h1>Registration Form</h1></div>
            <fieldset align="center">
                <legend>Register</legend>
                <form action="register-customer.php" method="post">
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" required><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required onkeyup="checkPasswordStrength()"><br><br>
                    <div id="password-strength" class="password-strength"></div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                    <button name="submit" type="submit">Submit</button>
                </form>
            </fieldset>
            <div class="exsits">
                <a href="./login-customer.php">Already have a account?</a>
            </div>
        </div>
    </div>
    <footer>
        <div class="info">
            <div class="main">
                QuickBite
                <div class="more">
                    <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, quo!</h4>
                </div>
            </div>
            <div class="contact">
                <p>+94654654643</p>
                <p>quickbite@gmail.com</p>
            </div>
            <div class="faq">
                <p>privacy policy</p>
                <p>Help center</p>
            </div>
        </div>
        <hr>
        <h4>copyright &copy 2024. ALl right reserved</h4>
    </footer>
    <script src="./../assets/js/main.js"></script>