<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/homepage.css">
    <link rel="stylesheet" href="./assets/css/choose.css">
    <title>QuickBite</title>
    <style>
        /* Dropdown Styles */
        .dropdown-menu {
            display: none; /* Initially hide the dropdown */
            position: absolute;
            top: 58px;
            right: 151px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 10px 0;
        }

        .dropdown-menu a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu a:hover {
            background-color: #ddd;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block; /* Show the dropdown on hover */
        }

        .avatar-header img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
    </style>
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
        <div class="btn">
        <?php if (isset($_SESSION['username'])) : ?>
        <!-- If user is logged in, show dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle">
                <div class="avatar-header">
                    <img src="path_to_avatar.jpg" alt="User Avatar">
                </div>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="transaction.html">Transactions History</a>
                <a class="dropdown-item" href="setting.html">Settings</a>
                <a class="dropdown-item" href="./layout/logout.php">Log out</a>
            </div>
        </li>
    <?php else : ?>
        <!-- If user is not logged in, show login link -->
        <a href="./choose.php">Login</a>
    <?php endif; ?>
</div>
        </div>
    </header>
    <hr>

    <script>
        // JavaScript for handling click event if you want to toggle the dropdown on click instead of hover
        document.querySelector('.nav-link').addEventListener('click', function(event) {
            const dropdownMenu = this.nextElementSibling; // Get the dropdown menu
            dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
            event.stopPropagation(); // Prevent the click from propagating to the document
        });

        // Close the dropdown if the user clicks anywhere outside
        document.addEventListener('click', function(event) {
            const dropdownMenu = document.querySelector('.dropdown-menu');
            const dropdownToggle = document.querySelector('.nav-link');
            if (!dropdownToggle.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>