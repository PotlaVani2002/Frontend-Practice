<?php 
require 'config/database.php';
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    // Get and sanitize form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Validate required fields
    if (!$title) {
        $_SESSION['edit-post'] = "Title is required.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Category is required.";
    } elseif (!$body) {
        // Use original body if empty in form
        $query = "SELECT body FROM posts WHERE id=$id";
        $result = mysqli_query($connection, $query);
        $post = mysqli_fetch_assoc($result);
        $body = $post['body'];
    }

    // Handle thumbnail upload if a new file is uploaded
    if ($thumbnail['name']) {
        $time = time(); // For unique file name
        $thumbnail_name = $time . '_' . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        $allowed_files = ['jpg', 'png', 'jpeg'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

        if (in_array($extension, $allowed_files)) {
            if ($thumbnail['size'] < 2_000_000) { // 2MB max
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

                // Delete previous thumbnail if new one is uploaded
                if ($previous_thumbnail_name && file_exists('../images/' . $previous_thumbnail_name)) {
                    unlink('../images/' . $previous_thumbnail_name);
                }
            } else {
                $_SESSION['edit-post'] = "File size too large. Max: 2MB";
            }
        } else {
            $_SESSION['edit-post'] = "Invalid file type. Use png, jpg, or jpeg";
        }
    } else {
        // Use old thumbnail if no new one is provided
        $thumbnail_name = $previous_thumbnail_name;
    }

    // Redirect if there are errors
    if (isset($_SESSION['edit-post'])) {
        header('Location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        die();
    } else {
        // If this post is featured, set all others to non-featured
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0 WHERE id != $id";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Update the specific post in the database
        $query = "UPDATE posts SET 
                    title='$title', 
                    body='$body', 
                    thumbnail='$thumbnail_name', 
                    category_id=$category_id, 
                    is_featured=$is_featured 
                  WHERE id=$id";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            $_SESSION['edit-post'] = "Error updating post: " . mysqli_error($connection);
            header('Location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
            die();
        } else {
            $_SESSION['edit-post-success'] = "Post updated successfully";
            header('Location: ' . ROOT_URL . 'admin/index.php');
            die();
        }
    }
}

header('Location: ' . ROOT_URL . 'admin/');
die();
?>
