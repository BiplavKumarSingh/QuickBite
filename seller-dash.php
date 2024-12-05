<?php
session_start();

//database connection
include './config/config.php';  

// Check if the seller is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] != 'seller') {
    header('Location: ./logins/login-seller.php'); 
    exit;
}

$seller_id = $_SESSION['seller_id']; 

// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM seller WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $seller = $result->fetch_assoc();
} else {
    // Handle when the query fails
    die("Error fetching seller details: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/seller.css">
    <link rel="stylesheet" href="./assets/css/homepage.css">
    <title>Seller Dashboard</title>
</head>
<body>
<header>
        <div class="logo">
            <a href="./index.php"><img src="./assets/image/icon/download.png" alt=""></a>
        </div>
        <nav>
            <ul>
                <li><a href="./shop.php">Shop</a></li>
                <li><a href="./cart.php">Cart</a></li>
            </ul>
        </nav>
</header>
<hr>
<section>
        <h1>Welcome, <?php echo htmlspecialchars($seller['fullname']); ?>!</h1>
        <ul>
        <a href="./add_product.php">Add Product</a>
        <a href="view_orders.php">View Orders</a>
        <a href="logout.php">Logout</a>
        </ul>
</section>
    <h2>Seller Dashboard</h2>

    <?php include_once "./layout/footer.php" ?>
