<?php
require "./../config/config.php"; // Ensure the config file is properly set up to connect to your database
session_start();

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Input validation
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Please fill in all fields');</script>";
    } else {
        // Sanitize user inputs
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Validate email
        if ($result->num_rows > 0) {
            $fetch = $result->fetch_assoc();

            // Validate password
            if (password_verify($password, $fetch['mypassword'])) {
                // Successful login; set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['email'] = $fetch['email'];

                // Redirect to product page
                header('Location: ./../index.php');
                exit;
            } else {
                echo "<script>alert('Invalid email or password');</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password');</script>";
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
    <title>QuickBite - Seller Login</title>
</head>
<body>
    <header>
        <div class="logo">
        <a href="./../index.php"><img src="./../assets/image/icon/download.png" alt=""></a>
        </div>
        <nav>
            <ul>
                <a href="./../shop.php"><li>Shop</li></a>
                <a href="./../cart.php"><li>Cart</li></a>
            </ul>
        </nav>
        <div class="btn">
            <a href="./../choose.php">Login</a>
        </div>
    </header>
    <hr>
    <div class="choose">
        <div class="box">
            <div class="chooseBoxTitle">Seller Login</div>
            <fieldset align="center">
                <legend>Login</legend>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                    <button name="submit" type="submit">Login</button>
                </form>
            </fieldset>
        </div>
    </div>
    <?php include_once "./../layout/footer.php"; ?>
</body>
</html>
