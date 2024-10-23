<?php
session_start();
require 'config/database.php';

// Get signup form data if the signup button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Store form data temporarily in the session to retain form values on redirection
    $_SESSION['signup-data'] = $_POST;

    // Validate input values
    if (!$firstname) {
        $_SESSION['signup'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['signup'] = "Please enter your Username";
    } elseif (!$email) {
        $_SESSION['signup'] = "Please enter a valid Email";
    } elseif (strlen($createpassword) < 8) {
        $_SESSION['signup'] = "Password should be 8+ characters";
    } elseif ($createpassword !== $confirmpassword) {
        $_SESSION['signup'] = "Passwords do not match";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Please upload an Avatar";
    } else {
        // Check if username or email already exists in the database
        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $user_check_result = mysqli_query($connection, $user_check_query);

        if (mysqli_num_rows($user_check_result) > 0) {
            $_SESSION['signup'] = "Username or Email already exists";
        } else {
            // Work on avatar
            $time = time(); // Make each image name unique using current timestamp
            $avatar_name = $time . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = 'images/' . $avatar_name;

            // Check if file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $avatar_name);
            $extension = end($extension);

            if (in_array($extension, $allowed_files)) {
                // Check if image size is not too large (1MB+)
                if ($avatar['size'] < 1000000) {
                    // Upload avatar
                    move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                } else {
                    $_SESSION['signup'] = "File size is too large. It should be less than 1MB";
                }
            } else {
                $_SESSION['signup'] = "File should be of type png, jpg, jpeg";
            }
        }
    }

    // Redirect back to signup page if there was any problem
    if (isset($_SESSION['signup'])) {
        header('Location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // Hash the password and insert the new user into the users table
        $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
            VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
        $insert_user_result=mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            $_SESSION['signup-success'] = "Registration successful. Please log in.";
            header('Location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }
} else {
    // If the button wasn't clicked, redirect back to signup page
    header('Location: ' . ROOT_URL . 'signup.php');
    die();
}
