<?php
require 'config/database.php';
session_start(); // Start the session

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // For later: Update posts to belong to 'Uncategorized' category if needed
    // Example: $uncategorized_id = 1;
     $update_query = "UPDATE posts SET category_id=5 WHERE category_id=$id";
     mysqli_query($connection, $update_query);
  
     if(!mysqli_errno($connection)){
           // Delete category
        $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);

    if (mysqli_affected_rows($connection) > 0) {
        // Success: category was deleted
        $_SESSION['delete-category-success'] = "Category deleted successfully";
    } else {
        // Failure: could not delete category
        $_SESSION['delete-category'] = "Couldn't delete category";
    }
     }

    
    
}

// Redirect back to manage categories page
header('Location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
?>
