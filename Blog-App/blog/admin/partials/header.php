<?php
session_start(); // Start the session
require 'config/database.php';
// require '../partials/header.php';

// Check if the user is not logged in
if (!isset($_SESSION['user-id'])) {
    // Redirect to the sign-in page if the user is not logged in
    header('Location: ' . ROOT_URL . 'signin.php');
    die();
}

// If the user is logged in, fetch the user's avatar
if (isset($_SESSION['user-id'])) {
    // Sanitize user ID
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Query to fetch the avatar from the users table
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);
    
    // Check if the query was successful
    if ($result && mysqli_num_rows($result) == 1) {
        $avatar = mysqli_fetch_assoc($result); // Fetch the avatar data
    } else {
        $avatar = null; // Set avatar to null if no record is found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Blog with Admin Panel</title>
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/css/stylee.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">Tutorials</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                
                <?php if (isset($_SESSION['user-id'])): ?>
                    <li class="nav__profile">
                        <div class="avatar">
                            <!-- Display avatar only if it's available -->
                            <?php if (!empty($avatar['avatar'])): ?>
                                <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="User Avatar">
                            <?php else: ?>
                                <img src="<?= ROOT_URL . 'images/default-avatar.png' ?>" alt="Default Avatar"> <!-- Optional: Default avatar -->
                            <?php endif; ?>
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <?php endif; ?>
            </ul>
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
</body>
</html>
