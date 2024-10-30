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
        
        // Delete avatar image if it exists
        if ($avatar_name && file_exists($avatar_path)) {
            unlink($avatar_path); // Remove the avatar image
        }
    }

    // Fetch and delete all thumbnails of user's posts
    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id=$id";
    $thumbnails_result = mysqli_query($connection, $thumbnails_query);
    if (mysqli_num_rows($thumbnails_result) > 0) {
        while ($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
            $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
            // Delete thumbnail from images folder if it exists
            if (file_exists($thumbnail_path)) {
                unlink($thumbnail_path);
            }
        }
    }

    // Delete all posts by the user from the database
    $delete_posts_query = "DELETE FROM posts WHERE author_id=$id";
    $delete_posts_result = mysqli_query($connection, $delete_posts_query);

    // Delete user from the database
    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);

    if (mysqli_errno($connection)) {
        $_SESSION['delete-user'] = "Couldn't delete '{$user['firstname']} {$user['lastname']}' from the database.";
    } else {
        $_SESSION['delete-user-success'] = "User '{$user['firstname']} {$user['lastname']}' and their posts were deleted successfully.";
    }
}

// Redirect to manage-users.php
header('Location: ' . ROOT_URL . 'admin/manage-users.php');
die();
?>
