<?php
include './../config/config.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Input validation
    if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_FILES['image']['name'])) {
        echo "<script>alert('One or more inputs are missing');</script>";
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Handling image upload
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageError = $_FILES['image']['error'];
        $imageType = $_FILES['image']['type'];

        // Check if the image is valid (allowing only images)
        $allowedTypes = array('image/jpeg', 'image/png', 'image/jpg');
        if (in_array($imageType, $allowedTypes)) {
            // Check for upload errors
            if ($imageError === 0) {
                if ($imageSize < 5000000) { // Maximum file size (5MB)
                    // Generate a unique name for the image
                    $imageNewName = uniqid('', true) . '.' . pathinfo($imageName, PATHINFO_EXTENSION);
                    
                    // Ensure the upload directory exists
                    $uploadDir = './../uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
                    }

                    // Set the image upload path
                    $imageUploadPath = $uploadDir . $imageNewName;

                    // Move the uploaded image to the target directory
                    if (move_uploaded_file($imageTmpName, $imageUploadPath)) {
                        // Assuming the seller's ID is available in the session
                        $seller_id = 1; // Example seller ID (replace with actual session variable)

                        // Insert product into the database
                        $insert = $conn->prepare("INSERT INTO products (seller_id, name, description, price, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");

                        // Bind parameters and execute
                        $insert->bind_param("issds", $seller_id, $name, $description, $price, $imageNewName);

                        if ($insert->execute()) {
                            echo "<script>alert('Product added successfully!');</script>";
                            echo "<script>window.location.href='./../shop.php';</script>"; // Redirect to shop page after success
                        } else {
                            echo "<script>alert('Error: Could not execute the query.');</script>";
                        }
                    } else {
                        echo "<script>alert('Error uploading the image.');</script>";
                    }
                } else {
                    echo "<script>alert('Image file is too large. Maximum size is 5MB.');</script>";
                }
            } else {
                echo "<script>alert('Error uploading image.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image type. Only JPG, JPEG, and PNG are allowed.');</script>";
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
    <title>QuickBite - Add Product</title>
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
    </header>
    <hr>

    <div class="choose">
        <div class="box">
            <div class="chooseBoxTitle">Add New Product</div>
            <fieldset align="center">
                <legend>Product Information</legend>
                <form action="add-product.php" method="POST" enctype="multipart/form-data">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required><br><br>
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea><br><br>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required><br><br>

                    <label for="image">Product Image:</label>
                    <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/jpg" required><br><br>

                    <button name="submit" type="submit">Add Product</button>
                </form>
            </fieldset>
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
        <h4>copyright &copy 2024. All right reserved</h4>
    </footer>

</body>
</html>
