<?php
session_start();
require "./../config/config.php"; // Make sure this file connects to your database

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Input validation
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Please fill in all fields');</script>";
    } else {
        // Sanitize user inputs
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM seller WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // If email exists in seller table, handle seller login
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if the password is correct
            if (password_verify($password, $user['mypassword'])) {
                // Set session variables for logged-in seller
                $_SESSION['logged_in'] = true;
                $_SESSION['seller_id'] = $user['seller_id'];  // Set seller_id in session
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = 'seller'; // Set role as seller

                // Redirect to seller dashboard
                header('Location: ./../seller-dash.php');
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
    <title>Login</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password: </label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>
