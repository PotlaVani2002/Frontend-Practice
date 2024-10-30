<?php 
require 'config/database.php';
session_start();

if (isset($_POST['submit'])) {
    // Get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate input fields
    if (!$username_email) {
        $_SESSION['signin'] = "Username or Email required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password required";
    } else {
        // Fetch user from the database
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            // Convert record into associative array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password']; // Corrected typo

            // Verify password
            if (password_verify($password, $db_password)) {
                // Set session for access control
                $_SESSION['user-id'] = $user_record['id'];

                // Set session if the user is an admin
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // Log user in and redirect to the admin page
                header('Location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Incorrect password";
            }
        } else {
            $_SESSION['signin'] = "User not found";
        }
    }

    // If there's any problem, redirect back to sign-in page with form data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    // Redirect if the form was not submitted
    header('Location: ' . ROOT_URL . 'signin.php');
    die();
}
?>
