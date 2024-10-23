<?php 
require 'config/database.php';
session_start();

if (isset($_POST['submit'])) {
    // Get form data
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT) : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Validate form data
    if (!$title) {
        $_SESSION['add-post'] = "Enter Post Title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select Post Category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter Post Body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose Post Thumbnail";
    } else {
        // Process the thumbnail
        // Rename the image
        $time = time(); // Create a unique timestamp
        $thumbnail_name = $time . '_' . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // Allowed file types
        $allowed_files=['jpg','png','jpeg'];
        $extension=explode('.',$thumbnail_name);
        $extension=end($extension);
        if(in_array($extension,$allowed_files)){
            // make sure image is not too large. 2mb+
            if($thumbnail['size']<2_000_000){
                move_uploaded_file($thumbnail_tmp_name,$thumbnail_destination_path);

            }else{
                $_SESSION['add-post']="File is too large, should be less than 2mb";
            }
        }else{
            $_SESSION['add-post']="File should be png, jpg, or jpeg";
        }
    }

    // If there are any errors, redirect back to the form
    if (isset($_SESSION['add-post'])) {
        header('Location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        // Set is_featured of all posts to 0 if the current post is featured
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Insert the new post into the database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) 
                  VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['add-post'] = "Error in adding post";
        } else {
            $_SESSION['add-post-success'] = "New post added successfully";
            header('Location: ' . ROOT_URL . 'admin/index.php');
        die();
        }

        // Redirect to the manage posts page
        
    }
}
header('Location: ' . ROOT_URL . 'admin/add-post.php');
        die();
?>
