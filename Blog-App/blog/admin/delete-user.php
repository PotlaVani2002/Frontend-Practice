<?php
session_start(); // Ensure session is started
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Fetch user from database
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    // Make sure we got back only one user
    if (mysqli_num_rows($result) == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;
        
        // Delete image if available
        if ($avatar_name && file_exists($avatar_path)) {
            unlink($avatar_path); // Remove the avatar image
        }
    }

    // Fetch and delete all thumbnails of user's posts (to be handled later)
    // Code for this should be added here when necessary

    // Delete user from the database
    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);

    if (mysqli_errno($connection)) {
        $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']} {$user['lastname']}' from the database.";
    } else {
        $_SESSION['delete-user-success'] = "User '{$user['firstname']} {$user['lastname']}' deleted successfully.";
    }
}

// Redirect to manage-users.php
header('Location: ' . ROOT_URL . 'admin/manage-users.php');
die();
?>
