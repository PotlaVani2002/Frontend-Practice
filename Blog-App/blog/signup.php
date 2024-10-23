<?php
session_start();
require 'config/constants.php';

// Delete signup data session
unset($_SESSION['signup-data']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Multipage Blog Website</title>
    <link rel="stylesheet" href="./css/stylee.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign Up</h2>
            
            <!-- Error Message Display -->
            <?php if (isset($_SESSION['signup'])): ?>
                <div class="alert__message error">
                    <p><?= htmlspecialchars($_SESSION['signup']); ?></p>
                    <?php unset($_SESSION['signup']); ?>
                </div>
            <?php endif; ?>

            <!-- Signup Form -->
            <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" placeholder="First Name" value="<?= isset($_SESSION['signup-data']['firstname']) ? htmlspecialchars($_SESSION['signup-data']['firstname']) : '' ?>">
                <input type="text" name="lastname" placeholder="Last Name" value="<?= isset($_SESSION['signup-data']['lastname']) ? htmlspecialchars($_SESSION['signup-data']['lastname']) : '' ?>">
                <input type="text" name="username" placeholder="Username" value="<?= isset($_SESSION['signup-data']['username']) ? htmlspecialchars($_SESSION['signup-data']['username']) : '' ?>">
                <input type="email" name="email" placeholder="Email" value="<?= isset($_SESSION['signup-data']['email']) ? htmlspecialchars($_SESSION['signup-data']['email']) : '' ?>">
                <input type="password" name="createpassword" placeholder="Create Password">
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
                <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
    <script src='./main.js'></script>
</body>
</html>

<?php
// Clear form data after displaying it
if (isset($_SESSION['signup-data'])) {
    unset($_SESSION['signup-data']);
}
