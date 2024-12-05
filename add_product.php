<?php
session_start();

// Include the database connection file
include './config/config.php';  // Make sure the path is correct

// Check if the seller is logged in
if (!isset($_SESSION['seller_id'])) {
    header('Location: ./../logins/login-seller.php');  // Redirect to login if not logged in
    exit;
}

$seller_id = $_SESSION['seller_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Handle file upload for product image
    $image = '';  // Default value
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Generate a unique image name to prevent conflicts
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION); // Get the image extension
        $image_name_unique = uniqid('product_', true) . '.' . $image_extension; // Unique image name

        // Define the upload directory
        $upload_dir = './assets/image/upload/';
        $image_url = $upload_dir . $image_name_unique;

        // Ensure the directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);  // Create the directory if it doesn't exist
        }

        // Upload the image to the server
        if (move_uploaded_file($image_tmp, $image_url)) {
            // Image uploaded successfully
        } else {
            $error = "Failed to upload image.";
        }
    }

    // Insert the product into the database
    $sql = "INSERT INTO products (seller_id, name, description, price, image) 
            VALUES ('$seller_id', '$product_name', '$description', '$price', '$image_name_unique')";

    if (mysqli_query($conn, $sql)) {
        $success = "Product added successfully!";
    } else {
        $error = "Error adding product: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/homepage.css">
    <link rel="stylesheet" href="./assets/css/add-product.css">
    <title>Add Product</title>
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
    <div class="choose">
        <div class="box">
            <!-- Success or Error message -->
            <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <fieldset align="center">
                <legend>
                    <h2>Add Product</h2>
                </legend>
                <form method="POST" action="" enctype="multipart/form-data">
                    <label for="product_name">Product Name:</label>
                    <input type="text" name="product_name" required>
                    <br>

                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>
                    <br>

                    <label for="price">Price:</label>
                    <input type="number" name="price" step="0.01" required>
                    <br>

                    <label for="image">Product Image:</label>
                    <input type="file" name="image" accept="image/*">
                    <br>

                    <button type="submit">Add Product</button>
                </form>
            </fieldset>
            <div class="exsits">
                <a href="seller-dash.php">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <?php include_once "./layout/footer.php" ?>