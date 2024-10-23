<?php
session_start();
require 'config/constants.php';
// Retrieve previous input values if form submission failed
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Multipage Blog Website</title>
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="./css/stylee.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign in</h2>
            <!-- Display success or error messages -->
            <?php if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert__message success">
                    <p><?= $_SESSION['signup-success']; unset($_SESSION['signup-success']); ?></p>
                </div>
            <?php elseif (isset($_SESSION['signin'])) : ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['signin']; unset($_SESSION['signin']); ?></p>
                </div>
            <?php endif; ?>

            <!-- Sign-in Form -->
            <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="text" name="username_email" placeholder="Username or Email" value="<?= htmlspecialchars($username_email) ?>">
                <input type="password" name="password" placeholder="Enter Password" value="<?= htmlspecialchars($password) ?>">
                <button type="submit" name="submit" class="btn">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign up</a></small>
            </form>
        </div>
    </section>
    <script src='./main.js'></script>
</body>
</html>
