<?php require "./../config/config.php"; ?>

<?php
if (isset($_POST['submit'])) {
    // Input validation
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are missing');</script>";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM seller WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Validate email
        if ($result->num_rows > 0) {
            $fetch = $result->fetch_assoc();

            // Validate password
            if (password_verify($password, $fetch['mypassword'])) {
                // Successful login; set session variables or redirect as necessary
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['email'] = $fetch['email'];
                echo "<script>window.location.href='./../index.php'</script>";
            } else {
                echo "<script>alert('Email or password is wrong');</script>";
            }
        } else {
            echo "<script>alert('Email or password is wrong');</script>";
        }

        $stmt->close();
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
            <a href="./../index.php">QuickBite</a>
        </div>
        <nav>
            <ul>
                <a href="./../shop.php">
                    <li>Shop</li>
                </a>
                <a href="./../cart.php">
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
        <div class="chooseBoxTitle">Registration Form</div>
        <fieldset align="center">
            <legend>Register</legend>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <button name="submit" type="submit">Submit</button>
            </form>

        </fieldset>
    </div>
</div>
<?php include_once "./../layout/footer.php"?>